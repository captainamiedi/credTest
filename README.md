# Cred Pal Test

Technical Assessment

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

To clone and run this application, you'll need [git](https://git-scm.com/downloads) and [Composer](https://getcomposer.org/download/)(which comes with [XAMPP](https://www.apachefriends.org/download.html)) installed on you computer.

### Installing

From your command line
```
# Clone this repository
$ git clone https://github.com/captainamiedi/credTest.git

# Go into the repository directory
$ cd credTest

# Install dependencies
$ composer install

# set up your .env as seen in .env.example

# set up your database

# Run migrations
$ php artisan migrate

# Install dependencies
$ npm install

# Run build
$ npm run watch

# run the app
$ php artisan serve

```

## Test KYC Simulation

1. Create a user with name **bright** or **james**

2. User the user account to test.

## API ENDPOINT
Endpoint | Functionality
-------- | -------------
POST /api/auth/login | login user
PATCH /api/auth/register | Register a user
GET /api/account | To get user Account Details
GET /api/transfer| To transfer funds to another user


## Running the tests

* Navigate to the project root directory
* After installation
* set up .env.testing as seen in .env.testing.example
* run `vendor/bin/phpunit`


## Built With

* [LARAVEL](https://laravel.com/) 
* [Vue.js](https://vuejs.org/)

## Author
Bright Eloghene Amidiagbe

## License
MIT