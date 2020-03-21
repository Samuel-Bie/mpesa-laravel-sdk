# MPesa Laravel SDK

[![Latest Version](https://img.shields.io/github/issues/Samuel-Bie/mpesa-laravel-sdk)](https://github.com/Samuel-Bie/mpesa-laravel-sdk/releases)

This is a fork of [this](https://github.com/abdulmueid/mpesa-php-api) package, some changes were made to be fully compatible  with laravel.

Mpesa Laravel SDK is a Laravel package that comunicates with Mpesa

```php
use samuelbie\mpesa\Transaction;
$mpesa = new Transaction();
$response = $mpesa->c2b('10','258845968745', 'reference' ,'unique_reference);
```

## Installing SDK

The recommended way to install is through
[Composer](https://getcomposer.org/).

```bash
composer require samuelbie/mpesa
```

## Methods available

C2B

```php
use samuelbie\mpesa\Transaction;
$mpesa = new Transaction();
$response = $mpesa->c2b('10','258845968745', 'reference' ,'unique_reference);
```

B2C

Signature
```php
   public function b2c(float $amount, string $msisdn, string $reference, string $third_party_reference): TransactionResponseInterface{}
```

Use
```php
use samuelbie\mpesa\Transaction;
$mpesa = new Transaction();

$response = $mpesa->b2c('10','258845968745', 'reference' ,'unique_reference);
```

