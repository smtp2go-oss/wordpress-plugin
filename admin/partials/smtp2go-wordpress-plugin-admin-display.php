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
define('SMTP_TEXT_DOMAIN', 'smtp2go-wordpress-plugin');

if (isset($_GET['settings-updated'])) {
    // add settings saved message with the class of "updated"
    add_settings_error('smtp2go_messages', 'smtp2go_message', __('Settings Saved', SMTP_TEXT_DOMAIN), 'updated');
}

// show error/update messages
settings_errors('smtp2go_messages');
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h1><?php _e('Smtp2Go Settings', SMTP_TEXT_DOMAIN)?></h1>
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
</div>