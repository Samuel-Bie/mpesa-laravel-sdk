<?php

namespace samuelbie\mpesa;

/**
 * Transaction Class implements all API calls as per Transaction Interface
 *
 * @author      Abdul Mueid Akhtar <abdul.mueid@gmail.com>
 * @copyright   Copyright (c) Abdul Mueid akhtar
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/abdulmueid/mpesa-php-api
 */


use Exception;
use GuzzleHttp\Client;
use samuelbie\mpesa\Config;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;
use samuelbie\mpesa\TransactionResponse;
use GuzzleHttp\Exception\TooManyRedirectsException;
use samuelbie\mpesa\helpers\ValidationHelper;
use samuelbie\mpesa\interfaces\ConfigInterface;
use samuelbie\mpesa\interfaces\TransactionInterface;
use samuelbie\mpesa\interfaces\TransactionResponseInterface;

/**
 * Class Transaction
 * @package abdulmueid\mpesa
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

    /**
     * Initiates a C2B transaction on the M-Pesa API.
     * @param float $amount
     * @param string $msisdn
     * @param string $reference
     * @param string $third_party_reference
     * @return TransactionResponseInterface
     * @throws Exception
     */
    public function c2b(float $amount, string $msisdn, string $reference, string $third_party_reference): TransactionResponseInterface
    {
        $msisdn = ValidationHelper::normalizeMSISDN($msisdn);
        $amount = round($amount, 2);

        $endpoint = config('mpesa.c2b_endpoint');
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
            'Content-Length' => strlen(json_encode($payload)),
            'Origin' => $this->config->getOrigin(),
        ]);

        $options = [
            'headers' => $headers,
            // one of the following is enougth to send the request
            'form_params' => $payload,
            'json' => $payload,
        ];


       return $this->executeRequest($endpoint, $method, $options);


    }

    /**
     * Initiates a B2C transaction on the M-Pesa API.
     * @param float $amount
     * @param string $msisdn
     * @param string $reference
     * @param string $third_party_reference
     * @return TransactionResponseInterface
     * @throws Exception
     */
    public function b2c(float $amount, string $msisdn, string $reference, string $third_party_reference): TransactionResponseInterface
    {
        $msisdn = ValidationHelper::normalizeMSISDN($msisdn);
        $amount = round($amount, 2);

        $endpoint = config('mpesa.b2c_endpoint');
        $method = config('mpesa.b2c_method');
        $payload = [
            'input_ServiceProviderCode' => $this->config->getServiceProviderCode(),
            'input_CustomerMSISDN' => $msisdn,
            'input_Amount' => $amount,
            'input_TransactionReference' => $reference,
            'input_ThirdPartyReference' => $third_party_reference
        ];

        $headers = array_merge($this->headers, [
            'Authorization' => $this->config->getBearerToken(),
            'Content-Length' => strlen(json_encode($payload)),
            'Origin' => $this->config->getOrigin(),
        ]);


        $options = [
            'headers' => $headers,
            // one of the following is enougth to send the request
            'form_params' => $payload,
            'json' => $payload,
        ];
       return $this->executeRequest($endpoint, $method, $options);

    }

    /**
     * Initiates a B2B transaction on the M-Pesa API.
     * @param float $amount
     * @param string $receiver_party_code
     * @param string $reference
     * @param string $third_party_reference
     * @return TransactionResponseInterface
     */
    public function b2b(
        float $amount,
        string $receiver_party_code,
        string $reference,
        string $third_party_reference
    ): TransactionResponseInterface {
        $amount = round($amount, 2);
        $endpoint = config('mpesa.b2b_endpoint');
        $method = config('mpesa.b2b_method');

        $payload = [
            'input_Amount' => $amount,
            'input_TransactionReference' => $reference,
            'input_ThirdPartyReference' => $third_party_reference,
            'input_PrimaryPartyCode' => $this->config->getServiceProviderCode(),
            'input_ReceiverPartyCode' => $receiver_party_code,
        ];

        $headers = array_merge($this->headers, [
            'Authorization' => $this->config->getBearerToken(),
            'Content-Length' => strlen(json_encode($payload)),
            'Origin' => $this->config->getOrigin(),
        ]);

        $options = [
            'headers' => $headers,
            // one of the following is enougth to send the request
            'form_params' => $payload,
            'json' => $payload,
        ];

        return $this->executeRequest($endpoint, $method, $options);
    }

    /**
     * Initiates a Reversal transaction on the M-Pesa API.
     * @param float $amount
     * @param string $transaction_id
     * @param string $third_party_reference
     * @return TransactionResponseInterface
     */
    public function reversal(
        float $amount,
        string $transaction_id,
        string $third_party_reference
    ): TransactionResponseInterface {
        $amount = round($amount, 2);

        $endpoint = config('mpesa.reversal_endpoint');
        $method = config('mpesa.reversal_method');

        $payload = [
            'input_Amount' => $amount,
            'input_TransactionID' => $transaction_id,
            'input_ThirdPartyReference' => $third_party_reference,
            'input_ServiceProviderCode' => $this->config->getServiceProviderCode(),
            'input_InitiatorIdentifier' => $this->config->getInitiatorIdentifier(),
            'input_SecurityCredential' => $this->config->getSecurityCredential(),

        ];

        $headers = array_merge($this->headers, [
            'Authorization' => $this->config->getBearerToken(),
            'Content-Length' => strlen(json_encode($payload)),
            'Origin' => $this->config->getOrigin(),
        ]);

        $options = [
            'headers' => $headers,
            // one of the following is enougth to send the request
            'form_params' => $payload,
            'json' => $payload,
        ];

        return $this->executeRequest($endpoint, $method, $options);

    }

    /**
     * Initiates a transaction Query on the M-Pesa API.
     * @param string $query_reference
     * @param string $third_party_reference
     * @return TransactionResponseInterface
     */
    public function query(
        string $query_reference,
        string $third_party_reference
    ): TransactionResponseInterface {
        $payload = [
            'input_QueryReference' => $query_reference,
            'input_ServiceProviderCode' => $this->config->getServiceProviderCode(),
            'input_ThirdPartyReference' => $third_party_reference
        ];

        $endpoint = config('mpesa.c2b_endpoint');
        $method = config('mpesa.c2b_method');

        $headers = array_merge($this->headers, [
            'Authorization' => $this->config->getBearerToken(),
            'Content-Length' => strlen(json_encode($payload)),
            'Origin' => $this->config->getOrigin(),
        ]);

        $options = [
            'headers' => $headers,
            'query' => $payload,
        ];

        return $this->executeRequest($endpoint, $method, $options);
    }


    private function executeRequest($method, $endpoint, $options) : TransactionResponseInterface {
        try {
            //code...
            $httpclient = new Client();
            $response = $httpclient->request($method, $endpoint, $options);
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
            // Connection Error
            $response = $th->getResponse();
            return new TransactionResponse($response);
        } catch (TooManyRedirectsException $th) {
            $response = $th->getResponse();
            return new TransactionResponse($response);s
        }
    }
}
