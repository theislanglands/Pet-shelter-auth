# Pet Shelter
Laravel Excersize#2 for Web Tech Course 2021

The pet shelter board is an application where registered users can post pets they are giving in for adoption and adopt pets posted by other users.

In this exersize the neccesary authentication and authorization features is implemented.

## Setup
1. Run `docker-compose up -d` within the director to spin up a MySQL server on port 3306 in detached mode
2. Run `php artisan migrate:fresh --seed` to migrate and seed the database
3. Run `php artisan serve` to boot up your application on port 8000

## Route overview
The following routes are created for the pet shelter application:

| URL                          | Method | Controller         | Description                                                  |
|------------------------------|--------|--------------------|--------------------------------------------------------------|
| /                            | GET    | HomeController     | Shows home page                                              |
| /adoptions                   | POST   | AdoptionController | Creates a new listing for an adoption                        |
| /adoptions/create            | GET    | AdoptionController | Displays the form that creates a new listing for an adoption |
| /adoptions/mine              | GET    | AdoptionController | Lists the pets that you have adopted                         |
| /adoptions/{adoption}        | GET    | AdoptionController | Shows the details for a given {adoption}                     |
| /adoptions/{adoption}/adopt  | POST   | AdoptionController | Allows you to adopt a given {adoption}                       |
| /login                       | GET    | HomeController     | Shows the login page                                         |
| /login                       | POST   | HomeController     | Processes the login request and logs the user in             |
| /logout                      | GET    | HomeController     | Logs out the current authenticated user                      |
| /register                    | GET    | HomeController     | Displays the form that creates a new user                    |
| /register                    | POST   | HomeController     | Creates a new user                                           |
