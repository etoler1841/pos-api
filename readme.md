# POS API Reference
## Introduction
This API is used to facilitate communication between the [Price Busters Games website](http://www.pricebustersgames.com) and the **PHP Desktop POS** application.
## Products
*Coming soon*
## Categories
> URL: http://www.pricebustersgames.com/pbadmin/pos-api/category

Only one parameter will be accepted. If multiple parameters are defined, only the first will be processed. If no parameters are set, all categories will be returned.

#### Parameters
><p>**id** *(integer)*<br />
Category ID of the requested category</p>

#### Response
```
{
  "status": "ok" || "err",
  "errors": [],
  "result": [{
    "categories_id": 0,
    "categories_name": "string"
    "children": [
      {
        "categories_id": 1,
        "categories_name": "string",
        "children": []
      }
    ]
  }, {
    "categories_id": 1,
    "categories_name": "string"
  }, (...)]
}
```
