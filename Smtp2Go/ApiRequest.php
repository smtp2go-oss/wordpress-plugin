<?php
namespace Smtp2Go;

/**
 * Makes http requests to the smtp2go api
 * @since 1.0.0
 * @package    Smtp2go\WordpressPlugin
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
     * Determines the mechanism used to make the request. Default is curl, falls back to stream
     *
     * @var string either "curl" or "stream"
     */
    protected $send_method = 'curl';

    public function __construct($api_key = '')
    {
        if (empty($api_key)) {
            $this->setApiKey(get_option('smtp2go_api_key'));
        } else {
            $this->setApiKey($api_key);
        }
        if (!function_exists('curl_init')) {
            $this->send_method = 'stream';
        }
    }
    /**
     * Send the request to the api via php stream
     *
     * @since 1.0.0
     * @return bool
     */
    public function send(Requestable $request)
    {
        $payload = $request->buildRequestPayload();

        if (defined('WP_DEBUG') && WP_DEBUG === true) {
            error_log(print_r($payload, 1));
        }

        if ($this->send_method === 'curl') {
            return $this->sendViaCurl($request, $payload);
        } else {
            return $this->sendViaStream($request, $payload);
        }
    }

    /**
     * Send the request using cURL
     *
     * @param Requestable $request
     * @param array $payload
     * @return void
     */
    protected function sendViaCurl(Requestable $request, $payload)
    {
        $curl = curl_init($this->url . $request->getEndpoint());

        $payload['body']['api_key'] = $this->api_key;

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
        ));

        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array_filter($payload['body']), JSON_UNESCAPED_SLASHES));
        curl_setopt($curl, CURLOPT_CAINFO, dirname(__FILE__, 5) . '/wp-includes/certificates/ca-bundle.crt');

        $this->last_response = json_decode(curl_exec($curl));
        $this->last_meta     = curl_getinfo($curl);
        
        curl_close($curl);
        
        if (!empty($this->last_response->data->error_code)) {
            error_log('Error returned from Smtp2Go API...');
            error_log(print_r($this->last_response, 1));
        }

        return empty($this->last_response->data->error_code);
    }

    /**
     * Send the request using http stream
     *
     * @param Requestable $request
     * @param array $payload
     * @return void
     */
    protected function sendViaStream($request, $payload)
    {
        $endpoint = $request->getEndpoint();
        $options  = array();

        $payload['body']['api_key'] = $this->api_key;

        $options['http']['method']  = $payload['method'];
        $options['http']['header']  = array("Content-Type: application/json");
        $options['http']['content'] = json_encode(array_filter($payload['body']), JSON_UNESCAPED_SLASHES);

        //we want to get the api response if not a 200 response so we can examine
        //the error data
        $options['http']['ignore_errors'] = true;

        $options['ssl']['verify_peer'] = true;
        $options['ssl']['CN_match']    = 'smtp2go.com';
        $options['ssl']['cafile']      = dirname(__FILE__, 5) . '/wp-includes/certificates/ca-bundle.crt';

        $context = stream_context_create($options);

        $stream = fopen($this->url . $endpoint, 'r', false, $context);

        //maybe log this if a debug mode is turned on?
        $this->last_meta = stream_get_meta_data($stream);

        $response = stream_get_contents($stream);

        //maybe log this if a debug mode is turned on?
        $this->last_response = json_decode($response);

        fclose($stream);
        if (!empty($this->last_response->data->error_code)) {
            error_log('Error returned from Smtp2Go API...');
            error_log(print_r($this->last_response, 1));
        }
        return empty($this->last_response->data->error_code);
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
     * Get determines the mechanism used to make the request. Default is Curl, falls back to streams
     *
     * @return  string
     */
    public function getSendMethod()
    {
        return $this->send_method;
    }

    /**
     * Set determines the mechanism used to make the request. Default is Curl, falls back to streams
     *
     * @param  string  $send_method  The mechanism used to make the request. Accepted values are 'curl', 'stream'
     *
     * @return  self
     */
    public function setSendMethod(string $send_method)
    {
        if (in_array($send_method, array('curl', 'stream'))) {
            $this->send_method = $send_method;
        }

        return $this;
    }
}
