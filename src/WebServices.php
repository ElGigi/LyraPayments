<?php
/**
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2018 Ronan GIRON
 * @author    Ronan GIRON <https://github.com/ElGigi>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code, to the root.
 */

namespace ElGigi\LyraPayments;

use ElGigi\LyraPayments\Exception\ResponseException;
use ElGigi\LyraPayments\Exception\LyraPaymentsException;
use ElGigi\LyraPayments\Request\Card;
use ElGigi\LyraPayments\Request\Common;
use ElGigi\LyraPayments\Request\Customer;
use ElGigi\LyraPayments\Request\ExtendedResponse;
use ElGigi\LyraPayments\Request\LegacyTransactionKey;
use ElGigi\LyraPayments\Request\Order;
use ElGigi\LyraPayments\Request\Payment;
use ElGigi\LyraPayments\Request\Query;
use ElGigi\LyraPayments\Request\Settlement;
use ElGigi\LyraPayments\Request\ShoppingCart;
use ElGigi\LyraPayments\Request\Subscription;
use ElGigi\LyraPayments\Request\Tech;
use ElGigi\LyraPayments\Request\ThreeDS;

/**
 * Class WebServices.
 *
 * @package ElGigi\LyraPayments
 *
 * @method array|null getPaymentUuid(LegacyTransactionKey $legacyTransactionKeyRequest)
 *
 * @method array|null createPayment(ThreeDS | null $threeDSRequest, Payment $paymentRequest, Order $orderRequest, Card $cardRequest, Customer | null $customerRequest, Tech | null $techRequest, ShoppingCart | null $shoppingCartRequest)
 * @method array|null updatePayment(Query $queryRequest, Payment $paymentRequest)
 * @method array|null updatePaymentDetails(Query $queryRequest, ShoppingCart $shoppingCartRequest)
 * @method array|null cancelPayment(Query $queryRequest)
 * @method array|null findPayments(Query $queryRequest)
 * @method array|null refundPayment(Payment $paymentRequest, Query $queryRequest)
 * @method array|null duplicatePayment(Payment $paymentRequest, Query $queryRequest, Order $orderRequest)
 * @method array|null validatePayment(Query $queryRequest)
 * @method array|null capturePayment(Settlement $settlementRequest)
 * @method array|null getPaymentDetails(Query $queryRequest, ExtendedResponse | null $extendedResponseRequest)
 * @method array|null verifyThreeDSEnrollment(Payment $paymentRequest, Card $cardRequest, Tech | null $techRequest, ThreeDS | null $threeDSRequest)
 * @method array|null checkThreeDSAuthentication(ThreeDS $threeDSRequest)
 *
 * @method array|null createToken(Card $cardRequest, Customer $customerRequest)
 * @method array|null createTokenFromTransaction(Query $queryRequest, Card | null $cardRequest)
 * @method array|null updateToken(Query $queryRequest, Card | null $cardRequest, Customer | null $customerRequest)
 * @method array|null getTokenDetails(Query $queryRequest)
 * @method array|null cancelToken(Query $queryRequest)
 * @method array|null reactivateToken(Query $queryRequest)
 * @method array|null createSubscription(Order $orderRequest, Subscription $subscriptionRequest, Card $cardRequest)
 * @method array|null updateSubscription(Query $queryRequest, Subscription $subscriptionRequest, Payment | null $paymentRequest)
 * @method array|null getSubscriptionDetails(Query $queryRequest)
 * @method array|null cancelSubscription(Query $queryRequest)
 */
class WebServices
{
    const SOAP_HEADERS_NAMESPACE = 'http://v5.ws.vads.lyra.com/Header/';
    // Modes
    const MODE_TEST = 'TEST';
    const MODE_PRODUCTION = 'PRODUCTION';
    // Methods
    const METHODS = [// Backward compatibility
                     'getPaymentUuid'             => ['legacyTransactionKeyRequest' => LegacyTransactionKey::class],
                     // Classic payments
                     'createPayment'              => ['?threeDSRequest'      => ThreeDS::class,
                                                      'paymentRequest'       => Payment::class,
                                                      'orderRequest'         => Order::class,
                                                      'cardRequest'          => Card::class,
                                                      '?customerRequest'     => Customer::class,
                                                      '?techRequest'         => Tech::class,
                                                      '?shoppingCartRequest' => ShoppingCart::class],
                     'updatePayment'              => ['queryRequest'   => Query::class,
                                                      'paymentRequest' => Payment::class],
                     'updatePaymentDetails'       => ['queryRequest'        => Query::class,
                                                      'shoppingCartRequest' => ShoppingCart::class],
                     'cancelPayment'              => ['queryRequest' => Query::class],
                     'findPayments'               => ['queryRequest' => Query::class],
                     'refundPayment'              => ['paymentRequest' => Payment::class,
                                                      'queryRequest'   => Query::class],
                     'duplicatePayment'           => ['paymentRequest' => Payment::class,
                                                      'queryRequest'   => Query::class,
                                                      'orderRequest'   => Order::class],
                     'validatePayment'            => ['queryRequest' => Query::class],
                     'capturePayment'             => ['settlementRequest' => Settlement::class],
                     'getPaymentDetails'          => ['queryRequest'             => Query::class,
                                                      '?extendedResponseRequest' => ExtendedResponse::class],
                     'verifyThreeDSEnrollment'    => ['paymentRequest'  => Payment::class,
                                                      'cardRequest'     => Card::class,
                                                      '?techRequest'    => Tech::class,
                                                      '?threeDSRequest' => ThreeDS::class],
                     'checkThreeDSAuthentication' => ['threeDSRequest' => ThreeDS::class],
                     // Tokens
                     'createToken'                => ['cardRequest'     => Card::class,
                                                      'customerRequest' => Customer::class],
                     'createTokenFromTransaction' => ['queryRequest' => Query::class,
                                                      '?cardRequest' => Card::class],
                     'updateToken'                => ['queryRequest'     => Query::class,
                                                      '?cardRequest'     => Card::class,
                                                      '?customerRequest' => Customer::class],
                     'getTokenDetails'            => ['queryRequest' => Query::class],
                     'cancelToken'                => ['queryRequest' => Query::class],
                     'reactivateToken'            => ['queryRequest' => Query::class],
                     'createSubscription'         => ['orderRequest'        => Order::class,
                                                      'subscriptionRequest' => Subscription::class,
                                                      'cardRequest'         => Card::class],
                     'updateSubscription'         => ['queryRequest'        => Query::class,
                                                      'subscriptionRequest' => Subscription::class,
                                                      '?paymentRequest'     => Payment::class],
                     'getSubscriptionDetails'     => ['queryRequest' => Query::class],
                     'cancelSubscription'         => ['queryRequest' => Query::class]];
    const METHODS_RESULT = ['getPaymentUuid' => 'legacyTransactionKeyResult'];
    /** @var \SoapClient SOAP Client */
    private $soapClient;
    /** @var string Shop id */
    private $shopId;
    /** @var string Certificate */
    private $certificate;
    /** @var string Transaction type (TEST or PRODUCTION) */
    private $mode;
    /** @var string|null SOAP session ID */
    private $soapSessionId;
    /** @var string|null Log filename */
    private $logFile;
    /** @var Common */
    private $commonRequest;
    /** @var mixed Last result */
    private $lastResult;

    /**
     * WebServices constructor.
     *
     * @param string $wsdl WSDL file link
     * @param string $shopId Shop id
     * @param string $certificate Shop certificate
     * @param string $mode Transaction type (TEST or PRODUCTION)
     * @param array $contextOptions Context options
     * @param array $soapClientOptions
     * @throws \SoapFault
     */
    public function __construct(
        string $wsdl,
        string $shopId,
        string $certificate,
        string $mode = WebServices::MODE_TEST,
        array $contextOptions = [],
        array $soapClientOptions = []
    ) {
        // Init variables
        $this->shopId = $shopId;
        $this->certificate = $certificate;
        $this->mode = $mode;

        // Context options
        $contextOptions = array_replace_recursive(['ssl' => ['peer_name'        => parse_url($wsdl, PHP_URL_HOST) ?? null,
                                                             'verify_peer'      => true,
                                                             'verify_peer_name' => true,
                                                             'cafile'           => __DIR__ . '/cacert.pem',
                                                             'SNI_enabled'      => true]],
                                                  $contextOptions);

        // Init SOAP client
        $soapClientOptions = array_merge([
            'trace' => true,
            'exceptions' => true,
            'encoding' => 'UTF-8',
            'stream_context' => stream_context_create($contextOptions)
        ], $soapClientOptions);
        
        $this->soapClient = new \SoapClient($wsdl, $soapClientOptions);
    }

    /**
     * Datetime ISO 8601.
     *
     * @param int|null $timestamp
     *
     * @return string
     */
    public function getDatetime(?int $timestamp = null): string
    {
        return gmdate('Y-m-d\TH:i:s\Z', empty($timestamp) ? time() : $timestamp);
    }

    /**
     * Log request.
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
     * Log beautify.
     *
     * @param string $xml
     *
     * @return string
     */
    private function logBeautifyXml(string $xml): string
    {
        $dom = new \DOMDocument;
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($xml);
        $dom->formatOutput = true;

        return $dom->saveXml();
    }

    /**
     * Set log file.
     *
     * @param string $logFile Log filename
     *
     * @return \ElGigi\LyraPayments\WebServices
     */
    public function setLogFile(string $logFile): WebServices
    {
        $this->logFile = $logFile;

        return $this;
    }

    /**
     * Get Soap client.
     *
     * @return \SoapClient
     */
    public function getSoapClient(): \SoapClient
    {
        return $this->soapClient;
    }

    /**
     * Soap request.
     *
     * @param string $functionName Function name
     * @param array  $args         Arguments
     *
     * @return mixed
     *
     * @throws \ElGigi\LyraPayments\Exception\LyraPaymentsException
     */
    private function soapRequest(string $functionName, array $args)
    {
        try {
            // Prepare args
            $args = array_merge(['commonRequest' => $this->getCommonRequest()], $args);
            array_walk_recursive($args,
                function (&$value) {
                    if ($value instanceof AbstractObject) {
                        $value = $value->getArrayCopy();
                    } else {
                        $value = (string) $value;
                    }
                });

            // Soap request
            $this->soapClient->__setSoapHeaders($this->getHeaders());
            $result = call_user_func([$this->soapClient, $functionName], $args);

            // Property name
            if (isset(self::METHODS_RESULT[$functionName])) {
                $resultPropertyName = self::METHODS_RESULT[$functionName];
            } else {
                $resultPropertyName = sprintf('%sResult', $functionName);
            }

            // Check response error
            if (!property_exists($result, $resultPropertyName)) {
                throw new LyraPaymentsException('Bad format of result', 0);
            } else {
                $this->lastResult = $result->{$resultPropertyName};

                if (!property_exists($this->lastResult, 'commonResponse')) {
                    throw new LyraPaymentsException('Bad format of response', 0);
                } else {
                    if (isset($this->lastResult->commonResponse->responseCode) && $this->lastResult->commonResponse->responseCode != 0) {
                        throw new ResponseException($this->lastResult->commonResponse->responseCodeDetail, $this->lastResult->commonResponse->responseCode);
                    }
                }
            }
        } catch (\SoapFault $e) {
            $this->lastResult = null;
            throw new LyraPaymentsException($e->getMessage(), $e->getCode(), $e);
        } catch (LyraPaymentsException $e) {
            $this->lastResult = null;
            throw $e;
        } finally {
            // Log request and response
            $this->log();

            // Get and save session id
            $matches = [];
            if (preg_match("#JSESSIONID=([-a-z0-9.]+)#i", $this->soapClient->__getLastResponseHeaders(), $matches) == 1) {
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

        return $this->lastResult;
    }

    /**
     * Add Soap headers.
     *
     * @return \SoapHeader[]
     */
    private function getHeaders(): array
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
     * Generate an unique request id.
     *
     * @return string
     */
    private function genUuid(): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                       mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                       mt_rand(0, 0xffff),
                       mt_rand(0, 0x0fff) | 0x4000,
                       mt_rand(0, 0x3fff) | 0x8000,
                       mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }

    /**
     * Set common request.
     *
     * @param \ElGigi\LyraPayments\Request\Common $commonRequest
     *
     * @return \ElGigi\LyraPayments\WebServices
     */
    public function setCommonRequest(Common $commonRequest): WebServices
    {
        $this->commonRequest = $commonRequest;

        return $this;
    }

    /**
     * Get common request.
     *
     * @return \ElGigi\LyraPayments\Request\Common
     * @throws \ElGigi\LyraPayments\Exception\LyraPaymentsException
     */
    public function getCommonRequest(): Common
    {
        if (is_null($this->commonRequest)) {
            $this->commonRequest = new Common;
        }
        $this->commonRequest->submissionDate = $this->getDatetime();

        return $this->commonRequest;
    }

    /**
     * Return last result object or null.
     *
     * @return null|array
     */
    public function getLastResult(): ?array
    {
        if (!is_null($this->lastResult)) {
            $resultArray = [];

            foreach (json_decode(json_encode($this->lastResult), true) as $key => $value) {
                if (substr($key, -8) == 'Response') {
                    $resultArray[substr($key, 0, -8)] = $value;
                } else {
                    $resultArray[$key] = $value;
                }
            }

            return $resultArray;
        }

        return null;
    }

    /**
     * __call() magic method.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return array|null
     * @throws \ElGigi\LyraPayments\Exception\LyraPaymentsException
     */
    public function __call(string $name, array $arguments)
    {
        // Check if method exists
        if (isset(static::METHODS[$name])) {
            // Check number of arguments types
            if (($nbArgs = count(static::METHODS[$name])) == count($arguments)) {
                $finalArguments = [];

                // Check arguments
                $iArg = 0;
                foreach (static::METHODS[$name] as $argumentName => $type) {
                    $required = substr($argumentName, 0, 1) != '?';

                    if (!$required) {
                        $argumentName = substr($argumentName, 1);
                    }

                    if (($required === false && is_null($arguments[$iArg])) || is_a($arguments[$iArg], $type, true)) {
                        $finalArguments[$argumentName] = $arguments[$iArg];
                    } else {
                        throw new \InvalidArgumentException(sprintf('Argument "%s" of "%s::%s()" method need to be of type "%s"',
                                                                    $argumentName, static::class, $name, $type));
                    }
                    $iArg++;
                }

                // Get result
                $this->soapRequest($name, $finalArguments);

                return $this->getLastResult();
            } else {
                throw new LyraPaymentsException(sprintf('Method "%s::%s()" needs %d arguments', static::class, $name, $nbArgs));
            }
        } else {
            throw new LyraPaymentsException(sprintf('Unknown "%s::%s()" method', static::class, $name));
        }
    }
}
