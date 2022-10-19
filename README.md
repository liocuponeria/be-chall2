
# Implemented Items

1. Get all products with type lipstick and category lip_gloss and show only name price and description:

  

- Was implemented a Service with "makeup-api" as data source.

- Files:

- src/app/Services/ProductService.php

- src/app/Services/DataSource/ProductSourceInterface.php

- src/app/Services/DataSource/Product.php

- Method:

- ProductService::searchByTypeAndCategory


```
Api request exmaple:

Method: GET
Endpoint: localhost/product/search/lipstick/lip_gloss
```

\
2. Get the cheapest and the most expensive product under brand nyx and show only name, price and description:

- Was implemented a Service with "makeup-api" as data source.

- Files:

- src/app/Services/ProductService.php

- src/app/Services/DataSource/ProductSourceInterface.php

- src/app/Services/DataSource/Product.php

  

- Method:

- ProductService::searchCheapestAndMostExpensiveByBrand

```
Api request exmaple:

Method: GET
Endpoint: localhost/product/brands/nyx
```

##

  

> The product's price is showed in BRL coverted with **FastForex** on **CoinConverterService**.

> The service use a Singleton instance and make an unique request to get the USDxBRL exchange rate used to convert all product amounts.

>

>  - The FastForex Api Key in .env file.

  

##

  

3. Simulate a purchase with params on a json body

- Files:

- src/app/Services/TransactionService.php

  

- Methods:

- TransactionService::saveWithEloquent (Save with Eloquent Model)

- TransactionService::saveWithQueryBuilder (Save with Query Builder)

- TransactionService::saveWithRawSql (Save with RAW SQL)

```
Api request exmaple:

Method: POST
Endpoint: localhost/product/buy

Body:
{
	"productId": 10,
	"UserId": 40,
	"Price": 51.21,
	"Date": "2022-10-18"
}
```

4. Create a table named transaction with the following schema having transactionId as Primary Key(PK)

- Implemented with migrations

- Files:

- src/database/migrations/2022_10_18_215924_transactions_table.php

  

5. Process request number 3 above

- The endpoint **localhost/product/buy** insert three records for each request with teh methods:

- TransactionService::saveWithEloquent (Save with Eloquent Model)

- TransactionService::saveWithQueryBuilder (Save with Query Builder)

- TransactionService::saveWithRawSql (Save with RAW SQL)

  

6. Add documentation to all methods and code (if necessary to explain something)

- Added with DocBlocks on Service Methods

- Gerenerated documentation with phpDocumentator on **/docs** folder

  

### Have To

  

[&#10003;] Use [Lúmen](https://lumen.laravel.com/docs/8.x/) as your framework.\

[&#10003;] Use MVC model\

[&#10003;] Return a JSON on all responses\

[&#10003;] Use cURL as html form is not allowed\

(Developed as middleware **src/app/Http/Middleware/CurlMiddleware.php**)

  

#

#

  

# Backend Developer Test V 2.0 - Cuponeria

  

  

  

This test aims to test the candidate's knowledge regarding the technologies used by the **Cuponeria Backend Developer Team**.

  

  

  

## Instructions

  

  

  

* Clone this repository.

  

  

* Create a new branch with your name.

  

  

* Checkout to the branch of your name.

  

  

* Commit your workflow.

  

  

* After you're done, push to the origin and create a pull request of the branch with your name.

  

  

* Main API to be used: [http://makeup-api.herokuapp.com/](http://makeup-api.herokuapp.com/)

  

  

  

## To run the container

  

  

  

Download and install [docker](https://www.docker.com/products/docker-desktop)

  

  

Initialize the container with the following command

  

  

```

  

docker-compose up

  

```

  

  

access <http://localhost/>

  

  

## Skills Required

  

  

1. Get all products with type lipstick and category lip_gloss and show only:

  

1. name

  

2. price original and in BRL*

  

3. description

  

  

* Endpoint: localhost/product/search/{type}/{category}

  

* Method: GET

  

* Params: type, category

  

  

2. Get the cheapest and the most expensive product under brand nyx and show only:

  

1. name

  

2. price original and in BRL*

  

3. description

  

  

* Endpoint: localhost/product/brands/{brand}

  

* Method: GET

  

* Params: brand

  

  

3. Simulate a purchase with params on a json body

  

* Endpoint: localhost/product/buy

  

* Method: POST

  

* Params: productId Int(11), UserId Int(11), Price Float(10,2), Date Datetime(YYYY-dd-mm)

  

  

4. Create a table named transaction with the following schema having transactionId as Primary Key(PK)

  

  

* transactionId(PK) Varchar(50)

  

* productId Int(11)

  

* userId Int(11)

  

* price Decimal(10,2)

  

* date Date(YYYY-dd-mm)

  

  

5. Process request number 3 above

  

1. show a transaction id. This id is a random alphanumeric string with 50 positions.

  

2. show a raw sql insert query

  

3. show a query in lumen query builder

  

4. insert 3 different transactions

  

  

6. Add documentation to all methods and code (if necessary to explain something)

  

  

  

#### Notes

  

  

1. need another api to convert

  

* https://www.fastforex.io/

  

* https://free.currencyconverterapi.com/

  

  

## Have to

  

  

1. Use [Lúmen](https://lumen.laravel.com/docs/8.x/) as your framework.

  

  

2. Use MVC model

  

  

3. Return a JSON on all responses

  

  

4. Use cURL as html form is not allowed

  

  

  

## GLHF (Good Luck and Have Fun!)