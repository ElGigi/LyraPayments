<?php
namespace SystemPay;

use SystemPay\exception\ResponseException;
use SystemPay\exception\SystemPayException;
use SystemPay\model\CardRequest;
use SystemPay\model\CommonRequest;
use SystemPay\model\CustomerRequest;
use SystemPay\model\Object;
use SystemPay\model\OrderRequest;
use SystemPay\model\PaymentRequest;
use SystemPay\model\QueryRequest;
use SystemPay\model\Response;
use SystemPay\model\ShoppingCartRequest;
use SystemPay\model\TechRequest;
use SystemPay\model\ThreeDSRequest;

/**
 * Class SystemPay
 *
 * @package SystemPay
 * @see     \SoapClient
 */
class SystemPay extends \SoapClient
{
    const SOAP_WSDL = 'https://paiement.systempay.fr/vads-ws/v5?wsdl';
    const SOAP_HEADERS_NAMESPACE = 'http://v5.ws.vads.lyra.com/Header/';
    /** @var \SoapClient SOAP Client */
    private $soapClient;
    /** @var string Shop id */
    private $shopId;
    /** @var string Certificate */
    private $certificate;
    /** @var string Transaction type (TEST or PRODUCTION) */
    private $mode;
    /** @var string SOAP session ID */
    private $soapSessionId;
    /** @var string Log filename */
    private $logFile;
    /** @var CommonRequest */
    private $commonRequest;

    /**
     * SystemPay constructor.
     *
     * @param mixed  $shopId         Shop id
     * @param mixed  $certificate    Shop certificate
     * @param string $mode           Transaction type (TEST or PRODUCTION)
     * @param array  $contextOptions Context options
     */
    public function __construct($shopId, $certificate, $mode = 'TEST', array $contextOptions = [])
    {
        // Init variables
        $this->shopId = $shopId;
        $this->certificate = $certificate;
        $this->mode = $mode;

        // Init SOAP client
        $this->soapClient = new \SoapClient(self::SOAP_WSDL,
                                            ['trace'          => true,
                                             'exceptions'     => true,
                                             'encoding'       => 'UTF-8',
                                             'stream_context' => stream_context_create($contextOptions)]);
    }

    /**
     * Datetime ISO 8601
     *
     * @param int|null $timestamp
     *
     * @return string
     */
    public function getDatetime($timestamp = null)
    {
        return gmdate('Y-m-d\TH:i:s\Z', empty($timestamp) ? time() : $timestamp);
    }

    /**
     * Log request
     */
    private function log()
    {
        if (!is_null($this->logFile) && ((is_file($this->logFile) && is_writable($this->logFile)) || (!is_file($this->logFile) && is_writable(dirname($this->logFile))))) {
            $logData = '>>>>>>>>>>>>>>>>>>>> Request (' . date('Y-m-d H:i:s') . ')' . "\r\n\r\n" .
                       trim($this->getSoapClient()->__getLastRequestHeaders()) . "\r\n\r\n" .
                       trim($this->logBeautifyXml($this->getSoapClient()->__getLastRequest())) . "\r\n\r\n" .
                       '<<<<<<<<<<<<<<<<<<<< Response' . "\r\n\r\n" .
                       trim($this->getSoapClient()->__getLastResponseHeaders()) . "\r\n\r\n" .
                       trim($this->logBeautifyXml($this->getSoapClient()->__getLastResponse())) . "\r\n\r\n" .
                       "\r\n";

            // Mask credit card numbers and csc
            $logData = preg_replace(['/<number>([0-9]{6})[0-9]+([0-9]{4})<\/number>/i',
                                     '/<cardSecurityCode>[0-9]{1,4}<\/cardSecurityCode>/i'],
                                    ['<number>\\1xxxxxx\\2</number>',
                                     '<cardSecurityCode>xxx</cardSecurityCode>'],
                                    $logData);

            // Write log
            file_put_contents($this->logFile, $logData, FILE_APPEND);
        }
    }

    /**
     * Log beautify
     *
     * @param string $xml
     *
     * @return $xml
     */
    private function logBeautifyXml($xml)
    {
        $dom = new \DOMDocument;
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($xml);
        $dom->formatOutput = true;

        return $dom->saveXml();
    }

    /**
     * Set log file
     *
     * @param string $logFile Log filename
     */
    public function setLogFile($logFile)
    {
        $this->logFile = $logFile;
    }

    /**
     * Get Soap client
     *
     * @return \SoapClient
     */
    public function getSoapClient()
    {
        return $this->soapClient;
    }

    /**
     * Soap request
     *
     * @param string $function_name Function name
     * @param array  $args          Arguments
     *
     * @return mixed
     *
     * @throws SystemPayException
     */
    private function soapRequest($function_name, $args)
    {
        $result = null;

        try {
            // Prepare args
            $args = array_merge(['commonRequest' => $this->getCommonRequest()], $args);
            array_walk_recursive($args,
                function (&$value) {
                    if ($value instanceof Object) {
                        $value = $value->__set_state();
                    } else {
                        $value = (string) $value;
                    }
                });

            // Soap request
            $this->soapClient->__setSoapHeaders($this->getHeaders());
            $result = call_user_func([$this->soapClient, $function_name], $args);

            // Check response error
            if (!property_exists($result, $function_name . 'Result')) {
                throw new SystemPayException('Bad format of result', 0);
            } else {
                $result = $result->{$function_name . 'Result'};

                if (!property_exists($result, 'commonResponse')) {
                    throw new SystemPayException('Bad format of response', 0);
                } else {
                    if (isset($result->commonResponse->responseCode) && $result->commonResponse->responseCode != 0) {
                        throw new ResponseException($result->commonResponse->responseCodeDetail, $result->commonResponse->responseCode);
                    }
                }
            }
        } catch (\SoapFault $e) {
            throw new SystemPayException($e->getMessage(), $e->getCode(), $e);
        } finally {
            // Log request and response
            $this->log();

            // Get and save session id
            $matches = [];
            if (preg_match("#JSESSIONID=([a-z0-9.]+)#i", $this->soapClient->__getLastResponseHeaders(), $matches) == 1) {
                if ($matches[1] != $this->soapSessionId) {
                    $this->soapSessionId = $matches[1];
                    $this->soapClient->__setCookie('JSESSIONID', $this->soapSessionId);
                }
            } else {
                if (!is_null($this->soapSessionId)) {
                    $this->soapSessionId = null;
                    $this->soapClient->__setCookie('JSESSIONID', $this->soapSessionId);
                }
            }
        }

        return $result;
    }

    /**
     * Add Soap headers
     *
     * @return \SoapHeader[]
     */
    private function getHeaders()
    {
        $requestId = $this->genUuid();
        $timestamp = $this->getDatetime();
        $authToken = base64_encode(hash_hmac('sha256', $requestId . $timestamp, $this->certificate, true));

        // Create Soap headers
        $headerShopId = new \SoapHeader(self::SOAP_HEADERS_NAMESPACE, 'shopId', $this->shopId);
        $headerRequestId = new \SoapHeader(self::SOAP_HEADERS_NAMESPACE, 'requestId', $requestId);
        $headerTimestamp = new \SoapHeader(self::SOAP_HEADERS_NAMESPACE, 'timestamp', $timestamp);
        $headerMode = new \SoapHeader(self::SOAP_HEADERS_NAMESPACE, 'mode', $this->mode);
        $headerAuthToken = new \SoapHeader(self::SOAP_HEADERS_NAMESPACE, 'authToken', $authToken);

        return [$headerShopId,
                $headerRequestId,
                $headerTimestamp,
                $headerMode,
                $headerAuthToken];
    }

    /**
     * Generate an unique request id
     *
     * @return string
     */
    private function genUuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                       mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                       mt_rand(0, 0xffff),
                       mt_rand(0, 0x0fff) | 0x4000,
                       mt_rand(0, 0x3fff) | 0x8000,
                       mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }

    /**
     * Set common request
     *
     * @param \SystemPay\model\CommonRequest $commonRequest
     */
    public function setCommonRequest(CommonRequest $commonRequest)
    {
        $this->commonRequest = $commonRequest;
    }

    /**
     * Get common request
     *
     * @return \SystemPay\model\CommonRequest
     */
    public function getCommonRequest()
    {
        if (is_null($this->commonRequest)) {
            $this->commonRequest = new CommonRequest;
        }
        $this->commonRequest->submissionDate = $this->getDatetime();

        return $this->commonRequest;
    }

    /**
     * Create payment
     *
     * @param \SystemPay\model\ThreeDSRequest|null      $threeDSRequest
     * @param \SystemPay\model\PaymentRequest           $paymentRequest
     * @param \SystemPay\model\OrderRequest             $orderRequest
     * @param \SystemPay\model\CardRequest              $cardRequest
     * @param \SystemPay\model\CustomerRequest|null     $customerRequest
     * @param \SystemPay\model\TechRequest|null         $techRequest
     * @param \SystemPay\model\ShoppingCartRequest|null $shoppingCartRequest
     *
     * @return string[] Array describe status and transaction id
     */
    public function createPayment(ThreeDSRequest $threeDSRequest = null, PaymentRequest $paymentRequest, OrderRequest $orderRequest, CardRequest $cardRequest, CustomerRequest $customerRequest = null, TechRequest $techRequest = null, ShoppingCartRequest $shoppingCartRequest = null)
    {
        $soapParams = [];
        if (!is_null($threeDSRequest)) {
            $soapParams['threeDSRequest'] = $threeDSRequest;
        }
        $soapParams['paymentRequest'] = $paymentRequest;
        $soapParams['orderRequest'] = $orderRequest;
        $soapParams['cardRequest'] = $cardRequest;
        if (!is_null($customerRequest)) {
            $soapParams['customerRequest'] = $customerRequest;
        }
        if (!is_null($techRequest)) {
            $soapParams['techRequest'] = $techRequest;
        }
        if (!is_null($shoppingCartRequest)) {
            $soapParams['shoppingCartRequest'] = $shoppingCartRequest;
        }

        // Do Soap request
        $result = $this->soapRequest(__FUNCTION__, $soapParams);

        return ['status'          => $result->commonResponse->transactionStatusLabel,
                'transactionUuid' => $result->paymentResponse->transactionUuid];
    }

    /**
     * Get payment details
     *
     * @param \SystemPay\model\QueryRequest $queryRequest
     *
     * @return string[] Array describe status and transaction id
     */
    public function getPaymentDetails(QueryRequest $queryRequest)
    {
        // Do Soap request
        $result = $this->soapRequest(__FUNCTION__,
                                     ['queryRequest' => $queryRequest]);

        return ['status'          => $result->commonResponse->transactionStatusLabel,
                'transactionUuid' => $result->paymentResponse->transactionUuid];
    }

    /**
     * Create token
     *
     * @param \SystemPay\model\CardRequest     $cardRequest
     * @param \SystemPay\model\CustomerRequest $customerRequest
     *
     * @return Response
     */
    public function createToken(CardRequest $cardRequest, CustomerRequest $customerRequest)
    {
        // Do Soap request
        $result = $this->soapRequest(__FUNCTION__,
                                     ['cardRequest'     => $cardRequest,
                                      'customerRequest' => $customerRequest]);

        return $result->commonResponse->paymentToken;
    }

    /**
     * Cancel token
     *
     * @param \SystemPay\model\QueryRequest $queryRequest
     *
     * @return true
     */
    public function cancelToken(QueryRequest $queryRequest)
    {
        // Do Soap request
        $this->soapRequest(__FUNCTION__,
                           ['queryRequest' => $queryRequest]);

        return true;
    }
}