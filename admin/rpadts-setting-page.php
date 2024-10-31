<?php
/**
 * Plugin Name: RPADTS Settings
 * Description: This file contains functions for initializing and displaying the settings for the RPADTS plugin, including Stripe and recurring payment settings.
 * Version: 1.0.1
 *
 * @package RPADTS_Settings
 */

/**
 * Callback function to display the RPADTS settings page.
 * This function generates the settings page with tabs for Stripe, Recurring Payment, and Email Notifications.
 */
function rpadts_settings_callback() {

	if ( isset( $_GET ['tab'] ) ) {
		$active_tab = sanitize_text_field( wp_unslash( $_GET['tab'] ) );
	} else {
		$active_tab = 'tab_stripe';
	}
	?>  

	<div class="wrap">
		<h2><?php esc_html_e( 'Stripe Settings' ); ?> </h2>
		<?php
		if ( isset( $_GET['settings-updated'] ) == 'true' ) {
			?>
			<div class="updated notice">
				<p><?php esc_html_e( 'Settings saved.', 'rpadts' ); ?></p>
			</div>
		<?php } ?>
		<script type="text/javascript">
			jQuery ( document ).ready( function() {
					jQuery( '#upload_logo_button' ).click( function() {
					 formfield = jQuery( '.stripe_custom_logo_url' ).attr( 'name' );
					 tb_show ( '', 'media-upload.php?type=image&TB_iframe=true' );
					 return false;
					});
					
						window.send_to_editor = function( html ) {
							imgurl = jQuery ( 'img', html ).attr( 'src' );
							jQuery ( '.stripe_custom_logo_url' ). val ( imgurl );
							tb_remove ();
						}
					});

			</script>
		<h2 class="nav-tab-wrapper">  
			<a href="?page=rpadts-settings&tab=tab_stripe" class="nav-tab <?php echo 'tab_stripe' == $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Stripe', 'rpadts' ); ?></a>
			<a href="?page=rpadts-settings&tab=tab_recurring" class="nav-tab <?php echo 'tab_recurring' == $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Recurring Payment', 'rpadts' ); ?></a>
			<a href="?page=rpadts-settings&tab=tab_email_notification" class="nav-tab <?php echo 'tab_email_notification' == $active_tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Email Notifications', 'rpadts' ); ?></a>
		</h2> 
		<form method="post" action="options.php" onsubmit="return rpadts_continueOrNot()"> 
			<?php
			if ( 'tab_stripe' == $active_tab ) {
				settings_fields( 'rpadts-stripe-setting-group-1' );
				do_settings_sections( 'rpadts-stripe-setting-group-1' );
			} elseif ( 'tab_recurring' == $active_tab ) {
				settings_fields( 'rpadts-recurring-setting-group-2' );
				do_settings_sections( 'rpadts-recurring-setting-group-2' );
			} elseif ( 'tab_email_notification' == $active_tab ) {
				settings_fields( 'rpadts-email-setting-group-3' );
				do_settings_sections( 'rpadts-email-setting-group-3' );
			}
			submit_button();
			?>
			 
		</form> 
	</div>
	<?php
}

/**
 * Registers admin settings for the SWR (Stripe Webhooks and Recurring).
 *
 * This function registers multiple settings sections and settings for Stripe,
 * recurring payments, and email notifications within the WordPress admin area.
 * It sets up the sections and options necessary for configuring Stripe and related
 * functionalities in the admin panel.
 *
 * The function performs the following tasks:
 * - Adds settings sections for Stripe settings, shipping options, and email notifications.
 * - Registers individual settings for each section, including API keys, popup settings,
 *   recurring payment options, and email configuration.
 *
 * @since 1.0.0
 */
function rpadts_initialize_theme_options() {

	add_settings_section( 'razorpay_section', '', 'rpadts_stripe_setting_section_callback', 'rpadts-stripe-setting-group-1' );
	add_settings_section( 'shipping_section', '', 'rpadts_recurring_section_callback', 'rpadts-recurring-setting-group-2' );
	add_settings_section( 'email_notification_section', '', 'rpadts_email_section_callback', 'rpadts-email-setting-group-3' );

	register_setting( 'rpadts-stripe-setting-group-1', 'rpadts_apiMode' );
	register_setting( 'rpadts-stripe-setting-group-1', 'rpadts_currency' );
	register_setting( 'rpadts-stripe-setting-group-1', 'rpadts_secretKey_test' );
	register_setting( 'rpadts-stripe-setting-group-1', 'rpadts_publishKey_test' );
	register_setting( 'rpadts-stripe-setting-group-1', 'rpadts_secretKey_live' );
	register_setting( 'rpadts-stripe-setting-group-1', 'rpadts_publishKey_live' );

	register_setting( 'rpadts-stripe-setting-group-1', 'rpadts_popup_name' );
	register_setting( 'rpadts-stripe-setting-group-1', 'rpadts_popup_desc' );
	register_setting( 'rpadts-stripe-setting-group-1', 'stripe_custom_logo' );

	register_setting( 'rpadts-recurring-setting-group-2', 'rpadts_recurring_payment_check' );
	register_setting( 'rpadts-email-setting-group-3', 'rpadts_email_subject' );
	register_setting( 'rpadts-email-setting-group-3', 'rpadts_email_messagebody' );
	register_setting( 'rpadts-email-setting-group-3', 'rpadts_email_receipt_sender_address' );
	register_setting( 'rpadts-email-setting-group-3', 'rpadts_cc_payment_receipt' );

}
add_action( 'admin_init', 'rpadts_initialize_theme_options' );

/**
 * Outputs the settings form for the Stripe API in the admin settings page.
 *
 * This function generates the HTML for the Stripe API settings section in the WordPress
 * admin area. It displays various form fields where users can enter their Stripe API keys,
 * configure the payment currency, and set other related options.
 *
 * The form includes:
 * - Instructions for obtaining Stripe API keys.
 * - Radio buttons for selecting the API mode (Test or Live).
 * - Fields for entering Stripe Test and Live API keys.
 * - Fields for specifying payment currency, popup name, description, and logo.
 *
 * This function is hooked to the settings section callback and is used to render
 * the appropriate form elements based on the settings.
 *
 * @since 1.0.0
 */
function rpadts_stripe_setting_section_callback() {

	?>
	<p class="alert alert-info"><?php echo esc_html__( 'The Stripe API keys are required for payments to work. You can find your keys on your <a href="https://manage.stripe.com">Stripe Dashboard</a> -> Account Settings -> API Keys tab', 'rpadts' ); ?></p>
	<table class="form-table">
		<tbody>
			<tr valign="top">
			<th scope="row">
					<label class="control-label"><?php esc_html_e( 'API mode: ', 'rpadts' ); ?></label>
			</th>
			<td>
					<label class="radio">
							<input type="radio" name="rpadts_apiMode" id="modeTest" value="test" <?php echo ( esc_attr( get_option( 'rpadts_apiMode' ) ) == 'test' ) ? 'checked' : ''; ?> onclick="rpadts_hiddenKeyField();">
							Test
					</label> <label class="radio">
							<input type="radio" name="rpadts_apiMode" id="modeLive" value="live" <?php echo ( esc_attr( get_option( 'rpadts_apiMode' ) ) == 'live' ) ? 'checked' : ''; ?> onclick="rpadts_showKeyField();">
							Live
					</label>
			</td>
			</tr>
			<tr valign="top">
					<th scope="row">
							<label class="control-label" for="currency"><?php esc_html_e( 'Payment Currency: ', 'rpadts' ); ?></label>
					</th>
					<td>
						<div class="ui-widget">
							<select id="currency" name="rpadts_currency">
								<option value=""><?php esc_attr_e( 'Select from the list', 'rpadts' ); ?></option>
								<?php
								foreach ( rpadts_currencies() as $currency_key => $currency_obj ) {
									$option = '<option value="' . $currency_key . '"';
									if ( esc_attr( get_option( 'rpadts_currency' ) ) === $currency_key ) {
											$option .= 'selected="selected"';
									}
									$option .= '>';
									$option .= $currency_obj['name'] . ' (' . $currency_obj['code'] . ')';
									$option .= '</option>';
									echo esc_html( $option );

								}
								?>
							</select>
						</div>
					</td>
			</tr>
			
			<tr valign="top" class="testKeys">
					<th scope="row">
							<label class="control-label" for="secretKey_test"><?php esc_html_e( 'Stripe Test Secret Key: ', 'rpadts' ); ?></label>
					</th>
					<td>
							<input type="text" name="rpadts_secretKey_test" id="secretKey_test" value="<?php echo esc_attr( get_option( 'rpadts_secretKey_test' ) ); ?>" class="regular-text code">
					</td>
			</tr>
			<tr valign="top" class="testKeys">
					<th scope="row">
							<label class="control-label" for="publishKey_test"><?php esc_html_e( 'Stripe Test Publishable Key: ', 'rpadts' ); ?></label>
					</th>
					<td>
							<input type="text" id="publishKey_test" name="rpadts_publishKey_test" value="<?php echo esc_attr( get_option( 'rpadts_publishKey_test' ) ); ?>" class="regular-text code">
					</td>
			</tr>
			<tr valign="top" class="liveKeys" style="display:none;">
					<th scope="row">
							<label class="control-label" for="secretKey_live"><?php esc_html_e( 'Stripe Live Secret Key: ', 'rpadts' ); ?></label>
					</th>
					<td>
							<input type="text" name="rpadts_secretKey_live" id="secretKey_live" value="<?php echo esc_attr( get_option( 'rpadts_secretKey_live' ) ); ?>" class="regular-text code">
					</td>
			</tr>
			<tr valign="top" class="liveKeys" style="display:none;">
					<th scope="row">
							<label class="control-label" for="publishKey_live"><?php esc_html_e( 'Stripe Live Publishable Key: ', 'rpadts' ); ?></label>
					</th>
					<td>
						<input type="text" id="publishKey_live" name="rpadts_publishKey_live" value="<?php echo esc_attr( get_option( 'rpadts_publishKey_live' ) ); ?>" class="regular-text code">
					</td>
			</tr>
			
			<tr valign="top">
					<th scope="row">
							<label class="control-label" for="stripe_popup_name"><?php esc_html_e( 'Stripe Popup Name: ', 'rpadts' ); ?></label>
					</th>
					<td>
						<input type="text" id="stripe_popup_name" name="rpadts_popup_name" value="<?php echo esc_attr( get_option( 'rpadts_popup_name' ) ); ?>" class="regular-text code">
					</td>
			</tr>
			
			<tr valign="top">
					<th scope="row">
							<label class="control-label" for="stripe_popup_desc"><?php esc_html_e( 'Stripe Payment Popup Message: ', 'rpadts' ); ?></label>
					</th>
					<td>
						<input type="text" id="stripe_popup_desc" name="rpadts_popup_desc" value="<?php echo esc_attr( get_option( 'rpadts_popup_desc' ) ); ?>" class="regular-text code">
					</td>
			</tr>
			
			<tr valign="top">
					<th scope="row">
							<label class="control-label" for="stripe_popup_image"><?php esc_html_e( 'Stripe Payment Popup Logo: ', 'rpadts' ); ?></label>
					</th>
					<td>
					<?php if ( ! empty( get_option( 'stripe_custom_logo' ) ) ) { ?>
						<img class="stripe_custom_logo" src=" <?php echo esc_attr( get_option( 'stripe_custom_logo' ) ); ?> " height="100" width="100" />
					<?php } ?>
					<input class="stripe_custom_logo_url" type="text" name="stripe_custom_logo" size="60" value="<?php echo esc_attr( get_option( 'stripe_custom_logo' ) ); ?>">
					<input id="upload_logo_button" type="button" class="" value="Upload" /> <?php update_option( 'image_default_link_type', 'file' ); ?>
					</td>
			</tr>
		</tbody>
	</table>
	<?php

}

/**
 * Recurring payment setting section in backend.
 *
 * This function generates the HTML for the recurring payment settings section in the WordPress admin backend.
 *
 * @since 1.0.0
 */
function rpadts_recurring_section_callback() {

	?>
		<p> <label> <b> <?php esc_html_e( 'Recurring Payment ', 'rpadts' ); ?> </b> </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			<input type="checkbox" name="rpadts_recurring_payment_check" id="rpadts_recurring_payment_check" value="1" <?php checked( 1, get_option( 'rpadts_recurring_payment_check' ), true ); ?> /> <label> 
			<i> <?php esc_html_e( 'Do you want to recurring payment?' ); ?> </i> </label> 
		</p> 
	<?php

}

/**
 * Email notification setting section in backend.
 *
 * This function generates the HTML for the email notification settings section in the WordPress admin backend.
 * It includes fields for configuring email subject, email body, sender address, and CC recipients.
 *
 * @since 1.0.0
 */
function rpadts_email_section_callback() {

	?>
		<table class="form-table">
				<tr id="email_receipt_row" valign="top">
						<th scope="row">
								<label class="control-label"><?php esc_html_e( 'Plugin Email Templates: ', 'rpadts' ); ?></label>
						</th>
						<td>
								<input id="email_receipts" name="email_receipts" type="hidden">
								<table id="email_receipt_templates">
										<tr>
											<td>
												<label><?php esc_html_e( 'E-mail Subject', 'rpadts' ); ?></label><br>
												<input id="email_receipt_subject" name="rpadts_email_subject" type="text" class="large-text code" value="<?php echo esc_attr( get_option( 'rpadts_email_subject' ) ); ?>"><br>
												<label><?php esc_html_e( 'E-mail body (HTML)', 'rpadts' ); ?></label><br>
												<?php

													$content = get_option( 'rpadts_email_messagebody' );
													wp_editor( $content, 'rpadts_email_messagebody' );

												?>
											   
												<p class="description">
													<?php
													// translators: %FIRSTNAME% and %AMOUNT% are placeholders for the name of the customer and the payment amount, respectively.
													esc_html_e( '%FIRSTNAME% and %AMOUNT% are replaced with the name of the customer and payment amount, respectively.', 'rpadts' );
													?>
												<?php
												// translators: %s is the URL to the Help page.
												printf( esc_html__( 'See the <a target="_blank" href="%s">Help page</a> for more options.', 'rpadts' ), esc_url( admin_url( 'admin.php?page=rpadts-help#receipt-tokens' ) ) );
												?>
												</p>
											</td>
										</tr>
								</table>
						</td>
				</tr>
				<tr id="email_receipt_sender_address_row" valign="top">
						<th scope="row">
								<label class="control-label" for="email_receipt_sender_address"><?php esc_html_e( 'Email Sender Address:', 'rpadts' ); ?></label>
						</th>
						<td>
								<input id="rpadts_email_receipt_sender_address" name="rpadts_email_receipt_sender_address" type="text" class="regular-text" value="<?php echo esc_attr( get_option( 'rpadts_email_receipt_sender_address' ) ); ?>" >

								<p class="description"><?php esc_html_e( 'The sender address of email receipts. If you leave it empty then the email address of the blog admin will be used.', 'rpadts' ); ?></p>
						</td>
				</tr>
				<tr id="admin_payment_receipt_row" valign="top">
						<th scope="row">
								<label class="control-label"><?php esc_html_e( 'CC: ', 'rpadts' ); ?> </label>
						</th>
						<td>
								<input id="rpadts_cc_payment_receipt" name="rpadts_cc_payment_receipt" type="text" class="regular-text" value="<?php echo esc_attr( get_option( 'rpadts_cc_payment_receipt' ) ); ?>">

								<p class="description"><?php esc_html_e( 'If not enter email by default consider admin email.', 'rpadts' ); ?></p>
						</td>
				</tr>
		</table>
	<?php
}
