## Laravel 5.3 Uniqueable Jobs

### Install

Require this package with composer using the following command:

```bash
composer require "enimiste/laravel-uniqueable-jobs-l53:5.3.*"
```

After updating composer, add the service provider to the `providers` array in `config/app.php`

```php
Com\NickelIT\UniqueableJobs\UniqueableJobsServiceProvider::class,
```

And replace `Illuminate\Bus\BusServiceProvider::class` by `Com\NickelIT\UniqueableJobs\BusServiceProvider::class`

Publish migration : 
```bash
php artisan queue:table
php artisan vendor:publish --tag=migrations
```

In your Jobs classes use  `Com\NickelIT\UniqueableJobs\Uniqueable` instead of the default ones.  
NB : This trait should be used directly in the job class and not in the base class if exists.  

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

The Laravel 5.3 Uniqueable Jobs is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
