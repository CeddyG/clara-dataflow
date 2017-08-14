Clara dataflow
===============

## Installation

```php
composer require ceddyg/clara-dataflow
```

Add to your providers in 'config/app.php'
```php
CeddyG\ClaraDataflow\DataflowServiceProvider::class,
```

Then to publish the files.
```php
php artisan vendor:publish --provider="CeddyG\ClaraDataflow\DataflowServiceProvider"
```

## Use

