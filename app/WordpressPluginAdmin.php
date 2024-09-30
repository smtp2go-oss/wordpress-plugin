<?php

namespace SMTP2GO\App;


use SMTP2GOWPPlugin\SMTP2GO\ApiClient;
use SMTP2GOWPPlugin\SMTP2GO\Service\Service;

require_once dirname(__FILE__, 2) . '/build/vendor/autoload.php';

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.smtp2go.com
 * @since      1.0.1
 *
 * @package    SMTP2GO\WordpressPlugin
 * @subpackage SMTP2GO\WordpressPlugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    SMTP2GO\WordpressPlugin
 * @subpackage SMTP2GO\WordpressPlugin/admin
 * @author     SMTP2GO <ticket@smtp2go.com>
 */
class WordpressPluginAdmin
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.1
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.1
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.1
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
        $this->checkForConflictingPlugins();
    }

    /**
     * Check for send limit
     *
     * @since 1.7.2
     * @return void
     */
    private function isFreePlan()
    {
        $apiKey = get_option('smtp2go_api_key');
        if (empty($apiKey)) {
            return;
        }
        $keyHelper = new SecureApiKeyHelper();
        $apiKey    = $keyHelper->decryptKey($apiKey);
        $client = new ApiClient($apiKey);
        $stats   = null;
        if ($client->consume(new Service('stats/email_cycle'))) {
            $body = $client->getResponseBody();
            if (empty($body->data)) {
                return false;
            }
            $stats = $body->data;
        }

        if (empty($stats)) {
            return false;
        }

        return !empty($stats->cycle_max && $stats->cycle_max <= 1000);
    }

    /**
     * Check for possibly conflicting plugins
     *
     * @since 1.7.2
     * @return void
     */
    private function checkForConflictingPlugins()
    {
        if (!function_exists('get_plugins')) {
            include ABSPATH . '/wp-admin/includes/plugin.php';
        }

        $plugins = get_plugins();
        $active = get_option('active_plugins');

        $conflicting = [
            'wp-mail-smtp',
            'post-smtp',
            'fluent-smtp',
            'easy-wp-smtp',
            'wp-smtp',
            'smtp-mailer',
            'post-smtp',
            'wpsp',
            'sendwp',
        ];

        $conflicted = [];

        foreach ($plugins as $pluginFile => $pluginData) {
            if (in_array($pluginFile, $active) && in_array($pluginData['TextDomain'], $conflicting)) {
                $conflicted[] = $pluginData['Name'];
            }
        }

        if (!empty($conflicted)) {
            add_action('admin_notices', function () use ($conflicted) {
                echo '<div class="notice notice-error "><p>';
                echo 'SMTP2GO Wordpress Plugin may not be compatible with the following plugins: <strong>' . implode('</strong><strong>, ', $conflicted) . '</strong>.';
                echo '<br/>If you are experiencing issues with the SMTP2GO Wordpress Plugin, please disable these plugins and try again.';
                echo '</p></div>';
            });
        }
    }

    /**
     * Register all settings fields for the admin page
     *
     * @since 1.0.1
     * @return void
     */
    public function registerSettings()
    {
        /** add sections */
        add_settings_section(
            'smtp2go_settings_section',
            '',
            array($this, 'generalSection'),
            $this->plugin_name
        );
        add_settings_section('smtp2go_section_divider', '', array($this, 'sectionDivider'), $this->plugin_name);

        add_settings_section(
            'smtp2go_custom_headers_section',
            'Custom Headers',
            array($this, 'customHeadersSection'),
            $this->plugin_name
        );

        /** api key field */
        register_setting(
            'api_settings',
            'smtp2go_enabled'
        );

        add_settings_field(
            'smtp2go_enabled',
            __('Enable this plugin *', $this->plugin_name),
            array($this, 'outputCheckboxHtml'),
            $this->plugin_name,
            'smtp2go_settings_section',
            array(
                'name' => 'smtp2go_enabled', 'label' => __(''),
            )
        );

        /** api key field */
        register_setting(
            'api_settings',
            'smtp2go_api_key',
            array($this, 'validateApiKey')
        );

        add_settings_field(
            'smtp2go_api_key',
            __('API Key *', $this->plugin_name),
            array($this, 'outputApiKeyHtml'),
            $this->plugin_name,
            'smtp2go_settings_section',
            array()
        );

        /** from email address field */
        register_setting(
            'api_settings',
            'smtp2go_from_address'
        );

        add_settings_field(
            'smtp2go_from_address',
            __('Sender Email Address *', $this->plugin_name),
            [$this, 'outputTextFieldHtml'],
            $this->plugin_name,
            'smtp2go_settings_section',
            array(
                'name' => 'smtp2go_from_address', 'label' => '<span style="cursor: default; font-weight: normal;">This is the default email address that your emails will be sent from.</span>', 'type' => 'email', 'required' => true, 'placeholder' => 'john@example.com'
            )
        );

        /** from name field */
        register_setting(
            'api_settings',
            'smtp2go_from_name',
            array($this, 'validateSenderName')
        );

        add_settings_field(
            'smtp2go_from_name',
            __('Sender Name *', $this->plugin_name),
            [$this, 'outputTextFieldHtml'],
            $this->plugin_name,
            'smtp2go_settings_section',
            array(
                'name' => 'smtp2go_from_name',
                'label'      => '<span style="cursor: default; font-weight: normal;">This is the default name that your emails will be sent from (no " or / allowed).</span>', 'required' => true, 'placeholder' => 'John Example', 'pattern' => '[^/\x22]+',
            )
        );

        /**custom headers in own section */
        register_setting(
            'api_settings',
            'smtp2go_custom_headers'
        );

        add_settings_field(
            'smtp2go_custom_headers',
            false,
            [$this, 'outputCustomHeadersHtml'],
            $this->plugin_name,
            'smtp2go_custom_headers_section',
            array('class' => 'smtp2go_hide_title')
        );

        add_filter('pre_update_option_smtp2go_api_key_update', array($this, 'preUpdateApiKey'));

        add_filter('pre_update_option_smtp2go_custom_headers', array($this, 'cleanCustomHeaderOptions'));
    }



    /**
     * Clean empty values out of the custom header options $_POST
     *
     * @since 1.0.1
     * @param array $options
     * @return array
     */
    public function cleanCustomHeaderOptions($options)
    {
        $final = array('header' => array(), 'value' => array());

        if (!empty($options['header'])) {
            foreach ($options['header'] as $index => $value) {
                if (!empty($value) && !empty($options['value'][$index])) {
                    $final['header'][] = $value;
                    $final['value'][]  = $options['value'][$index];
                }
            }
        }

        return $final;
    }

    public function outputRadioOptionsHtml($args)
    {
        $currentValue = get_option($args['name'], 1);
        foreach ($args['options'] as $value => $label) {
            $selected = $value == $currentValue ? 'checked="checked"' : '';
            echo '<input ' . $selected . ' type="radio" name="' . $args['name'] . '" value="' . $value . '">' . $label . PHP_EOL;
        }
        echo '<br/>', $args['label'];
    }

    /**
     * Output the html for managing custom headers
     *
     * @since 1.0.1
     * @return void
     */
    public function outputCustomHeadersHtml()
    {
        $existing_fields = '';

        $custom_headers = get_option('smtp2go_custom_headers');
        $first_remove   = 'first-remove';
        $hidden         = '';
        if (!empty($custom_headers['header'])) {
            $hidden = 'smtp2go-js-hidden';
            foreach ($custom_headers['header'] as $index => $existing_custom_header) {
                $existing_fields .=
                    '<tr>'
                    . '<td class="smtp2go_grey_cell"><span class="smtp2go_custom_header_increment"></span></td>'
                    . '<td><input class="smtp2go_text_input" type="text" placeholder="' . __('i.e. Reply-To', $this->plugin_name) . '" name="smtp2go_custom_headers[header][]" value="' . esc_attr($existing_custom_header) . '"/></td>'
                    . '<td><input class="smtp2go_text_input" type="text" placeholder="' . __('bob@example.com', $this->plugin_name) . '" name="smtp2go_custom_headers[value][]" value="' . esc_attr($custom_headers['value'][$index]) . '"/></td>'
                    . '<td  class="smtp2go_grey_cell">'
                    . '<a href="javascript:;" class="smtp2go_add_remove_row j-add-row">+</a>'
                    . '<a href="javascript:;" class="smtp2go_add_remove_row ' . $first_remove . ' j-remove-row">-</a>'
                    . '</td>'
                    . '</tr>';
                $first_remove = '';
            }
        }

        echo '<table class="smtp2go_custom_headers">'
            . '<tr><thead>'
            . '<th class="heading smtp2go_grey_cell" style="width:20px">&nbsp;</th>'
            . '<th class="heading">' . __('Header', $this->plugin_name) . '</th>'
            . '<th class="heading">' . __('Value', $this->plugin_name) . '</th>'
            . '<th class="heading smtp2go_grey_cell" >&nbsp;</th></thead>'
            . '<tbody class="smtp2go_custom_headers_table_body">'
            . $existing_fields
            . '<tr class="' . $hidden . '">'
            . '<td class="smtp2go_grey_cell"><span class="smtp2go_custom_header_increment"></span></td>'
            . '<td><input class="smtp2go_text_input" type="text" placeholder="' . __('i.e. Reply-To', $this->plugin_name) . '" name="smtp2go_custom_headers[header][]"/></td>'
            . '<td><input  class="smtp2go_text_input" type="text" placeholder="' . __('bob@example.com', $this->plugin_name) . '" name="smtp2go_custom_headers[value][]"/></td>'
            . '<td  class="smtp2go_grey_cell">'
            . '<a href="javascript:;" class="smtp2go_add_remove_row j-add-row">+</a>'
            . '<a href="javascript:;" class="smtp2go_add_remove_row ' . $first_remove . ' j-remove-row">-</a>'
            . '</td>'

            . '</tr>'
            . '</tbody>'
            . '</table>';
    }

    public function generalSection()
    {
        return;
    }
    public function sectionDivider()
    {
        echo '<hr/>';
    }
    public function customHeadersSection()
    {
        echo '<span class="smtp2go_help_text">'
            . __('Custom Headers are an optional set of custom headers that are applied to your emails.
         These are often used for custom tracking with third-party tools such as X-Campaign.') . '</span>';
    }

    /**
     * Output Text Field Html
     *
     * @param array $args
     * @return void
     */
    public function outputTextFieldHtml($args)
    {
        $field_name = $args['name'];

        $setting = get_option($field_name);

        if (empty($setting)) {
            $setting = '';
        }
        $required = '';
        if (!empty($args['required'])) {
            $required = ' required="required"';
        }

        $type = 'text';
        if (!empty($args['type'])) {
            $type = $args['type'];
        }

        $placeholder = '';
        if (!empty($args['placeholder'])) {
            $placeholder = $args['placeholder'];
        }

        $pattern = '';
        if (!empty($args['pattern'])) {
            $pattern = ' pattern="' . $args['pattern'] . '"';
        }

        echo '<input type="' . $type . '"' . $required . ' class="smtp2go_text_input" name="' . $field_name . '"';
        echo ' value="' . esc_attr($setting) . '" placeholder="' . esc_attr($placeholder) . '"' . $pattern . '/>';

        if (!empty($args['label'])) {
            $label = $args['label'];
            echo '<br /><label for="' . $field_name . '">' . $label . '</label> ';
        }
    }

    public function outputCheckboxHtml($args)
    {
        $field_name = $args['name'];

        $setting = get_option($field_name);
        $checked = '';
        if (empty($setting)) {
            $setting = '';
        }
        if (!empty($setting)) {
            $checked = ' checked="checked"';
        }
        $required = '';
        if (!empty($args['required'])) {
            $required = 'required="required"';
        }

        $type = 'text';
        if (!empty($args['type'])) {
            $type = $args['type'];
        }
        $label = '';
        if (!empty($args['label'])) {
            $label = $args['label'];
        }
        echo '<div style="display:flex;align-items:center;"><input  id="' . $field_name . '" type="checkbox"' . $required . ' class="smtp2go_text_input" name="' . $field_name . '" value="1"' . $checked . '/> <label for="' . $field_name . '">' . $label . '</label></div>';
    }

    public function outputApiKeyHtml()
    {
        $setting = get_option('smtp2go_api_key');
        $secureHelper = new SecureApiKeyHelper();

        $setting = $secureHelper->decryptKey($setting);
        $hint    = '<span style="cursor: default; font-weight: normal;">The API key will need permissions <i>Emails</i> and <i>Statistics.</i></span>';
        if (empty($setting)) {
            $this->outputTextFieldHtml(array(
                'name'     => 'smtp2go_api_key',
                'required' => true,
                'type'     => 'text',
                'label'    => $hint,
            ));
            return;
        }

        echo '<div style="display:flex;align-items:center;margin-bottom:10px">';
        echo '<span class="smtp2go_obscured_key">', substr($setting, 0, 9), str_repeat('x', 30), '</span>';
        $this->outputTextFieldHtml(
            array(
                'name'     => 'smtp2go_api_key_update',
                'required' => true,
                'type'     => 'hidden',
            )
        );
        echo '<input type="hidden" name="smtp2go_api_key" value="" readonly/>';
        echo '&nbsp;<a class="j-smtp2go_toggle_apikey_edit" href="javascript:;">Edit</a>';
        echo '</div>';
        echo $hint;
    }

    /**
     * Add Menu Page
     *
     * @return void
     */
    public function addMenuPage()
    {
        add_menu_page(
            'SMTP2GO',
            'SMTP2GO',
            'manage_options',
            $this->plugin_name,
            array($this, 'renderManagementPage'),
            'dashicons-email-alt'
        );
    }

    public function renderStatsPage()
    {
        $apiKey = get_option('smtp2go_api_key');
        $apiKeyHelper = new SecureApiKeyHelper();
        $client = new ApiClient($apiKeyHelper->decryptKey($apiKey));
        $stats   = null;
        if ($client->consume(new Service('stats/email_summary', ['username' => substr($apiKey, 0, 16)]))) {
            $stats = $client->getResponseBody()->data;
        }
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/smtp2go-wordpress-plugin-stats-display.php';
    }

    public function renderManagementPage()
    {
        $onFreePlan = $this->isFreePlan();

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/smtp2go-wordpress-plugin-admin-display.php';
    }
    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.1
     */
    public function enqueueStyles()
    {
        wp_enqueue_style($this->plugin_name, dirname(plugin_dir_url(__FILE__)) . '/admin/css/smtp2go-wordpress-plugin-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.1
     */
    public function enqueueScripts()
    {
        wp_enqueue_script($this->plugin_name, dirname(plugin_dir_url(__FILE__)) . '/admin/js/smtp2go-wordpress-plugin-admin.js', array('jquery'), $this->version, false);
    }

    public function sendTestEmail()
    {
        define('SMTP2GO_TEST_MAIL', true);
        /** @var SMTP2GOMailer $phpmailer */
        global $phpmailer;

        $to_email = $to_name = null;

        if (!empty($_POST['to_email']) && filter_var($_POST['to_email'], FILTER_VALIDATE_EMAIL)) {
            $to_email = sanitize_email($_POST['to_email']);
        }
        if (!empty($_POST['to_name'])) {
            $to_name  = sanitize_text_field($_POST['to_name']);
            $to_email = '"' . $to_name . '" <' . $to_email . '>';
        }
        if (empty($to_email)) {
            wp_send_json(array('success' => 0, 'reason' => 'Invalid recipient specified'));
        }
        $body = __('Success!', $this->plugin_name) . "\n";
        $body .= __('You have successfully set up your SMTP2GO Wordpress Plugin', $this->plugin_name);

        $success = wp_mail($to_email, __('Test Email Via SMTP2GO Wordpress Plugin', $this->plugin_name), $body);

        if (defined('WP_DEBUG') && WP_DEBUG === true) {
            error_log('PHPMAILER Instance:' . print_r($phpmailer, 1));
        }

        if (!$phpmailer || !$phpmailer instanceof SMTP2GOMailer) {
            $reason = 'Another plugin is conflicting with this one. Expected $phpmailer to be an instance of SMTP2GOMailer but it is ' . get_class($phpmailer);
            wp_send_json(array('success' => 0, 'reason' => htmlentities($reason)));
            exit;
        }

        if ($phpmailer->isError()) {
            $reason = 'PHPMailer Error: ' . $phpmailer->ErrorInfo;
            wp_send_json(array('success' => 0, 'reason' => htmlentities($reason)));
            exit;
        }

        $request = $phpmailer->getLastRequest();
        $response = $request->getResponseBody();

        if (empty($request)) {
            $reason = 'Unable to find the request made to the SMPT2GO API. The most likely cause is a conflict with another plugin.';
            wp_send_json(array('success' => 0, 'reason' => htmlentities($reason)));
            exit;
        }
        if (defined('WP_DEBUG') && WP_DEBUG === true) {
            error_log('last request!' . print_r($request, 1));
            error_log('last response!' . print_r($response, 1));
        }
        // create / map better error messages where appropriate
        $reason = '';
        $failures = $response->data->failures ?? [];
        // API returns failures two different ways - either in failures
        if (is_countable($failures) && count($failures) > 0) {
            $reason = $failures[0];

            // map when we don't get error_code
            if (strpos($reason, "unable to verify sender address")) {
                $reason = 'Unable to verify sender address, please check Sender Email Address';
            }

            wp_send_json(array('success' => 0, 'reason' => htmlentities($reason)));
        }


        if (empty($success)) {

            if (!empty($response->data->field_validation_errors->message)) {
                $reason = $response->data->field_validation_errors->message;
            } elseif (!empty($response->data->error)) {
                $reason = $response->data->error . '<br />' . $response->data->error_code;
            }
            // API returns failures two different ways - or with error codes
            switch ($response->data->error_code ?? '') {
                case 'E_ApiResponseCodes.NON_VALIDATING_IN_PAYLOAD':
                    $reason = $response->data->field_validation_errors->message;
                    if (strpos($reason, "was expecting a valid RFC-822 formatted email field but found")) {
                        $reason = 'The supplied To Email address was invalid please correct and try again';
                    }
                    $reason = str_replace(', Please correct your JSON payload and try again', '', $reason);
                    break;
            }
        }
        wp_send_json(array('success' => intval($success), 'reason' => $reason, 'response' => $response));
    }

    /** input validations */

    /**
     * Validate the api key
     *
     * @param string $input
     * @return string
     */
    public function validateApiKey($input)
    {
        $keyHelper = new SecureApiKeyHelper();

        // click edit - replacing obsfucated key with new key
        if (!empty($_POST['smtp2go_api_key_update'])) {
            $input = $_POST['smtp2go_api_key_update'];
        }

        // initial key input
        if (empty($input)) {
            $input = get_option('smtp2go_api_key');
            $input = $keyHelper->decryptKey($input);
        }

        // switch encrypted vs not keys
        if (strpos($input, 'api-') === 0) {
            $key = $input;
        } elseif (strpos($keyHelper->decryptKey($input), 'api-') === 0) {
            $key = $keyHelper->decryptKey($input);
        } else {
            $key = false;
        }

        if (!$key) {
            add_settings_error('smtp2go_messages', 'smtp2go_message', __('Invalid API key entered. The key should begin with "api-"', $this->plugin_name));
            return get_option('smtp2go_api_key');
        }
        //make sure the key is valid
        $client = new ApiClient($key);
        if (!$client->consume(new Service('stats/email_summary', ['username' => substr($input, 0, 16)]))) {
            add_settings_error('smtp2go_messages', 'smtp2go_message', __('Invalid API key entered. Unable to make a successful call to the API with the provided key.', $this->plugin_name));
            return get_option('smtp2go_api_key');
        }


        $plain = sanitize_text_field($key);

        return $keyHelper->encryptKey($plain);
    }

    public function validateSenderName($input)
    {
        if (empty($input) || preg_match('|[/\x22]|', $input)) {
            add_settings_error('smtp2go_messages', 'smtp2go_message', __('Invalid Sender Name entered.', $this->plugin_name));
            return get_option('smtp2go_from_name');
        }

        return sanitize_text_field($input);
    }

    public function addSettingsLink($links)
    {
        $mylinks = array();
        if (current_user_can('manage_options')) {
            $mylinks[] = '<a href="' . esc_url(admin_url('admin.php?page=' . $this->plugin_name)) . '">Settings</a>';
        }
        return array_merge($links, $mylinks);
    }

    public function spamRating($value)
    {
        $value = floatval($value);

        if ($value <= 0.06) {
            return ['label' => 'Good', 'css_class' => 'smtp2go-good-status'];
        }
        if ($value <= 0.1) {
            return ['label' => 'Fair', 'css_class' => 'smtp2go-fair-status'];
        }
        return ['label' => 'Poor', 'css_class' => 'smtp2go-poor-status'];
    }

    public function bounceRating($value)
    {
        $value = intval($value);

        if ($value <= 8) {
            return ['label' => 'Good', 'css_class' => 'smtp2go-good-status'];
        }
        if ($value <= 12) {
            return ['label' => 'Fair', 'css_class' => 'smtp2go-fair-status'];
        }
        return ['label' => 'Poor', 'css_class' => 'smtp2go-poor-status'];
    }
}
