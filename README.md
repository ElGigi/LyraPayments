# SystemPay WS v5 PHP Client

PHP client to dialog with SystemPay web services of french Natixis banks.


## Installation

### Composer

You can install the client with [Composer](https://getcomposer.org/), it's the recommended installation.

```bash
$ composer require elgigi/systempay
```

### Dependencies

* **PHP** >= 7.1


## Methods

All methods available in web services v5 of SystemPay are functional.

Each implemented method return only the transaction status label. To get detail of result, call `SystemPay::getLastResult()` method after calling your method.

For more detail on functionality of each method, report you to the web services documentation.

### Routine transactions on payments

```php
string createPayment(?ThreeDS $threeDSRequest, Payment $paymentRequest, Order $orderRequest, Card $cardRequest, ?Customer $customerRequest, ?Tech $techRequest, ?ShoppingCart $shoppingCartRequest)
string updatePayment(Query $queryRequest, Payment $paymentRequest)
string updatePaymentDetails(Query $queryRequest, ShoppingCart $shoppingCartRequest)
string cancelPayment(Query $queryRequest)
string findPayments(Query $queryRequest)
string refundPayment(Payment $paymentRequest, Query $queryRequest)
string duplicatePayment(Payment $paymentRequest, Query $queryRequest, Order $orderRequest)
string validatePayment(Query $queryRequest)
string capturePayment(Settlement $settlementRequest)
string getPaymentDetails(Query $queryRequest, ?ExtendedResponse $extendedResponseRequest)
string verifyThreeDSEnrollment(Payment $paymentRequest, Card $cardRequest, ?Tech $techRequest, ?ThreeDS $threeDSRequest)
string checkThreeDSAuthentication(ThreeDS $threeDSRequest)
```

### Token payments

```php
string createToken(Card $cardRequest, Customer $customerRequest)
string createTokenFromTransaction(Query $queryRequest, ?Card $cardRequest)
string updateToken(Query $queryRequest, ?Card $cardRequest, ?Customer $customerRequest)
string getTokenDetails(Query $queryRequest)
string cancelToken(Query $queryRequest)
string reactivateToken(Query $queryRequest)
string createSubscription(Order $orderRequest, Subscription $subscriptionRequest, Card $cardRequest)
string updateSubscription(Query $queryRequest, Subscription $subscriptionRequest, ?Payment $paymentRequest)
string getSubscriptionDetails(Query $queryRequest)
string cancelSubscription(Query $queryRequest)
```


## Models

Models available to use payment methods:

- `Info\CartItem`
- `Info\Ext`
- `Request\BillingDetails`
- `Request\Card`
- `Request\Common`
- `Request\Customer`
- `Request\ExtendedResponse`
- `Request\ExtraDetails`
- `Request\Order`
- `Request\Payment`
- `Request\Query`
- `Request\Settlement`
- `Request\ShippingDetails`
- `Request\ShoppingDetails`
- `Request\ShoppingCart`
- `Request\Subscription`
- `Request\Tech`
- `Request\ThreeDS`

It's a simple integration of model describes on web services documentation **with data format control**.