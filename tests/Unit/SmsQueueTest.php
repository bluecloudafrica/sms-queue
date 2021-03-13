<?php


namespace Bluecloud\SmsQueue\Tests\Unit;


use Bluecloud\SmsQueue\Models\Message;
use Tests\TestCase;

class SmsQueueTest extends TestCase
{
    public function test_queue_sms()
    {
        Message::queue('0888123456', 'Test sms');

        $this->assertDatabaseCount('sq-messages', 1);
        $this->assertNotNull(Message::first()->{'scheduled_at'});
        $this->assertDatabaseHas('sq-messages', [
            'msisdn' => '0888123456',
            'message' => 'Test sms'
        ]);
    }
}
