<?php


namespace Bluecloud\SmsQueue\Services\Messaging;


use Illuminate\Support\Facades\Http;

class Messenger implements IMessenger
{
    public function send(string $msisdn, string $message): void
    {
        $url = config('sms-queue.messenger_url');
        Http::post($url, ['phone' => $msisdn, 'message' => $message]);
    }
}
