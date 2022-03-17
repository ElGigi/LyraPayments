# Lyra payments Webservices v5 PHP Client

[![Latest Version](http://img.shields.io/packagist/v/elgigi/lyra-payments.svg?style=flat-square)](https://github.com/ElGigi/LyraPayments/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/github/workflow/status/ElGigi/LyraPayments/Tests/master.svg?style=flat-square)](https://github.com/ElGigi/LyraPayments/actions/workflows/tests.yml?query=branch%3Amaster)
[![Codacy Grade](https://img.shields.io/codacy/grade/a330af553b394da58c0e04b34331f6e2.svg?style=flat-square)](https://www.codacy.com/app/ElGigi/LyraPayments?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ElGigi/LyraPayments&amp;utm_campaign=Badge_Grade)
[![Total Downloads](https://img.shields.io/packagist/dt/elgigi/lyra-payments.svg?style=flat-square)](https://packagist.org/packages/elgigi/lyra-payments)

PHP client to dialog with Lyra Network web services v5, payment solution for:
- **WebServices** of french Natixis banks
- **Payzen** for all french banks, most european banks, Brazil, Chile, Argentina, Peru, Mexico, USA and Canada, India and soon Colombia.
- **Sogecommerce** for the **Société Générale** french bank
- The **Crédit du Nord** french bank group
- The **OSB** bank to Tahiti
- The **CSB** bank to Noumea
- The **BNPP** bank in Africa
- **FirstData** to Brazil
- **Innocard** to Switzerland

## Installation

### Composer

You can install the client with [Composer](https://getcomposer.org/), it's the recommended installation.

```bash
$ composer require elgigi/lyra-payments
```

### Dependencies

* **PHP** >= 7.1


## Methods

All methods available in web services v5 of Lyra Network payment system are functional.

Each implemented method return detail of result ; you are able to call too `WebServices::getLastResult()` method after calling your method.

For more detail on functionality of each method and theirs details results, report you to the web services documentation.

### Backward compatibility of WebServices

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