Laravel Modules
===============

- [Upgrade Guide](#upgrade-guide)
- [Installation](#installation)
- [Configuration](#configuration)
- [Creating Module](#creating-a-module)
- [Artisan Commands](#artisan-commands)
- [Facades](#facades)
- [Entity](#entity)
- [Publishing Modules](#publishing-modules)

`pingpong/modules` is a laravel package which created to manage your large laravel app using modules. Module is like a laravel package, it have some views, controllers or models. This package is supported and tested in both Laravel 4 and Laravel 5.

<a name="upgrade-guide"></a>
## Upgrade Guide

#### From Laravel 4 to Laravel 5

If upgrade your Laravel app from Laravel 4 to Laravel 5, there is a few things to do if you are using this package. You will receive some kind errors about config not loaded. To fix this issue, please follow this instruction.

- If you publish the package's configuration file, you need to move the config file from `app/config/packages/pingpong/modules/config.php` to `app/config/modules.php`.
- If you are not publish the package's configuration file and you want to publish the config file, just run `php artisan vendor:publish` command and you are done. 

#### From 1.1.* to 1.2.0

New configuration file. This breaking change affected if you publish the configuration file from this package. To fix this issue, create new config file called `config.php` in your `app/config/packages/pingpong/modules/` directory. Next move the array contents from `paths.php` file to `paths` array in new configuration file.
Your config file will looks like [this](https://github.com/pingpong-labs/modules/blob/1.2.0/src/config/config.php).

<a name="installation"></a>
## Installation

To install through composer, simply put the following in your composer.json file:

```json
{
    "require": {
        "pingpong/modules": "2.0.*@dev"
    }
}
```

And then run `composer install` to fetch the package.

#### Quick Installation

You could also simplify the above code by using the following command:

```
composer require "pingpong/modules:2.0.*@dev"
```

#### Add Service Provider

Next add the following service provider in `config/app.php`.

```php
'providers' => array(

    // ...

    'Pingpong\Modules\ModulesServiceProvider'

),
```

Next publish the package's configuration file by run :

```
php artisan vendor:publish
```

#### Autoloading

By default controllers, entities or repositories not loaded automatically. You can autoload all that stuff using `psr-4`. For example :

```json
{
    "autoload": {
        "psr-4": {
            "Modules\\": "Modules"
        }
    }
}
```

<a name="configuration"></a>
## Configuration

- `modules` - Used for save the generated modules.
- `assets` - Used for save the modules's assets from each modules.
- `migration` - Used for save the modules's migrations if you publish the modules's migrations.
- `generator` - Used for generate modules folders.
- `scan` - Used for allow to scan other folders.
  - `enabled` - If `true`, the package will scan other paths. By default the value is `false`
  - `paths` - The list of path which can scanned automatically by the package.
- `composer`
  - `vendor` - Composer vendor name.
  - `author.name` - Composer author name.
  - `author.email` - Composer author email.
- `cache`
  - `enabled` - If `true`, the scanned modules (all modules) will cached automatically. By default the value is `false`
  - `key` - The name of cache.
  - `lifetime` - Lifetime of cache.

<a name="creating-a-module"></a>
## Creating A Module

To create a new module you can simply run :

```
php artisan module:make <module-name>
```

- `<module-name>` - Required. The name of module will be created.

**Create a new module**

```
php artisan module:make Blog
```

**Create multiple modules**

```
php artisan module:make Blog User Auth
```

**Naming Convension**

Because we are autoloading the modules using `psr-4`, we strongly recommend using `StudlyCase` convension.

**Folder Structure**

```
laravel-app/
  app/
  bootstrap/
  vendor/
  Modules/
    ├── Blog/
      ├── Assets/
      ├── Config/
      ├── Console/
      ├── Database/
          ├── Migrations/
          ├── Seeders/
      ├── Entities/
      ├── Http/
          ├── Controllers/
          ├── Filters/
          ├── Requests/
          ├── routes.php
      ├── Providers/
          ├── BlogServiceProvider.php
      ├── Resources/
          ├── lang/
          ├── views/
      ├── Repositories/
      ├── Tests/
      ├── composer.json
      ├── module.json
      ├── start.php
```

<a name="artisan-commands"></a>
## Artisan Commands

Create new module.

```
php artisan module:make blog
  ```

Use the specified module. Please see [#26](https://github.com/pingpong-labs/modules/pull/26).

```php
php artisan module:use blog
```

Show all modules in command line.

```
php artisan module:list
```
  
Create new command for the specified module.
  
  ```
  php artisan module:command CustomCommand blog

  php artisan module:command CustomCommand --command=custom:command blog

  php artisan module:command CustomCommand --namespace=Modules\Blog\Commands blog
  ```
  
Create new migration for the specified module.

  ```
  php artisan module:migration create_users_table blog

  php artisan module:migration create_users_table --fields="username:string, password:string" blog

  php artisan module:migration add_email_to_users_table --fields="email:string:unique" blog

  php artisan module:migration remove_email_from_users_table --fields="email:string:unique" blog

  php artisan module:migration drop_users_table blog
  ```

Rollback, Reset and Refresh The Modules Migrations.
```
  php artisan module:migrate-rollback

  php artisan module:migrate-reset

  php artisan module:migrate-refresh
```

Rollback, Reset and Refresh The Migrations for the specified module.
```
  php artisan module:migrate-rollback blog

  php artisan module:migrate-reset blog

  php artisan module:migrate-refresh blog
```
  
Create new seed for the specified module.

  ```
  php artisan module:seed-make users blog
  ```
  
Migrate from the specified module.

  ```
  php artisan module:migrate blog
  ```
  
Migrate from all modules.

  ```
  php artisan module:migrate
  ```
  
Seed from the specified module.

  ```
  php artisan module:seed blog
  ```
  
Seed from all modules.
 
  ```
  php artisan module:seed
  ```

Create new controller for the specified module.

  ```
  php artisan module:controller SiteController blog
  ```

Publish assets from the specified module to public directory.

  ```
  php artisan module:publish blog
  ```

Publish assets from all modules to public directory.

  ```
  php artisan module:publish
  ```

Create new model for the specified module.

  ```
  php artisan module:model User blog

  php artisan module:model User blog --fillable="username,email,password"
  ```

Create new service provider for the specified module.

  ```
  php artisan module:provider MyServiceProvider blog
  ```

Publish migration for the specified module or for all modules.
    This helpful when you want to rollback the migrations. You can also run `php artisan migrate` instead of `php artisan module:migrate` command for migrate the migrations.

For the specified module.
```
php artisan module:publish-migration blog
```

For all modules.
```
php artisan module:publish-migration
```

Enable the specified module.

```
php artisan module:enable blog
```

Disable the specified module.

```
php artisan module:disable blog
```

Generate new filter class.
```
php artisan module:filter-make AuthFilter
```

Update dependencies for the specified module.
```
php artisan module:update ModuleName
```

Update dependencies for all modules.
```
php artisan module:update
```

<a name="facades"></a>
## Facades

Get all modules.
```php
Module::all();
```

Get all cached modules.
```php
Module::getCached()
```

Get ordered modules. The modules will be ordered by the `priority` key in `module.json` file.
```php
Module::getOrdered();
```

Get scanned modules.
```php
Module::scan();
```

Find a specific module.
```php
Module::find('name');
// OR
Module::get('name');
```

Find a module, if there is one, return the `Module` instance, otherwise throw `Pingpong\Modules\Exeptions\ModuleNotFoundException`.
```php
Module::findOrFail('module-name');
```

Get scanned paths.
```php
Module::getScanPaths();
```

Get all modules as a collection instance.
```php
Module::toCollection();
```

Get modules by the status. 1 for active and 0 for inactive.
```php
Module::getByStatus(1);
```

Check the specified module. If it exists, will return `true`, otherwise `false`.
```php
Module::has('blog');
```

Get all enabled modules.
```php
Module::enabled();
```

Get all disabled modules.
```php
Module::disabled();
```

Get count of all modules.
```php
Module::count();
```

Get module path.
```php
Module::getPath();
```

Register the modules.
```php
Module::register();
```

Boot all available modules.
```php
Module::boot();
```

Get all enabled modules as collection instance.
```php
Module::collections();
```

Get module path from the specified module.
```php
Module::getModulePath('name');
```

Get assets path from the specified module.
```php
Module::getAssetPath('name');
```

Get config value from this package.
```php
Module::config('composer.vendor');
```

Get used storage path.
```php
Module::getUsedStoragePath();
```

Get used module for cli session.
```php
Module::getUsedNow();
// OR
Module::getUsed();
```

Set used module for cli session.
```php
Module::setUsed('name');
```

Get modules's assets path.
```php
Module::getAssetsPath();
```

Get asset url from specific module.
```php
Module::asset('blog:img/logo.img');
```

Install the specified module by given module name.
```php
Module::install('pingpong-modules/hello');
```

Update dependencies for the specified module.
```php
Module::update('hello');
```

<a name="entity"></a>
## Module Entity

Get an entity from a specific module.

```php
  $module = Module::get('blog');

  $module->getName();

  $module->getLowerName();

  $module->getStudlyName();

  $module->getPath();

  $module->getExtraPath('Assets');

  $module->enable();

  $module->disable();

  $module->delete();
```

<a name="namespaces"></a>
## Custom Namespaces
When you create a new module it also registers new custom namespace for `Lang`, `View` and `Config`. For example, if you create a new module named blog, it will also register new namespace/hint blog for that module. Then, you can use that namespace for calling `Lang`, `View` or `Config`. Following are some examples of its usage:

Calling Lang:
```php
Lang::get('blog::group.name');
```

Calling View:
```php
View::make('blog::index')

View::make('blog::partials.sidebar')
```

Calling Config:
```php
Config::get('blog.name')
```

## Publishing Modules

Have you created a laravel modules? Yes, I've. Then, I want to publish my modules. Where do I publish it? That's the question. What's the answer ? The answer is [Packagist](http://packagist.org). In pingpong/modules version >= 1.2.0, when you generate a module, you will see there is a new file generated called `composer.json`.

### Autoloading

By default the `vendor` directory is not not scanned automatically, you need to update the configuration file to allow that. Set `scan.enabled` value to `true`. For example :

```php
// file [laravel-app]/config/packages/pingpong/modules/paths.php

return [
   //...
   'scan' => [
     'enabled' => true
   ]
   //...
]
```

<a name="publishing-modules"></a>
## Publishing Modules

After creating a module and you are sure your module module will be used by other developers. You can push your module to [github](https://github.com) or [bitbucket](https://bitbucket.org) and after that you can submit your module to the packagist website.

You can follow this step to publish your module.

1. Create A Module.
2. Push the module to github.
3. Submit your module to the packagist website.
   Submit to packagist is very easy, just give your github repository, click submit and you done.