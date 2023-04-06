# Shopping List Application

## Prerequisites:
This application is written with laravel 10 and Livewire - and uses an SQL database

Please follow the steps below to set up the project - or feel free to just browse this code and view the working demo at 
<a href="https://shopping-list.wadevelopment.com">https://shopping-list.wadevelopment.com</a>

## Setup:

```sh 
git clone https://github.com/wpa12/shopping-list-application.git

cd shopping-list-application

composer install
npm install

cp .env-example .env
```

from here add your database credentials in the projects .env file.

Once this is done, run the following:

```sh
    php artisan key:generate

    php artisan config:clear

    php artisan migrate
```

Once the database has been created run the npm run build command.

```sh
    npm run build
```

from here the project should be completely setup, any issues please contact me. 