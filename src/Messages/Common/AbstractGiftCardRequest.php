<?php

namespace DigiTickets\MeridianGiftCard\Messages\Common;

use Omnipay\Common\Message\AbstractRequest;

abstract class AbstractGiftCardRequest extends AbstractRequest
{
    public function setGateway($value)
    {
        $this->setParameter('gateway', $value);
    }

    public function getGateway()
    {
        return $this->getParameter('gateway');
    }

    public function getData()
    {
        // @TODO: Some of this will need to be split off into the subclasses.
        $result = implode(
            '&',
            [
                'Type=G',
                'Reference=92298057',
                'PinCode=',
                'MerchantID=merwebclient',
            ]
        );
        return $result;
    }

    protected function getEndpoint()
    {
        // @TODO: The IP and port will come from the parameters; the "GetBalance" will come from the subclass.
        return 'http://185.32.152.209:9099/service.asmx/GetBalance';
    }

    protected function getHeaders()
    {
        return [
//            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8', // @TODO: Work out what this should be.
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
    }

    public function sendData($data)
    {
        try {
            $responseXml = $this
                ->httpClient
                ->post($this->getEndpoint(), $this->getHeaders(), $data)
                ->send()
                ->getBody();
        } catch (\Exception $e) {
            // @TODO: We need to create an XML object with the error message inside.
            // @TODO: Using a temporary copy from the Tesco driver for now.
            $errorXml = <<<EOT
<?xml version="1.0" encoding="utf-16"?>
<Error message="{$e->getMessage()}"></Error>
EOT;
            $responseXml = simplexml_load_string(mb_convert_encoding($errorXml, 'UTF-16'));
        }

        // Send all the information to any listeners.
        foreach ($this->getGateway()->getListeners() as $listener) {
            $listener->update($this->getListenerAction(), $responseXml);
        }

        return $this->response = $this->buildResponse($this, $responseXml);
    }
}
