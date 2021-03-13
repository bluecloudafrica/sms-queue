<?php


namespace Bluecloud\SmsQueue\Models;


use Bluecloud\SmsQueue\Services\Messaging\SmsClient;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'sq-messages';
    protected $guarded = [];

    public static function queue(string $msisdn, string $message, $schedule_at = null): self
    {
        $schedule_at = $schedule_at ? Carbon::parse($schedule_at) : now();
        return self::create([
            'message' => $message,
            'msisdn' => $msisdn,
            'scheduled_at' => $schedule_at
        ]);
    }

    public function send(): self
    {
        (new SmsClient())->send($this->{'msisdn'}, $this->{'message'});
        $this->update(['delivered_at' => now()]);
        return $this;
    }
}
