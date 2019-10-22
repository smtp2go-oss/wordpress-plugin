<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://thefold.nz
 * @since      1.0.0
 *
 * @package    Smtp2go_Wordpress_Plugin
 * @subpackage Smtp2go_Wordpress_Plugin/admin/partials
 */

if (isset($_GET['settings-updated'])) {
    // add settings saved message with the class of "updated"
    add_settings_error('smtp2go_messages', 'smtp2go_message', __('Settings Saved', $this->plugin_name), 'updated');
}

// show error/update messages
settings_errors('smtp2go_messages');
function smtp2go_tab_active($tab)
{
    $default  = 'settings';
    $selected = !empty($_GET['tab']) ? $_GET['tab'] : $default;

    if ($selected === $tab) {
        return 'nav-tab-active';
    }
    return '';
}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap smtp2go">
    <div class="nav-tab-wrapper">
        <a href="<?php echo admin_url(add_query_arg(array('page' => 'smtp2go-wordpress-plugin', 'tab' => 'settings'), 'admin.php')) ?>" class="nav-tab <?php echo smtp2go_tab_active('settings') ?>">Settings</a>
        <a href="<?php echo admin_url(add_query_arg(array('page' => 'smtp2go-wordpress-plugin', 'tab' => 'test'), 'admin.php')) ?>" class="nav-tab <?php echo smtp2go_tab_active('test') ?>">Test</a>
        <a href="<?php echo admin_url(add_query_arg(array('page' => 'smtp2go-wordpress-plugin', 'tab' => 'stats'), 'admin.php')) ?>" class="nav-tab <?php echo smtp2go_tab_active('stats') ?>">Stats</a>
    </div>
    <?php if (!empty(smtp2go_tab_active('settings'))): ?>
    <h1><?php _e('SMTP2GO Settings', $this->plugin_name)?></h1>
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


<?php if (!empty(smtp2go_tab_active('test'))): ?>

    <h1><?php _e('Send Test Email', $this->plugin_name)?></h1>
    <p><?php _e('This will send a simple message to the recipient specified below, using the settings above.
     Please save any settings changes before sending the test.', $this->plugin_name);?></p>
    <div class="smtp2go-js-success smtp2go-success-message" style="display:none"><?php _e('Success! The test message was sent.', $this->plugin_name)?></div>
    <div class="smtp2go-js-failure smtp2go-error-message" style="display:none"></div>

    <form class="js-send-test-email-form" action="javascript:;">
    <table class="form-table">
        <tr>
            <td><?php _e('To Email', $this->plugin_name)?></td>
            <td><input type="email" name="smtp2go_to_email" id="smtp2go_to_email"></td>
        </tr>
        <tr>
            <td><?php _e('To Name', $this->plugin_name)?></td>
            <td><input type="text" name="smtp2go_to_name" id="smtp2go_to_name"></td>
        </tr>
    <tr>
        <td>
            <button class="js-send-test-email button button-primary"><?php _e('Send Test Email')?></button>
        </td>
        <td>&nbsp;</td>

    </tr>
    </table>
    </form>
<?php endif;?>

<?php if (!empty(smtp2go_tab_active('stats'))) :
    $this->renderStatsPage();
endif;
?>

</div>