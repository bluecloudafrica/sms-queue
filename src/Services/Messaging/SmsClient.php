<?php


namespace Bluecloud\SmsQueue\Services\Messaging;


class SmsClient
{
    private IMessenger  $messenger;

    public function __construct()
    {
        $this->messenger = app(IMessenger::class);
    }

    public function send(string $msisdn, string $message)
    {
        $this->messenger->send($msisdn, $message);
    }
}
