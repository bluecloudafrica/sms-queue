<?php

namespace Bluecloud\SmsQueue\Commands;

use Bluecloud\SmsQueue\Models\Message;
use Illuminate\Console\Command;

class SmsDeliveryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:send {--limit= : Send a specific number of messages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deliver messages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $limit = $this->option('limit') ? $this->option('limit') : config('sms-queue.deliveries_per_batch');

        Message::whereNull('delivered_at')->where('scheduled_at', '<=', now())->limit($limit)->get()
            ->each(function (Message $message) {
                $message->send();
            });
        return 0;
    }
}
