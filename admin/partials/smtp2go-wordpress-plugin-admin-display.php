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

        <a href="<?php echo admin_url(add_query_arg(array('page' => 'smtp2go-wordpress-plugin', 'tab' => 'settings'), 'admin.php')) ?>" class="nav-tab <?php echo SMTP2GO_tab_active('settings') ?>"><?php _e('Settings', $this->plugin_name) ?></a>
        <?php
        if (get_option('smtp2go_api_key')) :
        ?>
            <a href="<?php echo admin_url(add_query_arg(array('page' => 'smtp2go-wordpress-plugin', 'tab' => 'test'), 'admin.php')) ?>" class="nav-tab <?php echo SMTP2GO_tab_active('test') ?>">Test</a>

            <a href="<?php echo admin_url(add_query_arg(array('page' => 'smtp2go-wordpress-plugin', 'tab' => 'stats'), 'admin.php')) ?>" class="nav-tab <?php echo SMTP2GO_tab_active('stats') ?> js-stats-tab">Stats<span class="js-stats-tab-span spinner" style="float: none; display: none; margin: 0px 10px 2px ;"></span></a>

        <?php endif; ?>

    </div>

    <?php if (!empty(SMTP2GO_tab_active('settings'))) : ?>

        <h1><?php _e('General Settings', $this->plugin_name) ?></h1>

        <?php if (isset($onFreePlan) && $onFreePlan === true) : ?>
                <div class="notice notice-info" style="padding:15px">

                    <h3 style="line-height: 1.5;">You know our free plan is great, but our paid plans are even better!</h3>
                    <h3>Send more emails with fewer restrictions, and access more features such as email-to-SMS, full reporting, archiving, and 24/7 support via phone, chat and email. Woohoo!  &#127881;</h3>
                    <a class="button smtp2go-button-blue" target="_blank" href="https://app.smtp2go.com/account/changeplan/">Choose Your Plan</a>

                    <a class="button smtp2go-button-white" target="_blank" href="https://support.smtp2go.com/hc/en-gb/articles/20483715021081-Billing-Pricing-and-Plans-FAQ
">Learn More</a>
                </div>
        <?php endif; ?>


        <p style="font-weight: normal;">To create an API key, log in to the SMTP2GO web app, click "Sending > API Keys". Copy the API key then complete the details below.</p>
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
    <?php endif; ?>


    <?php if (!empty(SMTP2GO_tab_active('test'))) : ?>

        <h1><?php _e('Send Test Email', $this->plugin_name) ?></h1>
        <div class="smtp2go_text_input"><?php _e('This will send a simple message to the recipient specified below, using the settings you have provided. Please save any settings changes before sending the test.', $this->plugin_name); ?></div>

        <form class="js-send-test-email-form" action="javascript:;">

            <div class="smtp2go-admin-spacing">
                <div>
                    <input type="email" class="smtp2go_text_input" name="smtp2go_to_email" id="smtp2go_to_email" placeholder="john@example.com" required>
                </div>
                <div>
                    <label for="smtp2go_to_email"><span style="cursor: default; font-weight: normal;">A valid email address to send the test email to.</span></label>
                </div>
            </div>

            <div class="smtp2go-admin-spacing">
                <div>
                    <input type="text" class="smtp2go_text_input" name="smtp2go_to_name" id="smtp2go_to_name" placeholder="John Example" pattern="[a-zA-Z0-9 ]+" required>
                </div>
                <div>
                    <label for="smtp2go_to_name"><span style="cursor: default; font-weight: normal;">The email to name (alpha numeric characters only).</span></label>
                </div>
            </div>

            <div class="smtp2go-js-success smtp2go-success-message smtp2go_text_input" style="display:none">
                <?php _e('Success! The test message was sent.', $this->plugin_name) ?>
            </div>

            <div class="smtp2go-js-failure smtp2go-error-message smtp2go_text_input" style="display:none"></div>

            <button class="js-send-test-email button button-primary">
                <?php _e('Send Test Email') ?>
            </button>
            <span class="js-send-test spinner" style="float: none;"></span>

        </form>

    <?php endif; ?>

    <?php if (!empty(SMTP2GO_tab_active('stats'))) :
        $this->renderStatsPage();
    endif;
    ?>



</div>