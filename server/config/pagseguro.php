<?php

return [
    'env' => env('PAGSEGURO_ENV', 'sandbox'),
    'email' => env('PAGSEGURO_EMAIL', 'suporte@lojamodelo.com.br'),
    'token' => env('PAGSEGURO_TOKEN', '57BE455F4EC148E5A54D9BB91C5AC12C'),
    'webhook' => env('PAGSEGURO_WEBHOOK_URL')
];
