<?php


namespace Bluecloud\SmsQueue\Tests\Feature;

use Bluecloud\SmsQueue\Models\Message;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DeliverMessagesTest extends TestCase
{
    use WithFaker;

    public function test_deliver_messages()
    {
        Http::fake([config('sms-queue.messenger_url') => Http::response([], Response::HTTP_OK)]);

        $message = Message::create([
            'message' => 'This is a test message',
            'msisdn' => '0880000000',
            'scheduled_at' => now()
        ]);

        $this->artisan('sms:send')->assertExitCode(0)->run();

        $this->assertNotNull($message->fresh()->{'delivered_at'});

        Http::assertSent(function (Request $request) {
            return $request->url() == config('sms-queue.messenger_url') &&
                $request['phone'] == '0880000000' &&
                $request['message'] == 'This is a test message';
        });
    }
}
