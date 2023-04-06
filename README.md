# Shopping List Application

## Prerequisites:
This application is written with laravel 10 and Livewire - and uses an SQL database

Please follow the steps below to set up the project - or feel free to just browse this code and view the working demo at 

The Tesco API is currently inactive so i was unable to use this.

***
User Journeys that were Covered in this :


***
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

Once the database has been created run the npm dev and artisan serve commands (in addition to any SQL server required to connect and migrate the database) run build command.

```sh
    php artisan serve
    npm run dev
```

From here the project should be completely setup, any issues please contact me.