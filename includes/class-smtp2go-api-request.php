<?php
require_once dirname(__FILE__) . '/interface-smtp2go-api-requestable.php';

/**
 * Makes http requests to the smtp2go api
 * @since 1.0.0
 */
class Smtp2GoApiRequest
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
     * Send the request to the api via php stream
     *
     * @since 1.0.0
     * @return bool
     */
    public function send(SmtpApi2GoRequestable $request)
    {
        $endpoint = $request->getEndpoint();
        $payload  = $request->buildRequestPayload();
        $options  = array();

        $options['http']['method']  = $payload['method'];
        $options['http']['header']  = array("Content-Type: application/json");
        $options['http']['content'] = $payload['body'];
        //we want to get the api response if not a 200 response so we can log what went wrong
        $options['http']['ignore_errors'] = true;

        $options['ssl']['verify_peer'] = true;
        $options['ssl']['CN_match']           = 'smtp2go.com';
        $options['ssl']['cafile']             = dirname(__FILE__, 5) . '/wp-includes/certificates/ca-bundle.crt';

        $context = stream_context_create($options);

        $stream = fopen($this->url . $endpoint, 'r', false, $context);

        //maybe log this if a debug mode is turned on?
        $this->last_meta = stream_get_meta_data($stream);

        $response = stream_get_contents($stream);

        //maybe log this if a debug mode is turned on?
        $this->last_response = json_decode($response);

        fclose($stream);

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

}
