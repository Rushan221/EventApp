# Event App

This is a test assessment application. This application is built on Laravel framework. It utilizes different JS  libraries and packages such as jQuery, Ajax, Sweetalert2 and daterange picker.

## Prerequisites
For running the application, please make sure your system has PHP, a version control system(e.g. git) and composer installed.

## Steps of Installation
Clone the repository.

```bash
git clone https://github.com/Rushan221/EventApp.git
```
Create .env file for storing database settings. Make sure you enter valid database settings in the .env file generated.
```bash
cp .env.example .env
```
Install all the packages needed
```bash
composer install
```
Generate application key
```bash
php artisan key:gen
```
Now you can serve the application
```bash
php artisan key:gen
```
Create the tables in the database.
```bash
php artisan migrate
```
Insert few data using seeder
```bash
php artisan db:seed
```

## Usage
Run the application
```bash
php artisan serve --port 8000
```
