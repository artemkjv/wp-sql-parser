## Requirements for building and running the application

- [Composer](https://getcomposer.org/download/)
- [Docker](https://docs.docker.com/get-docker/)

## Application Build and Run

After cloning the repository get into the laravel-sail-mongodb directory and run:

`composer install`

`cp .env.example .env`

`./vendor/bin/sail up -d`

## Then finally test the application

Go to [http://localhost](http://localhost) in order to see the application running.
