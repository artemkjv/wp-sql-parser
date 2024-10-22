## Requirements for building and running the application

- [Composer](https://getcomposer.org/download/)
- [Docker](https://docs.docker.com/get-docker/)

## Application Build and Run

After cloning the repository get into the wp-sql-parser directory and run:

`composer install`

`cp .env.example .env`

`php artisan key:generate`

`./vendor/bin/sail up -d`

`sail artisan migrate`

`sail npm install`

`sail npm run build`

`sail artisan horizon`

## Then finally test the application

Go to http://localhost/register and register

After that go to the Dumps page and you can test the application by uploading a SQL file and parsing it.
