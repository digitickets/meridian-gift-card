<?php

namespace DigiTickets\MeridianGiftCard\Messages\Omnipay;

use DigiTickets\MeridianGiftCard\Messages\Common\AbstractGiftCardRequest;
use DigiTickets\MeridianGiftCard\Messages\GiftCard\ValidateRequest;
use DigiTickets\MeridianGiftCard\Messages\GiftCard\ValidateResponse;
use Omnipay\Common\Message\RequestInterface;

class AuthorizeRequest extends ValidateRequest
{
    /**
     * @param RequestInterface $request
     * @param mixed $response
     * @return AbstractResponse
     */
    protected function buildResponse($request, $response)
    {
        return new AuthorizeResponse($request, $response);
    }

    protected function getListenerAction(): string
    {
        return 'authorizeRequestSend';
    }
}
