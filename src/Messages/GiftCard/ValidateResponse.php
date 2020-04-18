<?php

namespace DigiTickets\MeridianGiftCard\Messages\GiftCard;

use DigiTickets\MeridianGiftCard\Messages\Common\AbstractVoucherResponse;
use Omnipay\Common\Message\RequestInterface;

class ValidateResponse extends AbstractVoucherResponse
{
    /**
     * @var float|null
     */
    private $balance;

    public function __construct(RequestInterface $request, $response)
    {
        parent::__construct($request, $response);

        // We need to extract the current balance out of the response. The parent constructor will have determined
        // whether the reponse was valid or not.
        $this->balance = null;
        if ($this->isSuccessful()) {
            if (property_exists($response->Meridian, 'BalanceEnquiry') &&
                property_exists($response->Meridian->BalanceEnquiry, 'Balance')) {
                $this->balance = (float) $response->Meridian->BalanceEnquiry->Balance;
            }
        }
    }

    public function getBalance()
    {
        return $this->balance;
    }
}
