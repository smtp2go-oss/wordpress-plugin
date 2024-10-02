=== SMTP2GO for WordPress - Email Made Easy ===
Contributors: 2050nz, greatsaltlake
Tags: email, smtp, inbox, delivery, wp_mail
Requires at least: 5.8
Tested up to: 6.6
Requires PHP: 7.4
Stable tag: 1.10.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Resolve email delivery issues, increase inbox placement, track sent email, get 24/7 support, and real-time reporting.

== Description ==

SMTP2GO’s WordPress plugin replaces the default built in wp_mail() functionality (phpmailer) and sends your email via SMTP2GO’s API and industry leading email delivery platform.

SMTP2GO provides valuable insights into every aspect of your email's life cycle, enabling you to track delivery rates, opens, clicks, and bounce rates. Whether your email is transactional, marketing, newsletter, contact form, or notification - we have got you covered.

**The main benefits of using the official SMTP2GO plugin:**

* We have made our plugin as easy and low maintenance as possible - you can set it up in under ten minutes.
* Take over from the default WordPress email system for more reliable delivery - you can be confident your emails have arrived at their destination inbox successfully.
* Get access to our intuitive real-time reporting tools. You can uncover what is going on behind the scenes with delivery, open rates, click rates, bounce, and unsubscription reports.
* We offer secure worldwide servers with intelligent routing for network redundancy and speedy delivery.
* We handle SPF and DKIM on your behalf. SMTP2GO can even turn your "http" links into "https".
* Diagnose and resolve delivery issues with our insightful reporting page, or reach out to our award-winning support team who are available almost 24/7 to help address problems in a timely, friendly fashion.
* We have a dedicated Review team who constantly monitor the reputations of our IP's and we proactively alert members to any suspicious changes in their email regimen.
* Avoid poor reputation and throttling or limitations from over-used shared web hosts and other providers.

[Sign up here](https://www.smtp2go.com/).


== FAQ ==

= Do I need an SMTP2GO account? =

Yes, the SMTP2GO WordPress plugin uses SMTP2GO’s API to deliver emails and get statistics. Creating an account on SMTP2GO quick and simple - [sign up here](https://www.smtp2go.com/).

Once logged into your account and you have completed the required setup steps, you can get an API Key (Sending > API Keys) which you’ll need to get the plugin up and running.

= How much will it cost me? =

SMTP2GO offers a free plan that includes 1,000 emails per month. You can use this for your WordPress site but also any other email and SMTP needs you have! One account can cover all your inbox delivery and SMTP needs.

For more email volume per month and fewer restrictions, you can easily upgrade to one of the many available plans to suit your sending needs. Paid plans start at $10 USD/month - check out our [pricing here](https://www.smtp2go.com/pricing).

= Can you tell me about the compatibility of this plugin? =
Sure can! We replace the default **wp_mail** so most other plugins that need to send email will be compatible.

We are always looking to improve, so if you do find any compatibility issues, please let us know.

**Email Made Easy** has been tested for Linux and other Unix type operating systems. We do not recommend using the plugin on Windows/IIS based systems as we do not currently support these platforms.

We also recommend keeping your WordPress up to date and only use the the most recent version of WordPress, or no more than one major release behind.

= Can I get support? =

Absolutely! The SMTP2GO support team has agents located in the US, EU, UK, and the Pacific to cover all time zones providing assistance when you need it most. If you have questions or need help then feel free to contact the support team by logging into your SMTP2GO dashboard and clicking on the support icon on the top-right. We can be reached by instant message, ticket, or phone.


= How do I avoid emails going to the spam or junk folder? =

1. Check that your domain names are fully verified in the "Sending > Verified Sender" section of your SMTP2GO account.

2. Make sure your domain has a great reputation and isn't listed on any blacklists. A good place to start checking is MXToolbox.

3. Think about your email content and subject line to avoid words and phrases that could trigger a spam filter.

If you're needing extra help, our support team has lots of tips and tricks to help you out. You can find the support tab in your SMTP2GO dashboard.

== Installation ==

If you are not an existing customer, you will need an SMTP2GO account - [a free plan is available!](https://www.smtp2go.com)

https://www.youtube.com/watch?v=28MaT2NWR5A

**Standard:**

1. Click the "Plugins" tab in your WordPress administration (wp-admin) dashboard, and choose "Add New".
2. Search for "Email Made Easy" or "SMTP2GO".
3. Click the "Install Now" button.
4. Once the plug in is installed, click "Activate".


**Configuration:**

You will need to enable the plugin and enter the required details under the "Settings" tab.

1. Tick the checkbox labelled "Enable Email Made Easy by SMTPGO".
2. Enter your API Key which can be found in your SMTP2GO dashboard: "Sending > API Keys".

 **Note:**
 The API Key needs at least the following permissions:

* Emails
* Statistics
* Sender Domains

3. Set the default From Email Address.
4. Set the default From Name.
5. Save the settings by clicking the "Save Settings" button at the bottom.

 **Note:**
 The default From Email Address and From Name will only be used if your other plugins don't specify a sending email address.


You can add custom headers to your emails, such as headers for custom tracking with third-party tools such as "X-Campaign".

The "Test" tab can be used to send a test email to ensure your settings have been entered correctly.

And that's it! If any problem occurs, please contact us via the "Support" tab within the SMTP2GO app.


**Advanced Setup:**

1. Copy the SMTP2GO directory into your wp-content/plugins directory.
2. Activate the plugin through the wp-admin "Plugins" page.
3. Once successfully activated, the SMTP2GO plugin will appear in the "Settings" menu in the WordPress Admin Panel.
4. Click on "Settings > SMTP2GO" to open the plugin configuration page.
5. Retrieve a copy of your API key by going to the "Sending > API Keys" section of your SMTP2GO dashboard.
6. Enable the checkbox "Enable Email Made Easy by SMTPGO".
7. Add a default sending name and email address.

Note: The default From Email Address and From Name is only used if these are not specified by any other Wordpress function or plugin that is trying to send an email.

== Support ==

If you have questions or need assistance then feel free to contact the support team by logging into your [SMTP2GO dashboard](https://app.smtp2go.com) and clicking the support icon on the top right navigation bar.

More information on this plugin is available in our [knowledgebase](https://support.smtp2go.com/hc/en-gb/articles/900000195666-SMTP2GO-WordPress-Plugin).

== About SMTP2GO ==

Founded in 2006, SMTP2GO is a fast and scalable world class email service provider for sending transactional and marketing emails. It is developed and supported by a team of delivery experts at the forefront of the email industry, providing a reliable SMTP solution for over 35,000 businesses.

Complexities such as reputation monitoring, SPF and DKIM are professionally managed for each customer. Native-English speaking support is available worldwide (agents in the USA, EU, UK, Australia, and New Zealand).

Our data centers are located around the world, meaning lightning-fast connection speeds, network redundancy, and GDPR compliance.

== Changelog ==

= v1.10.1 =
* update readme
= v1.10.0 =
* encrypt API key in database
* check WordPress 6.6 compatibility
= v1.9.0 =
* add upsell modal if user is on free plan
* validate API key when entered
* e2e Github action tests
* iterate Guzzle version in composer package
= v1.8.2 =
* check WordPress 6.5 compatibility
= v1.8.1 =
* fix get_plugins getting called when not available
= v1.8.0 =
* add checking and warning for conflicting plugins
= v1.7.1 =
* admin and readme text correction
= v1.7.0 =
* bring back PHP 7.4 compatability
= v1.6.1 =
* require PHP 8.1
= v1.6.0 =
* use new smtp2go composer package with retry feature
= v1.5.6 =
* readme updated
* test on WordPress 6.3
* rename smtp2go dir to app for FlyWheel compatability
= v1.5.4 =
* drop testing / supporting PHP 7.2
= v1.5.3 =
* ensure phpmailer is set to use the 'mail' mailer
= v1.5.2 =
* tested on WordPress 6.2
= v1.5.1 =
* missed moving the tested up to version number with Readme update
= v1.5.0 =
* remove sender domains fn
* upgrade smtp2go-oss/smtp2go-php to 1.1.2