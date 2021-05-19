<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.smtp2go.com
 * @since      1.0.1
 *
 * @package    SMTP2GO\WordpressPlugin
 * @subpackage SMTP2GO\WordpressPlugin/admin/partials
 */

if (isset($_GET['settings-updated'])) {
    // add settings saved message with the class of "updated"
    add_settings_error('smtp2go_messages', 'smtp2go_message', __('Settings Saved', $this->plugin_name), 'updated');
}

// show error/update messages
settings_errors('smtp2go_messages');
function SMTP2GO_tab_active($tab)
{
    $default  = 'settings';
    $selected = !empty($_GET['tab']) ? $_GET['tab'] : $default;

    if ($selected === $tab) {
        return 'nav-tab-active';
    }
    return '';
}
?>



<div class="wrap smtp2go">
    <div class="smtp2go-intro-wrapper">
        <div class="inner">
            <img style="width: 150px" src="<?php echo plugins_url('smtp2go-logo-alt.svg', dirname(__FILE__, 2)) ?>" />
            <div class="container">
                <p><b>The SMTP2GO Wordpress plugin allows you to use SMTP2GO to deliver all emails from your Wordpress installation.</b></p>
                    <div><a class="button smtp2go-button-blue" target="_blank" href="https://app.smtp2go.com">Open the SMTP2GO
                            web app</a>

                            <a class="button smtp2go-button-white" target="_blank" href="https://support.smtp2go.com/hc/en-gb/articles/900000195666">View the plugin documentation</a>
                        </div>

            </div>
        </div>
    </div>
    <div class="nav-tab-wrapper">
        
        <a href="<?php echo admin_url(add_query_arg(array('page' => 'smtp2go-wordpress-plugin', 'tab' => 'settings'), 'admin.php')) ?>"
            class="nav-tab <?php echo SMTP2GO_tab_active('settings') ?>"><?php _e('Settings', $this->plugin_name)?></a>
        
        <a href="<?php echo admin_url(add_query_arg(array('page' => 'smtp2go-wordpress-plugin', 'tab' => 'test'), 'admin.php')) ?>"
            class="nav-tab <?php echo SMTP2GO_tab_active('test') ?>">Test</a>
        
        <a href="<?php echo admin_url(add_query_arg(array('page' => 'smtp2go-wordpress-plugin', 'tab' => 'stats'), 'admin.php')) ?>"
            class="nav-tab <?php echo SMTP2GO_tab_active('stats') ?> js-stats-tab">Stats<span
                class="js-stats-tab-span spinner" style="float: none; display: none; margin: 0px 10px 2px ;"></span></a>

                <a href="<?php echo admin_url(add_query_arg(array('page' => 'smtp2go-wordpress-plugin', 'tab' => 'validation'), 'admin.php')) ?>"
            class="nav-tab <?php echo SMTP2GO_tab_active('validation') ?> js-validation-tab">Sender Domain Validation<span
                class="js-validation-tab-span spinner" style="float: none; display: none; margin: 0px 10px 2px ;"></span></a>

    </div>
    <!--    <p><img src="--><?php //echo plugins_url('SMTP2GO_logo.png', dirname(__FILE__,2)) ?>
    <!--"/></p>-->

    <?php if (!empty(SMTP2GO_tab_active('settings'))): ?>

    <h1><?php _e('General Settings', $this->plugin_name)?></h1>
        <p style="font-weight: normal;">Open the SMTP2GO web app, create an API key, then complete the details below.</p>
    <form action="options.php" method="post">
        <?php
// output security fields for the registered setting "smtp2go"
settings_fields('api_settings');
// output setting sections and their fields
// (sections are registered for "smtp2go", each field is registered to a specific section)
do_settings_sections('smtp2go-wordpress-plugin');
// output save settings button
submit_button('Save Settings');
?>
    </form>
    <?php endif;?>


    <?php if (!empty(SMTP2GO_tab_active('test'))): ?>

    <h1><?php _e('Send Test Email', $this->plugin_name)?></h1>
    <p><?php _e('This will send a simple message to the recipient specified below, using the settings you have provided.
     Please save any settings changes before sending the test.', $this->plugin_name);?></p>
    <div class="smtp2go-js-success smtp2go-success-message" style="display:none">
        <?php _e('Success! The test message was sent.', $this->plugin_name)?></div>
    <div class="smtp2go-js-failure smtp2go-error-message" style="display:none"></div>

    <form class="js-send-test-email-form" action="javascript:;">
        <table class="form-table">
            <tr>
                <td style="width: 20%"><?php _e('To Email', $this->plugin_name)?></td>
                <td>
                    <input type="email" class="smtp2go_text_input" name="smtp2go_to_email" id="smtp2go_to_email" placeholder="john@example.com" required>
                    <br />
                    <label for="smtp2go_to_email"><span style="cursor: default; font-weight: normal;">A valid email address to send the test email to.</span></label>
                </td>
            </tr>
            <tr>
                <td><?php _e('To Name', $this->plugin_name)?></td>
                <td>
                    <input type="text" class="smtp2go_text_input" name="smtp2go_to_name" id="smtp2go_to_name" placeholder="John Example" pattern="[a-zA-Z0-9 ]+" required>
                    <br />
                    <label for="smtp2go_to_name"><span style="cursor: default; font-weight: normal;">The email to name (alpha numeric characters only).</span></label>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button class="js-send-test-email button button-primary">
                        <?php _e('Send Test Email')?>
                    </button>
                    <span class="js-send-test spinner" style="float: none;"></span>
                </td>

            </tr>
        </table>
    </form>

    <?php endif;?>

    <?php if (!empty(SMTP2GO_tab_active('stats'))):
    $this->renderStatsPage();
endif;
?>

<?php if (!empty(SMTP2GO_tab_active('validation'))):
    $this->renderValidationPage();
endif;
?>

</div>
