<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Kafka Configuration
    |--------------------------------------------------------------------------
    |
    | Set your Kafka broker connection and topic here. These values are used
    | by the Kafka producer and (optionally) consumer service.
    |
    */

    'brokers' => env('KAFKA_BROKERS', '127.0.0.1:9092'),

    'topic' => env('KAFKA_TOPIC', 'trip-events'),

];
