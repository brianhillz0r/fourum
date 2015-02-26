# Fourum #

Forum software, built responsibly.

## Package Development ##

Start by creating a new package:

```
php artisan make:package fourum/mypackage packages/mypackage
composer dump-autoload
```

That will create a basic structure in packages/mypackage with a service provider. Simply add that service provider to `config/app.php` and it should appear in `fourum.io/admin/packages`.
You can initialise a git repository inside `packages/mypackage` and develop it as you would any other library.