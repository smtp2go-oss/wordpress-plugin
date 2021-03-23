<?php
namespace SMTP2GO\Senders;

use SMTP2GO\Senders\SendsHttpRequests;

/**
 * Sends http requests using CURL - used in development for unit tests
 */
class CurlSender implements SendsHttpRequests
{
    /**
     * The last response relieved from the api as a json object
     *
     * @var mixed
     */
    protected $last_response;

    /**
     * Meta data about the last response from the api
     *
     * @var mixed
     */
    protected $last_meta;

    /**
     * store the failures data returned from the api
     *
     * @var array
     */
    protected $failures = array();

    /**
     * Send using CURL
     *
     * @param string $url
     * @param array $payload
     * @return bool
     */
    public function send(string $url, array $payload):bool
    {
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
        ));

        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array_filter($payload['body']), JSON_UNESCAPED_SLASHES));
        curl_setopt($curl, CURLOPT_CAINFO, dirname(__FILE__, 6) . '/wp-includes/certificates/ca-bundle.crt');

        $this->last_response = json_decode(curl_exec($curl));
        $this->last_meta     = curl_getinfo($curl);

        curl_close($curl);

        if (!empty($this->last_response->data->error_code)) {
            $this->logError();
        }
        if (!empty($this->last_response->data->failures)) {
            $this->logError();
            $this->failures = $this->last_response->data->failures;
        }

        return empty($this->last_response->data->error_code);
    }

    /**
     * Log errors
     *
     * @return void
     */
    protected function logError()
    {
        error_log('Error returned from SMTP2GO API...');
        error_log(print_r($this->last_response, 1));
    }

    public function getLastResponse()
    {
        return $this->last_response;
    }

    public function getFailures()
    {
        return $this->failures;
    }
}
