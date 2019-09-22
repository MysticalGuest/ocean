from scrapy_redis.spiders import RedisSpider
import scrapy
import re
from ..items import MinjianItem

class minjianSpider(RedisSpider):
    name = 'minjianspider'
    redis_key = 'minjianspider:start_urls'

    def parse(self, response):
        pattern = '.*?news/.*?/$'
        urls = response.xpath(".//a//@href").extract()
        lists = [ url for url in urls if re.match(pattern , url)]
        for list in lists:
            yield scrapy.Request(url = list ,callback=self.first_parse , dont_filter=True)
        pass
    # 进入分类文章的目录      http://www.6mj.com/news/xinjiang/
    def first_parse(self,response):
        item = MinjianItem()
        urls = response.xpath(".//div[@class = 'row-fluid content margin-top10']//@href").extract()
        next_lists = [url for url in urls if re.match('./index.*?.htm', url)]
        lists = [url for url in urls if re.match('.*?minjian/.*?.htm', url)]
        base = ''.join(response.xpath(".//div[@class = 'base']//text()").extract())
        s1 = re.sub('\r','',base)
        s2 = re.sub('\n','',s1)
        s3 = re.sub(' ','',s2)
        item['type'] = s3
        if not next_lists:
            for url in lists:
                url = response.urljoin(url)
                yield scrapy.Request(url = url , meta={'key':item},callback=self.parse_article , dont_filter=True )
        else:
            for url in next_lists:
                url = response.urljoin(url)
                yield scrapy.Request(url=url , meta={'key':item},callback=self.second_parse , dont_filter=True)
            pass
        pass

#提取文章       http://www.6mj.com/news/minjian/1172518356EE8K8E21GBB0FDHKFFFH.htm
    def parse_article(self,response):
        item = response.meta['key']
        title = response.xpath(".//div[@class = 'row-fluid content margin-top10']//h3/b/text()").extract_first()
        article = ''.join(response.xpath(".//div[@class = 'row-fluid content margin-top10']//text()").extract())
        article = re.sub('\r', '', article)
        article = re.sub('\n', '', article)
        if re.match('.*?作者：(.*?)\u3000', article):
            author = ''.join(re.match('.*?作者：(.*?)\u3000',article).groups())
        else:
            print("无法提取作者")
            author = None
        if re.match('.*?来源：(.*?)\u3000',article):
            original = ''.join(re.match('.*?来源：(.*?)\u3000',article).groups())
        else:
            print("无法提取来源")
            original = None
        url = response.url
        if re.match('.*?作者：.*?(\u3000.*?)上一篇文章.*', article):
            content = ''.join(re.match('.*?作者：.*?(\u3000.*?)上一篇文章.*', article).groups())
        else:
            print("无法提取文章")
            content = None
        item['url'] = url
        item['title'] = title
        item['author'] = author
        item['original'] = original
        item['content'] = content
        yield item
        pass

    def second_parse(self, response):
        item = MinjianItem()
        urls = response.xpath(".//div[@class = 'row-fluid content margin-top10']//@href").extract()
        next_lists = [url for url in urls if re.match('./index.*?.htm', url)]
        lists = [url for url in urls if re.match('.*?minjian/.*?.htm', url)]
        base = ''.join(response.xpath(".//div[@class = 'base']//text()").extract())
        s1 = re.sub('\r', '', base)
        s2 = re.sub('\n', '', s1)
        s3 = re.sub(' ', '', s2)
        item['type'] = s3