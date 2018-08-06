# POS API Reference
## Introduction
This API is used to facilitate communication between the [Price Busters Games website](http://www.pricebustersgames.com) and the **PHP Desktop POS** application.
All parameters not defined in the URL listing should be sent via the specified method (POST or GET).
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
      "categories_id": 0,
      "live_price": false
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
      "categories_id": 0,
      "live_price": false
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

## Inventory (POST)
>**URL:** http://www.pricebustersgames.com/pbadmin/pos-api/inventory/{id}

#### Parameters
><p>**id** *(integer)*<br />
Product ID of the requested product</p>
<p>**qty** *(integer)*<br />
Quantity to add (positive) or remove (negative) from the store's inventory</p>

#### Response
```
{
  "status": "ok" || "err",
  "errors": []
}
```

## Get Price Updates (GET)
>**URL** http://www.pricebustersgames.com/pbadmin/pos-api/price-change

This endpoint pulls all items which have different prices listed in the master products table from those listed in the individual store's inventory table.

#### Response
```
{
  "status": "ok" || "err",
  "errors": [],
  "results": [
    {
      "products_id": 0,
      "new_price": "0.00"
    }
  ]
}
```

**NOTE:** The products_price parameter will return a string due to an issue with PHP's serialization. The value will need to be converted to a float if being implemented directly into calculations.

## Update Price (POST)
>**URL** http://www.pricebustersgames.com/pbadmin/pos-api/price-change/{id}

This endpoint updates the individual store's online inventory to reflect price updates performed to match the master products table.

#### Parameters
><p>**id** *(integer)*<br />
Product Id of the product to update</p>
<p>**price** *(float)*<br />
New price of the selected product</p>

#### Response
```
{
  "status": "ok" || "err",
  "errors": []
}
```

## Download Stock Changes (GET)
>**URL** http://www.pricebustersgames.com/pbadmin/pos-api/product/queue/

This endpoint returns an array of all changes to product quantities on the website not yet received by the POS. (N.B.: Signs are **not** inverted, as the table records both additions AND subtractions to/from products. In other words, when a product sells on the website, it will be entered in the table as a negative value.)

#### Response
```
{
  "status": "ok" || "err",
  "errors": [],
  "results": [
    {
      "products_id": 0,
      "products_quantity": 0
    }, (...)
  ]
}
```
