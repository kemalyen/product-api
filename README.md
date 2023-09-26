## Product API Application

This repository is under heavy development. Please, visit the repository later.

After cloning the repository, you should run compose to download and install the packages.  

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
You may run the test using the following command. THe tests are written using PEST.

```
php artisan test
```

### Updating or regenerating the API documentation
I use Open API / Swagger to generate the API docs. 

```
php artisan l5-swagger:generate
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
