<p align="center"><img src="https://samuel-bie.github.io/images/larapesa.png" width="400"></p>

<p align="center">
<a href="https://packagist.org/packages/samuelbie/mpesa"><img src="https://poser.pugx.org/samuelbie/mpesa/v" alt="Ultima Versão estável"></a>
<a href="https://packagist.org/packages/samuelbie/mpesa"><img src="https://poser.pugx.org/samuelbie/mpesa/downloads" alt="Total Downloads"></a>
<a href="https://github.com/Samuel-Bie/mpesa-laravel-sdk/issues"><img alt="GitHub issues" src="https://img.shields.io/github/issues/Samuel-Bie/mpesa-laravel-sdk"></a>
<a href="https://github.com/Samuel-Bie/mpesa-laravel-sdk/network"><img alt="GitHub forks" src="https://img.shields.io/github/forks/Samuel-Bie/mpesa-laravel-sdk"></a>
<a href="https://github.com/Samuel-Bie/mpesa-laravel-sdk/stargazers"><img alt="GitHub stars" src="https://img.shields.io/github/stars/Samuel-Bie/mpesa-laravel-sdk"></a>
<a href="https://packagist.org/packages/samuelbie/mpesa"><img src="https://poser.pugx.org/samuelbie/mpesa/license" alt="License"></a>
<a href="https://twitter.com/intent/tweet?text=Wow:&url=https%3A%2F%2Fgithub.com%2FSamuel-Bie%2Fmpesa-laravel-sdk"><img alt="Twitter" src="https://img.shields.io/twitter/url?label=Samuel%20Bi%C3%A9&style=social&url=https%3A%2F%2Ftwitter.com%2FSamuelbie"></a>

</p>

# **MPesa Laravel SDK**

Laravel MPESA SDK é como o próprio nome diz um SDK para pagamentos Online Via MPESA.

A partir deste SDK é possivel comunicar com o [Open-api](https://developer.mpesa.vm.co.mz) e executar operações de coleta de valores, transferencias, pesquisa e outras possibilidadades disponibilizadas pelo Mpesa.

## Instalação

O método de instalação mais basico é usando o gestor de dependências [Composer](https://getcomposer.org/).

```bash
composer require samuelbie/mpesa
```

Ou por outra basta adicionar ao suas dependencias(***composer.json***):


```json
"samuelbie/mpesa": "^1.3",
```

e depois executar o comando:

```bash
composer update
```


## Configuração

Todas as suas configurações estarão guardas no ficheiro interno de configuração **mpesa.php** com o aspecto:

```php
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
```

Neste caso o passar todas as suas credenciais locais ou de produção no seu ficheiro **.env** anexe as seguintes chaves.

```env
MPESA_API_HOST='api.vm.co.mz' #ou api.sandbox.vm.co.mz
MPESA_API_KEY = 'api Key'
MPESA_PUBLIC_KEY = 'Chave Pubica='
MPESA_PROVIDER_NUMBER='171700'
MPESA_ORIGIN='*'
MPESA_INITIATOR_IDENTIFIER='JMhMnVM3dddddRMA3'
MPESA_SECURITY_CREDENTIAL='Sp0ng3dddd'
```


## Utilização


### Métodos disponíveis

#### [Coleta  (C2B)](https://developer.mpesa.vm.co.mz/apis/3/3)

Assinatura
```php

/**
* Initiates a C2B transaction on the M-Pesa API.
* @param float $amount Valor
* @param string $msisdn numero de telefone (Ex: 847386187 / +258850233654)
* @param string $reference Referencia da transacao. Ex: Compra de Modem 3G
* @param string $third_party_reference  Referencia única da transacao. Ex: 1285GVHss
* @return TransactionResponseInterface
* @throws Exception
 */
public function c2b(float $amount, string $msisdn, string $reference, string $third_party_reference): TransactionResponseInterface

```

Exemplo

```php

use samuelbie\mpesa\Transaction;
$mpesa = new Transaction();
$response = $mpesa->c2b('10','258845968745', 'reference' ,'unique_reference');

```


#### [Transferencia para cliente  (B2C)](https://developer.mpesa.vm.co.mz/apis/5/3)


Signature

```php

/**
 * Initiates a B2C transaction on the M-Pesa API.
 * @param float $amount Valor
 * @param string $msisdn numero de telefone (Ex: 847386187 / +258850233654)
 * @param string $reference Referencia da transacao. Ex: Pagamento de comissao de venda
 * @param string $third_party_reference  Referencia única da transacao. Ex: 1285GVHss
 * @return TransactionResponseInterface
 * @throws Exception
 */
public function b2c(float $amount, string $msisdn, string $reference, string $third_party_reference): TransactionResponseInterface

```

Exemplo

```php

use samuelbie\mpesa\Transaction;
$mpesa = new Transaction();
$response = $mpesa->b2c('10','258845968745', 'Comissao' ,'unique_reference');
```

#### [Transferencia para Entidade (B2B)](https://developer.mpesa.vm.co.mz/apis/4/3)

#### [Reverção  (Reversal)](https://developer.mpesa.vm.co.mz/apis/2/3)

Assinatura

```php

    /**
     * Initiates a Reversal transaction on the M-Pesa API.
     * @param float $amount Valor a ser revertido
     * @param string $transaction_id ID Transascao que precisa ser revertida
     * @param string $third_party_reference  Referencia única da transacao. Ex: 1285GVHss
     * @return TransactionResponseInterface
    */
    public function reversal(
        float $amount,
        string $transaction_id,
        string $third_party_reference
    ): TransactionResponseInterface
```

Exemplo

```php
use samuelbie\mpesa\Transaction;
$mpesa = new Transaction();
$response = $mpesa->reversal(10,'ACK19SSS', 'Agua2020');
```

#### [Consulta de estado  (Query Transaction Status)](https://developer.mpesa.vm.co.mz/apis/1/3/)

```php
/**
 * Initiates a transaction Query on the M-Pesa API.
 * @param string $query_reference Transaction id/ Conversation ID (Gerado pelo MPesa)
 * @param string $third_party_reference  Referencia única da transacao (Gerado pelo sistema de terceiro). Ex: 1285GVHss
 * @return TransactionResponseInterface
*/
public function query(string $query_reference, string $third_party_reference): TransactionResponseInterface
```

Exemplo

```php
use samuelbie\mpesa\Transaction;
$mpesa = new Transaction();
$response = $mpesa->query('56b97c7a59dd40738843ca7234796c4d', 'Agua2020');
```



### Resultados

Todas as operações de ou métodos disponiveis retornam um objecto de ***TransactionResponseInterface***, esta interface ordena que os que a implementam, implementem os métodos:

```php
    /**
     * Returns the Response Code
     *
     * @return string
     */
    public function getCode(): string;

    /**
     * Returns the response description
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Returns the TransactionID
     *
     * @return string
     */
    public function getTransactionID(): string;

    /**
     * Returns the Conversation ID
     *
     * @return string
     */
    public function getConversationID(): string;

    /**
     * Returns the Transaction Status from Query API
     *
     * @return string
     */
    public function getTransactionStatus(): string;

    /**
     * Returns the raw response from M-Pesa API
     *
     * @return string
     */
    public function getResponse(): string;

    /**
     * Returns the Response Code
     * @return string
     */
    public function getStatusCode(): string;


    /**
     * Returns the JSON response from M-Pesa API
     * @return string
     */
    public function getBody();

```

## Recomendações

É recomendado que q acima de tudo o usuário desta biblioteca leia a documentação do [Open-Api](https://developer.mpesa.vm.co.mz) e entenda o principio de funcionamento desta, para que possa entender os códigos de respostas, e as mensagens.


## Contributo

Desde ja queremos agradecer aos criadores do pacote para PHP [abdulmueid\mpesa](https://github.com/abdulmueid/mpesa-php-api), uma vez que este pacote é uma adaptação do pacote por eles criados. Aqui vai meu Kanimanbo a vocês

## Vulnerabilidades de Segurança

Se descobrires alguma vulnerabilidade neste pacote, por favor envie um email para Samuel Bié via [samuel.bie75@gmail.com](mailto:samuel.bie75@gmail.com). Todas as falhas de segurança serão devidamente analizadas e tratadas.

## Licença

Mpesa Laravel SDK é de codigo livre sob licença [MIT license](https://opensource.org/licenses/MIT).

