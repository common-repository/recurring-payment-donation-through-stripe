<?php
/**
 * Plugin Name: RPADTS Settings
 *
 * @package RPADTS_Settings
 */

/**
 * Displays the help section for setting up Stripe integration and email receipts.
 */
function rpadts_help() { ?>
	<div class="wrap">
		<h4>Setup</h4>
		<ol>
			<li>You need a free Stripe account from <a target="_blank" href="https://stripe.com">Stripe.com</a></li>
			<li>Get your Stripe API keys from your
				<a target="_blank" href="https://manage.stripe.com">Stripe Dashboard</a> -> Account Settings -> API Keys tab
			</li>
			<li>Update the Full Stripe settings with your API keys and select the mode.<br/>(Test most is recommended initially to make sure everything is setup correctly)</li>
		</ol>
		<h4>Payments</h4>
		<p>To show a payment form, add the following shortcode to any post or page:
			<code>[stripe-checkout-page]</code>
		</p>
		<p>Once a payment is taken using the form, the payment information will appear on the Payments page as well as on your Stripe Dashboard.</p>
		<a name="receipt-tokens"></a>
		<h4>Email Receipts</h4>
		<p>All payment forms (standard, checkout, and subscription) can send customized email notifications.<br/>
			Payment forms can send a payment receipt.<br/>
			Subscription forms can send a subscription receipt, and a notification when a subscription has ended.<br>
			<br/>
			You have a few tokens that can be placed in the email HTML
			and WP Full Stripe will replace them with the relevant values at the point of successful payment.  The tokens you can use are: <br/>
		<ul>
			<li><strong>%AMOUNT%</strong> - The payment amount</li>
			<li><strong>%SITENAME%</strong> - The name of your WordPress blog</li>
			<li><strong>%FIRSTNAME%</strong> - The customer's first name</li>
			<li><strong>%LASTNAME%</strong> - The customer's last name</li>
			<li><strong>%CUSTOMER_EMAIL%</strong> - The customer's email address</li>
			<li><strong>%ADDRESS%</strong> - The customer's billing address</li>
			<li><strong>%CITY%</strong> - The customer's billing address city</li>
			<li><strong>%STATE%</strong> - The customer's billing address state</li>
			<li><strong>%COUNTRY%</strong> - The customer's billing address country</li>
			<li><strong>%ZIP%</strong> - The customer's billing address zip (or postal) code</li>
			<li><strong>%PAYMENTDATE%</strong> - The customer's billing date</li>
			<li><strong>%DONATIONTYPE%</strong> - The customer's payment type. Eg One time payment or recurring payment</li>
			<li><strong>%RECURRING_PAYMENT_START%</strong> - The customer recurring start payment date</li>
			<li><strong>%RECURRING_PAYMENT_END%</strong> - The customer recurring end payment date</li>
		</ul>
		</p>
		
	</div>
	<?php
}
