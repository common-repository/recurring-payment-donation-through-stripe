=== Recurring payment and donation through Stripe ===

Contributors: brainvireinfo
Donate link: https://www.brainvire.com/
Tags: Stipe, Recurring payment, Payment Gateway, Stripe Checkout, Stripe Payment 
Author URI: https://www.brainvire.com/
Author: brainvireinfo
Requires at least: 4.5
Tested up to: 6.6
Requires PHP: 5.2.4
Stable tag: 5.3
Version: 1.1
License: GPLv2 or later

Easy, simple setup of stripe payment gateway for accepting donations and payment seamlessly with WordPress.

== Description ==

This <b>Recurring payment and donation through Stripe</b> plugin provide you facility for start accepting donations and payment seamlessly with WordPress. This plugin provide a best backend functionality for manage the payment mode like recurring payment or one-time payment.

AS now a days stripe is one of the leading quick payment gateway. We have used stripe software to develop a plugin that can accept payment from user faster and provide them seamless experience. Our high-end developed plugin is fully secured and user-friendly.  This plugin gives you the options of receiving payment in recurring option or one-time payment.

This plugin can be helpful to make payment task easier for the user. Here, the user just has to click a few time and a donation will be made. This plugin is specially designed to make payment step faster and easier. This plugin will truly helpful to any organization that allows their users to make recurring payments on given schedules.

== Installation ==

= Minimum Requirements =

* WordPress 4.4 or greater
* PHP version 5.2.4 or greater
* MySQL version 5.0 or greater

= Install =

Using The WordPress Dashboard

    1. Navigate to "Plugins -> Add New" from your dashboard
    2. Search for "Recurring payment and donation through Stripe"
    3. Click "Install Now" of this plugin
    4. Activate the plugin

Manual installation

	1. Upload the 'Recurring payment and donation through Stripe' folder to the '/wp-content/plugins/' directory.
	2. Activate the plugin through the 'Plugins' menu in WordPress.
	3. Go to Recurring P&D Through Stripe and update settings for the payment.

	
== Frequently Asked Questions ==

= 1. How to setup? =

First of all, you need to have an account with Stripe.com for API keys.

After successful login in stripe website, you have to go to stripe Dashboard > Account Settings > API Keys tab.

You have to use API key in our plugin to transact amount through your website. (Test mode is recommended initially to make sure everything is setup correctly)

= 2. How to do Custom Admin Settings? =

Plugins > Quick payment and donation through Stripe > settings.
In the setting, you have three tab options to configure different settings. 

(1) Stripe:
	Here you can set payment mode(test/live), currency and API keys for payment. 

(2)	Recurring Payment:
	This option will allow you to collect payments from a user on a recurring basis. Users can select payment option either one-time payment or recurring payment. Recurring payment has different period options like monthly, quarterly, half yearly and yearly.  
	To disable this function, you have to uncheck Recurring Payment check box. 

(3)	Email Notification:
For notification, you can design custom email template to inform the user that payment is done.
	
The user, who make payment will get notification automatically. All the payment forms (standard, checkout and subscription) have the option to send customized email notifications to the user.

In the template you can use different token as well. These token will replace values once your payment has been done and that email will be trigger to respective user. 

The tokens you can use are: 

	%AMOUNT% - The payment amount
	%NAME% - The name of your WordPress blog
	%FIRSTNAME% - The customer's first name
	%LASTNAME% - The customer's last name
	%CUSTOMER_EMAIL% - The customer's email address
	%ADDRESS% - The customer's billing address
	%CITY% - The customer's billing address city
	%STATE% - The customer's billing address state
	%COUNTRY% - The customer's billing address country
	%ZIP% - The customer's billing address zip (or postal) code
	%PAYMENTDATE% - The customer's billing date
	%RECURRING_PAYMENT_START% - The customer recurring start payment date
	%RECURRING_PAYMENT_END% - The customer recurring end payment date
 
= 3. How to integrate into the website? =
 
To show a payment form on the website, you have to add the following shortcode [stripe-checkout-page] to any post or page.

= 4. How to check payments? = 

Once the user completes the transaction, you will be able to see all the transaction detail on the "Payments" page as well as on your Stripe Dashboard.

== Screenshots ==

1. API settings
2. Email notification settings
3. Recurring payment setting
4. Transaction list


== Changelog ==
 
= 1.0 =
* Initial Release


== Upgrade Notice ==

= 1.1 =
* Plugin Compatible with latest version of Wordpress
