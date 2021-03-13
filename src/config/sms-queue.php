<?php

return [
    'deliveries_per_batch' => env('SMS_QUEUE_DELIVERIES_PER_BATCH', 100),
    'messenger_url' => env('SMS_QUEUE_MESSENGER_URL', 'http://localhost')
];
