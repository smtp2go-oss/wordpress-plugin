<?php
/**
 * These functions are used in place of real wordpress functions in Unit Tests
 * They provide the bare minimum of functionality for the tests to run
 */

use SMTP2GO\Senders\CurlSender;
use SMTP2GO\SMTP2GOMailer;

define('ABSPATH', dirname(__FILE__, 5) . '/');
define('WPINC', 'wp-includes');

function wp_remote_post($url, $payload)
{
    $sender = new $GLOBALS['senderClassName'];

    $result = $sender->send($url, array('body' => json_decode($payload['body'], true)));

    //Array containing 'headers', 'body', 'response', 'cookies', 'filename'

    return array(
        'body'    => json_encode($sender->getLastResponse()),
        'headers' => [],
    );
}

function get_option($option, $default = '')
{
    switch (true) {
        case $option == 'smtp2go_from_address':
            return SMTP2GO_TEST_SENDER_EMAIL;
            break;
        case $option == 'smtp2go_from_name':
            return SMTP2GO_TEST_SENDER_NAME;
            break;
        case $option == 'smtp2go_api_key':
            return SMTP2GO_API_KEY;
            break;
        case $option == 'smtp2go_custom_headers':
            return array(['x-sent-by' => 'phpunit test']);
            break;
    }
}

function apply_filters($tag, $args)
{
    if ($tag === 'wp_mail') {
        global $phpmailer;
        if (!$phpmailer instanceof SMTP2GOMailer) {
            $phpmailer          = new SMTP2GOMailer;
            $phpmailer->wp_args = $args;
        } else {
            $phpmailer->wp_args = $args;
        }
    }
}

function network_home_url($path = '', $scheme = null)
{
    return 'http://test.test';
}

function is_wp_error($thing)
{
    return false;
}

function get_bloginfo($option)
{
    switch (true) {
        case $option == 'charset':
            return 'UTF-8';
            break;
    }
}

function do_action_ref_array($tag, $args)
{
    return;
}

function do_action($tag, ...$arg)
{
    return;
}

function wp_parse_url($url, $component = -1)
{
    return parse_url($url, $component);
}
