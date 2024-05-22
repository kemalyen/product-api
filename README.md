## Product API Application

This repository is under heavy development. Please, visit the repository later.

After cloning the repository, you should run composer to download and install the packages.  

```
composer install
```

Rename `.env.sample` to `.env` . Run the migrator with the database seeder. This will create an SQLite database with some sample data.

```
php artisan migrate --seed
```

Start the built-in server to run the application 

```
php artisan serve 
```


### Running test
You may run the test using the following command. The tests are written using PEST.

```
php artisan test
``` 

### API Documentation
![api-docs](https://github.com/kemalyen/product-api/assets/1696570/3c3f1e06-34e5-4f12-9a6d-9be9cc9ff6f1)

Postman Collection (https://github.com/kemalyen/product-api/blob/main/public/docs/collection.json)

Open API (https://github.com/kemalyen/product-api/blob/main/public/docs/openapi.yaml)

Web-based documents are located at HTTP://localhost/docs/index.html

If you want to re-generate your API, simple just run following command:

```
php artisan scribe:generate
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
