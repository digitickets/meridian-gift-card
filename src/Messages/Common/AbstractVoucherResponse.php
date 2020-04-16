<?php

namespace DigiTickets\MeridianGiftCard\Messages\Common;

use DigiTickets\OmnipayAbstractVoucher\VoucherResponseInterface;
use Omnipay\Common\Message\AbstractResponse;

// @TODO: This needs a constructor that will interpret the response, and determine whether it was successful and any error message.
class AbstractVoucherResponse extends AbstractResponse implements VoucherResponseInterface
{
    public function isSuccessful(): bool
    {
        // @TODO: Implement isSuccessful() method.
        return false;
    }


}
