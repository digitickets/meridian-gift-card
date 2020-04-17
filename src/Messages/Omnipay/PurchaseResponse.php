<?php

namespace DigiTickets\MeridianGiftCard\Messages\Omnipay;

use DigiTickets\MeridianGiftCard\Messages\Common\AbstractGiftCardRequest;
use DigiTickets\MeridianGiftCard\Messages\Common\AbstractVoucherResponse;

class PurchaseResponse extends AbstractVoucherResponse
{
    /**
     * Gateway Reference
     *
     * @return null|string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference()
    {
        /** @var $request AbstractGiftCardRequest */
        $request = $this->getRequest();

        return $request->getGiftCardReference();
    }
}
