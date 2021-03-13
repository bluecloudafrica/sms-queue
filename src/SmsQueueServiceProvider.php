<?php

namespace Bluecloud\SmsQueue;

use Bluecloud\SmsQueue\Commands\SmsDeliveryCommand;
use Bluecloud\SmsQueue\Services\Messaging\IMessenger;
use Bluecloud\SmsQueue\Services\Messaging\Messenger;
use Illuminate\Support\ServiceProvider;

class SmsQueueServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IMessenger::class, Messenger::class);
        $this->mergeConfigFrom(
            __DIR__.'/config/sms-queue.php', 'sms-queue'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->publishes([
            __DIR__.'/config/sms-queue.php' => config_path('sms-queue.php'),
        ]);
        if ($this->app->runningInConsole()) {
            $this->commands([
                SmsDeliveryCommand::class,
            ]);
        }
    }
}
