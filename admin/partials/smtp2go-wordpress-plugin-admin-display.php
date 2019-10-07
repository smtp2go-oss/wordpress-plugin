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
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    Hello World
    <form action="/wp-admin/admin-post.php" method="post">
  <input type="hidden" name="action" value="manage_smtp2go_options">
  <input type="hidden" name="data" value="foobarid">
  <input type="submit" value="Submit">
</form>
</div>