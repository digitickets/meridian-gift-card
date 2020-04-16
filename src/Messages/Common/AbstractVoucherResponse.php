<?php

namespace DigiTickets\MeridianGiftCard\Messages\Common;

use DigiTickets\OmnipayAbstractVoucher\VoucherResponseInterface;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class AbstractVoucherResponse extends AbstractResponse implements VoucherResponseInterface
{
    /**
     * @var bool
     */
    protected $successful = false;

    /**
     * @var string|null
     */
    protected $message;

    public function __construct(RequestInterface $request, $response)
    {
        parent::__construct($request, $response);

        // Interpret the response here and set successful/message accordingly.
        $this->successful = false; // Assume worst case, until we know different.
        if (property_exists($response, 'error')) {
            // Something went wrong with the actual request.
            if (property_exists($response->error, 'message')) {
                $this->message = $response->error->message;
            } else {
                // We didn't even get a message!
                $this->message = 'There was a problem; cause is unknown';
            }
        } else {
            $this->message = 'Could not determine cause of error'; // Assume the worst, until we know better.
            if (property_exists($response, 'Meridian')) {
                if (property_exists($response->Meridian, 'Status')) {
                    $responseStatus = $response->Meridian->Status;
                    if (property_exists($responseStatus, 'Status') && $responseStatus->Status === 'true') {
                        $this->successful = true;
                        $this->message = 'Successful';
                    } else {
                        if (property_exists($responseStatus, 'Message')) {
                            $this->message = $responseStatus->Message;
                        }
                    }
                }
            }

        }
    }

    public function isSuccessful(): bool
    {
        return $this->successful;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
