<?php
return [

    'api_host'              => env('MPESA_API_HOST', 'api.sandbox.vm.co.mz'),

    "c2b_endpoint"          => env('MPESA_C2B_ENDPOINT', 'https://api.sandbox.vm.co.mz:18352/ipg/v1x/c2bPayment/singleStage/'),
    "b2c_endpoint"          => env('MPESA_B2C_ENDPOINT', 'https://api.sandbox.vm.co.mz:18345/ipg/v1x/b2cPayment/'),
    "query_endpoint"        => env('MPESA_Query_ENDPOINT', 'https://api.sandbox.vm.co.mz:18353/ipg/v1x/queryTransactionStatus/'),
    "reversal_endpoint"     => env('MPESA_Reversal_ENDPOINT', 'https://api.sandbox.vm.co.mz:18354/ipg/v1x/reversal/'),

    "c2b_method"        => env('MPESA_C2B_METHOD', "POST"),
    "b2c_method"        => env('MPESA_B2C_METHOD', "POST"),
    "query_method"      => env('MPESA_Query_METHOD', "GET"),
    "reversal_method"   => env('MPESA_Reversal_METHOD', "PUT"),


    'public_key'            => env('MPESA_PUBLIC_KEY'),
    'api_key'               => env('MPESA_API_KEY'),
    'origin'                => env('MPESA_ORIGIN', '*'),

    'service_provider_code' => env('MPESA_PROVIDER_NUMBER', '171717'),

    'initiator_identifier'  => env('MPESA_INITIATOR_IDENTIFIER'),
    'security_credential'   => env('MPESA_SECURITY_CREDENTIAL'),

    'mpesa_percentage_fee' => env('MPESA_FEE', 3)
];
