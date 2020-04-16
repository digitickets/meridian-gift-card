# omnipay-meridian-gift-card

**Meridian gift card driver for the Omnipay PHP payment processing library**

Omnipay implementation of the Meridian gift card payment gateway.

[![Build Status](https://travis-ci.org/digitickets/omnipay-meridian-gift-card.png?branch=master)](https://travis-ci.org/digitickets/omnipay-meridian-gift-card)
[![Coverage Status](https://coveralls.io/repos/github/digitickets/omnipay-meridian-gift-card/badge.svg?branch=master)](https://coveralls.io/github/digitickets/omnipay-meridian-gift-card?branch=master)
[![Latest Stable Version](https://poser.pugx.org/digitickets/omnipay-meridian-gift-card/version.png)](https://packagist.org/packages/digitickets/omnipay-meridian-gift-card)
[![Total Downloads](https://poser.pugx.org/digitickets/omnipay-meridian-gift-card/d/total.png)](https://packagist.org/packages/digitickets/omnipay-meridian-gift-card)

## Installation

**Important: Driver requires [PHP's Intl extension](http://php.net/manual/en/book.intl.php) and [PHP's SOAP extension](http://php.net/manual/en/book.soap.php) to be installed.**

The Meridian gift card Omnipay driver is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "digitickets/omnipay-meridian-gift-card": "~1.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## What's Included

This driver handles transactions being processed by Meridian gift cards, ie making payments via a gift card.

## What's Not Included

It does not handle refunds/credits to a gift card.

## Basic Usage

For general Omnipay usage instructions, please see the main [Omnipay](https://github.com/omnipay/omnipay)
repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you believe you have found a bug in this driver, please report it using the [GitHub issue tracker](https://github.com/digitickets/omnipay-meridian-gift-card/issues),
or better yet, fork the library and submit a pull request.
