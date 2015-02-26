# Fourum #

Forum software, built responsibly on Laravel 5.

## Installation ##

Fourum development uses [Homestead](http://laravel.com/docs/5.0/homestead) for its development environment. Follow
the link to setup Homestead, then come back and continue.

To install Fourum, SSH into Homestead and do the following:

```
git clone git@github.com:fourum/fourum.git
composer install
```

Now you need to configure the database connection in the `.env` file. Make sure you create an empty database on your
MySQL instance first. Then:

```
php artisan install
```

That will setup the database tables and populate some basic data to get started with. You should now have a basic
Fourum setup working! Congrats!

## Package Development ##

Start by creating a new package:

```
php artisan make:package fourum/mypackage packages/mypackage
composer dump-autoload
```

That will create a basic structure in packages/mypackage with a service provider. Simply add that service provider to `config/app.php` and it should appear in `fourum.io/admin/packages`.
You can initialise a git repository inside `packages/mypackage` and develop it as you would any other library.