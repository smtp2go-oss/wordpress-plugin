<?php
namespace SMTP2GO;

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
     * The last response recieved from the api as a json object
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
    public function send(Requestable $request)
    {
        $payload = $request->buildRequestPayload();

        if (defined('WP_DEBUG') && WP_DEBUG === true) {
            error_log(print_r($payload, 1));
        }
        return $this->sendViaHttpApi($request, $payload);
    }

    /**
     * Send using Wordpress' built in http functionality. This is the default option.
     *
     * @param Requestable $request
     * @param array $payload
     * @return void
     */
    public function sendViaHttpApi(Requestable $request, $payload)
    {
        $payload['body']['api_key'] = $this->api_key;

        $payload['headers']['Content-type'] = 'application/json';

        $payload['body'] = json_encode(array_filter($payload['body']), JSON_UNESCAPED_SLASHES);

        //Array containing 'headers', 'body', 'response', 'cookies', 'filename'
        $response = wp_remote_post($this->url . $request->getEndpoint(), $payload);

        if (is_array($response)) {
            $this->last_response = json_decode($response['body']);
            $this->last_meta     = $response['response'];
        } elseif (is_wp_error($response)) {
            error_log('WP_Http Error' . print_r($response->get_error_messages(), 1));
            return false;
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

    /**
     * Get the last response recieved from the api as a json object
     *
     * @return  mixed
     */
    public function getLastResponse()
    {
        return $this->last_response;
    }

    /**
     * Get meta data about the last response from the api
     *
     * @return  mixed
     */
    public function getLastMeta()
    {
        return $this->last_meta;
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
     * Get determines the mechanism used to make the request.
     *
     * @return  string
     */
    public function getSendMethod()
    {
        return $this->send_method;
    }

    /**
     * Set determines the mechanism used to make the request. Currently
     * only WP_Http is allowed.
     *
     * @param  string  $send_method  The mechanism used to make the request.
     *
     * @return  self
     */
    public function setSendMethod(string $send_method)
    {
        if (in_array($send_method, array('WP_Http'))) {
            $this->send_method = $send_method;
        }

        return $this;
    }
}
