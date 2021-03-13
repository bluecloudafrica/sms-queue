<?php


namespace Bluecloud\SmsQueue\Models;


use Bluecloud\SmsQueue\Services\Messaging\SmsClient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'sq-messages';
    protected $guarded = [];

    public static function queue(string $msisdn, string $message): self
    {
        return self::create([
            'message' => $message,
            'msisdn' => $msisdn,
            'scheduled_at' => now()
        ]);
    }

    public function send(): self
    {
        (new SmsClient())->send($this->{'msisdn'}, $this->{'message'});
        $this->update(['delivered_at' => now()]);
        return $this;
    }
}
