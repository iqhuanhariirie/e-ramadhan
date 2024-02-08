
## Installation:

Local installation with these requirements:

### Server specs

1. PHP 8.1 (and compatible with [Laravel 10.x server requirements ](https://laravel.com/docs/10.x/deployment#server-requirements)).
2. Database: MySQL/MariaDB.


### Installation steps:

1. Clone repository with this command: `https://github.com/iqhuanhariirie/e-ramadhan.git`
2. Enter the e-ramadhan directory: `$ cd e-ramadhan`
3. Install the dependencies with: `$ composer install`
4. Copy file `.env.example` to `.env` with this command: `$ cp .env.example .env`
5. Generate application key: `$ php artisan key:generate`
6. Create MySQL database for this application.
7. Configure the database and other configurations in file `.env`.
    ```
    APP_URL=http://localhost
    APP_TIMEZONE="Asia/Kuala_Lumpur"

    DB_DATABASE=homestead
    DB_USERNAME=root
    DB_PASSWORD=

    MASJID_NAME="Masjid Ar-Rahman"
    MASJID_DEFAULT_BOOK_ID=1
    AUTH_DEFAULT_PASSWORD=password

    MONEY_CURRENCY_CODE="RM"
    MONEY_PRECISION=2
    MONEY_DECIMAL_SEPARATOR="."
    MONEY_THOUSANDS_SEPARATOR=","
    ```
8.  Migrate database: `$ php artisan migrate --seed`
9.  Create passport keys: `$ php artisan passport:keys`
10. Create storage link: `$ php artisan storage:link`
11. Start the server: `$ php artisan serve`
12. Open the web browser with this web address: http://localhost:8000, login with this account:
    ```
    email: admin@example.net
    password: password
    ```

