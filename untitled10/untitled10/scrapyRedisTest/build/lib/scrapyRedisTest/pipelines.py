# -*- coding: utf-8 -*-

# Define your item pipelines here
#
# Don't forget to add your pipeline to the ITEM_PIPELINES setting
# See: https://doc.scrapy.org/en/latest/topics/item-pipeline.html
import pymongo
from elasticsearch import  Elasticsearch
class ScrapyredistestPipeline(object):
    def process_item(self, item, spider):
        return item

class MongoPipeline(object):
    def __init__(self,mongo_uri,mongo_db):
        self.mongo_uri = mongo_uri
        self.mongo_db = mongo_db

    @classmethod
    def from_crawler(cls , crawler):
        return cls(
            mongo_uri = crawler.settings.get("MONGO_URI"),
            mongo_db = crawler.settings.get("MONGO_DB")
        )

    def open_spider(self,spider):
        self.client = pymongo.MongoClient(self.mongo_uri)
        self.db = self.client[self.mongo_db]

    def process_item(self,item,spider):
        print(dict(item))
        print('\n'*10)

        self.db['article'].insert_one(dict(item))
        return item

    def close_spider(self,spider):
        self.client.close()

# class EsPipeline(object):
#     def __init__(self , es_uri , es_index):
#         self.es_url = es_uri
#         self.es_index = es_index
#         pass
#
#     @classmethod
#     def from_crawler(cls,crawler):
#         return cls(
#             es_url = crawler.settings.get('ES_URI'),
#             es_index = crawler.settings.get('ES_INDEX'),
#         )
#
#     def open_spider(self,spider):
#         self.es = Elasticsearch(self.es_url)
#
#     def precess_item(self,item , spider):
#         self.es.index(index=self.es_index,body=dict(item))
#         pass
#
#     def close_spider(self,spider):
#         pass