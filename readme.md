<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>


## Installation steps pgptest

- Clone the repo (https://github.com/ronit-rajput/pgphptest.git).
- Create a copy of .env.example and rename to .env.
- Generate unique key in .env using (php artisan key:generate).
- Install dependencies via composer install command.
- Create a database in postgres and replace db details in .env.
- Create table via run the migration files (php artisan migrate).
- Create default records via run the db seed. (php artisan db:seed).

## Handle GET REQUEST

 please use below route to call a get request that will render default template with user's detail such as name, comment, profile picture.
 
- /user/{id} -- valid id will be from this values (1,2)


## Handle POST API CALL

Please use below route to create POST request and append comments.

- /api/comment

- id, comments, password are the valid post params
- This API will also works for raw JSON in POST request

## Handle REQUEST from console

Please use below console command to make a call request from console and append the comment of the user.

- php artisan post:comment {id?} {comments?}

where the id and comments will be required params with whitespace. see the example below:

- php artisan post:comment 1 "test comment"


## Unit Test Cases

I have created a unit test case for verify GET request. you can run the test case using below url:

- ./vendor/bin/phpunit
