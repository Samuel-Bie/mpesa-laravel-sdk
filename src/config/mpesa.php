<?php
return [
    'provider_number' => env('MPESA_PROVIDER_NUMBER'),


    "c2b_endpoint"      => env('MPESA_C2B_ENDPOINT'),
    "b2c_endpoint"      => env('MPESA_B2C_ENDPOINT'),
    "query_endpoint"    => env('MPESA_Query_ENDPOINT'),
    "reversal_endpoint" => env('MPESA_Reversal_ENDPOINT'),



    "c2b_method" => env('MPESA_C2B_METHOD', "POST"),
    "b2c_method" => env('MPESA_B2C_METHOD', "POST"),
    "query_method" => env('MPESA_Query_METHOD', "GET"),
    "reversal_method" => env('MPESA_Reversal_METHOD', "PUT"),


    'public_key'            => env('MPESA_PUBLIC_KEY'),
    'api_host'              => env('MPESA_API_HOST'),
    'api_key'               => env('MPESA_API_KEY'),
    'origin'                => env('MPESA_ORIGIN', '*'),
    'service_provider_code' => env('MPESA_PROVIDER_NUMBER', '171717'),
    'initiator_identifier'  => env('MPESA_INITIATOR_IDENTIFIER'),
    'security_credential'   => env('MPESA_SECURITY_CREDENTIAL')
];
