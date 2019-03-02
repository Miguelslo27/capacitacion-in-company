<?php
global $gateway, $pmpro_review, $skip_account_fields, $pmpro_paypal_token, $wpdb, $current_user, $pmpro_msg, $pmpro_msgt, $pmpro_requirebilling, $pmpro_level, $pmpro_levels, $tospage, $pmpro_show_discount_code, $pmpro_error_fields;
global $discount_code, $username, $password, $password2, $bfirstname, $blastname, $baddress1, $baddress2, $bcity, $bstate, $bzipcode, $bcountry, $bphone, $bemail, $bconfirmemail, $CardType, $AccountNumber, $ExpirationMonth,$ExpirationYear;

/**
 * Filter to set if PMPro uses email or text as the type for email field inputs.
 *
 * @since 1.8.4.5
 *
 * @param bool $use_email_type, true to use email type, false to use text type
 */
$pmpro_email_field_type = apply_filters('pmpro_email_field_type', true);
?>
<div id="pmpro_level-<?php echo esc_attr($pmpro_level->id); ?>">
	<form id="pmpro_form" class="pmpro_form" action="<?php if(!empty($_REQUEST['review'])) echo pmpro_url("checkout", "?level=" . $pmpro_level->id); ?>" method="post">

		<input type="hidden" id="level" name="level" value="<?php echo esc_attr($pmpro_level->id) ?>" />
		<input type="hidden" id="checkjavascript" name="checkjavascript" value="1" />
		<?php if ($discount_code && $pmpro_review) { ?>
			<input class="input <?php echo pmpro_getClassForField("discount_code");?>" id="discount_code" name="discount_code" type="hidden" size="20" value="<?php echo esc_attr($discount_code) ?>" />
		<?php } ?>

		<?php if($pmpro_msg) { ?>
			<div id="pmpro_message" class="pmpro_message <?php echo esc_attr($pmpro_msgt)?>"><?php echo esc_html($pmpro_msg)?></div>
		<?php } else { ?>
			<div id="pmpro_message" class="pmpro_message" style="display: none;"></div>
		<?php } ?>

		<?php if($pmpro_review) { ?>
			<p><?php echo esc_attr__('Almost done. Review the membership information and pricing below then <strong>click the "Complete Payment" button</strong> to finish your order.', 'ivy-school' );?></p>
		<?php } ?>
		<div id="pmpro_pricing_fields" class="pmpro_checkout">
			<h3>
				<span class="pmpro_checkout-h3-name"><?php echo esc_html__('Membership Level', 'ivy-school' );?></span>
				<?php if(count($pmpro_levels) > 1) { ?><span class="pmpro_checkout-h3-msg"><a href="<?php echo pmpro_url("levels"); ?>"><?php echo esc_html__('change', 'ivy-school' );?></a></span><?php } ?>
			</h3>
			<div class="pmpro_checkout-fields">
				<p>
					<?php printf(esc_attr__('You have selected the <strong>%s</strong> membership level.', 'ivy-school' ), $pmpro_level->name);?>
				</p>

				<?php
				/**
				 * All devs to filter the level description at checkout.
				 * We also have a function in includes/filters.php that applies the the_content filters to this description.
				 * @param string $description The level description.
				 * @param object $pmpro_level The PMPro Level object.
				 */
				$level_description = apply_filters('pmpro_level_description', $pmpro_level->description, $pmpro_level);
				if(!empty($level_description))
					echo esc_html($level_description);
				?>

				<div id="pmpro_level_cost">
					<?php if($discount_code && pmpro_checkDiscountCode($discount_code)) { ?>
						<?php printf(__('<p class="pmpro_level_discount_applied">The <strong>%s</strong> code has been applied to your order.</p>', 'ivy-school' ), $discount_code);?>
					<?php } ?>
					<?php echo wpautop(pmpro_getLevelCost($pmpro_level)); ?>
					<?php echo wpautop(pmpro_getLevelExpiration($pmpro_level)); ?>
				</div>

				<?php do_action("pmpro_checkout_after_level_cost"); ?>

				<?php if($pmpro_show_discount_code) { ?>
					<?php if($discount_code && !$pmpro_review) { ?>
						<p id="other_discount_code_p" class="pmpro_small"><a id="other_discount_code_a" href="#discount_code"><?php echo esc_html__('Click here to change your discount code', 'ivy-school' );?></a>.</p>
					<?php } elseif(!$pmpro_review) { ?>
						<p id="other_discount_code_p" class="pmpro_small"><?php echo esc_html__('Do you have a discount code?', 'ivy-school' );?> <a id="other_discount_code_a" href="#discount_code"><?php echo esc_html__('Click here to enter your discount code', 'ivy-school' );?></a>.</p>
					<?php } elseif($pmpro_review && $discount_code) { ?>
						<p><strong><?php echo esc_html__('Discount Code', 'ivy-school' );?>:</strong> <?php echo esc_html($discount_code)?></p>
					<?php } ?>
				<?php } ?>

				<?php if($pmpro_show_discount_code) { ?>
					<div id="other_discount_code_tr" style="display: none;">
						<label for="other_discount_code"><?php echo esc_html__('Discount Code', 'ivy-school' );?></label>
						<input id="other_discount_code" name="other_discount_code" type="text" class="input <?php echo pmpro_getClassForField("other_discount_code");?>" size="20" value="<?php echo esc_attr($discount_code); ?>" />
						<input type="button" name="other_discount_code_button" id="other_discount_code_button" value="<?php echo esc_html__('Apply', 'ivy-school' );?>" />
					</div>
				<?php } ?>
			</div> <!-- end pmpro_checkout-fields -->
		</div> <!-- end pmpro_pricing_fields -->

		<?php
		do_action('pmpro_checkout_after_pricing_fields');
		?>

		<?php if(!$skip_account_fields && !$pmpro_review) { ?>
			<hr />
			<div id="pmpro_user_fields" class="pmpro_checkout">
				<h3>
					<span class="pmpro_checkout-h3-name"><?php echo esc_html__('Account Information', 'ivy-school' );?></span>
					<span class="pmpro_checkout-h3-msg"><?php echo esc_html__('Already have an account?', 'ivy-school' );?> <a href="<?php echo add_query_arg( 'redirect_to', pmpro_url( "checkout", "?level=" . $pmpro_level->id ), thim_get_login_page_url() ); ?>"><?php echo esc_html__('Log in here', 'ivy-school' );?></a></span>
				</h3>
				<div class="pmpro_checkout-fields">
					<div class="pmpro_checkout-field pmpro_checkout-field-username">
						<label for="username"><?php echo esc_html__('Username', 'ivy-school' );?></label>
						<input id="username" name="username" type="text" class="input <?php echo pmpro_getClassForField("username");?>" size="30" value="<?php echo esc_attr($username); ?>" />
					</div> <!-- end pmpro_checkout-field-username -->

					<?php
					do_action('pmpro_checkout_after_username');
					?>

					<div class="pmpro_checkout-field pmpro_checkout-field-password">
						<label for="password"><?php echo esc_html__('Password', 'ivy-school' );?></label>
						<input id="password" name="password" type="password" class="input <?php echo pmpro_getClassForField("password");?>" size="30" value="<?php echo esc_attr($password); ?>" />
					</div> <!-- end pmpro_checkout-field-password -->

					<?php
					$pmpro_checkout_confirm_password = apply_filters("pmpro_checkout_confirm_password", true);
					if($pmpro_checkout_confirm_password) { ?>
						<div class="pmpro_checkout-field pmpro_checkout-field-password2">
							<label for="password2"><?php echo esc_html__('Confirm Password', 'ivy-school' );?></label>
							<input id="password2" name="password2" type="password" class="input <?php echo pmpro_getClassForField("password2");?>" size="30" value="<?php echo esc_attr($password2); ?>" />
						</div> <!-- end pmpro_checkout-field-password2 -->
					<?php } else { ?>
						<input type="hidden" name="password2_copy" value="1" />
					<?php }
					?>

					<?php
					do_action('pmpro_checkout_after_password');
					?>

					<div class="pmpro_checkout-field pmpro_checkout-field-bemail">
						<label for="bemail"><?php echo esc_html__('E-mail Address', 'ivy-school' );?></label>
						<input id="bemail" name="bemail" type="<?php echo esc_attr($pmpro_email_field_type ? 'email' : 'text'); ?>" class="input <?php echo pmpro_getClassForField("bemail");?>" size="30" value="<?php echo esc_attr($bemail); ?>" />
					</div> <!-- end pmpro_checkout-field-bemail -->

					<?php
					$pmpro_checkout_confirm_email = apply_filters("pmpro_checkout_confirm_email", true);
					if($pmpro_checkout_confirm_email) { ?>
						<div class="pmpro_checkout-field pmpro_checkout-field-bconfirmemail">
							<label for="bconfirmemail"><?php echo esc_html__('Confirm E-mail Address', 'ivy-school' );?></label>
							<input id="bconfirmemail" name="bconfirmemail" type="<?php echo esc_attr($pmpro_email_field_type ? 'email' : 'text'); ?>" class="input <?php echo pmpro_getClassForField("bconfirmemail");?>" size="30" value="<?php echo esc_attr($bconfirmemail); ?>" />
						</div> <!-- end pmpro_checkout-field-bconfirmemail -->
					<?php } else { ?>
						<input type="hidden" name="bconfirmemail_copy" value="1" />
					<?php }
					?>

					<?php
					do_action('pmpro_checkout_after_email');
					?>

					<div class="pmpro_hidden">
						<label for="fullname"><?php echo esc_html__('Full Name', 'ivy-school' );?></label>
						<input id="fullname" name="fullname" type="text" class="input <?php echo pmpro_getClassForField("fullname");?>" size="30" value="" /> <strong><?php echo esc_html__('LEAVE THIS BLANK', 'ivy-school' );?></strong>
					</div> <!-- end pmpro_hidden -->

					<div class="pmpro_checkout-field pmpro_captcha">
						<?php
						global $recaptcha, $recaptcha_publickey;
						if($recaptcha == 2 || ($recaptcha == 1 && pmpro_isLevelFree($pmpro_level))) {
							echo pmpro_recaptcha_get_html($recaptcha_publickey, NULL, true);
						}
						?>
					</div> <!-- end pmpro_captcha -->

					<?php
					do_action('pmpro_checkout_after_captcha');
					?>
				</div>  <!-- end pmpro_checkout-fields -->
			</div> <!-- end pmpro_user_fields -->
		<?php } elseif($current_user->ID && !$pmpro_review) { ?>
			<div id="pmpro_account_loggedin" class="pmpro_message pmpro_alert">
				<?php printf(__('You are logged in as <strong>%s</strong>. If you would like to use a different account for this membership, <a href="%s">log out now</a>.', 'ivy-school' ), $current_user->user_login, wp_logout_url()); ?>
			</div> <!-- end pmpro_account_loggedin -->
		<?php } ?>

		<?php
		do_action('pmpro_checkout_after_user_fields');
		?>

		<?php
		do_action('pmpro_checkout_boxes');
		?>

		<?php if(pmpro_getGateway() == "paypal" && empty($pmpro_review) && true == apply_filters('pmpro_include_payment_option_for_paypal', true ) ) { ?>
			<div id="pmpro_payment_method" class="pmpro_checkout" <?php if(!$pmpro_requirebilling) { ?>style="display: none;"<?php } ?>>
				<hr />
				<h3>
					<span class="pmpro_checkout-h3-name"><?php echo esc_html__('Choose your Payment Method', 'ivy-school' ); ?></span>
				</h3>
				<div class="pmpro_checkout-fields">
			<span class="gateway_paypal">
				<input type="radio" name="gateway" value="paypal" <?php if(!$gateway || $gateway == "paypal") { ?>checked="checked"<?php } ?> />
				<a href="javascript:void(0);" class="pmpro_radio"><?php echo esc_html__('Check Out with a Credit Card Here', 'ivy-school' );?></a>
			</span>
					<span class="gateway_paypalexpress">
				<input type="radio" name="gateway" value="paypalexpress" <?php if($gateway == "paypalexpress") { ?>checked="checked"<?php } ?> />
				<a href="javascript:void(0);" class="pmpro_radio"><?php echo esc_html__('Check Out with PayPal', 'ivy-school' );?></a>
			</span>
				</div> <!-- end pmpro_checkout-fields -->
			</div> <!-- end pmpro_payment_method -->
		<?php } ?>

		<?php
		$pmpro_include_billing_address_fields = apply_filters('pmpro_include_billing_address_fields', true);
		if($pmpro_include_billing_address_fields) { ?>
			<div id="pmpro_billing_address_fields" class="pmpro_checkout" <?php if(!$pmpro_requirebilling || apply_filters("pmpro_hide_billing_address_fields", false) ){ ?>style="display: none;"<?php } ?>>
				<hr />
				<h3>
					<span class="pmpro_checkout-h3-name"><?php echo esc_html__('Billing Address', 'ivy-school' );?></span>
				</h3>
				<div class="pmpro_checkout-fields">
					<div class="pmpro_checkout-field pmpro_checkout-field-bfirstname">
						<label for="bfirstname"><?php echo esc_html__('First Name', 'ivy-school' );?></label>
						<input id="bfirstname" name="bfirstname" type="text" class="input <?php echo pmpro_getClassForField("bfirstname");?>" size="30" value="<?php echo esc_attr($bfirstname); ?>" />
					</div> <!-- end pmpro_checkout-field-bfirstname -->
					<div class="pmpro_checkout-field pmpro_checkout-field-blastname">
						<label for="blastname"><?php echo esc_html__('Last Name', 'ivy-school' );?></label>
						<input id="blastname" name="blastname" type="text" class="input <?php echo pmpro_getClassForField("blastname");?>" size="30" value="<?php echo esc_attr($blastname); ?>" />
					</div> <!-- end pmpro_checkout-field-blastname -->
					<div class="pmpro_checkout-field pmpro_checkout-field-baddress1">
						<label for="baddress1"><?php echo esc_html__('Address 1', 'ivy-school' );?></label>
						<input id="baddress1" name="baddress1" type="text" class="input <?php echo pmpro_getClassForField("baddress1");?>" size="30" value="<?php echo esc_attr($baddress1); ?>" />
					</div> <!-- end pmpro_checkout-field-baddress1 -->
					<div class="pmpro_checkout-field pmpro_checkout-field-baddress2">
						<label for="baddress2"><?php echo esc_html__('Address 2', 'ivy-school' );?></label>
						<input id="baddress2" name="baddress2" type="text" class="input <?php echo pmpro_getClassForField("baddress2");?>" size="30" value="<?php echo esc_attr($baddress2); ?>" />
					</div> <!-- end pmpro_checkout-field-baddress2 -->
					<?php
					$longform_address = apply_filters("pmpro_longform_address", true);
					if($longform_address) { ?>
						<div class="pmpro_checkout-field pmpro_checkout-field-bcity">
							<label for="bcity"><?php echo esc_html__('City', 'ivy-school' );?></label>
							<input id="bcity" name="bcity" type="text" class="input <?php echo pmpro_getClassForField("bcity");?>" size="30" value="<?php echo esc_attr($bcity); ?>" />
						</div> <!-- end pmpro_checkout-field-bcity -->
						<div class="pmpro_checkout-field pmpro_checkout-field-bstate">
							<label for="bstate"><?php echo esc_html__('State', 'ivy-school' );?></label>
							<input id="bstate" name="bstate" type="text" class="input <?php echo pmpro_getClassForField("bstate");?>" size="30" value="<?php echo esc_attr($bstate); ?>" />
						</div> <!-- end pmpro_checkout-field-bstate -->
						<div class="pmpro_checkout-field pmpro_checkout-field-bzipcode">
							<label for="bzipcode"><?php echo esc_html__('Postal Code', 'ivy-school' );?></label>
							<input id="bzipcode" name="bzipcode" type="text" class="input <?php echo pmpro_getClassForField("bzipcode");?>" size="30" value="<?php echo esc_attr($bzipcode); ?>" />
						</div> <!-- end pmpro_checkout-field-bzipcode -->
					<?php } else { ?>
						<div class="pmpro_checkout-field pmpro_checkout-field-bcity_state_zip">
							<label for="bcity_state_zip"><?php echo esc_html__('City, State Zip', 'ivy-school' );?></label>
							<input id="bcity" name="bcity" type="text" class="input <?php echo pmpro_getClassForField("bcity");?>" size="14" value="<?php echo esc_attr($bcity); ?>" />,
							<?php
							$state_dropdowns = apply_filters("pmpro_state_dropdowns", false);
							if($state_dropdowns === true || $state_dropdowns == "names") {
								global $pmpro_states;
								?>
								<select name="bstate" class="<?php echo pmpro_getClassForField("bstate");?>">
									<option value="">--</option>
									<?php
									foreach($pmpro_states as $ab => $st) { ?>
										<option value="<?php echo esc_attr($ab);?>" <?php if($ab == $bstate) { ?>selected="selected"<?php } ?>><?php echo esc_html($st);?></option>
									<?php } ?>
								</select>
							<?php } elseif($state_dropdowns == "abbreviations") {
								global $pmpro_states_abbreviations;
								?>
								<select name="bstate" class="<?php echo pmpro_getClassForField("bstate");?>">
									<option value="">--</option>
									<?php
									foreach($pmpro_states_abbreviations as $ab)
									{
										?>
										<option value="<?php echo esc_attr($ab);?>" <?php if($ab == $bstate) { ?>selected="selected"<?php } ?>><?php echo esc_html($ab);?></option>
									<?php } ?>
								</select>
							<?php } else { ?>
								<input id="bstate" name="bstate" type="text" class="input <?php echo pmpro_getClassForField("bstate");?>" size="2" value="<?php echo esc_attr($bstate); ?>" />
							<?php } ?>
							<input id="bzipcode" name="bzipcode" type="text" class="input <?php echo pmpro_getClassForField("bzipcode");?>" size="5" value="<?php echo esc_attr($bzipcode); ?>" />
						</div> <!-- end pmpro_checkout-field-bcity_state_zip -->
					<?php } ?>

					<?php
					$show_country = apply_filters("pmpro_international_addresses", true);
					if($show_country) { ?>
						<div class="pmpro_checkout-field pmpro_checkout-field-bcountry">
							<label for="bcountry"><?php echo esc_html__('Country', 'ivy-school' );?></label>
							<select name="bcountry" id="bcountry" class="<?php echo pmpro_getClassForField("bcountry");?>">
								<?php
								global $pmpro_countries, $pmpro_default_country;
								if(!$bcountry) {
									$bcountry = $pmpro_default_country;
								}
								foreach($pmpro_countries as $abbr => $country) { ?>
									<option value="<?php echo esc_attr($abbr)?>" <?php if($abbr == $bcountry) { ?>selected="selected"<?php } ?>><?php echo esc_html($country)?></option>
								<?php } ?>
							</select>
						</div> <!-- end pmpro_checkout-field-bcountry -->
					<?php } else { ?>
						<input type="hidden" name="bcountry" value="US" />
					<?php } ?>
					<div class="pmpro_checkout-field pmpro_checkout-field-bphone">
						<label for="bphone"><?php echo esc_html__('Phone', 'ivy-school' );?></label>
						<input id="bphone" name="bphone" type="text" class="input <?php echo pmpro_getClassForField("bphone");?>" size="30" value="<?php echo esc_attr(formatPhone($bphone)); ?>" />
					</div> <!-- end pmpro_checkout-field-bphone -->
					<?php if($skip_account_fields) { ?>
						<?php
						if($current_user->ID) {
							if(!$bemail && $current_user->user_email) {
								$bemail = $current_user->user_email;
							}
							if(!$bconfirmemail && $current_user->user_email) {
								$bconfirmemail = $current_user->user_email;
							}
						}
						?>
						<div class="pmpro_checkout-field pmpro_checkout-field-bemail">
							<label for="bemail"><?php echo esc_html__('E-mail Address', 'ivy-school' );?></label>
							<input id="bemail" name="bemail" type="<?php echo esc_attr($pmpro_email_field_type ? 'email' : 'text'); ?>" class="input <?php echo pmpro_getClassForField("bemail");?>" size="30" value="<?php echo esc_attr($bemail); ?>" />
						</div> <!-- end pmpro_checkout-field-bemail -->
						<?php
						$pmpro_checkout_confirm_email = apply_filters("pmpro_checkout_confirm_email", true);
						if($pmpro_checkout_confirm_email) { ?>
							<div class="pmpro_checkout-field pmpro_checkout-field-bconfirmemail">
								<label for="bconfirmemail"><?php echo esc_html__('Confirm E-mail', 'ivy-school' );?></label>
								<input id="bconfirmemail" name="bconfirmemail" type="<?php echo esc_attr($pmpro_email_field_type ? 'email' : 'text'); ?>" class="input <?php echo pmpro_getClassForField("bconfirmemail");?>" size="30" value="<?php echo esc_attr($bconfirmemail); ?>" />
							</div> <!-- end pmpro_checkout-field-bconfirmemail -->
						<?php } else { ?>
							<input type="hidden" name="bconfirmemail_copy" value="1" />
						<?php } ?>
					<?php } ?>
				</div> <!-- end pmpro_checkout-fields -->
			</div> <!--end pmpro_billing_address_fields -->
		<?php } ?>

		<?php do_action("pmpro_checkout_after_billing_fields"); ?>

		<?php
		$pmpro_accepted_credit_cards = pmpro_getOption("accepted_credit_cards");
		$pmpro_accepted_credit_cards = explode(",", $pmpro_accepted_credit_cards);
		$pmpro_accepted_credit_cards_string = pmpro_implodeToEnglish($pmpro_accepted_credit_cards);
		?>

		<?php
		$pmpro_include_payment_information_fields = apply_filters("pmpro_include_payment_information_fields", true);
		if($pmpro_include_payment_information_fields) { ?>
			<div id="pmpro_payment_information_fields" class="pmpro_checkout" <?php if(!$pmpro_requirebilling || apply_filters("pmpro_hide_payment_information_fields", false) ) { ?>style="display: none;"<?php } ?>>
				<hr />
				<h3>
					<span class="pmpro_checkout-h3-name"><?php echo esc_html__('Payment Information', 'ivy-school' );?></span>
					<span class="pmpro_checkout-h3-msg"><?php printf(esc_html__('We Accept %s', 'ivy-school' ), $pmpro_accepted_credit_cards_string);?></span>
				</h3>
				<?php $sslseal = pmpro_getOption("sslseal"); ?>
				<?php if(!empty($sslseal)) { ?>
				<div class="pmpro_checkout-fields-display-seal">
					<?php } ?>
					<div class="pmpro_checkout-fields">
						<?php
						$pmpro_include_cardtype_field = apply_filters('pmpro_include_cardtype_field', false);
						if($pmpro_include_cardtype_field) { ?>
							<div class="pmpro_checkout-field pmpro_payment-card-type">
								<label for="CardType"><?php echo esc_html__('Card Type', 'ivy-school' );?></label>
								<select id="CardType" name="CardType" class=" <?php echo pmpro_getClassForField("CardType");?>">
									<?php foreach($pmpro_accepted_credit_cards as $cc) { ?>
										<option value="<?php echo esc_attr($cc); ?>" <?php if($CardType == $cc) { ?>selected="selected"<?php } ?>><?php echo esc_html($cc); ?></option>
									<?php } ?>
								</select>
							</div>
						<?php } else { ?>
						<input type="hidden" id="CardType" name="CardType" value="<?php echo esc_attr($CardType);?>" />
						<?php } ?>
						<div class="pmpro_checkout-field pmpro_payment-account-number">
							<label for="AccountNumber"><?php echo esc_html__('Card Number', 'ivy-school' );?></label>
							<input id="AccountNumber" name="AccountNumber" class="input <?php echo pmpro_getClassForField("AccountNumber");?>" type="text" size="30" value="<?php echo esc_attr($AccountNumber); ?>" data-encrypted-name="number" autocomplete="off" />
						</div>
						<div class="pmpro_checkout-field pmpro_payment-expiration">
							<label for="ExpirationMonth"><?php echo esc_html__('Expiration Date', 'ivy-school' );?></label>
							<select id="ExpirationMonth" name="ExpirationMonth" class=" <?php echo pmpro_getClassForField("ExpirationMonth");?>">
								<option value="01" <?php if($ExpirationMonth == "01") { ?>selected="selected"<?php } ?>>01</option>
								<option value="02" <?php if($ExpirationMonth == "02") { ?>selected="selected"<?php } ?>>02</option>
								<option value="03" <?php if($ExpirationMonth == "03") { ?>selected="selected"<?php } ?>>03</option>
								<option value="04" <?php if($ExpirationMonth == "04") { ?>selected="selected"<?php } ?>>04</option>
								<option value="05" <?php if($ExpirationMonth == "05") { ?>selected="selected"<?php } ?>>05</option>
								<option value="06" <?php if($ExpirationMonth == "06") { ?>selected="selected"<?php } ?>>06</option>
								<option value="07" <?php if($ExpirationMonth == "07") { ?>selected="selected"<?php } ?>>07</option>
								<option value="08" <?php if($ExpirationMonth == "08") { ?>selected="selected"<?php } ?>>08</option>
								<option value="09" <?php if($ExpirationMonth == "09") { ?>selected="selected"<?php } ?>>09</option>
								<option value="10" <?php if($ExpirationMonth == "10") { ?>selected="selected"<?php } ?>>10</option>
								<option value="11" <?php if($ExpirationMonth == "11") { ?>selected="selected"<?php } ?>>11</option>
								<option value="12" <?php if($ExpirationMonth == "12") { ?>selected="selected"<?php } ?>>12</option>
							</select>
                            <span class="expiration-icon">/</span>
                            <select id="ExpirationYear" name="ExpirationYear" class=" <?php echo pmpro_getClassForField("ExpirationYear");?>">
								<?php
								for($i = date_i18n("Y"); $i < intval( date_i18n("Y") ) + 10; $i++)
								{
									?>
									<option value="<?php echo esc_attr($i)?>" <?php if($ExpirationYear == $i) { ?>selected="selected"<?php } ?>><?php echo esc_html($i)?></option>
									<?php
								}
								?>
							</select>
						</div>
						<?php
						$pmpro_show_cvv = apply_filters("pmpro_show_cvv", true);
						if($pmpro_show_cvv) { ?>
							<div class="pmpro_checkout-field pmpro_payment-cvv">
								<label for="CVV"><?php echo esc_html__('Security Code (CVC)', 'ivy-school' );?></label>
								<input id="CVV" name="CVV" type="text" size="4" value="<?php if(!empty($_REQUEST['CVV'])) { echo esc_attr($_REQUEST['CVV']); }?>" class="input <?php echo pmpro_getClassForField("CVV");?>" />  <small>(<a href="javascript:void(0);" onclick="javascript:window.open('<?php echo pmpro_https_filter(PMPRO_URL); ?>/pages/popup-cvv.html','cvv','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=600, height=475');"><?php echo esc_html__("what's this?", 'ivy-school' );?></a>)</small>
							</div>
						<?php } ?>
						<?php if($pmpro_show_discount_code) { ?>
							<div class="pmpro_checkout-field pmpro_payment-discount-code">
								<label for="discount_code"><?php echo esc_html__('Discount Code', 'ivy-school' );?></label>
								<input class="input <?php echo pmpro_getClassForField("discount_code");?>" id="discount_code" name="discount_code" type="text" size="10" value="<?php echo esc_attr($discount_code); ?>" />
								<input type="button" id="discount_code_button" name="discount_code_button" value="<?php echo esc_html__('Apply', 'ivy-school' );?>" />
								<p id="discount_code_message" class="pmpro_message" style="display: none;"></p>
							</div>
						<?php } ?>
					</div> <!-- end pmpro_checkout-fields -->
					<?php if(!empty($sslseal)) { ?>
					<div class="pmpro_checkout-fields-rightcol pmpro_sslseal"><?php echo stripslashes($sslseal); ?></div>
				</div> <!-- end pmpro_checkout-fields-display-seal -->
			<?php } ?>
			</div> <!-- end pmpro_payment_information_fields -->
		<?php } ?>

        <script>
            <!--
            //checking a discount code
            jQuery('#discount_code_button').click(function() {
                var code = jQuery('#discount_code').val();
                var level_id = jQuery('#level').val();

                if(code)
                {
                    //hide any previous message
                    jQuery('.pmpro_discount_code_msg').hide();

                    //disable the apply button
                    jQuery('#discount_code_button').attr('disabled', 'disabled');

                    jQuery.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',type:'GET',timeout:<?php echo apply_filters("pmpro_ajax_timeout", 5000, "applydiscountcode");?>,
                        dataType: 'html',
                        data: "action=applydiscountcode&code=" + code + "&level=" + level_id + "&msgfield=discount_code_message",
                        error: function(xml){
                            alert('Error applying discount code [1]');

                            //enable apply button
                            jQuery('#discount_code_button').removeAttr('disabled');
                        },
                        success: function(responseHTML){
                            if (responseHTML == 'error')
                            {
                                alert('Error applying discount code [2]');
                            }
                            else
                            {
                                jQuery('#discount_code_message').html(responseHTML);
                            }

                            //enable invite button
                            jQuery('#discount_code_button').removeAttr('disabled');
                        }
                    });
                }
            });
            -->
        </script>

		<?php do_action('pmpro_checkout_after_payment_information_fields'); ?>

		<?php if($tospage && !$pmpro_review) { ?>
			<div id="pmpro_tos_fields" class="pmpro_checkout">
				<hr />
				<h3>
					<span class="pmpro_checkout-h3-name"><?php echo esc_html($tospage->post_title);?></span>
				</h3>
				<div class="pmpro_checkout-fields">
					<div id="pmpro_license" class="pmpro_checkout-field">
						<?php echo wpautop(do_shortcode($tospage->post_content));?>
					</div> <!-- end pmpro_license -->
					<input type="checkbox" name="tos" value="1" id="tos" /> <label class="pmpro_label-inline pmpro_clickable" for="tos"><?php printf(__('I agree to the %s', 'ivy-school' ), $tospage->post_title);?></label>
				</div> <!-- end pmpro_checkout-fields -->
			</div> <!-- end pmpro_tos_fields -->
			<?php
		}
		?>

		<?php do_action("pmpro_checkout_after_tos_fields"); ?>

		<?php do_action("pmpro_checkout_before_submit_button"); ?>

		<div class="pmpro_submit">
			<hr />
			<?php if($pmpro_review) { ?>

				<span id="pmpro_submit_span">
				<input type="hidden" name="confirm" value="1" />
				<input type="hidden" name="token" value="<?php echo esc_attr($pmpro_paypal_token); ?>" />
				<input type="hidden" name="gateway" value="<?php echo esc_attr($gateway); ?>" />
				<input type="submit" class="pmpro_btn pmpro_btn-submit-checkout" value="<?php echo esc_html__('Complete Payment', 'ivy-school' );?> &raquo;" />
			</span>

			<?php } else { ?>

				<?php
				$pmpro_checkout_default_submit_button = apply_filters('pmpro_checkout_default_submit_button', true);
				if($pmpro_checkout_default_submit_button)
				{
					?>
					<span id="pmpro_submit_span">
					<input type="hidden" name="submit-checkout" value="1" />
					<input type="submit" class="pmpro_btn pmpro_btn-submit-checkout" value="<?php if($pmpro_requirebilling) { echo esc_html__('Submit and Check Out', 'ivy-school' ); } else { echo esc_html__('Submit and Confirm', 'ivy-school' );}?> &raquo;" />
				</span>
					<?php
				}
				?>

			<?php } ?>

			<span id="pmpro_processing_message" style="visibility: hidden;">
			<?php
			$processing_message = apply_filters("pmpro_processing_message", esc_html__("Processing...", 'ivy-school' ));
			echo esc_html($processing_message);
			?>
		</span>
		</div>
	</form>

	<?php do_action('pmpro_checkout_after_form'); ?>

</div> <!-- end pmpro_level-ID -->

<script>
    <!--
    // Find ALL <form> tags on your page
    jQuery('form').submit(function(){
        // On submit disable its submit button
        jQuery('input[type=submit]', this).attr('disabled', 'disabled');
        jQuery('input[type=image]', this).attr('disabled', 'disabled');
        jQuery('#pmpro_processing_message').css('visibility', 'visible');
    });

    //iOS Safari fix (see: http://stackoverflow.com/questions/20210093/stop-safari-on-ios7-prompting-to-save-card-data)
    var userAgent = window.navigator.userAgent;
    if(userAgent.match(/iPad/i) || userAgent.match(/iPhone/i)) {
        jQuery('input[type=submit]').click(function() {
            try{
                jQuery("input[type=password]").attr("type", "hidden");
            } catch(ex){
                try {
                    jQuery("input[type=password]").prop("type", "hidden");
                } catch(ex) {}
            }
        });
    }

    //add required to required fields
    jQuery('.pmpro_required').after('<span class="pmpro_asterisk"> <abbr title="Required Field">*</abbr></span>');

    //unhighlight error fields when the user edits them
    jQuery('.pmpro_error').bind("change keyup input", function() {
        jQuery(this).removeClass('pmpro_error');
    });

    //click apply button on enter in discount code box
    jQuery('#discount_code').keydown(function (e){
        if(e.keyCode == 13){
            e.preventDefault();
            jQuery('#discount_code_button').click();
        }
    });

    //hide apply button if a discount code was passed in
    <?php if(!empty($_REQUEST['discount_code'])) {?>
    jQuery('#discount_code_button').hide();
    jQuery('#discount_code').bind('change keyup', function() {
        jQuery('#discount_code_button').show();
    });
    <?php } ?>

    //click apply button on enter in *other* discount code box
    jQuery('#other_discount_code').keydown(function (e){
        if(e.keyCode == 13){
            e.preventDefault();
            jQuery('#other_discount_code_button').click();
        }
    });
    -->
</script>
<script>
    <!--
    //add javascriptok hidden field to checkout
    jQuery("input[name=submit-checkout]").after('<input type="hidden" name="javascriptok" value="1" />');
    -->
</script>