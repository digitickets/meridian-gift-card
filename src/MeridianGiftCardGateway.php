<?php

namespace DigiTickets\MeridianGiftCard;

use DigiTickets\OmnipayAbstractVoucher\AbstractVoucherGateway;
use DigiTickets\MeridianGiftCard\Messages\Omnipay\AuthorizeRequest;
use DigiTickets\MeridianGiftCard\Messages\Omnipay\PurchaseRequest;
use DigiTickets\MeridianGiftCard\Messages\GiftCard\RedeemRequest;
use DigiTickets\MeridianGiftCard\Messages\GiftCard\ValidateRequest;
use Omnipay\Common\Message\AbstractRequest;

class MeridianGiftCardGateway extends AbstractVoucherGateway
{
    public function getName()
    {
        return 'Meridian Gift Card';
    }

    protected function createRequest($class, array $parameters)
    {
        $parameters['gateway'] = $this;

        return parent::createRequest($class, $parameters);
    }

    // These are the standard Omnipay methods, which actually call the methods below.
    public function authorize(array $parameters = array())
    {
        return $this->createRequest(AuthorizeRequest::class, $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    // These are the methods that the DigiTickets voucher interface demands.
    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function validate(array $parameters = array())
    {
        return $this->createRequest(ValidateRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function redeem(array $parameters = array())
    {
        return $this->createRequest(RedeemRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     */
    public function unredeem(array $parameters = array())
    {
        throw new \RuntimeException('Cannot unredeem (credit) a Meridian Gift Card');
    }

    public function setIpAddress($value)
    {
        $this->setParameter('ipAddress', $value);
    }

    public function getIpAddress()
    {
        return $this->getParameter('ipAddress');
    }

    public function setPort($value)
    {
        $this->setParameter('port', $value);
    }

    public function getPort()
    {
        return $this->getParameter('port');
    }
}