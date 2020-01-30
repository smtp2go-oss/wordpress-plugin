<?php
namespace SMTP2GO;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://thefold.nz
 * @since      1.0.0
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
 * @author     The Fold <hello@thefold.co.nz>
 */
class WordpressPluginAdmin
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
    }

    /**
     * Register all settings fields for the admin page
     *
     * @since 1.0.0
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
            __('Enabled *', $this->plugin_name),
            array($this, 'outputCheckboxHtml'),
            $this->plugin_name,
            'smtp2go_settings_section',
            array('name' => 'smtp2go_enabled'
                , 'label' => __('Send Email Using SMTP2GO'),
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
            array($this, 'outputTextFieldHtml'),
            $this->plugin_name,
            'smtp2go_settings_section',
            array(
                'name'     => 'smtp2go_api_key',
                'required' => true,
                'label'    => '<span style="cursor: default;">Create/find your API key from the <i>Settings > API Keys page</i> in the SMTP2GO web app with permissions \'Emails\' and \'Statistics\'.</span>')
        );

        /** from email address field */
        register_setting(
            'api_settings',
            'smtp2go_from_address'
        );

        add_settings_field(
            'smtp2go_from_address',
            __('From Email Address *', $this->plugin_name),
            [$this, 'outputTextFieldHtml'],
            $this->plugin_name,
            'smtp2go_settings_section',
            array('name' => 'smtp2go_from_address'
                , 'label' => '<span style="cursor: default;">This is the default email address that your emails will be sent from.</span>'
                , 'type' => 'email'
                , 'required' => true)
        );

        /** from name field */
        register_setting(
            'api_settings',
            'smtp2go_from_name'
        );

        add_settings_field(
            'smtp2go_from_name',
            __('From Name *', $this->plugin_name),
            [$this, 'outputTextFieldHtml'],
            $this->plugin_name,
            'smtp2go_settings_section',
            array('name' => 'smtp2go_from_name',
                'label'      => '<span style="cursor: default;">This is the default name that your emails will be sent from.</span>'
                , 'required' => true)
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

        add_filter('pre_update_option_smtp2go_custom_headers', array($this, 'cleanCustomHeaderOptions'));
    }

    /**
     * Clean empty values out of the custom header options $_POST
     *
     * @since 1.0.0
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

    /**
     * Output the html for managing custom headers
     *
     * @since 1.0.0
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
                . '<td><input class="smtp2go_text_input" type="text" placeholder="' . __('Enter New Header Key', $this->plugin_name) . '" name="smtp2go_custom_headers[header][]" value="' . $existing_custom_header . '"/></td>'
                . '<td><input class="smtp2go_text_input" type="text" placeholder="' . __('Enter New Header Value', $this->plugin_name) . '" name="smtp2go_custom_headers[value][]" value="' . $custom_headers['value'][$index] . '"/></td>'
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
        . '<td><input class="smtp2go_text_input" type="text" placeholder="' . __('Enter New Header Key', $this->plugin_name) . '" name="smtp2go_custom_headers[header][]"/></td>'
        . '<td><input  class="smtp2go_text_input" type="text" placeholder="' . __('Enter New Header Value', $this->plugin_name) . '" name="smtp2go_custom_headers[value][]"/></td>'
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
            $required = 'required="required"';
        }

        $type = 'text';
        if (!empty($args['type'])) {
            $type = $args['type'];
        }

        echo '<input type="' . $type . '"' . $required . ' class="smtp2go_text_input" name="' . $field_name . '" value="' . esc_attr($setting) . '"/>';

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
            $checked = 'checked="checked"';
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
            array($this, 'renderManagementPage')
        );
    }

    public function renderStatsPage()
    {
        $summary = new ApiSummary;
        $request = new ApiRequest(get_option('smtp2go_api_key'));
        $stats   = null;
        if ($request->send($summary)) {
            $stats = $request->getLastResponse()->data;
        }
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/smtp2go-wordpress-plugin-stats-display.php';
    }

    public function renderManagementPage()
    {
        //fetch all the options

        //display the page
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/smtp2go-wordpress-plugin-admin-display.php';
    }
    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueueStyles()
    {
        wp_enqueue_style($this->plugin_name, dirname(plugin_dir_url(__FILE__)) . '/admin/css/smtp2go-wordpress-plugin-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueueScripts()
    {
        wp_enqueue_script($this->plugin_name, dirname(plugin_dir_url(__FILE__)) . '/admin/js/smtp2go-wordpress-plugin-admin.js', array('jquery'), $this->version, false);
    }

    public function sendTestEmail()
    {
        $to_email = $to_name = null;

        if (!empty($_POST['to_email']) && filter_var($_POST['to_email'], FILTER_VALIDATE_EMAIL)) {
            $to_email = sanitize_email($_POST['to_email']);
        }
        if (!empty($_POST['to_name'])) {
            $to_name  = sanitize_text_field($_POST['to_name']);
            $to_email = $to_name . '<' . $to_email . '>';
        }
        if (empty($to_email)) {
            wp_send_json(array('success' => 0, 'reason' => 'Invalid recipient specified'));
        }
        $body = __('Success!', $this->plugin_name) . "\n";
        $body .= __('You have successfully set up your SMTP2GO Wordpress Plugin', $this->plugin_name);

        $message = new ApiMessage($to_email, __('Test Email Via SMTP2GO Wordpress Plugin', $this->plugin_name), $body);

        $message->initFromOptions();

        $request = new ApiRequest(get_option('smtp2go_api_key'));

        $success = $request->send($message);
        $reason  = '';
        if (empty($success)) {
            $response = $request->getLastResponse();
            if (!empty($response->data->field_validation_errors->message)) {
                $reason = $response->data->field_validation_errors->message;
            } elseif (!empty($response->data->error)) {
                $reason = $response->data->error;
            }
        }
        wp_send_json(array('success' => intval($success), 'reason' => $reason));
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
        if (empty($input) || strpos($input, 'api-') !== 0) {
            add_settings_error('smtp2go_messages', 'smtp2go_message', __('Invalid Api key entered.', $this->plugin_name));
            return get_option('smtp2go_api_key');
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
