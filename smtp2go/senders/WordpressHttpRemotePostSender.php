<?php
namespace SMTP2GO\Senders;

use SMTP2GO\Senders\SendsHttpRequests;

class WordpressHttpRemotePostSender implements SendsHttpRequests
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
     * The max number of seconds the api call can take to return data
     *
     * @var integer
     */
    protected $timeout = 10;
    /**
     * Send using Wordpress' built in http functionality. This is the default option.
     *
     * @param string $url
     * @param array $payload
     * @return bool
     */
    public function send(string $url, array $payload): bool
    {
        $payload['headers']['Content-type'] = 'application/json';

        $payload['headers']['User-Agent'] = "smtp2go-wordpress/1.0.10 (https://www.smtp2go.com)";

        $payload['body'] = json_encode(array_filter($payload['body']), JSON_UNESCAPED_SLASHES);

        $payload['timeout'] = $this->timeout;

        //Array containing 'headers', 'body', 'response', 'cookies', 'filename'
        $response = wp_remote_post($url, $payload);
        if (is_array($response)) {
            $this->last_response = json_decode($response['body']);
            $this->last_meta     = $response['headers'];
        } elseif (is_wp_error($response)) {
            error_log('WP_Http Error' . print_r($response->get_error_messages(), 1) . "\n");
            return false;
        }

        // handle https://apidoc.smtp2go.com/documentation/#/POST/email/send success but with failures
        // mostly useful for the wp-admin send test email, this will fail silently if the plugin is enabled
        // but not setup correctly
        if (!empty($this->last_response->data->failures)) {
            $this->logError();
            $this->failures = $this->last_response->data->failures;
        }

        if (!empty($this->last_response->data->error_code)) {
            $this->logError();
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

    /**
     * Get the max number of seconds the api call can take to return data
     *
     * @return  integer
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Set the max number of seconds the api call can take to return data
     *
     * @param  integer  $timeout  The max number of seconds the api call can take to return data
     *
     * @return  self
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }
}
