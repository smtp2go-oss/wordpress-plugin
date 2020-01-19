=== SMTP2GO Plugin for Wordpress ===
Contributors: ethos49, greatsaltlake
Tags: email
Requires at least: 4.6
Tested up to: 5.3.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The SMTP2GO Wordpress plugin allows you to use SMTP2GO to send all email from your Wordpress installation. It replaces the default phpmailer / built in php mail() functionality and allows you to send out emails via SMTP2GO's API.

== Description ==

The SMTP2GO Wordpress Plugin allows you to use SMTP2GO as the email sender for your Wordpress installation.

Avoid SMTP and outgoing port issues.

Signup for a (free) account at https://www.smtp2go.com/

This plugin sends all WordPress wp_mail out via SMTP2GOs API

== Installation ==

Copy the smtp2go directory into your wp-content/plugins directory. Activate the plugin through the wp-admin plugins page. And load in your sending configuration.


== Changelog ==

= dev =
* Pre release


== Contributing ==

Contributions are welcome. Please include tests with your PR's.


== Testing ==

Tests are written for PHPUnit. The phpunit.phar executable and phpunit.xml file are not included in the repo, an example is below.
<?xml version="1.0" encoding="UTF-8"?>
<phpunit
         colors="true"
         convertErrorsToExceptions="true"
         convertNoticesToExceptions="true"
         convertWarningsToExceptions="true"
         processIsolation="false"
         stopOnFailure="false">
    <php>
        <const name="SMTP2GO_API_KEY" value="Your Api Key"/>
        <const name="SMTP2GO_TEST_RECIPIENT" value="Test Recipient &lt;test+recipient@yourdomain.co&gt;"/>
        <const name="SMTP2GO_TEST_SENDER" value="Test Sender &lt;test+sender@yourdomain.co&gt;"/>
    </php>
</phpunit>
