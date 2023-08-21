# Shopping List Application

## Prerequisites:
This application is written with laravel 10 and Livewire - and uses an SQL database

Please follow the steps below to set up the project - or feel free to just browse this code and view the working demo at 

The Tesco API is currently inactive so i was unable to use this.

***
User Journeys that were Covered in this:

* Item 1 - Create a shopping list that can contain a list of groceries
* Item 2 - Create a way for a user to add an item to the shopping list
* Item 3 - Create a way for a user to remove an item from the shopping list
* Item 4 - (think this is done, might have been confused on this)
* Item 5 - Persist shopping list state between page visits
* Item 7 - API was no functional
* Item 8 - Total up the prices of each list
* Item 9 - Put a spending limit and notify when limit is exceeded
* Item 11 - Build and authentication system for the user

Outstanding items (ran out of time)

* Item 6 - reordering the items.
* Item 10 - Emailing functionality.

***
## Setup:

```sh 
git clone https://github.com/wpa12/shopping-list-application.git

cd shopping-list-application

composer install
npm install

cp .env.example .env
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
