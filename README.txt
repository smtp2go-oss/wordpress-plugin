=== SMTP2GO - Email Made Easy ===
Contributors: 2050nz, greatsaltlake
Tags: email, wp_mail, smtp, smtp2go, phpmailer, newsletter, marketing, inbox, api, delivery
Requires at least: 5.5
Tested up to: 6.1
Requires PHP: 7.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Resolve email delivery issues, increase inbox placement, track sent email, get 24/7 support, and real-time reporting.

== Description ==

SMTP2GO provides valuable insight into every aspect of your email needs, whether it is transactional, marketing campaigns, contact forms, or notifications. SMTP2GO provides valuable insights into every aspect of your email's life cycle, enabling you to track delivery rates, opens, clicks, and bounce rates. Whether you are sending transactional, marketing, contact form, or notification emails - we have got you covered.

With **Email Made Easy**, you can access real-time reporting, statistics and charts in addition to having powerful features that will enhance your emailing experience at your fingertips. The plugin uses SMTP2GO’s industry-leading network to deliver all email from your WordPress installation by replacing the default phpmailer/built in wp_mail() functionality and sending via SMTP2GO’s API.

**The main benefitis of using the official SMTP2GO plugin:**

* We made our plugin easy and as low maintenance as possible. You can set it up in under ten minutes and there is zero maintenance required. Let it do its thing while you do yours!
* Take over from the WordPress email system for more reliable delivery - be confident your emails have been arrived at their destination successfully.
* Get access to our intuitive real-time reporting tools. You can uncover what's going on behind the scenes with delivery, open, click, bounce, and unsubscribe reports.
* We offer secure worldwide servers with intelligent, genius-level routing for network redundancy, speedy delivery, and lightning-fast reporting
* We handle SPF and DKIM on your behalf
* Diagnose and resolve delivery issues with our insightful reporting page, or reach out to our award-winning support team who are available almost 24/7 to help address problems in a timely, friendly fashion.
* We have a dedicated Review team who constantly monitor the reputations of out IP's  and we proactively alert members to any suspicious changes in their email regimen.
* Our architecture is scalable to cater to any sending volume- whether it's 1000 emails a month, or 5 million. We like numbers big and small!
* Avoid poor reputation and throttling or limitations from over used shared web hosts and other providers

Sign up for a [free account here](https://www.smtp2go.com/).


== FAQ ==

= Do I need an SMTP2GO account? =

Yes, the SMTP2GO WordPress plugin uses SMTP2GO’s API to deliver emails and get statistics. Creating an account on SMTP2GO is free, quick and simple to set up - [sign up here](https://www.smtp2go.com/).

Once logged into your account and completed the required setup steps, you can get an API Key (Settings > API Keys) which you’ll need to get the plugin up and running.

= How much does it cost? =

SMTP2GO offers a free forever plan that includes 1,000 emails per month.

For more email volume per month and no daily restrictions, you can upgrade within your SMTP2GO account to one of the many available plans to suit your sending needs.

Paid plans have access to very useful extra features such as Subaccounts, Email Archiving, Email Testing, and Dedicated IPs.

Paid plans start at $10 USD/month - check out our [pricing here](https://www.smtp2go.com/pricing).

= Can you tell me about the compatibility of this plugin? =
Sure can! We replace the default **wp_mail** so any plugin that makes use of this will be compatible.

If you do find some compatibility issues, please do let the support team know.

**Email Made Easy** has been tested for Linux and other Unix type operating systems. We do not recommend using the plugin on Windows/IIS based systems as we do not currently support these platforms.

We also recommend keeping your WordPress up to date and only use the the most recent version of WordPress, or no more than one major release behind.

= Can I get support? =

Absolutely! SMTP2GO has support agents located in the US, EU, UK, and the Pacific to cover all time zones providing assistance when you need it most. If you have questions or need assistance then feel free to contact the support team by logging into your SMTP2GO dashboard and clicking on the support icon on the top-right of the screen. We can be reached by instant message, ticket, or phone.


= How do I avoid emails going to the spam or junk folder? =

1. Ensure you have added your Sender Domain Names to the "Sending > Verified" section of your SMTP2GO account, and have them all fully verified.

2. Make sure your domain has a great reputation and isn't listed on any blacklists.

3. Think about your email content and avoid words and phrases that could trigger a spam filter.

If you're needing extra help, our support team has lots of tips and tricks to help you out. You can find the support tab in your SMTP2GO dashboard.

== Installation ==

If you are not an existing customer, you will need to signup for an SMTP2GO account - [a free plan is available!](https://www.smtp2go.com)

https://www.youtube.com/watch?v=28MaT2NWR5A

**Standard:**

1. Click the "Plugins" tab in your WordPress administration (wp-admin) dashboard, and choose "Add New".
2. Search for "Email Made Easy" or "SMTP2GO".
3. Click the "Install Now" button.
4. Once the plug in is installed, click "Activate".


**Configuration:**

You will need to enable the plugin and enter the required details under the "Settings" tab.

1. Enable the checkbox "Enable Email Made Easy by SMTPGO".
2. Enter your API Key which can be found in your SMTP2GO: "Settings > API Keys".

 **Note:**
 The API Key needs at least the following permissions:

* Emails
* Statistics
* Sender Domains

3. Set the default From Email Address.
4. Set the default From Name.
5. Save the settings by clicking the "Save Settings" button at the bottom.

 **Note:**
 The default From Email Address and From Name can be changed programmatically.


You can add custom headers to your emails, such as headers for custom tracking with third-party tools such as "X-Campaign".

The "Test" tab can be used to send a test email to ensure your settings have been entered correctly.

The "Stats" tab will give you an overview of your SMTP2GO plan’s quota as well as your Spam and Bounce rates for the past 30 days.

And that's it! Once you've installed and enabled the plugin, all emails originating from your WordPress installation will be routed via your SMTP2GO account.

If any problem occurs, please contact us at ticket@smtp2go.com or via the "Support" tab within the SMTP2GO app.


**Advanced Setup:**

1. Copy the SMTP2GO directory into your wp-content/plugins directory.
2. Activate the plugin through the wp-admin "Plugins" page.
3. Once successfully activated, the SMTP2GO plugin will appear in the "Settings" menu in the WordPress Admin Panel.
4. Click on "Settings > SMTP2GO" to open the plugin configuration page.
5. Retrieve a copy of your API key by going to the "Settings > API Keys" section of your SMTP2GO dashboard.
6. Enable the checkbox "Enable Email Made Easy by SMTPGO".
7. Add a default sending name and email address.

Note: The default From Email Address and From Name can be changed programmatically.

== Support ==

If you have questions or need assistance then feel free to contact the support team by logging into your [SMTP2GO dashboard](https://app.smtp2go.com) then clicking the support icon on the top-right of the screen.

More information on this plugin is available in our [Knowledgebase](https://support.smtp2go.com/hc/en-gb/articles/900000195666-SMTP2GO-WordPress-Plugin).

== About SMTP2GO ==

Founded in 2006, SMTP2GO is a fast and scalable world clase email service provider for sending transactional and marketing emails. It is developed and supported by a team of delivery experts at the forefront of the email industry, providing a reliable and scalable SMTP solution for over 35,000 businesses.

Complexities such as reputation monitoring, SPF and DKIM are professionally managed for each customer. Native-English speaking support is available worldwide (agents in the USA, EU, UK, Australia, and New Zealand).

Our data centers located around the world, meaning lightning-fast connection speeds, network redundancy, and GDPR compliance.

== Changelog ==

= v1.5.1 = missed moving the tested up to version number with Readme update
= v1.5.0 =
* remove sender domains fn
* upgrade smtp2go-oss/smtp2go-php to 1.1.2
= v1.4.2 = test on WordPress 6.1
= v1.4.1 = handle php 8.1 PHP Deprecated notices
= v1.4.0 = default SMTP2GO API send call to version 2 structure https://apidoc.smtp2go.com/documentation/#/POST/email/send
= v1.3.0 =
* update smtp2go-oss/smtp2go-php handle duplicate reply-to headers
= v1.2.7 =
* test on WordPress 6.0
= v1.2.6 =
* fix for inline attachment handling
= v1.2.5 =
* test on WordPres 5.9
= v1.2.4 =
* API call for stats pulls detail for specific key / user
= v1.2.3 =
* plugin layout updates
= v1.2.2 =
* PHP 7.2 compatability
= v1.2.1 =
* user php-scoper to avoid potential conflicts
* fix issue with header handling
* additional error handling in admin test email setup
= v1.2.0 =
* use composer package for API integration https://github.com/smtp2go-oss/smtp2go-php
* fix sender domain validation check
= v1.1.5 =
* add sender domain verification tab
* add uninstaller / clean up database
= v1.1.4 =
* check the enable/disable flag, plugin wasn't honouring the flag and sending out via API regardless
= v1.1.3 =
* HTML email handling issue
* check variable for type instead of type hint
= v1.1.2 =
* support GravityForms multiple email recipients
* handle plugin conflicts when admin sends a test email
= v1.1.1 =
* initMailer returns args for wp_mailer
= v1.1.0 =
* codebase updated, no longer override wp_mail, remove BC
* updated unit tests
* admin email test send updated
= v1.0.10 =
* revert depreciated mailer handling while we figure out how / if to implement backwards compatibility
= v1.0.9 =
* update Deprecated: class-phpmailer.php handling
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
