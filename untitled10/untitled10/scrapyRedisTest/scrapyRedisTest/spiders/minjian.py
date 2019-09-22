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
            # 将第一页加入到next_lists
            next_lists.insert(0,response.url)
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
        next_page_urls_pattern = re.sub('.htm','_[0-9].*',response.url)
        next_page_urls = response.xpath(".//div[@class = 'row-fluid content margin-top10']//a/@href").extract()
        next_page_lists = [url for url in next_page_urls if re.match(next_page_urls_pattern, response.urljoin(url))]
        next_page_lists = set(next_page_lists)
        if re.search(".*?来源：(.*?)作者：([\u4e00-\u9fa5]*)([\s\S]*?)上一篇文章",article):
            original = re.search(".*?来源：(.*?)作者：([\u4e00-\u9fa5]*)([\s\S]*?)上一篇文章",article).groups()[0]
            author =  re.search(".*?来源：(.*?)作者：([\u4e00-\u9fa5]*)([\s\S]*?)上一篇文章",article).groups()[1]
            content = re.search(".*?来源：(.*?)作者：([\u4e00-\u9fa5]*)([\s\S]*?)上一篇文章",article).groups()[2]
        else:
            original = None
            author = None
            content = None
        url = response.url
        item['url'] = url
        item['title'] = title
        item['author'] = author
        item['original'] = original
        item['content'] = content
        if not next_page_lists:
            for url in next_page_lists:
                yield scrapy.Request(url=url , meta={'second_key':item} , callback= self.next_page_parse , dont_filter=True)

            pass
        yield item
        pass

    def second_parse(self, response):
        item = response.meta['key']
        urls = response.xpath(".//div[@class = 'row-fluid content margin-top10']//@href").extract()
        # next_lists = [url for url in urls if re.match('./index.*?.htm', url)]
        lists = [url for url in urls if re.match('.*?minjian/.*?.htm', url)]
        # base = ''.join(response.xpath(".//div[@class = 'base']//text()").extract())
        # s1 = re.sub('\r', '', base)
        # s2 = re.sub('\n', '', s1)
        # s3 = re.sub(' ', '', s2)
        for url in lists:
            url = response.urljoin(url)
            yield scrapy.Request(url=url, meta={'key': item}, callback=self.parse_article, dont_filter=True)

    def next_page_parse(self , response):
        item = response.meta['second_key']
        article = ''.join(response.xpath(".//div[@class = 'row-fluid content margin-top10']//text()").extract())
        if re.search(".*?来源：(.*?)作者：([\u4e00-\u9fa5]*)([\s\S]*?)上一篇文章", article):
            content = re.search(".*?来源：(.*?)作者：([\u4e00-\u9fa5]*)([\s\S]*?)上一篇文章", article).groups()[2]
            item['content'] += content
        yield item
        pass