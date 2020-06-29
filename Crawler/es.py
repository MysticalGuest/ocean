from elasticsearch import Elasticsearch
es = Elasticsearch('148.70.15.23')
print(es.ping())
body = {
    "mappings":{
        'doc':{
            "properties":{
                "url":{
                    "type":"keyword",
                },
                "title":{
                    "type":"text",
                },
                "author":{
                    "type":"text",
                },
                "content":{
                    "type":"text",
                },
                "original":{
                    "type":"keyword",
                }
            }
        }
    }
}
# print(es.indices.create(index="search" , body=body))
# print(es.index('search' , body={'title':'严轶轩','original':'123'}))