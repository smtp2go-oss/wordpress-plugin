# Wordpress Plugin
The SMTP2GO Plugin For Wordpress allows you to use SMTP2GO as the email sender for your Wordpress installation.

# Installation

Copy the repo into your wp-content/plugins directory. Activate the plugin through the wp-admin plugins page.

# Contributing

Contributions are welcome. Please include tests with your PR's.

# Testing
Tests are written for PHPUnit. The phpunit.phar executable and phpunit.xml file are not included in the repo, an example is below.
```
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
```