# logs-viewer
============

## Compatible
Log Viewer for Laravel 10 

## Install via composer
```bash
composer require Vietstars/logs-viewer
```

## Add the following in `bootstrap/app.php`:
```php
$app->register(\Vietstars\LogsViewer\LogsViewerServiceProvider::class);
```

## Explicitly set the namespace in `app/Http/routes.php`:
```php
$router->group(['namespace' => '\Vietstars\LogsViewer'], function() use ($router) {
    $router->get('logs', 'LogsViewerController@index');
});
```

## Customize view
Publish `log.blade.php` into `/resources/views/vendor/logs-viewer/` for view customization:

```bash
php artisan vendor:publish \
  --provider="Vietstars\LogsViewer\LogsViewerServiceProvider" \
  --tag=views
``` 

## Edit configuration
Publish `logviewer.php` configuration file into `/config/` for configuration customization:

```bash
php artisan vendor:publish \
  --provider="Vietstars\LogsViewer\LogsViewerServiceProvider"
``` 
