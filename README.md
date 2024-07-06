
# Application Name

Brief description of the application.

## Prerequisites

- [PHP](https://www.php.net/) >= 8.1
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) with npm
- [MySQL](https://www.mysql.com/) or another database supported by Laravel

## Installation

### 1. Clone the repository

```sh
git clone https://github.com/your-repo/application-name.git
cd application-name
```

### 2. Install PHP dependencies

```sh
composer install
```

### 3. Copy the `.env.example` file to `.env`

```sh
cp .env.example .env
```

### 4. Generate the application key

```sh
php artisan key:generate
```

### 5. Configure the database

Open the `.env` file and configure your database connection settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6. Migrate and seed the database

```sh
php artisan migrate --class="WorldSeeder"
php artisan migrate
```

### 7. Install JavaScript dependencies

```sh
npm install
```

### 8. Compile the assets

```sh
npm run dev
```
### 9. update.env file
Add the following keys to your .env file

#### Stripe :
```sh
STRIPE_SK= *your_stripe_secret_key*
STRIPE_PK= *your_stripe_public_key*
```



## Usage

### Start the development server

```sh
php artisan serve
```

The application will be accessible at [http://localhost:8000](http://localhost:8000).

## Tests

### Run the tests

Make sure your test database is configured in the `.env.testing` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_test_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Then run the tests:

```sh
php artisan test
```

If the test results in a db error, run the following command:

```sh
php artisan migrate --env=testing
php artisan db:seed --class="WorldSeeder" --env=testing
php artisan db:seed --env=testing
```
