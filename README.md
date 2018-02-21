# SystemPay WS v5 PHP Client

[![Latest Version](http://img.shields.io/packagist/v/elgigi/systempay.svg?style=flat-square)](https://github.com/ElGigi/SystemPay/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/scrutinizer/build/g/elgigi/systempay.svg?style=flat-square)](https://scrutinizer-ci.com/g/elgigi/systempay/build-status/master)
[![Quality Score](https://img.shields.io/scrutinizer/g/elgigi/systempay.svg?style=flat-square)](https://scrutinizer-ci.com/g/elgigi/systempay)
[![Total Downloads](https://img.shields.io/packagist/dt/elgigi/systempay.svg?style=flat-square)](https://packagist.org/packages/elgigi/systempay)

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

Each implemented method return detail of result ; you are able to call too `SystemPay::getLastResult()` method after calling your method.

For more detail on functionality of each method and theirs details results, report you to the web services documentation.

### Backward compatibility of SystemPay

```php
array|null getPaymentUuid(LegacyTransactionKey $legacyTransactionKeyRequest)
```

### Routine transactions on payments

```php
array|null createPayment(?ThreeDS $threeDSRequest, Payment $paymentRequest, Order $orderRequest, Card $cardRequest, ?Customer $customerRequest, ?Tech $techRequest, ?ShoppingCart $shoppingCartRequest)
array|null updatePayment(Query $queryRequest, Payment $paymentRequest)
array|null updatePaymentDetails(Query $queryRequest, ShoppingCart $shoppingCartRequest)
array|null cancelPayment(Query $queryRequest)
array|null findPayments(Query $queryRequest)
array|null refundPayment(Payment $paymentRequest, Query $queryRequest)
array|null duplicatePayment(Payment $paymentRequest, Query $queryRequest, Order $orderRequest)
array|null validatePayment(Query $queryRequest)
array|null capturePayment(Settlement $settlementRequest)
array|null getPaymentDetails(Query $queryRequest, ?ExtendedResponse $extendedResponseRequest)
array|null verifyThreeDSEnrollment(Payment $paymentRequest, Card $cardRequest, ?Tech $techRequest, ?ThreeDS $threeDSRequest)
array|null checkThreeDSAuthentication(ThreeDS $threeDSRequest)
```

### Token payments

```php
array|null createToken(Card $cardRequest, Customer $customerRequest)
array|null createTokenFromTransaction(Query $queryRequest, ?Card $cardRequest)
array|null updateToken(Query $queryRequest, ?Card $cardRequest, ?Customer $customerRequest)
array|null getTokenDetails(Query $queryRequest)
array|null cancelToken(Query $queryRequest)
array|null reactivateToken(Query $queryRequest)
array|null createSubscription(Order $orderRequest, Subscription $subscriptionRequest, Card $cardRequest)
array|null updateSubscription(Query $queryRequest, Subscription $subscriptionRequest, ?Payment $paymentRequest)
array|null getSubscriptionDetails(Query $queryRequest)
array|null cancelSubscription(Query $queryRequest)
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
- `Request\LegacyTransactionKey`
- `Request\Order`
- `Request\Payment`
- `Request\Query`
- `Request\Settlement`
- `Request\ShippingDetails`
- `Request\ShoppingCart`
- `Request\Subscription`
- `Request\Tech`
- `Request\ThreeDS`

It's a simple integration of model describes on web services documentation **with data format control**.