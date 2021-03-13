<?php

namespace Bluecloud\SmsQueue\Services\Messaging;

interface IMessenger
{
    public function send(string $msisdn, string $message): void;
}
