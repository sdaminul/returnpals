# ReturnPal (Laravel + MySQL) — Local Setup (XAMPP)

## Requirements
- PHP 8.1+ (your XAMPP 8.2 is OK)
- MySQL (XAMPP)
- Composer

## 1) Put project into htdocs
1. Extract the ZIP into: `C:\xampp\htdocs\returnpal`
2. Open the folder in a terminal.

## 2) Create database
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Create a database named: `returnpal`

## 3) Configure environment
1. Copy `.env.example` to `.env` if needed.
2. Make sure these lines are correct:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=returnpal
DB_USERNAME=root
DB_PASSWORD=
```

## 4) Install & generate key
Run:

```
composer install
php artisan key:generate
```

## 5) Run migrations
```
php artisan migrate
```

## 6) Run the app
### Option A (recommended)
```
php artisan serve
```
Then open `http://127.0.0.1:8000`

### Option B (XAMPP Apache)
- Create an Apache VirtualHost pointing to `public/` **or**
- Put it inside `htdocs` and access `http://localhost/returnpal/public`

## Login
- Register a new account from `/register`, then login from `/login`.

## Dashboard modules implemented
- Packages Sent: add/edit/delete with products + notes
- Received: list (requires records with status Received/Processing/Processed)
- Items Pending: list
- Sold Items: list + summary cards
- Invoices: list + download (HTML file)
- Settings: VAT switch + Discord webhook URL
