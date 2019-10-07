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
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h1><?php _e('Plugin Settings', SMTP_TEXT_DOMAIN) ?></h1>
    <form action="options.php" method="post">
    <?php
        // output security fields for the registered setting "wporg"
        settings_fields( 'api_settings' );
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
        do_settings_sections( 'smtp2go-wordpress-plugin' );
        // output save settings button
        submit_button( 'Save Settings' );
    ?>
    </form>
</div>