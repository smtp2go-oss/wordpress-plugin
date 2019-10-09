<?php
declare (strict_types = 1);

require_once 'includes/class-smtp2go-api.php';

use PHPUnit\Framework\TestCase;

/**
 * The constants used in these tests must be declared in your phpunit.xml
 * and tailored to your individual details
 */

class ApiSendTest extends TestCase
{
    public function __construct()
    {
        parent::__construct();

    }

    private function createTestInstance()
    {
        $api = new Smtp2GoApi(SMTP2GO_TEST_RECIPIENT, 'Test Message', '');

        return $api;
    }

    public function testSendEmailThroughApi()
    {
        $api = $this->createTestInstance();

        $api->setApiKey(SMTP2GO_API_KEY);

        $api->setAttachments(dirname(dirname(__FILE__)) . '/Attachments/cat.jpg');

        $wp_path = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))));

        define('ABSPATH', $wp_path . '/');
        define('WPINC', 'wp-includes/');

        require ABSPATH . WPINC . '/load.php';
        require ABSPATH . WPINC . '/cache.php';
        require ABSPATH . WPINC . '/functions.php';
        require ABSPATH . WPINC . '/general-template.php';
        require ABSPATH . WPINC . '/link-template.php';
        require ABSPATH . WPINC . '/plugin.php';
        require ABSPATH . WPINC . '/compat.php';
        require ABSPATH . WPINC . '/class-wp-list-util.php';
        require ABSPATH . WPINC . '/formatting.php';
        require ABSPATH . WPINC . '/meta.php';
        require ABSPATH . WPINC . '/class-wp-meta-query.php';
        require ABSPATH . WPINC . '/class-wp-matchesmapregex.php';
        require ABSPATH . WPINC . '/class-wp.php';
        require ABSPATH . WPINC . '/class-wp-error.php';
        

        require_once $wp_path . '/wp-includes/class-http.php';
        //WP_Http this is basically untestable. Consider writing a thin curl wrapper to do the http transport.
        $api->send(new WP_Http);

    }

}
