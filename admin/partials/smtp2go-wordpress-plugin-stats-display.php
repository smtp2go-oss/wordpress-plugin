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
    <h1><?php _e('Smtp2Go Stats', SMTP_TEXT_DOMAIN)?></h1>

    <?php if (!empty($stats)): ?>

    <?php foreach ($stats as $label => $value): ?>

    <dl class="smtp2go-datalist">
        <dt><?php echo ucwords(str_replace('_', ' ', $label)) ?></dt>
        <dd><?php echo $value ?></dd>
    </dl>
    <?php endforeach;?>

    <?php else: ?>

    <h3>Unable to retrieve stats. Please wait a minute and try again.</h3>
    <?php endif;?>
</div>