<?php

namespace DigiTickets\MeridianGiftCard\Messages\GiftCard;

use DigiTickets\MeridianGiftCard\Messages\Common\AbstractGiftCardRequest;
use Omnipay\Common\Message\RequestInterface;

class ValidateRequest extends AbstractGiftCardRequest
{
    protected function getMessageParams(): array
    {
        $this->validate('giftCardReference');

        return [
            'Type=G',
            'Reference='.$this->getGiftCardReference(),
            'PinCode=',
            'MerchantID=merwebclient',
        ];
    }

    /**
     * @param RequestInterface $request
     * @param mixed $response
     * @return AbstractResponse
     */
    protected function buildResponse($request, $response)
    {
        return new ValidateResponse($request, $response);
    }

    protected function getListenerAction(): string
    {
        return 'validateRequestSend';
    }
}
