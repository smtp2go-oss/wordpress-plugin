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
    <form action="/wp-admin/admin-post.php" method="post">
        <input type="hidden" name="action" value="manage_smtp2go_options">

        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row"><label for="api_key"><?php _e('Api Key', SMTP_TEXT_DOMAIN) ?></label></th>
                    <td>
                        <input class="smtp2go_wide_input" id="api_key" type="text" name="smtp2go_settings[api_key]" value=""
                            placeholder="Enter your <?php _e('Enter your Api Key here', SMTP_TEXT_DOMAIN) ?>" />
                
                            <small class="smtp2go_help_text"><?php _e('You can find your api key somewhere') ?></small>
                        </td>
                </tr>
            </tbody>

        </table>
        <input type="submit" class="button" value="Submit">
    </form>
</div>