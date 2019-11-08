# core
 
 ## Installation
 
 #### Clone this repository

```cli
git clone git@gitlab.com:witarsana/servhris.git
```

#### Composer

```cli
composer install 	
```

## Configuration

#### Environment

Copy `.env.example` to `.env`.

```cli
cp .env.example .env
```

#### Setup database

Once this app is installed, you should also configure your database.

```
DB_CONNECTION=main
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=servhris
DB_USERNAME=root
DB_PASSWORD=secret
```


#### Installing

Next, you should run the `install` command. This command will setup all commands (please check `app\Console\Commands\Dev\Install.php`).

```cli
php artisan install
```


## Usage

#### Create Company

```cli
php artisan make:company
```
