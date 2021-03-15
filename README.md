# Sms Queue

Queue messages from your Laravel app to your SMS API. 

DISCLAIMER This package does not handle the actual sending of the messages to the recepient. You will need an SMS solution for that. This will however ease the task of scheduling and queueing an SMS from anywhere in your code

## Quick Guide

Install the package via composer

```terminal
composer require bluecloud/sms-queue
```
Publish package service provider
```terminal
php artisan vendor:publish --provider=Bluecloud\SmsQueue\SmsQueueServiceProvider
```
Run the migrations to create sms queue table
```terminal
php artisan migrate
```

### Queueing messages

```php
use Bluecloud\SmsQueue\Models\Message;

Message::queue('0888800800', 'Test message');
Message::queue('0888800800', 'Test message', '2021-03-13 09:30:00');
```

### Sending messages

```terminal
php artisan sms:send
```

To limit the number of messages to send per batch set the env variable `SMS_QUEUE_DELIVERIES_PER_BATCH`. 

To set a one-time limit use `php artisan sms:send --limit=10`

You can schedule the messages to be sent at an interval with Laravel Scheduler

```php
// app/Console/Kernel.php

use Illuminate\Console\Scheduling\Schedule;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sms:send')->everyMinute()->runInBackground();
    }
}

```

### Configuration
To set your config, create the following entries in your env file and replace the default values as desired
```dotenv
SMS_QUEUE_DELIVERIES_PER_BATCH=100

SMS_QUEUE_MESSENGER_URL=http://localhost
```
