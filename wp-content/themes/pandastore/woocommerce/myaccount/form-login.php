<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 7.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<div class="login-popup" id="customer_login">
	<?php do_action( 'woocommerce_before_customer_login_form' ); ?>
	<div class="tab tab-nav-simple tab-nav-boxed form-tab">
		<ul class="nav nav-tabs nav-fill" role="tablist">
			<li class="nav-item">
				<a href="signin" class="nav-link active" data-toggle="tab"><?php esc_html_e( 'Login', 'pandastore' ); ?></a>
			</li>
		<?php if ( 'yes' == get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
			<li class="nav-item">
				<a href="signup" class="nav-link" data-toggle="tab"><?php esc_html_e( 'Register', 'pandastore' ); ?></a>
			</li>
		<?php endif; ?>
		</ul>
		<div class="tab-content">

			<div class="tab-pane active" id="signin">
				<form class="woocommerce-form woocommerce-form-login login" method="post">

					<?php do_action( 'woocommerce_login_form_start' ); ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username"  placeholder="<?php esc_html_e ('Username or email address','pandastore') ?>"  required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" 
oninvalid="this.setCustomValidity('<?php esc_attr_e('Enter a username or email address.', 'woocommerce'); ?>')" 
oninput="this.setCustomValidity('')"  value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
					</p>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_html_e  ('Password','pandastore') ?>"  required 
oninvalid="this.setCustomValidity('<?php esc_attr_e('Please enter your password.', 'woocommerce'); ?>')" 
oninput="this.setCustomValidity('')"  />
					</p>

					<?php do_action( 'woocommerce_login_form' ); ?>

					<div class="form-row">
						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme form-checkbox">
							<input class="woocommerce-form__input woocommerce-form__input-checkbox"  name="rememberme" type="checkbox" id="rememberme" value="forever"  /> <span><?php esc_html_e( 'Remember me', 'pandastore' ); ?></span>
						</label>
						<p class="woocommerce-LostPassword lost_password">
							<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'pandastore' ); ?></a>
						</p>
					</div>

					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
					<button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Sign In', 'pandastore' ); ?>"><?php esc_html_e( 'Login', 'pandastore' ); ?></button>

					<p class="submit-status"></p>

					<?php do_action( 'woocommerce_login_form_end' ); ?>

				</form>
			</div>

		<?php if ( 'yes' == get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
			<div class="tab-pane" id="signup">
				<form method="post" class="woocommerce-form woocommerce-form-login register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

					<?php do_action( 'woocommerce_register_form_start' ); ?>

					<?php if ( 'no' == get_option( 'woocommerce_registration_generate_username' ) ) : ?>
						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" title="input required" placeholder="<?php  esc_html_e ('Username','pandastore') ?>" required value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
						</p>

					<?php endif; ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" placeholder="<?php esc_html_e('Your Email address','pandastore') ?>" required oninput="if (this.value.trim() === '') { this.setCustomValidity('<?php echo esc_attr__('Please fill the email address.','mailpoet'); ?>'); } else { this.setCustomValidity(''); }" oninvalid="if (this.value.trim() === '') { this.setCustomValidity('<?php echo esc_attr__('Please fill in the email address.','woocommerce'); ?>'); } else { this.setCustomValidity('<?php echo esc_attr__('Invalid email address', 'woocommerce'); ?>'); }"
 value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
					</p> 

					<?php if ( 'no' == get_option( 'woocommerce_registration_generate_password' ) ) : ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<input type="password"  class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" placeholder="<?php  esc_html_e('Password','pandastore') ?>" required />
						</p>

					<?php else : ?>

						<p><?php esc_html_e( 'A password will be sent to your email address.', 'pandastore' ); ?></p>

					<?php endif; ?>

					<?php do_action( 'woocommerce_register_form' ); ?>

					<?php do_action( 'alpha_register_form' ); ?>

					<?php
					/* translators: opening and ending p tag */
					$text = sprintf( esc_html__( '%1$sI agree to the %2$s', 'pandastore' ), '<p class="custom-checkbox"><input type="checkbox" id="register-policy" required=""  class="mr-2" oninvalid="this.setCustomValidity(\''. esc_attr__('Please check this checkbox to proceed', 'woocommerce') .'\')" oninput="this.setCustomValidity(\'\')"><label for="register-policy">', '[privacy_policy]</label></p>' );
echo wpautop( wc_replace_policy_page_link_placeholders( $text ) );

					
					?>

					<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
					<button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Sign Up', 'pandastore' ); ?>"><?php esc_html_e( 'Register', 'pandastore' ); ?></button>

					<p class="submit-status"></p>

					<?php do_action( 'woocommerce_register_form_end' ); ?>

				</form>
			</div>
		<?php endif; ?>
		</div>
	</div>

	<?php do_action( 'alpha_after_customer_login_form' ); ?>
</div>
