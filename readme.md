# POS API Reference
## Introduction
This API is used to facilitate communication between the [Price Busters Games website](http://www.pricebustersgames.com) and the **PHP Desktop POS** application.
All parameters not defined in the URL listing should be appended to the URL as a query string.
## Connecting to the API
All API calls must include the following HTTP header:
>Authorization: bearer {token}

Where {token} is the unique security token assigned to each store.
## Categories (GET)
To view details of a specific category:
>**URL:** http://www.pricebustersgames.com/pbadmin/pos-api/category/{id}

#### Parameters
><p>**id** *(integer; optional)*<br />
Category ID of the requested category; if omitted, returns all categories</p>
<p>**limit:** *(integer; default: 100)*<br />
Number of results to return; acceptable range: 1-100</p>
<p>**offset:** *(integer; default: 0)*<br />
Number of results to skip before beginning the return; must not be negative</p>
<p>**before:** *(timestamp; default: now)*<br />
Pulls only categories created before the given time.</p>
<p>**after:** *(timestamp; default: 0)*<br />
Pulls only categories created after the given time.</p>

#### Response
```
{
  "status": "ok" || "err",
  "errors": [],
  "results": [
    {
      "categories_id": 0,
      "categories_name": "string",
      "parent_id": 0
    }
  ]
}
```
To generate a tree listing a given category and all of its children:
>**URL:** http://www.pricebustersgames.com/pbadmin/pos-api/category/tree/{id}

#### Parameters
><p>**id** *(integer)*<br />
Category ID of the top-level category in the requested tree</p>

#### Response:
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
To view all direct children of a given category:
>**URL:** http://www.pricebustersgames.com/pbadmin/pos-api/category/parent/{id}

#### Parameters
><p>**id** *(integer; default: 0)*<br />
Category ID of the parent category</p>
<p>**limit:** *(integer; default: 100)*<br />
Number of results to return; acceptable range: 1-100</p>
<p>**offset:** *(integer; default: 0)*<br />
Number of results to skip before beginning the return; must not be negative</p>
<p>**before:** *(timestamp; default: now)*<br />
Pulls only categories created before the given time.</p>
<p>**after:** *(timestamp; default: 0)*<br />
Pulls only categories created after the given time.</p>

#### Response
```
{
  "status": "ok" || "err",
  "errors": [],
  "results": [
    {
      "categories_id": 0,
      "categories_name": "string",
      "parent_id": 0
    }, (...)
  ]
}
```

## Products (GET)
To view details of a specific product:
>**URL:** http://www.pricebustersgames.com/pbadmin/pos-api/product/{id}

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
      "products_price": "0.00",
      "categories_id": 0
    }
  ]
}
```

To view all products in a given category:
>**URL:** http://www.pricebustersgames.com/pbadmin/pos-api/product/category/{id}

#### Parameters
><p>**id** *(integer)*<br />
Category ID of the requested category</p>
<p>**limit:** *(integer; default: 100)*<br />
Number of results to return; acceptable range: 1-100</p>
<p>**offset:** *(integer; default: 0)*<br />
Number of results to skip before beginning the return; must not be negative</p>
<p>**before:** *(timestamp; default: now)*<br />
Pulls only products created before the given time.</p>
<p>**after:** *(timestamp; default: 0)*<br />
Pulls only products created after the given time.</p>

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
      "products_price": "0.00",
      "categories_id": 0
    }, (...)
  ]
}
```

**NOTE:** On all product calls, the products_price parameter will return a string due to an issue with PHP's serialization. The value will need to be converted to a float if being implemented directly into calculations.

## Labels (GET)
>**URL:** http://www.pricebustersgames.com/pbadmin/pos-api/label/{id}

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
