# Laravel Multisite

[![Latest Version on Packagist](https://img.shields.io/packagist/v/appstract/laravel-multisite.svg?style=flat-square)](https://packagist.org/packages/appstract/laravel-multisite)
[![Total Downloads](https://img.shields.io/packagist/dt/appstract/laravel-multisite.svg?style=flat-square)](https://packagist.org/packages/appstract/laravel-multisite)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/appstract/laravel-multisite/master.svg?style=flat-square)](https://travis-ci.org/appstract/laravel-multisite)

With this package it is possible to build multiple sites/(sub)domains on one codebase.

## Installation

You can install the package via composer:

```bash
composer require appstract/laravel-multisite
```

### Provider

Then add the ServiceProvider to your `config/app.php` file:

```php
'providers' => [
    ...

    Appstract\Multisite\MultisiteServiceProvider::class,

    ...
],
```

### Config (hosts, homestead)

You need to add the sites to your `/etc/hosts` file and `Homestead.yaml`. For example, `mywebsite.dev` and `blog.mywebsite.dev`. In the `Homestead.yaml, you need to map the sites to the same folder.

### Publish

By running `php artisan vendor:publish --provider="Appstract\Multisite\MultisiteServiceProvider"` in your project all files for multisite will be published. The files that will be published are: a migration, a seeder and a config file.

### Seeder

The seeder will be published but needs to be run when running `php artisan db:seed`, so you need the add `$this->call(SitesTableSeeder::class);` to your `DatabaseSeeder.php` file. After migrating and seeding the sites are now present in the database.

## Usage

This is the main part, within your `routes/web.php` you can set routes for your sites within route groups, like this:

```php
Route::group([
    'domain' => 'blog.'.config('multisite.host'),
    'as' => 'blog.',
    'middleware' => 'site:blog'
], function () {

    Route::get('/', 'BlogController@homepage')->name('homepage');

});
```

The magic happens with the site middleware `site:blog`. This will tell your app that the routes within the group are belonging to the blog. It will provide a variable called `$currentSite` in all your views. There is also a config available, which you can access with `Config::get('multisite.site')`.

## Testing

``` bash
$ composer test
```

## Contributing

Contributions are welcome, [thanks to y'all](https://github.com/appstract/laravel-multisite/graphs/contributors) :)

## About Appstract

Appstract is a small team from The Netherlands. <3 Laravel, Vue and other awesome tools.

## Buy Us A Beer

Would be awesome if you would [buy us a beer](https://www.paypal.me/teamappstract/10)! Or [a lot of beer](https://www.patreon.com/appstract) :)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
