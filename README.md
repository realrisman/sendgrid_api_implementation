# Implementation SendGrid API using Symfony 4

## Requirements
  * PHP 7.1.3 or higher;
  * PDO-SQLite PHP extension enabled;

## Setup Project
* copy **.env** to **.env.local** for your local development
* setup your database and put the information into **.env.local**
* create account **https://sendgrid.com/** and put **SENDGRID_KEY** from your account to **.env.local**

## Run Project
* `composer install`
* `php -S 127.0.0.1:8000 -t ./public` or `symfony server:start`

## Other commands
* `php bin/console debug:router` to get list of routes
