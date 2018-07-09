# POS API Reference
## Introduction
This API is used to facilitate communication between the [Price Busters Games website](http://www.pricebustersgames.com) and the **PHP Desktop POS** application.
## Connecting to the API
All API calls must include the following HTTP header:
>Authorization: bearer $token

Where $token is the unique security token assigned to each store.
## Categories (GET)
>**URI:** http://www.pricebustersgames.com/pbadmin/pos-api/category/{id}

#### Parameters
><p>**id** *(integer)*<br />
Category ID of the requested category</p>

#### Optional Parameters (URL encoded)
><p>**tree** *(1 or 0; default: 1)*<br />
Toggles tree view

#### Response
###### Tree View:
```
{
  "status": "ok" || "err",
  "errors": [],
  "results": [
    {
      "categories_id": 0,
      "categories_name": "string"
      "children": [
        {
          "categories_id": 1,
          "categories_name": "string",
          "children": []
        }
      ]
    },
    {
      "categories_id": 1,
      "categories_name": "string",
      "children": []
    }, (...)
  ]
}
```
###### Single Category View:
```
{
  "status": "ok" || "err",
  "errors": [],
  "results": [
    {
      "categories_id": 0,
      "categories_name": "string"
      "parent_id": 0
    }
  ]
}
```

## Products (GET)
>**URI:** http://www.pricebustersgames.com/pbadmin/pos-api/product/{id}

#### Parameters
><p>**id** *(integer)*<br />
Product ID of the requested product</p>

#### Response
```
{
  "status": "ok" || "err",
  "errors": [],
  "results": [
    {
      "products_id": 0,
      "products_name": "string",
      "products_quantity": 0,
      "products_model": "string",
      "products_price": 0.00,
      "categories_id": 0
    }
  ]
}
```

## Labels (GET)
>**URI:** http://www.pricebustersgames.com/pbadmin/pos-api/label/{id}

#### Parameters
><p>**id** *(integer)*<br />
Category ID of the requested product</p>

#### Response
```
{
  "status": "ok" || "err",
  "errors": [],
  "results": [
    {
      "categories_id": 0,
      "standard": 0,
      "barcode": 0,
      "game_case": 0,
      "game_sleeve": 0
    }
  ]
}
```
