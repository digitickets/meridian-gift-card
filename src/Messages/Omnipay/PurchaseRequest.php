<?php

namespace DigiTickets\MeridianGiftCard\Messages\Omnipay;

use DigiTickets\MeridianGiftCard\Messages\Common\AbstractGiftCardRequest;
use DigiTickets\MeridianGiftCard\Messages\GiftCard\RedeemRequest;
use Omnipay\Common\Message\AbstractResponse;

class PurchaseRequest extends RedeemRequest
{
    /**
     * @param RequestInterface $request
     * @param mixed $response
     * @return AbstractResponse
     */
    protected function buildResponse($request, $response)
    {
        return new PurchaseResponse($request, $response);
    }
}
