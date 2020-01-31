# Code Exercise OOP

This project will consume an [API](https://www.itccompliance.co.uk/recruitment-webservice/api/) to fetch some products and display them on the screen.

## Installation

Simply run composer install and that should be enough to get going.

```bash
composer install
```

## Usage

You'll see a table list of products on the homepage. Simply click view more to to view product details.

## Testing

Simply run the following command: 
```bash
phpunit Tests/ApiTest.php
```

## Comments
So I have used the Guzzle HTTP package to carry out my HTTP requests, I could have used Curl directly but Guzzle nicely abstracts away all the tedious details and it's more readable with less code.

I created an API class which has a generic `apiCall` method that can take any type of request and it will return a response. The `ProductInventory` class is basically the main class which has the getter methods for the products. I didn't know what else to call it :/ 

The `register.php` file is basically registering everything, sort of similar to Laravel's bootstrap file and similar to a Java main class.
