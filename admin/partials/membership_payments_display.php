<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://mydevitsolutions.com
 * @since      1.0.0
 *
 * @package    Membership
 * @subpackage Membership/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
		  // Check PayPal / Stripe settings submit.
		  $settings = Members_Settings::get_instance();
		  $stripe_publishable_key = $settings->get_value( 'stripe_publishable_key' );
		  $stripe_secret_key = $settings->get_value( 'stripe_secret_key' );
		  $stripe_webhook_url = $settings->get_value( 'stripe_webhook_url' );
		  $stripe_mode = $settings->get_value( 'stripe_mode' );
		  
		  // Paypal 
	      $paypal_client_id = $settings->get_value( 'paypal_client_id' );
		  $paypal_secret = $settings->get_value( 'paypal_secret' );
		  $paypal_webhook_url = $settings->get_value( 'paypal_webhook_url' );
		  $paypal_mode = $settings->get_value( 'paypal_mode' );
		 
        if (isset($_POST['strip-settings-submit']) && check_admin_referer('stripe-settings-nonce')) {
            $settings->set_value('stripe_publishable_key' ,( isset($_POST['stripe_publishable_key']) ? sanitize_text_field($_POST['stripe_publishable_key']) : ''));
            $settings->set_value('stripe_secret_key' ,( isset($_POST['stripe_secret_key']) ? sanitize_text_field($_POST['stripe_secret_key']) : ''));
            $settings->set_value('stripe_webhook_url' ,( isset($_POST['stripe_webhook_url']) ? sanitize_text_field($_POST['stripe_webhook_url']) : ''));
            $settings->set_value('stripe_mode' ,( isset($_POST['stripe_mode']) ? sanitize_text_field($_POST['stripe_mode']) : ''));
			
			$settings->set_value('paypal_client_id' ,( isset($_POST['paypal_client_id']) ? sanitize_text_field($_POST['paypal_client_id']) : ''));
			$settings->set_value('paypal_secret' ,( isset($_POST['paypal_secret']) ? sanitize_text_field($_POST['paypal_secret']) : ''));
			$settings->set_value('paypal_mode' ,( isset($_POST['paypal_mode']) ? sanitize_text_field($_POST['paypal_mode']) : ''));
			$settings->set_value('paypal_webhook_url' ,( isset($_POST['paypal_webhook_url']) ? sanitize_text_field($_POST['paypal_webhook_url']) : ''));

            $settings->save();
            echo '<div class="notice notice-success"><p>' . __('Strip API settings updated successfully.', 'simple-membership') . '</p></div>';
        }
		
		

?>



<div class="wrap members-cm gateway-settings">
  <h1>Membership Gateway Settings</h1>

  <div class="tabs home">
    <div class="tab-button active" onclick="showTab(event, 'g-setting')">Genral Setting</div>
    <div class="tab-button" onclick="showTab(event, 'paypal-setting')">Paypal API</div>
    <div class="tab-button" onclick="showTab(event, 'stripe-setting')">Stripe Setting</div>
  </div>


    <div id="g-setting" class="tab-content active">
    <form method="get" action="">
      <h3>Sandbox or Test Mode Payment Settings.</h3>
      <p>Thes section allows you 10 enable/daabie sandbox or test mode for the payment buttons and transactions.</p>
      <table class="form-table" role="presentation">
      <tbody>
        <tr>
          <th scope="row">Membership</th>
          <td>
            <fieldset>
              <label class="screen-reader-text">
                <span>Membership</span>
              </label>
              <label for="a-register">
                <input name="a-register" type="checkbox" id="a-register" value="1">
                Anyone can register
              </label>
            </fieldset>
          </td>
        </tr>

        <tr>
          <th scope="row">Enable Sandbox</th>
          <td>
            <fieldset>
              <label class="screen-reader-text">
                <span>Enable Sandbox</span>
              </label>
              <label for="e-sandbox">
                <input name="e-sandbox" type="checkbox" id="e-sandbox" value="1">
                Anyone can register
              </label>
            </fieldset>
          </td>
        </tr>

        <tr>
          <th scope="row">Enable Test Mode</th>
          <td>
            <fieldset>
              <label class="screen-reader-text">
               <span>Enable Test Mode</span>
              </label>
              <label for="e-test-mode">
                <input name="e-test-mode" type="checkbox" id="e-test-mode" value="1">
                Anyone can register
              </label>
            </fieldset>
          </td>
        </tr>
      </tbody>
    </table>

    <button type="submit" name="strip-settings-submit" class="button button-primary" fdprocessedid="182mtc">Save Changes</button>  
      
    </form>
  </div>

    <div id="paypal-setting" class="tab-content">

    <form method="post" class="g-formst">
    <!-- PayPal Section -->
    <h3>PayPal Configuration</h3>
    <table class="form-table">
      <tr>
        <th><label for="paypal_mode">Mode</label></th>
        <td>
          <select id="paypal_mode" name="paypal_mode">
          
       <option value="sandbox" <?php echo ($paypal_mode == 'sandbox') ? 'selected' : '' ;?>>Sandbox (Test)</option>
            <option value="live" <?php echo ($paypal_mode == 'live') ? 'selected' : '' ;?>>Live</option>
          </select>
        </td>
      </tr>
      <tr>
        <th><label for="paypal_client_id">PayPal Client ID</label></th>
        <td>
          <input type="text" id="paypal_client_id" name="paypal_client_id" class="regular-text" value="<?php echo $paypal_client_id; ?>" placeholder="Enter PayPal Client ID">
        </td>
      </tr>
      <tr>
        <th><label for="paypal_secret">PayPal Secret</label></th>
        <td>
          <input type="password" id="paypal_secret" name="paypal_secret" class="regular-text" value="<?php echo $paypal_secret; ?>" placeholder="Enter PayPal Secret">
        </td>
      </tr>
      <tr>
        <th><label for="paypal_webhook_url">Webhook URL</label></th>
        <td>
          <input type="url" id="paypal_webhook_url" name="paypal_webhook_url" value="<?php echo $paypal_webhook_url; ?>" class="regular-text" placeholder="https://yoursite.com/webhook/paypal">
        </td>
      </tr>
    </table>
    <p class="submit">
    <?php wp_nonce_field('stripe-settings-nonce');?>
      <button type="submit" name="strip-settings-submit" class="button button-primary">Save Gateway Settings</button>
    </p>

    </form>
    </div>

    <div id="stripe-setting" class="tab-content">
   <form method="post" class="g-formst">

    <!-- Stripe Section -->
    <h3>Stripe Configuration</h3>
    <table class="form-table">
      <tr>
        <th><label for="stripe_mode">Mode</label></th>
        <td>
          <select id="stripe_mode" name="stripe_mode">
            <option value="test" <?php echo ($stripe_mode == 'test') ? 'selected' : '' ;?>>Test</option>
            <option value="live" <?php echo ($stripe_mode == 'live') ? 'selected' : '' ;?>>Live</option>
      
    
          </select>
        </td>
      </tr>
      <tr>
        <th><label for="stripe_publishable_key">Stripe Publishable Key</label></th>
        <td>
          <input type="text" id="stripe_publishable_key" name="stripe_publishable_key" value="<?php echo $stripe_publishable_key; ?>" class="regular-text" placeholder="pk_test_********"  >
        </td>
      </tr>
      <tr>
        <th><label for="stripe_secret_key">Stripe Secret Key</label></th>
        <td>
          <input type="password" id="stripe_secret_key" name="stripe_secret_key" class="regular-text" value="<?php echo $stripe_secret_key; ?>" placeholder="sk_test_********">
        </td>
      </tr>
      <tr>
        <th><label for="stripe_webhook_url">Webhook URL</label></th>
        <td>
          <input type="url" id="stripe_webhook_url" name="stripe_webhook_url" class="regular-text" value="<?php echo $stripe_webhook_url; ?>"placeholder="https://yoursite.com/webhook/stripe">
        </td>
      </tr>
    </table>

    <p class="submit">
    <?php wp_nonce_field('stripe-settings-nonce');?>
      <button type="submit" name="strip-settings-submit" class="button button-primary">Save Gateway Settings</button>
    </p>
  </form>     
    </div>

</div>




<script>
  function showTab(event, tabId) {
    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
    event.target.classList.add('active');
  }
</script>