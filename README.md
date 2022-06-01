
# Backend Developer Test V 2.0 - Cuponeria

  

This test aims to test the candidate's knowledge regarding the technologies used by the **Cuponeria Backend Developer Team**.

  

## Instructions

  

* Clone this repository.

* Create a new branch with your name.

* Checkout to the branch of your name.

* Commit your workflow, you can check this [article](https://medium.com/@rafael.oliveira/como-escrever-boas-mensagens-de-commit-9f8fe852155a).

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

1. Get all products with type lipstick and category lip_gloss and show only (@See api http://makeup-api.herokuapp.com/) :
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
