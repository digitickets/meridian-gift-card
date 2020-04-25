<?php

namespace DigiTickets\MeridianGiftCard\Messages\GiftCard;

use DigiTickets\MeridianGiftCard\Messages\Common\AbstractGiftCardRequest;
use Omnipay\Common\Message\RequestInterface;

class RedeemRequest extends AbstractGiftCardRequest
{
    protected function getMessageParams(): array
    {
        $this->validate('giftCardReference', 'transactionId');

        // The type is hard-coded to "G" for "Gift Card".
        // The PIN code must be empty.
        return [
            'Type=G',
            'Reference='.$this->getGiftCardReference(),
            'SaleReference='.$this->getTransactionId(),
            'UsageValue='.$this->getAmount(),
            'MerchantID='.$this->getGateway()->getMerchantId(),
            'PinCode=',
        ];
    }

    protected function getEndpointAction(): string
    {
        return 'AddUsage';
    }

    /**
     * @param RequestInterface $request
     * @param mixed $response
     * @return AbstractResponse
     */
    protected function buildResponse($request, $response)
    {
        return new RedeemResponse($request, $response);
    }

    protected function getListenerAction(): string
    {
        return 'redeemRequestSend';
    }
}
