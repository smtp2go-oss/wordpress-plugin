<?php
namespace SMTP2GO\Api;

use SMTP2GO\Senders\SendsHttpRequests;

/**
 * Makes http requests to the SMTP2GO api
 * @since 1.0.1
 * @package    SMTP2GO\WordpressPlugin
 *
 */
class ApiRequest
{
    /**
     * the "base" url for the api
     *
     * @var string
     */
    protected $url = 'https://api.smtp2go.com/v3/';

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
     * Api key for the api service
     *
     * @var string
     */
    protected $api_key;

    /**
     * store failed email sends, the plugin only sends one email at a time, so count will be 0 or 1
     *
     * @var array
     */
    private $failures = [];

    /**
     * Determines the mechanism used to make the request. Default is wordpress http class.
     * Other options are currently unavailable.
     * @see \WP_Http
     * @var string "WP_Http"
     */
    protected $send_method = 'WP_Http';

    public function __construct($api_key = '')
    {
        if (empty($api_key)) {
            $this->setApiKey(get_option('smtp2go_api_key'));
        } else {
            $this->setApiKey($api_key);
        }
    }
    /**
     * Send the request to the api
     *
     * @since 1.0.1
     * @return bool
     */
    public function send(Requestable $request, SendsHttpRequests $sender)
    {
        $payload = $request->buildRequestPayload();

        if (defined('WP_DEBUG') && WP_DEBUG === true) {
            error_log(print_r($payload, 1));
        }
        $payload['body']['api_key'] = $this-> api_key;

        $bool_result = $sender->send($this->url . $request->getEndpoint(), $payload);

        $this->last_response = $sender->getLastResponse();
        $this->failures = $sender->getFailures();
        return $bool_result;
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

    /**
     * Get the last response received from the api as a json object
     *
     * @return  mixed
     */
    public function getLastResponse()
    {
        return $this->last_response;
    }

    /**
     * Set the value of the api key
     *
     * @return  self
     */
    public function setApiKey($api_key)
    {
        $this->api_key = $api_key;

        return $this;
    }

    /**
     * get any send failures
     *
     * @return array
     */
    public function getFailures()
    {
        return $this->failures;
    }
}
