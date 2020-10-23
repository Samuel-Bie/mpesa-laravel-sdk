<?php


use function GuzzleHttp\json_decode;
use Psr\Http\Message\ResponseInterface;
use Samuelbie\Mpesa\Interfaces\TransactionResponseInterface;


/**
 * TransactionResponse parses all incoming responses from M-Pesa and provides the information in a clean way
 *
 * @author      Abdul Mueid Akhtar <abdul.mueid@gmail.com>
 * @copyright   Copyright (c) Abdul Mueid akhtar
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/abdulmueid/mpesa-php-api
 */



/**
 * Class TransactionResponse
 * @package abdulmueid\mpesa
 */
class TransactionResponse implements TransactionResponseInterface
{
    /**
     * Full response from the M-Pesa API
     * @var string
     */
    private $response;


    /**
     * Full JSON response from the M-Pesa API
     * @var string
     */
    private $body;

    /**
     * Response Code from M-Pesa API
     * @var string
     */
    private $code;
    /**
     * Response Code from M-Pesa API
     * @var string
     */
    private $statusCode;

    /**
     * Response Description from M-Pesa API
     * @var string
     */
    private $description;

    /**
     * Transaction ID from M-Pesa Payment and Refund API
     * @var string
     */
    private $transaction_id;

    /**
     * Conversation ID from M-Pesa Payment and Refund API
     * @var string
     */
    private $conversation_id;

    /**
     * Transaction Status from M-Pesa Query API
     * @var string
     */
    private $transaction_status;

    /**
     * TransactionResponse constructor.
     * @param string $response
     */
    public function __construct(ResponseInterface $response = null)
    {


        $body = $response ? json_decode($response->getBody()->getContents()) : json_decode('[]');

        $this->response = json_encode($response);
        $this->statusCode  = $response? $response->getStatusCode() : 460;
        $this->body  = $body;
        $this->code = $body->output_ResponseCode ?? '';
        $this->description = $body->output_ResponseDesc ?? '';
        $this->transaction_id = $body->output_TransactionID ?? '';
        $this->conversation_id = $body->output_ConversationID ?? '';
        $this->transaction_status = $body->output_ResponseTransactionStatus ?? '';
    }

    /**
     * Returns the Response Code
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
    /**
     * Returns the Response Code
     * @return string
     */
    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    /**
     * Returns the response description
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Returns the TransactionID
     * @return string
     */
    public function getTransactionID(): string
    {
        return $this->transaction_id;
    }

    /**
     * Returns the Conversation ID
     * @return string
     */
    public function getConversationID(): string
    {
        return $this->conversation_id;
    }

    /**
     * Returns the Transaction Status from Query API
     * @return string
     */
    public function getTransactionStatus(): string
    {
        return $this->transaction_status;
    }

    /**
     * Returns the raw response from M-Pesa API
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
    }

    /**
     * Returns the JSON response from M-Pesa API
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}
