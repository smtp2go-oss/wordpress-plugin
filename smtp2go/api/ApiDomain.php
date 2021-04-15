<?php
namespace SMTP2GO\Api;

class ApiDomain implements Requestable
{
    protected $endpoint;
    protected $payload;

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function buildRequestPayload()
    {
        return [
            'method' => 'POST',
            'body'   => $this->payload,
        ];
    }

    protected function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    protected function setRequestPayload(array $payload = [])
    {
        $this->payload = $payload;
    }

    public function addSenderDomain($domain, $auto_verify = true)
    {
        $this->setRequestPayload([
            'domain'      => $domain,
            'auto_verify' => $auto_verify,
        ]);

        $this->setEndpoint('domain/add');
        return $this;
    }

    public function removeSenderDomain($domain)
    {
        $this->setRequestPayload([
            'domain' => $domain,
        ]);

        $this->setEndpoint('domain/remove');
        return $this;
    }
    /**
     * Returns a list of sender domains on your account.
     *
     */
    public function view()
    {
        $this->setRequestPayload();
        $this->setEndpoint('domain/view');
        return $this;
    }

    public function verify($domain)
    {
        $this->setRequestPayload(['domain' => $domain]);
        $this->setEndpoint('domain/verify');
        return $this;
    }
}
