# Lift Journal

A Simple [Laravel](https://laravel.com/) `5.5` App, Made with [Bulma.io](https://bulma.io)
This app is a simple diary for logging a person's workout sessions on theiy daily basis.

```
This is just a demonstration of skill sets, it is not meant for commercial, service use or any other similar cases.
```

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development.

This does not have testing purposes and deployment notes (to be decided).

`By the way, I am using a Windows 10 Operating System. This may vary to a different system/version of yours`

### Prerequisites

There will be a list of things you need on your system to start this project
List below shows a list of prerequisites:

```
PHP 5.6 or above                - XAMPP Included
MySQL (10.1.21-MariaDB)         - XAMPP Included
[Composer](https://getcomposer.org/download/)   
[Node and npm](https://nodejs.org/en/download/) make them GLOBAL for your own convenience
[Redis](https://github.com/ServiceStack/redis-windows) for Windows. The version I used is Version: 3.0.503 (June 28, 2016) - I downloaded 'redis-latest.zip'
```

### Installation

How to get the development env running.
Follow the steps below:

1. Get a copy of this lift_journal source code. Either clone or download them.
2. From your database, create a `lift_journal` database as its name.
```
You can edit the configuration in ./.env file
DB_DATABASE=lift_journal
```
3. From your cli, in `lift_journal` directory, Run `php artisan migrate` or `php artisan migrate:fresh`. This should give you the tables of the database you just created
4. Run `php artisan db:seed`, this will populate the database.
5. Run `npm install` to install the node package (node_modules folder) dependencies.
6. Run `composer install` to install the composer package dependencies (vendor folder).

### Running the App (in Development)

We will need atleast 2 CLIs and redis server

* A backend server to run laravel app
* A server that integrates with (or mounts on) the Node.JS HTTP Server: `socket.io` Reference: [socket.io chat](https://socket.io/get-started/chat/)
* Redis server for publishing events (Redis from frontend will listen and socket.io will emit events to corresponding connections) - for `realtime` to work.

1. Run your XAMPP's MySQL or make sure your database is up for connections.
2. From your app's dir: 1st CLI 
```
php artisan serve
```

Notifies you: 
```
Laravel development server started: <http://127.0.0.1:8000> (make sure port 8000 is not used by any other application)
```
3. app's dir: 2nd CLI to run socket.io
```
node resources/assets/js/server.js
```
4. Run your redis server. When it is running, it notifies you:
```
The server is now ready to accept connections on port 6739
```

## Congratulations!
The server should be live at http://127.0.0.1:8000 

### On Login
As an example, I have created a user during seeding `php artisan db:seed`.
```
username: bob_d@example.com
password: 123456
```

## Notes

### For development purposes:

Use `npm run watch` from cli (make sure you are in the app's dir)
This will update your code every after save.

The app comes with laravel-mix to compile the javascript from resources/assets/js folder. You can check it on ./webpack.mix.js

1st arg is to be compiled, next is destination.
```
mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
```

### Realtime

Try to login with the same user in 2 different browsers(or one in incognito, and the other, not)

Whenever you Create a Journal,
You should be able to get some updates from the other browser `no need to refresh page`.

This also works for Edit and Delete, however, I did not create some notification, so it just happens instantly.

## Acknowledgments

* [Laracasts](https://laracasts.com/) for teaching me to code laravel.
* Stack Overflow