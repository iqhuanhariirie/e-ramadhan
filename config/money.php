<?php

return [
    'currency_code' => env('MONEY_CURRENCY_CODE', 'RM'),

    'precision' => env('MONEY_PRECISION', 2),

    'decimal_separator' => env('MONEY_DECIMAL_SEPARATOR', '.'),

    'thousands_separator' => env('MONEY_THOUSANDS_SEPARATOR', ','),
];
