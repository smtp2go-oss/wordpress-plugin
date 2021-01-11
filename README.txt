=== SMTP2GO Plugin for Wordpress ===
Contributors: thefoldnz, greatsaltlake
Tags: email, wp_mail, email reliability, smtp, smtp2go, phpmailer, mail, email marketing, newsletter, welcome email, marketing
Requires at least: 4.6
Tested up to: 5.6.0
Requires PHP: 7.0
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


== Description ==

The SMTP2GO Wordpress plugin allows you to use SMTP2GO to send all emails from your Wordpress installation.
It replaces the default phpmailer / built in php mail() functionality and allows you to send out emails via SMTP2GO's API.

Signup for a free account at https://www.smtp2go.com/


== Installation ==

Copy the SMTP2GO directory into your wp-content/plugins directory. Activate the plugin through the wp-admin 'Plugins' page.
Once successfully activated, the SMTP2GO plugin will appear in the "Settings" menu in the WordPress Admin Panel. Click on "Settings > SMTP2GO" to open the plugin configuration page.


== Support ==

If you have questions or need assistance then feel free to contact the support team by logging into the App (https://app.smtp2go.com) then clicking the support icon on the top-right of the screen.

== Changelog ==

= v1.0.8 =
* handle Deprecated: class-phpmailer.php is deprecated
* handle php var not defined error
= v1.0.7 =
* hide API key in admin
* don't pass empty BCC string to API call
* text update
* test on WordPress 5.5.1
= v1.0.6 =
* set from address from parsed headers if present / if other plugins are injecting headers like this
= v1.0.5 =
* Honor wp_mail_from and wp_mail_from_name filters
* Test with 5.5
= v1.0.4 =
* Allow extra characters into Sender Name, quote field through send process
