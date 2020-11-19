<?php
return [
    /*
    |--------------------------------------------------------------------------
    | API host of M-Pesa API
    |--------------------------------------------------------------------------
    |
    | Here you may specify the API host provided by Vodacom for API operations
    |
    */
    'api_host'              => env('MPESA_API_HOST', 'api.sandbox.vm.co.mz'),

    /*
    |--------------------------------------------------------------------------
    | Public key for use in M-Pesa API
    |--------------------------------------------------------------------------
    |
    | Here you may specify the public key provided by Vodacom to you
    |
    */
    'public_key'            => env('MPESA_PUBLIC_KEY'),
    /*
    |--------------------------------------------------------------------------
    | API Key of M-Pesa API
    |--------------------------------------------------------------------------
    |
    | Here you may specify the API key provided by Vodacom to you
    |
    */
    'api_key'               => env('MPESA_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Origin of M-Pesa API
    |--------------------------------------------------------------------------
    |
    |
    */
    'origin'                => env('MPESA_ORIGIN', '*'),

    /*
    |--------------------------------------------------------------------------
    | Service Provider Code of M-Pesa API
    |--------------------------------------------------------------------------
    |
    | Here you may specify the service provider code of M-Pesa provided by Vodacom to you
    |
    */
    'service_provider_code' => env('MPESA_PROVIDER_NUMBER', '171717'),

    /*
    |--------------------------------------------------------------------------
    | Initiator Identifier of M-Pesa API
    |--------------------------------------------------------------------------
    |
    | Here you may the initiator identifier provided by Vodacom to you
    |
    */
    'initiator_identifier'  => env('MPESA_INITIATOR_IDENTIFIER'),

    /*
    |--------------------------------------------------------------------------
    | Security credential of M-Pesa API
    |--------------------------------------------------------------------------
    |
    | Here you may specify the security credential provided by Vodacom to you
    |
    */
    'security_credential'   => env('MPESA_SECURITY_CREDENTIAL'),


    "c2b_endpoint"          => env('MPESA_C2B_ENDPOINT', ':18352/ipg/v1x/c2bPayment/singleStage/'),
    "b2c_endpoint"          => env('MPESA_B2C_ENDPOINT', ':18345/ipg/v1x/b2cPayment/'),
    "query_endpoint"        => env('MPESA_Query_ENDPOINT', ':18353/ipg/v1x/queryTransactionStatus/'),
    "reversal_endpoint"     => env('MPESA_Reversal_ENDPOINT', ':18354/ipg/v1x/reversal/'),

    "c2b_method"        => env('MPESA_C2B_METHOD', "POST"),
    "b2c_method"        => env('MPESA_B2C_METHOD', "POST"),
    "query_method"      => env('MPESA_Query_METHOD', "GET"),
    "reversal_method"   => env('MPESA_Reversal_METHOD', "PUT"),
];
