<?php

namespace DigiTickets\MeridianGiftCard\Messages\GiftCard;

use DigiTickets\MeridianGiftCard\Messages\Common\AbstractGiftCardRequest;
use Omnipay\Common\Message\RequestInterface;

class ValidateRequest extends AbstractGiftCardRequest
{
    protected function getMessageParams(): array
    {
        $this->validate('giftCardReference');

        // The type is hard-coded to "G" for "Gift Card".
        // The PIN code must be empty.
        return [
            'Type=G',
            'Reference='.$this->getGiftCardReference(),
            'PinCode=',
            'MerchantID='.$this->getGateway()->getMerchantId(),
        ];
    }

    protected function getEndpointAction(): string
    {
        return 'GetBalance';
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
