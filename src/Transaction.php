<?php

namespace Samuelbie\Mpesa;

use Exception;
use GuzzleHttp\Client;
use Samuelbie\Mpesa\Config;
use Samuelbie\Mpesa\TransactionResponse;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;
use Samuelbie\Mpesa\Helpers\ValidationHelper;
use Samuelbie\Mpesa\Interfaces\ConfigInterface;
use GuzzleHttp\Exception\TooManyRedirectsException;
use Samuelbie\Mpesa\Interfaces\TransactionInterface;
use Samuelbie\Mpesa\Interfaces\TransactionResponseInterface;

/**
 * Transaction Class implements all API calls as per Transaction Interface
 *
 * @author      Abdul Mueid Akhtar <abdul.mueid@gmail.com>
 * @copyright   Copyright (c) Abdul Mueid akhtar
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/abdulmueid/mpesa-php-api
 */

class Transaction implements TransactionInterface
{
    /**
     * The configuration class
     * @var ConfigInterface
     */
    private $config;
    private $headers;

    /**
     * Transaction constructor.
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config = null)
    {
        $config = $config ? $config : new Config();
        $this->config = $config;

        $this->headers = [
            'Origin' => '*',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }

    private function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * Initiates a C2B transaction on the M-Pesa API.
     * @param float $amount Valor
     * @param string $msisdn numero de telefone (Ex: 847386187 / +258850233654)
     * @param string $reference Referencia da transação. Ex: Compra de Modem 3G
     * @param string $third_party_reference  Referencia única da transação. Ex: 1285GVHss
     * @return TransactionResponseInterface
     * @throws Exception
     */
    public function c2b(
        float $amount,
        string $msisdn,
        string $reference,
        string $third_party_reference
    ): TransactionResponseInterface {
        $msisdn = ValidationHelper::normalizeMSISDN($msisdn);
        $amount = round($amount, 2);

        $endpoint = $this->getConfig()->generateURI(config('mpesa.c2b_endpoint'));
        $method = config('mpesa.c2b_method');

        $payload = [
            'input_ServiceProviderCode' => $this->config->getServiceProviderCode(),
            'input_CustomerMSISDN' => $msisdn,
            'input_Amount' => $amount,
            'input_TransactionReference' => $reference,
            'input_ThirdPartyReference' => $third_party_reference
        ];

        $headers = array_merge($this->headers, [
            'Authorization' => $this->config->getBearerToken(),
            'Origin' => $this->config->getOrigin(),
        ]);

        $options = [
            'headers' => $headers,
            // one of the following is enough to send the request
            'form_params' => $payload,
            'json' => $payload,
        ];

        return $this->executeRequest($method, $endpoint, $options);
    }

    /**
     * Initiates a B2C transaction on the M-Pesa API.
     * @param float $amount Valor
     * @param string $msisdn numero de telefone (Ex: 847386187 / +258850233654)
     * @param string $reference Referencia da transação. Ex: Pagamento de comissão de venda
     * @param string $third_party_reference  Referencia única da transação. Ex: 1285GVHss
     * @return TransactionResponseInterface
     * @throws Exception
     */
    public function b2c(
        float $amount,
        string $msisdn,
        string $reference,
        string $third_party_reference
    ): TransactionResponseInterface {
        $msisdn = ValidationHelper::normalizeMSISDN($msisdn);
        $amount = round($amount, 2);


        $endpoint = $this->getConfig()->generateURI(config('mpesa.b2c_endpoint'));

        $method = config('mpesa.b2c_method');
        $payload = [
            'input_ServiceProviderCode' => $this->getConfig()->getServiceProviderCode(),
            'input_CustomerMSISDN' => $msisdn,
            'input_Amount' => $amount,
            'input_TransactionReference' => $reference,
            'input_ThirdPartyReference' => $third_party_reference
        ];

        $headers = array_merge($this->headers, [
            'Authorization' => $this->config->getBearerToken(),
            'Origin' => $this->config->getOrigin(),
        ]);


        $options = [
            'headers' => $headers,
            // one of the following is enough to send the request
            'form_params' => $payload,
            'json' => $payload,
        ];

        return $this->executeRequest($method, $endpoint, $options);
    }

    /**
     * Initiates a B2B transaction on the M-Pesa API.
     * @param float $amount
     * @param string $receiver_party_code
     * @param string $reference
     * @param string $third_party_reference  Referencia única da transação. Ex: 1285GVHss
     * @return TransactionResponseInterface
     */
    public function b2b(
        float $amount,
        string $receiver_party_code,
        string $reference,
        string $third_party_reference
    ): TransactionResponseInterface {
        $amount = round($amount, 2);
        $endpoint = $this->getConfig()->generateURI(config('mpesa.b2b_endpoint'));

        $method = config('mpesa.b2b_method');

        $payload = [
            'input_Amount' => $amount,
            'input_TransactionReference' => $reference,
            'input_ThirdPartyReference' => $third_party_reference,
            'input_PrimaryPartyCode' => $this->getConfig()->getServiceProviderCode(),
            'input_ReceiverPartyCode' => $receiver_party_code,
        ];

        $headers = array_merge($this->headers, [
            'Authorization' => $this->getConfig()->getBearerToken(),
            'Origin' => $this->getConfig()->getOrigin(),
        ]);

        $options = [
            'headers' => $headers,
            // one of the following is enough to send the request
            'form_params' => $payload,
            'json' => $payload,
        ];

        return $this->executeRequest($method, $endpoint, $options);
    }

    /**
     * Initiates a Reversal transaction on the M-Pesa API.
     * @param float $amount Valor a ser revertido
     * @param string $transaction_id ID Transação que precisa ser revertida
     * @param string $third_party_reference  Referencia única da transação. Ex: 1285GVHss
     * @return TransactionResponseInterface
     */
    public function reversal(
        float $amount,
        string $transaction_id,
        string $third_party_reference
    ): TransactionResponseInterface {
        $amount = round($amount, 2);

        $endpoint = $this->getConfig()->generateURI(config('mpesa.reversal_endpoint'));
        $method = config('mpesa.reversal_method');

        $payload = [
            'input_Amount' => $amount,
            'input_TransactionID' => $transaction_id,
            'input_ThirdPartyReference' => $third_party_reference,
            'input_ServiceProviderCode' => $this->getConfig()->getServiceProviderCode(),
            'input_InitiatorIdentifier' => $this->getConfig()->getInitiatorIdentifier(),
            'input_SecurityCredential' => $this->getConfig()->getSecurityCredential(),

        ];

        $headers = array_merge($this->headers, [
            'Authorization' => $this->config->getBearerToken(),
            'Origin' => $this->config->getOrigin(),
        ]);

        $options = [
            'headers' => $headers,
            // one of the following is enough to send the request
            'form_params' => $payload,
            'json' => $payload,
        ];

        return $this->executeRequest($method, $endpoint, $options);
    }

    /**
     * Initiates a transaction Query on the M-Pesa API.
     * @param string $query_reference Transaction id/ Conversation ID (Gerado pelo MPesa)
     * @param string $third_party_reference  Referencia única da transação (Gerado pelo sistema de terceiro).
     *  Ex: 1285GVHss
     * @return TransactionResponseInterface
     */
    public function query(
        string $query_reference,
        string $third_party_reference
    ): TransactionResponseInterface {
        $payload = [
            'input_QueryReference' => $query_reference,
            'input_ServiceProviderCode' => $this->getConfig()->getServiceProviderCode(),
            'input_ThirdPartyReference' => $third_party_reference
        ];

        $endpoint = $this->getConfig()->generateURI(config('mpesa.query_endpoint'));

        $method = config('mpesa.query_method');

        $headers = array_merge($this->headers, [
            'Authorization' => $this->getConfig()->getBearerToken(),
            'Origin' => $this->getConfig()->getOrigin(),
        ]);

        $options = [
            'headers' => $headers,
            'query' => $payload,
        ];
        return $this->executeRequest($method, $endpoint, $options);
    }


    private function executeRequest($method, $endpoint, $options): TransactionResponseInterface
    {
        $options = array_merge($options, [
            // TODO We have to check this
            'connect_timeout' => 120,
        ]);
        // dd($options);
        try {
            //code...
            $httpClient = new Client();
            $response = $httpClient->request($method, $endpoint, $options);
            // $response->getStatusCode();
            // $response->getBody();
            return new TransactionResponse($response);
        } catch (ServerException $th) {
            // Connection error in range 500
            $response = $th->getResponse();
            return new TransactionResponse($response);
        } catch (ClientException $th) {
            // Connection error on range 400
            $response = $th->getResponse();
            return new TransactionResponse($response);
        } catch (ConnectException $th) {
            // Connection Error, on range 400
            // $response = $th->getResponse(); This method is not available 4 this error
            return new TransactionResponse();
        } catch (TooManyRedirectsException $th) {
            // Error on range 300
            $response = $th->getResponse();
            return new TransactionResponse($response);
        }
    }
}
