<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://brainvire.com
 * @since             1.0.1
 * @package           Recurring Payment & Donation Through Stripe
 *
 * @wordpress-plugin
 * Plugin Name: Recurring Payment & Donation Through Stripe
 * Plugin URI:  http://brainvire.com/
 * Description: Recurring Payment & Donation Through Stripe
 * Version: 1.1
 * Author: Brainvireinfo
 * Author URI: https://www.brainvire.com/
 * Text Domain: recurring-payment-donation
 * License: GPLv2 or later
 */

/**
 * Adds a 'Settings' link to the plugin action links in the admin area.
 *
 * @param array  $actions     An array of plugin action links.
 * @param string $plugin_file The plugin file path.
 * @return array The array of plugin action links with the 'Settings' link added.
 */
function eapm_admin_settings( $actions, $plugin_file ) {
	static $plugin;
	if ( ! isset( $plugin ) ) {
		$plugin = plugin_basename( __FILE__ );
	}
	if ( $plugin === $plugin_file ) {
		$settings = array(
			'settings' => '<a href="' . esc_url( admin_url( 'admin.php?page=rpadts-help' ) ) . '">' . __( 'Settings', 'disable-wp-user-login' ) . '</a>',
		);
		$actions  = array_merge( $settings, $actions );
	}
	return $actions;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'eapm_admin_settings', 10, 2 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'RPADTS_NAME' ) ) {
	define( 'RPADTS_NAME', trim( dirname( plugin_basename( __FILE__ ) ), '/' ) );
}

if ( ! defined( 'RPADTS_BASENAME' ) ) {
	define( 'RPADTS_BASENAME', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'RPADTS_DIR' ) ) {
	define( 'RPADTS_DIR', plugin_dir_path( __FILE__ ) );
}

// Stripe PHP library.
require_once( dirname( __FILE__ ) . '/vendor/stripe/stripe-php/init.php' );
if ( esc_attr( get_option( 'rpadts_apiMode' ) ) == 'test' ) {
	\Stripe\Stripe::setApiKey( esc_attr( get_option( 'rpadts_secretKey_test' ) ) );
} else if ( esc_attr( get_option( 'rpadts_apiMode' ) ) == 'live' ) {
	\Stripe\Stripe::setApiKey( esc_attr( get_option( 'rpadts_secretKey_live' ) ) );
}

include_once RPADTS_DIR . '/admin/rpadts-setting-page.php';
include_once RPADTS_DIR . '/admin/rpadts-currency.php';
include_once RPADTS_DIR . '/admin/rpadts-help-page.php';
include_once RPADTS_DIR . '/admin/class-rpadts-payment-list-table.php';

/**
 * Enqueue scripts and styles for the plugin.
 */
function rpadts_enqueue_scripts() {

	wp_register_style( 'rpadts-main-css', plugins_url( '/assets/css/newstyle.css', __FILE__ ), array(), '1.0.1' );
	wp_enqueue_style( 'rpadts-main-css' );

	wp_register_script( 'rpadts-checkout-form', plugins_url( '/assets/js/rpadts-checkout-form.js', __FILE__ ), array(), '1.0.1', true );
	wp_enqueue_script( 'rpadts-checkout-form' );

	wp_register_script( 'rpadts-jquery-validate', plugins_url( '/assets/js/jquery.validate.js', __FILE__ ), array( 'jquery' ), '1.19.3', true );
	wp_enqueue_script( 'rpadts-jquery-validate' );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery' ), '1.12.1', true );

	wp_register_style( 'rpadts-jquery-ui', plugins_url( '/assets/css/jquery-ui.css', __FILE__ ), array(), '1.12.1' );
	wp_enqueue_style( 'rpadts-jquery-ui' );
}
add_action( 'wp_enqueue_scripts', 'rpadts_enqueue_scripts' );
/**
 * Enqueue admin scripts and styles for the plugin.
 */
function rpadts_admin_enqueue_scripts() {

	wp_register_style( 'rpadts-css-main', plugins_url( '/assets/css/main.css', __FILE__ ), array(), '1.0.1' );
	wp_enqueue_style( 'rpadts-css-main' );
	wp_enqueue_style( 'thickbox' );

	wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery' ), '1.12.1', true );

	wp_enqueue_script( 'media-upload', array( 'jquery' ), '5.3.2', true );

	wp_enqueue_script( 'rpadts-admin-validation', plugins_url( '/assets/js/rpadts-admin-validation.js', __FILE__ ), array( 'jquery' ), '1.0.1', true );

	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'rpadts_admin_enqueue_scripts' );

/**
 *  Auto-Create table while active plugin
 */
function rpadts_custom_plugin_activation() {

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	global $wpdb;
	$stripe_transaction_table = $wpdb->prefix . 'stripe_transaction_table';
	$stripe_transaction_query = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $stripe_transaction_table ) );

	if ( $stripe_transaction_query != $stripe_transaction_table ) {

		if ( ! empty( $wpdb->charset ) ) {
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		}

		if ( ! empty( $wpdb->collate ) ) {
			$charset_collate .= " COLLATE $wpdb->collate";
		}

		$sql_rp = 'CREATE TABLE ' . $stripe_transaction_table . " (
                         id int(10) unsigned NOT NULL AUTO_INCREMENT,
                         first_name varchar(256) NOT NULL,
                         last_name varchar(256) NOT NULL,
                         email varchar(256) NOT NULL,
						 phone_number varchar(256) NOT NULL,
						 address text NOT NULL,
						 country text NOT NULL,
						 state text NOT NULL,
						 city text NOT NULL,
						 zipcode varchar(256) NOT NULL,
						 amount varchar(256) NOT NULL,
						 donation_type varchar(256) NOT NULL,
						 period_start varchar(256) NOT NULL,
						 period_end varchar(256) NOT NULL,
						 payment_currency varchar(256) NOT NULL,
                         payment_id varchar(256) NOT NULL,
                         payment_status varchar(256) NOT NULL,
                         created_at varchar(256) NOT NULL,
					PRIMARY KEY (id)
			 )		$charset_collate;";

			dbDelta( $sql_rp );
	}

	$user_id = get_current_user_id();

	if ( get_page_by_title( 'Stripe Thank you!' ) == null ) {
		$thankyou_post = array(
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'post_author' => $user_id,
			'post_name' => 'stripe-thank-you',
			'post_status' => 'publish',
			'post_title' => 'Stripe Thank you!',
			'post_content' => '',
			'post_type' => 'page',
		);
		// insert page and save the id.
		$thankyou_page = wp_insert_post( $thankyou_post );
	}

	update_option( 'rpadts_apiMode', 'test' );
	update_option( 'rpadts_currency', 'usd' );
	update_option( 'rpadts_email_subject', 'Payment Receipt' );
	update_option(
		'rpadts_email_messagebody',
		'<html><body><p>Hi %FIRSTNAME% %LASTNAME%,</p><p>Thanks for your payment/donation. Here your receipt for your payment.</p><p>%FIRSTNAME% - %LASTNAME%</p><p>%ADDRESS%</p><p>%CITY%, %STATE%</p><p>%COUNTRY% - %ZIP%</p><br/><p>Payment Mode:</p><p>Donation Amount: %AMOUNT% </p><p>Donation frequency: %DONATIONTYPE%</p><p>Date of Donation: %PAYMENTDATE%</p><br/>
	<p>Sincerely,</p><p>%SITENAME%</p><body></html>'
	);
}
register_activation_hook( __FILE__, 'rpadts_custom_plugin_activation' );

/**
 * Add admin menu pages for the plugin.
 */
function rpadts_menu_pages() {
	// Add the top-level admin menu.
	$page_title = 'Recurring P&D Through Stripe Setting';
	$menu_title = 'Recurring P&D Through Stripe';
	$menu_slug  = 'rpadts-settings';
	$capability = 'manage_options';
	$function   = 'rpadts_settings_callback';
	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function );

	// Add submenu page with same slug as parent to ensure no duplicates.
	$sub_menu_title = 'Settings';
	add_submenu_page( $menu_slug, $page_title, $sub_menu_title, $capability, $menu_slug, $function );

	$submenu_page_title = 'Stripe Payments';
	$submenu_title      = 'Payments';
	$submenu_slug       = 'stripe-payments';
	$submenu_function   = 'rpadts_payments';
	add_submenu_page( $menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, $submenu_function );

	$submenu_page_title = 'Help';
	$submenu_title      = 'Help';
	$submenu_slug       = 'rpadts-help';
	$submenu_function   = 'rpadts_help';
	add_submenu_page( $menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, $submenu_function );
}
add_action( 'admin_menu', 'rpadts_menu_pages' );

/**
 * Checkout Page Function
 */
function rpadts_checkout_page_callback() {
	if ( isset( $_POST['_wpnonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'rpadts_checkout_form' ) ) {
		wp_die( 'Nonce verification failed, please try again.' );
	}

	$current_time = current_time( 'timestamp' );
	if ( ! empty( $_POST['stripeToken'] ) && ! empty( $_POST['amount'] ) ) {
		$errors = array();
		global $wpdb;

		$fname = ! empty( $_POST['fname'] ) ? sanitize_text_field( wp_unslash( $_POST['fname'] ) ) : '';
		$lname = ! empty( $_POST['lname'] ) ? sanitize_text_field( wp_unslash( $_POST['lname'] ) ) : '';
		$email = ! empty( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
		$phone = ! empty( $_POST['phone_no'] ) ? sanitize_text_field( wp_unslash( $_POST['phone_no'] ) ) : '';
		$address = ! empty( $_POST['address'] ) ? sanitize_text_field( wp_unslash( $_POST['address'] ) ) : '';
		$country = ! empty( $_POST['country'] ) ? sanitize_text_field( wp_unslash( $_POST['country'] ) ) : '';
		$state = ! empty( $_POST['state'] ) ? sanitize_text_field( wp_unslash( $_POST['state'] ) ) : '';
		$city = ! empty( $_POST['city'] ) ? sanitize_text_field( wp_unslash( $_POST['city'] ) ) : '';
		$zipcode = ! empty( $_POST['zipcode'] ) ? sanitize_text_field( wp_unslash( $_POST['zipcode'] ) ) : '';
		$amount = ! empty( $_POST['amount'] ) ? absint( wp_unslash( $_POST['amount'] ) ) : '';
		$payment_interval = ! empty( $_POST['recurringInterval'] ) ? sanitize_text_field( wp_unslash( $_POST['recurringInterval'] ) ) : '1time';
		$created_at = strtotime( current_time( 'Y-m-d H:i:s' ) );
		$end_date_recurring = ! empty( $_POST['end_date_recurring'] ) ? sanitize_text_field( wp_unslash( $_POST['end_date_recurring'] ) ) : '';
		$end_date_rec = strtotime( $end_date_recurring );

		$token = sanitize_text_field( wp_unslash( $_POST['stripeToken'] ) );
		$amt = $amount * 100;
		$full_name = $fname . ' ' . $lname;
		$description = $full_name . ' from Payment:';

		$metadata = array(
			'customer_name'           => $full_name,
			'customer_email'          => $email,
			'customer_phone'          => $phone,
			'billing_address_line'    => $address,
			'billing_address_country' => $country,
			'billing_address_state'   => $state,
			'billing_address_city'    => $city,
			'billing_address_zip'     => $zipcode,
		);

		$random_id = rpadts_random_string(
			array(
				'characters' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789',
				'length'     => 14,
			)
		);

		if ( '1time' == $payment_interval || 1 != esc_attr( get_option( 'rpadts_recurring_payment_check' ) ) ) {

			try {
				$customer = \Stripe\Customer::create(
					array(
						'email'    => $email,
						'card'     => $token,
						'metadata' => $metadata,
					)
				);

				$charge = \Stripe\Charge::create(
					array(
						'customer'    => $customer->id,
						'amount'      => $amt,
						'currency'    => get_option( 'rpadts_currency' ),
						'description' => $description,
						'metadata'    => $metadata,
					)
				);

				$payment_id = $charge->id;
				$payment_status = $charge->status;
				$payment_amount = $charge->amount / 100;
				$payment_frequency = 'One Time Payment';

				$currency_sign = '';
				foreach ( rpadts_currencies() as $currency_key => $currency_obj ) {
					if ( esc_attr( get_option( 'rpadts_currency' ) ) === $currency_key ) {
						$currency_sign .= $currency_obj['symbol'];
					}
				}

				$payment_amt = $currency_sign . '' . $payment_amount;

				rpadts_send_payment_email_receipt( $email, $created_at, $address, $city, $state, $country, $zipcode, '', '', $payment_amt, $fname, $lname, site_url(), $payment_frequency );
				if ( 'succeeded' == $charge->status ) {
					rpadts_stripe_create_order( $fname, $lname, $email, $phone, $address, $country, $state, $city, $zipcode, $payment_amount, $payment_frequency, '', '', get_option( 'rpadts_currency' ), $payment_id, $payment_status, $created_at );
				}

				session_start();
				$_SESSION['confirmation_msg'] = $payment_id;
				$_SESSION['confirmation_full_name'] = $full_name;
				$_SESSION['confirmation_email'] = $email;
				wp_redirect( home_url( 'stripe-thank-you' ) );
				exit;
			} catch ( \Stripe\Exception\CardException $e ) {
				$errors['stripe'] = array(
					'success' => false,
					'ex_msg'  => $e->getMessage(),
				);
			} catch ( Exception $e ) {
				$errors['stripe'] = array(
					'success' => false,
					'ex_msg'  => $e->getMessage(),
				);
			}
		} elseif ( in_array( $payment_interval, array( '1m', '3m', '6m', '12m' ) ) ) {
			$payment_levels = array(
				'1m'  => array(
					'count' => 1,
					'interval' => 'month',
					'freq' => 'Monthly',
				),
				'3m'  => array(
					'count' => 3,
					'interval' => 'month',
					'freq' => 'Quarterly',
				),
				'6m'  => array(
					'count' => 6,
					'interval' => 'month',
					'freq' => 'Semi-Annually',
				),
				'12m' => array(
					'count' => 1,
					'interval' => 'year',
					'freq' => 'Annually',
				),
			);
			$level = $payment_levels[ $payment_interval ];

			try {
				$customer = \Stripe\Customer::create(
					array(
						'email'    => $email,
						'card'     => $token,
						'metadata' => $metadata,
					)
				);

				$plan = \Stripe\Plan::create(
					array(
						'name'           => $payment_interval . '-' . $random_id,
						'id'             => $payment_interval . '-' . $random_id,
						'interval'       => $level['interval'],
						'interval_count' => $level['count'],
						'currency'       => esc_attr( get_option( 'rpadts_currency' ) ),
						'amount'         => $amt,
						'metadata'       => $metadata,
					)
				);

				$subscription = \Stripe\Subscription::create(
					array(
						'customer' => $customer->id,
						'plan'     => $payment_interval . '-' . $random_id,
					)
				);

				$subscription_end = \Stripe\Subscription::retrieve( $subscription->id );
				$subscription_end->trial_end = $end_date_rec;
				$subscription_end->prorate = false;
				$subscription_end->save();

				$charges = \Stripe\Charge::all( array( 'limit' => 1 ) );
				$charge = $charges->data[0];

				$payment_id = $charge->id;
				$payment_status = $charge->status;
				$payment_amount = $charge->amount / 100;
				$payment_frequency = $level['freq'];

				$currency_sign = '';
				foreach ( rpadts_currencies() as $currency_key => $currency_obj ) {
					if ( esc_attr( get_option( 'rpadts_currency' ) ) === $currency_key ) {
						$currency_sign .= $currency_obj['symbol'];
					}
				}

				$payment_amt = $currency_sign . '' . $payment_amount;

				$get_invoice = \Stripe\Invoice::upcoming(
					array(
						'customer' => $customer->id,
					)
				);

				$period_end = $get_invoice->period_end;
				$period_start = $get_invoice->period_start;

				rpadts_send_payment_email_receipt( $email, $created_at, $address, $city, $state, $country, $zipcode, $period_start, $period_end, $payment_amt, $fname, $lname, site_url(), $payment_frequency );

				rpadts_stripe_create_order( $fname, $lname, $email, $phone, $address, $country, $state, $city, $zipcode, $payment_amount, $payment_frequency, $period_start, $period_end, get_option( 'rpadts_currency' ), $payment_id, $payment_status, $created_at );

				session_start();
				$_SESSION['confirmation_msg'] = $payment_id;
				$_SESSION['confirmation_full_name'] = $full_name;
				$_SESSION['confirmation_email'] = $email;
				wp_redirect( home_url( 'stripe-thank-you' ) );
				exit;
			} catch ( \Stripe\Exception\CardException $e ) {
				$errors['stripe'] = array(
					'success' => false,
					'ex_msg'  => $e->getMessage(),
				);
			} catch ( Exception $e ) {
				$errors['stripe'] = array(
					'success' => false,
					'ex_msg'  => $e->getMessage(),
				);
			}
		}
	}
	?>
	<script type="text/javascript">
	<?php if ( esc_attr( get_option( 'rpadts_apiMode' ) ) == 'test' ) : ?>
		Stripe.setPublishableKey('<?php echo esc_attr( get_option( 'rpadts_publishKey_test' ) ); ?>');
	<?php elseif ( esc_attr( get_option( 'rpadts_apiMode' ) ) == 'live' ) : ?>
		Stripe.setPublishableKey('<?php echo esc_attr( get_option( 'rpadts_publishKey_live' ) ); ?>');
	<?php endif; ?>
</script>

	<?php
	$fname_var = ! empty( $_POST['fname'] ) ? sanitize_text_field( wp_unslash( $_POST['fname'] ) ) : '';
	$lname_var = ! empty( $_POST['lname'] ) ? sanitize_text_field( wp_unslash( $_POST['lname'] ) ) : '';
	$email_var = ! empty( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone_no_var = ! empty( $_POST['phone_no'] ) ? sanitize_text_field( wp_unslash( $_POST['phone_no'] ) ) : '';
	$address_var = ! empty( $_POST['address'] ) ? sanitize_textarea_field( wp_unslash( $_POST['address'] ) ) : '';
	$city_var = ! empty( $_POST['city'] ) ? sanitize_text_field( wp_unslash( $_POST['city'] ) ) : '';
	$state_var = ! empty( $_POST['state'] ) ? sanitize_text_field( wp_unslash( $_POST['state'] ) ) : '';
	$country_var = ! empty( $_POST['country'] ) ? sanitize_text_field( wp_unslash( $_POST['country'] ) ) : '';
	$zipcode_var = ! empty( $_POST['zipcode'] ) ? sanitize_text_field( wp_unslash( $_POST['zipcode'] ) ) : '';
	$amount_var = ! empty( $_POST['amount'] ) ? absint( wp_unslash( $_POST['amount'] ) ) : '';

	$rpadts_currency = get_option( 'rpadts_currency' ) ? esc_attr( get_option( 'rpadts_currency' ) ) : '';

	$publish_stripe_key = '';
	if ( esc_attr( get_option( 'rpadts_apiMode' ) ) == 'test' ) {
		$publish_stripe_key = esc_attr( get_option( 'rpadts_publishKey_test' ) );
	} elseif ( esc_attr( get_option( 'rpadts_apiMode' ) ) == 'live' ) {
		$publish_stripe_key = esc_attr( get_option( 'rpadts_publishKey_live' ) );
	}

	$html = '';
	$html .= '<form action="" method="POST" class="form-horizontal stripe-payment-frm" id="stripe-payment-frm">';
	$html .= '<fieldset>';

	if ( isset( $errors ) && ! empty( $errors ) && is_array( $errors ) ) {
		foreach ( $errors as $e ) {
			$html .= '<p class="alert alert-error">"' . esc_html( $e['ex_msg'] ) . '"</p>';
		}
	}

	// Nonce field.
	$html .= wp_nonce_field( 'rpadts_checkout_form', '_wpnonce', true );

	$html .= '<div class="control-group">';
	$html .= '<label class="control-label fullstripe-form-label">First Name<span style="color:red;">*</span></label>';
	$html .= '<div class="controls">';
	$html .= '<input type="text" class="fullstripe-form-input" name="fname" value="' . esc_attr( $fname_var ) . '">';
	$html .= '</div>';
	$html .= '</div>';

	$html .= '<div class="control-group">';
	$html .= '<label class="control-label fullstripe-form-label">Last Name<span style="color:red;">*</span></label>';
	$html .= '<div class="controls">';
	$html .= '<input type="text" class="fullstripe-form-input" name="lname" value="' . esc_attr( $lname_var ) . '">';
	$html .= '</div>';
	$html .= '</div>';

	$html .= '<div class="control-group">';
	$html .= '<label class="control-label fullstripe-form-label">Email<span style="color:red;">*</span></label>';
	$html .= '<div class="controls">';
	$html .= '<input type="email" class="fullstripe-form-input" name="email" value="' . esc_attr( $email_var ) . '">';
	$html .= '</div>';
	$html .= '</div>';

	$html .= '<div class="control-group">';
	$html .= '<label class="control-label fullstripe-form-label">Phone Number<span style="color:red;">*</span></label>';
	$html .= '<div class="controls">';
	$html .= '<input type="text" class="fullstripe-form-input" name="phone_no" maxlength="13" value="' . esc_attr( $phone_no_var ) . '">';
	$html .= '</div>';
	$html .= '</div>';

	$html .= '<div class="control-group">';
	$html .= '<label class="control-label fullstripe-form-label">Address/Street<span style="color:red;">*</span></label>';
	$html .= '<div class="controls">';
	$html .= '<textarea name="address" class="fullstripe-form-input">' . esc_textarea( $address_var ) . '</textarea><br>';
	$html .= '</div>';
	$html .= '</div>';

	$html .= '<div class="control-group">';
	$html .= '<label class="control-label fullstripe-form-label">City<span style="color:red;">*</span></label>';
	$html .= '<div class="controls">';
	$html .= '<input type="text" name="city" class="fullstripe-form-input" value="' . esc_attr( $city_var ) . '"><br>';
	$html .= '</div>';
	$html .= '</div>';

	$html .= '<div class="control-group">';
	$html .= '<label class="control-label fullstripe-form-label">State<span style="color:red;">*</span></label>';
	$html .= '<div class="controls">';
	$html .= '<input type="text" name="state" class="fullstripe-form-input" value="' . esc_attr( $state_var ) . '"><br>';
	$html .= '</div>';
	$html .= '</div>';

	$html .= '<div class="control-group">';
	$html .= '<label class="control-label fullstripe-form-label">Country<span style="color:red;">*</span></label>';
	$html .= '<div class="controls">';
	$html .= '<input type="text" name="country" class="fullstripe-form-input" value="' . esc_attr( $country_var ) . '"><br>';
	$html .= '</div>';
	$html .= '</div>';

	$html .= '<div class="control-group">';
	$html .= '<label class="control-label fullstripe-form-label">Zip<span style="color:red;">*</span></label>';
	$html .= '<div class="controls">';
	$html .= '<input type="text" name="zipcode" maxlength="10" class="fullstripe-form-input" value="' . esc_attr( $zipcode_var ) . '"><br>';
	$html .= '</div>';
	$html .= '</div>';

	$html .= '<div class="control-group">';
	$html .= '<label class="control-label fullstripe-form-label"> Amount (' . esc_html( $rpadts_currency ) . ')<span style="color:red;">*</span></label>';
	$html .= '<div class="controls">';
	$html .= '<input type="text" name="amount" maxlength="10" class="fullstripe-form-input" value="' . esc_attr( $amount_var ) . '" placeholder=""><br>';
	$html .= '</div>';
	$html .= '</div>';

	if ( esc_attr( get_option( 'rpadts_recurring_payment_check' ) ) == 1 ) {
		$html .= '<div class="control-group recurring">';
		$html .= '<label class="control-label fullstripe-form-label" for="stripe-recurring-sec">Payment Mode</label>';
		$html .= '<div class="controls">';
		$html .= '<select name="recurringInterval" class="neon2Field2" onchange="rpadts_show_datepicker(this.value);">';
		$html .= '<option value="1time">One Time</option>';
		$html .= '<option value="1m">Monthly</option>';
		$html .= '<option value="3m">Quarterly</option>';
		$html .= '<option value="6m">Semi-Annually</option>';
		$html .= '<option value="12m">Annually</option>';
		$html .= '</select>';
		$html .= '</div>';
		$html .= '</div>';
	} else {
		$html .= '<input type="hidden" name="payment_type_radio" value="one_time_payment">';
	}

	$html .= '<div class="control-group" id="recurringEndDate" style="display:none;">';
	$html .= '<label class="control-label fullstripe-form-label">End Date</label>';
	$html .= '<div class="controls">';
	$html .= '<div class="">';
	$html .= '<input type="text" name="end_date_recurring" class="form-control" id="recurring_end_date" readonly>';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>';

	$html .= '<div class="control-group">';
	$html .= '<div class="controls">';
	$html .= '<button type="submit" class="make_payment_btn" name="submit_form">Make Payment</button>';
	$html .= '</div>';
	$html .= '</div>';

	$html .= '<div class="stripe_popup" style="display: none;">';
	$html .= '<script type="text/javascript" src="https://js.stripe.com/v2/"></script>';
	$html .= '<script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="' . esc_attr( $publish_stripe_key ) . '" data-amount="" data-name="' . esc_attr( get_option( 'rpadts_popup_name' ) ) . '" data-description="' . esc_attr( get_option( 'rpadts_popup_desc' ) ) . '" data-image="' . esc_attr( get_option( 'stripe_custom_logo' ) ) . '" data-locale="auto"></script>';
	$html .= '</div>';

	$html .= '</fieldset>';
	$html .= '</form>';

	return $html;
}
add_shortcode( 'stripe-checkout-page', 'rpadts_checkout_page_callback' );

/**
 * Insert data into the Stripe transaction table in the database.
 *
 * @param string $fname         First name of the customer.
 * @param string $lname         Last name of the customer.
 * @param string $email         Email address of the customer.
 * @param string $phone         Phone number of the customer.
 * @param string $address       Address of the customer.
 * @param string $country       Country of the customer.
 * @param string $state         State of the customer.
 * @param string $city          City of the customer.
 * @param string $zipcode       Zipcode of the customer.
 * @param int    $amount        Amount of the transaction.
 * @param string $payment_type  Type of the payment (e.g., donation, purchase).
 * @param string $period_start  Start period for the payment.
 * @param string $period_end    End period for the payment.
 * @param string $payment_currency Currency used for the payment.
 * @param string $payment_id    Payment ID from the payment gateway.
 * @param string $payment_status Status of the payment (e.g., succeeded, failed).
 * @param int    $created_at    Timestamp of when the record was created.
 *
 * @return bool True on success, false on failure.
 */
function rpadts_stripe_create_order( $fname, $lname, $email, $phone, $address, $country, $state, $city, $zipcode, $amount, $payment_type, $period_start, $period_end, $payment_currency, $payment_id, $payment_status, $created_at ) {

	global $wpdb;
	$current_time = current_time( 'timestamp' );
		$insert = $wpdb->insert(
			$wpdb->prefix . 'stripe_transaction_table',
			array(
				'first_name'        => $fname,
				'last_name'         => $lname,
				'email'             => $email,
				'phone_number'      => $phone,
				'address'           => $address,
				'country'           => $country,
				'state'             => $state,
				'city'              => $city,
				'zipcode'           => $zipcode,
				'amount'            => $amount,
				'donation_type'     => $payment_type,
				'period_start'      => $period_start,
				'period_end'        => $period_end,
				'payment_currency'  => $payment_currency,
				'payment_id'        => $payment_id,
				'payment_status'    => $payment_status,
				'created_at' => gmdate( 'Y-m-d H:i:s', $created_at ),
			),
			array(
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
			)
		);

	if ( $insert ) {
		$wpdb->insert_id;
	} else {
		return false;
	}
}

/**
 * Handles page template redirection for the Stripe thank you page.
 * Starts output buffering and session, then checks if the current page is the 'stripe-thank-you' page.
 * If the session contains a confirmation message, it adds a filter to modify the page content.
 */
function rpadts_page_template_redirect() {
	// Start output buffering and session.
	ob_start();
	session_start();

	if ( is_page( 'stripe-thank-you' ) && ! empty( $_SESSION['confirmation_msg'] ) ) {
		add_filter( 'the_content', 'rpadts_thankyou_page_content' );
	}
}
add_action( 'template_redirect', 'rpadts_page_template_redirect' );

/**
 * Generates and returns the content for the Stripe thank you page.
 *
 * This function constructs a thank you message using session data and
 * returns it as the content for the thank you page. It also clears the
 * session data after use.
 *
 * @param string $content The original content of the page.
 * @return string The modified content with the thank you message.
 */
function rpadts_thankyou_page_content( $content ) {

	$success = '';
	$get_trans = $_SESSION['confirmation_msg'];
	$get_full_name = $_SESSION['confirmation_full_name'];
	$get_email = $_SESSION['confirmation_email'];

	$success .= '<div class="container">';
	$success .= '<h4 class="greencolor"><strong>Dear ' . $get_full_name . '</strong></h4><h5>Your payment has been processed successfully.</h5><p>Your payment ID - ' . $get_trans . '</p>';
	$success .= '<p>We have sent your receipt to your email id which is used for payment - ' . $get_email . '</p></br></div>';

	unset( $_SESSION['confirmation_msg'] );
	unset( $_SESSION['confirmation_full_name'] );
	unset( $_SESSION['confirmation_email'] );
	ob_flush();

	return $success;
}

/**
 * Generate a random string.
 *
 * @param array $args {
 *     Optional. An array of arguments to customize the random string.
 *
 *     @type string  $characters Characters to use for generating the random string. Default empty string.
 *     @type int     $length     Length of the random string. Default empty string.
 *     @type string  $before     String to prepend to the random string. Default empty string.
 *     @type string  $after      String to append to the random string. Default empty string.
 *     @type bool    $echo       Whether to echo the random string. Default false.
 * }
 * @return string|null The generated random string if not echoed.
 */
function rpadts_random_string( $args = array() ) {
	$random_string = '';
	$defaults = array(
		'characters' => '',
		'length'     => '',
		'before'     => '',
		'after'      => '',
		'echo'       => false,
	);
	$args = wp_parse_args( $args, $defaults );

	if ( absint( $args['length'] ) < 1 ) {
		return;
	}

	$characters_count = strlen( $args['characters'] );
	for ( $i = 0; $i < $args['length']; $i++ ) {
		$start = mt_rand( 0, $characters_count - 1 );
		$random_string .= substr( $args['characters'], $start, 1 );
	}

	$random_string = $args['before'] . $random_string . $args['after'];

	if ( $args['echo'] ) {
		echo esc_html( $random_string );
	} else {
		return $random_string;
	}
}

/**
 * Send a payment email receipt.
 *
 * This function sends an email receipt to the user after a successful payment.
 *
 * @param string $user_email                The email address of the user receiving the receipt.
 * @param string $payment_date              The date of the payment.
 * @param string $address                  The address of the user.
 * @param string $city                     The city of the user.
 * @param string $state                    The state of the user.
 * @param string $country                  The country of the user.
 * @param string $zipcode                  The zipcode of the user.
 * @param string $recurring_payment_start  The start date of the recurring payment period.
 * @param string $recurring_payment_end    The end date of the recurring payment period.
 * @param float  $amount                   The amount of the payment.
 * @param string $fname                    The first name of the user.
 * @param string $lname                    The last name of the user.
 * @param string $sitename                 The name of the site sending the email.
 * @param string $donation_type            The type of donation or payment.
 *
 * @return void
 */
function rpadts_send_payment_email_receipt( $user_email, $payment_date, $address, $city, $state, $country, $zipcode, $recurring_payment_start, $recurring_payment_end, $amount, $fname, $lname, $sitename, $donation_type ) {

	$set_from = ( esc_attr( get_option( 'rpadts_email_receipt_sender_address' ) ) ? esc_attr( get_option( 'rpadts_email_receipt_sender_address' ) ) : get_option( 'admin_email' ) );
	$set_cc = ( esc_attr( get_option( 'rpadts_cc_payment_receipt' ) ) ? esc_attr( get_option( 'rpadts_cc_payment_receipt' ) ) : get_option( 'admin_email' ) );
	$to = $user_email;
	$subject = esc_attr( get_option( 'rpadts_email_subject' ) );
	$msg_body = get_option( 'rpadts_email_messagebody' );
	$rep_keyword = array( '%CUSTOMER_EMAIL%', '%PAYMENTDATE%', '%ADDRESS%', '%CITY%', '%STATE%', '%COUNTRY%', '%ZIP%', '%RECURRING_PAYMENT_START%', '%RECURRING_PAYMENT_END%', '%AMOUNT%', '%FIRSTNAME%', '%LASTNAME%', '%SITENAME%', '%DONATIONTYPE%' );
	$rep_value = array( $user_email, $payment_date, $address, $city, $state, $country, $zipcode, $recurring_payment_start, $recurring_payment_end, $amount, $fname, $lname, $sitename, $donation_type );
	$body = str_replace( $rep_keyword, $rep_value, $msg_body );
	$site_url = get_bloginfo();

	$header = "From: $set_from \r\n";
	$header .= "Cc: $set_cc \r\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-type: text/html\r\n";

	wp_mail( $to, $subject, $body, $header );
}
