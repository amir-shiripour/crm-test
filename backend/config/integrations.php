<?php
return [
  'sentry' => [
    'dsn' => env('SENTRY_DSN', ''),
    'enabled' => env('SENTRY_ENABLED', false),
  ],
  'pusher' => [
    'key' => env('PUSHER_APP_KEY', ''),
    'secret' => env('PUSHER_APP_SECRET', ''),
    'app_id' => env('PUSHER_APP_ID', ''),
    'cluster' => env('PUSHER_APP_CLUSTER', 'mt1'),
  ],
];
