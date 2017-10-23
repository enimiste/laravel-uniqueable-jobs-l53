## Laravel 5.3 Uniqueable Jobs

### Install

Require this package with composer using the following command:

```bash
composer require enimiste/laravel-uniqueable-jobs-l53
```

After updating composer, add the service provider to the `providers` array in `config/app.php`

```php
Com\NickelIT\UniqueableJobs\UniqueableJobsServiceProvider::class,
```

And replace `Illuminate\Bus\BusServiceProvider::class` by `Com\NickelIT\UniqueableJobs\BusServiceProvider::class`

Publish migration : 
```bash
php artisan vendor:publish --provider=Com\NickelIT\UniqueableJobs\UniqueableJobsServiceProvider
```

In your Jobs classes use  `Com\NickelIT\UniqueableJobs\Uniqueable` instead of the default ones.

To ensure that a given job will be stored in the database once per model and model id you use `->unique(Model::class, $model->id)` on the job instance or after calling `dispatch()` method like :
```php
$u = User::first();
    $job = new DoSomething('Hello from unique job ' . $u->email);
    $job->unique(User::class, $u->id);
    dispatch($job);
    
    $job = new DoSomething('Hello from unique job ' . $u->email);
    $job->unique(User::class, $u->id);
    dispatch($job);
//In this case the job will be stored once if it was already in the db
```

### License

The Laravel IDE Helper Generator is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

[link-packagist]: https://packagist.org/packages/enimiste/laravel-uniqueable-jobs-l53
[link-author]: https://github.com/enimiste
[link-contributors]: ../../contributors