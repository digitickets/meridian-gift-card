<?php

namespace DigiTickets\MeridianGiftCard\Messages\Common;

use Omnipay\Common\Message\AbstractRequest;

abstract class AbstractGiftCardRequest extends AbstractRequest
{
    abstract protected function getMessageParams(): array;

    abstract protected function getEndpointAction(): string;

    public function getGateway()
    {
        return $this->getParameter('gateway');
    }

    public function setGateway($value)
    {
        $this->setParameter('gateway', $value);
    }

    /**
     * Sets the gift card reference. Unfortunately, to be consistent with other similar drivers, the parameter is called
     * "voucherCode", hence the names of these methods.
     *
     * @param $giftCardReference
     *
     * @return AbstractRequest
     */
    public function setVoucherCode($giftCardReference)
    {
        return $this->setParameter('giftCardReference', $giftCardReference);
    }

    public function getVoucherCode()
    {
        return $this->getParameter('giftCardReference');
    }

    /**
     * This is just a wrapper round "getVoucherCode()".
     * @return mixed
     */
    public function getGiftCardReference()
    {
        return $this->getVoucherCode();
    }

    public function getData()
    {
        // @TODO: Inline this when finished.
        $result = implode('&', $this->getMessageParams());
        return $result;
    }

    protected function getEndpoint()
    {
        return sprintf(
            'http://%s:%d/service.asmx/%s',
            $this->getGateway()->getIpAddress(),
            $this->getGateway()->getPort(),
            $this->getEndpointAction()
        );
    }

    protected function getHeaders()
    {
        return [
            'Accept' => 'application/xml',
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

            // The response is a bit weird, and SimpleXMLElement doesn't seem to be able to parse it, so we extract the
            // middle bit (the "Meridian" node) out and go from there. And yes, preg_match looks for the parent tag,
            // which seems to disappear when SimpleXMLElement parses it (but it crashes if you pass in the "Meridian" node).
            $matches = [];
            preg_match('/<diffgr:diffgram.*<\/diffgr:diffgram>/s', $responseXml, $matches);
            if (is_array($matches) && count($matches) > 0) {
                $simpleCoreXml = new \SimpleXMLElement($matches[0]);
                $responseObj = json_decode(json_encode($simpleCoreXml));
            } else {
                throw new \RuntimeException('Unexpected response format');
            }
        } catch (\Exception $e) {
            // Build a small stdClass containing the error message.
            $responseObj = json_decode(sprintf('{"error":{"message":"%s"}}', $e->getMessage()));
        }

        // Send all the information to any listeners.
        foreach ($this->getGateway()->getListeners() as $listener) {
            $listener->update($this->getListenerAction(), $responseObj);
        }

        return $this->response = $this->buildResponse($this, $responseObj);
    }
}
