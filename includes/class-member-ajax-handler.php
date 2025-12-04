<?php

class MemberajaxHandler
{



    public function __construct()
    {

        add_action('wp_ajax_nopriv_register_after_payment', [$this, 'register_after_payment_callback']);

        add_action('wp_ajax_register_after_payment', [$this, 'register_after_payment_callback']);

        add_action('wp_ajax_membership_cancel_demand', [$this, 'cancel_membership_callback']);
    }



    /**

     * Handle registration after payment (one-time or subscription)

     */

    public function register_after_payment_callback()
    {

        header('Content-Type: application/json');



        require_once '/home1/mydevits/public_html/alqimi/wp-content/plugins/Membership/lib/init.php';



        \Stripe\Stripe::setApiKey('sk_test_51JeCtcSBo56wci5DRXTInJi6EjyQVvLrFiM1H8CpFAklVdKXEevdbItOnS3smrWZuhdm6PFknppO7J5qwnSVF3mW00ywvc7RmJ');



        $plan_type = sanitize_text_field($_POST['plan_type']);

        $email = sanitize_email($_POST['member_email']);

        $password = sanitize_text_field($_POST['member_password']);

        $name = sanitize_text_field($_POST['member_name']);

        $membershipid = sanitize_text_field($_POST['membershipid']);

        $member_data = array(
            'street' => sanitize_text_field($_POST['member_street']),
            'city' => sanitize_text_field($_POST['member_city']),
            'state' => sanitize_text_field($_POST['member_state']),
            'pincode' => sanitize_text_field($_POST['member_pincode']),
            'country' => sanitize_text_field($_POST['member_country'])
        );






        try {

            if ($plan_type === 'one_time') {

                $payment_id = sanitize_text_field($_POST['payment_id']);

                $this->handle_one_time_payment($email, $password, $name, $payment_id, $membershipid, $member_data);
            } elseif ($plan_type === 'subscription') {

                $payment_method = sanitize_text_field($_POST['payment_method']);

                $price_id = sanitize_text_field($_POST['price_id']);

                $customer_id = sanitize_text_field($_POST['customer_id']);

                $this->handle_subscription($email, $password, $name, $payment_method, $price_id, $customer_id, $membershipid, $member_data);
            } else {

                wp_send_json(['success' => false, 'message' => 'Invalid plan type.']);
            }
        } catch (\Stripe\Exception\ApiErrorException $e) {

            wp_send_json(['success' => false, 'message' => 'Stripe API error: ' . $e->getMessage()]);
        } catch (Exception $e) {

            wp_send_json(['success' => false, 'message' => 'General error: ' . $e->getMessage()]);
        }
    }



    /**

     * Handle one-time payment registration

     */

    private function handle_one_time_payment($email, $password, $name, $payment_id, $membershipid, $member_data)
    {

        if (email_exists($email)) {

            wp_send_json(['success' => false, 'message' => 'Email already registered.']);
        }


        $user_id = wp_create_user($email, $password, $email);

        if (is_wp_error($user_id)) {

            wp_send_json(['success' => false, 'message' => $user_id->get_error_message()]);
        }

        wp_update_user(['ID' => $user_id, 'display_name' => $name]);

        update_user_meta($user_id, 'stripe_payment_id', $payment_id);
        update_user_meta($user_id, 'membershipid', $membershipid);



        // Update the user meta for each member data field
        foreach ($member_data as $key => $value) {
            update_user_meta($user_id, 'member_' . $key, $value);
        }



        wp_send_json(['success' => true, 'message' => 'User registered successfully with one-time payment.']);
    }



    /**

     * Handle subscription registration

     */

    private function handle_subscription($email, $password, $name, $payment_method, $price_id, $customer_id, $membershipid, $member_data)
    {

        $user = get_user_by('email', $email);

        $user_wp_id = $user ? $user->ID : null;

        $payment_method;

        global $wpdb;





        // Get or create Stripe customer

        $this->get_or_create_customer($email, $user_wp_id);

        $customer_id = $customer_id;

        // Attach payment method safely

        $pm = \Stripe\PaymentMethod::retrieve($payment_method);



        if (!$pm->customer) {

            $pm->attach(['customer' => $customer_id]);
        }







        // Set default payment method

        \Stripe\Customer::update($customer_id, [

            'invoice_settings' => [

                'default_payment_method' => $payment_method

            ]

        ]);



        // Create subscription

        $subscription = \Stripe\Subscription::create([

            'customer' => $customer_id,

            'items' => [['price' => $price_id]],

            'expand' => ['latest_invoice.payment_intent']

        ]);





        // Create WP user AFTER Stripe success

        if (!$user) {

            $user_id = wp_create_user($email, $password, $email);

            wp_update_user(['ID' => $user_id, 'display_name' => $name]);
        } else {

            $user_id = $user->ID;
        }



        // Store Stripe customer ID permanently

        update_user_meta($user_id, 'stripe_customer_id', $customer_id);

        update_user_meta($user_id, 'stripe_subscription_id', $subscription->id);
        foreach ($member_data as $key => $value) {
            // Update user meta using the key and value from the $member_data array
            update_user_meta($user_id, 'member_' . $key, $value);
        }





        $wpdb->insert(

            $wpdb->prefix . 'md_subscriptions',

            [

                'user_id' => $user_id,

                'membership_id' => $membershipid, // or your internal plan ID

                'price' => $subscription->plan->amount / 100,

                'total' => $subscription->plan->amount / 100,

                'gateway' => 'stripe',

                'period_type' => $subscription->plan->interval, // month, year

                'status' => $subscription->status,          // active

                'subscription_id' => $subscription->id

            ]

        );


        $table = $wpdb->prefix . 'md_subscriptions';

        $registration_date = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT created_at FROM $table WHERE user_id =%d ORDER BY id DESC LIMIT 1",
                $user_id
            )
        );

        $registration_formatted = $registration_date ? date('d-m-Y', strtotime($registration_date)) : 'N/A';




        // Path to your email template
        $email_template = MEMBERSHIP_PATH . 'templates/emails/user/email-membership-confrimed.php';

        // Load the template file contents
        ob_start();
        include $email_template;
        $message = ob_get_clean();

        // Email subject
        $subject = 'Membership Confirmation';

        // Headers (HTML email)
        $headers = array('Content-Type: text/html; charset=UTF-8');

        // Send the email
        $mail = wp_mail($email, $subject, $message, $headers);

        // wp_send_json(['success' => true, 'message' => 'Subscription created and user registered successfully.']);




        // Path to admin template
        $admin_template = MEMBERSHIP_PATH . 'templates/emails/admin/email-new-user-registered.php';

        ob_start();
        include $admin_template;
        $admin_message = ob_get_clean();

        $admin_email   = get_option('admin_email');
        $admin_subject = 'New Membership Subscription Notification';
        $admin_headers = array('Content-Type: text/html; charset=UTF-8');

        wp_mail($admin_email, $admin_subject, $admin_message, $admin_headers);

        // FINAL RESPONSE (only one)
        wp_send_json([
            'success' => true,
            'message' => 'Subscription created and user registered successfully.'
        ]);
    }



    /**

     * Get or create Stripe customer, safely

     */

    public function get_or_create_customer($email, $user_wp_id = null)
    {

        // Check if WP user has customer ID

        if ($user_wp_id) {

            $customer_id = get_user_meta($user_wp_id, 'stripe_customer_id', true);

            if ($customer_id) {

                try {

                    $customer = \Stripe\Customer::retrieve($customer_id);

                    if ($customer && $customer->id)
                        return $customer->id;
                } catch (\Stripe\Exception\ApiErrorException $e) {

                    // Customer ID invalid → create new

                }
            }
        }



        // Create new customer

        $customer = \Stripe\Customer::create([

            'email' => $email

        ]);



        // Save customer ID to WP user meta if available

        if ($user_wp_id) {

            update_user_meta($user_wp_id, 'stripe_customer_id', $customer->id);
        }



        return $customer->id;
    }

    public function cancel_membership_callback()
    {
        
        global $wpdb;

        if (!isset($_POST['sus_id']) || empty($_POST['sus_id'])) {
            wp_send_json([
                'success' => false,
                'message' => 'No subscription ID received.'
            ]);
        }



        $subscription_id = sanitize_text_field('sub_1SXGW9SBo56wci5DlhNm41yV');

        $user_id = intval($_POST['user_id']);                     


        if ($user_id !== get_current_user_id()) {
            wp_send_json([
                'success' => false,
                'message' => 'Unauthorized request.'
            ]);
        }

        // USER EMAIL DIRECT GET
        $user = get_user_by('ID', $user_id);
        $name  = $user->display_name;
        $email = $user->user_email;

        $table = $wpdb->prefix . 'md_subscriptions';

        $membership_id = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT membership_id FROM $table WHERE user_id = %d ORDER BY id DESC LIMIT 1",
                $user_id
            )
        );

        $custom_logo_id = get_theme_mod('custom_logo');

        // Get the full URL of the logo image
        $logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');


        // Load Stripe SDK and set API key
        // require_once '/home1/mydevits/public_html/alqimi/wp-content/plugins/Membership/lib/init.php';
        // \Stripe\Stripe::setApiKey('sk_test_51JeCtcSBo56wci5DRXTInJi6EjyQVvLrFiM1H8CpFAklVdKXEevdbItOnS3smrWZuhdm6PFknppO7J5qwnSVF3mW00ywvc7RmJ');

        // try {
        //     $cancel_res = \Stripe\Subscription::update($subscription_id, [
        //         'cancel_at_period_end' => true
        //     ]);

        //     wp_send_json([
        //         'success' => true,
        //         'message' => 'Subscription cancellation scheduled.',
        //         'data' => $cancel_res
        //     ]);
        // } catch (\Stripe\Exception\ApiErrorException $e) {
        //     wp_send_json([
        //         'success' => false,
        //         'message' => 'Stripe API error: ' . $e->getMessage()
        //     ]);
        // } catch (\Exception $e) {
        //     wp_send_json([
        //         'success' => false,
        //         'message' => 'General error: ' . $e->getMessage()
        //     ]);
        // }



        // Path to user membership cancllation template
        $email_template = MEMBERSHIP_PATH . 'templates/emails/user/email-membership-cancllation.php';

        ob_start();
        include $email_template;
        $message = ob_get_clean();

        $subject = 'Membership Cancllation';

        $headers = array('Content-Type: text/html; charset=UTF-8');

        $mail = wp_mail($email, $subject, $message, $headers);


        // Path to admin template
        $admin_template = MEMBERSHIP_PATH . 'templates/emails/admin/email-notify-membership-canclled.php';

        ob_start();
        include $admin_template;
        $admin_message = ob_get_clean();

        $admin_email   = get_option('admin_email');
        $admin_subject = 'Membership Cancllation Alert';
        $admin_headers = array('Content-Type: text/html; charset=UTF-8');

        wp_mail($admin_email, $admin_subject, $admin_message, $admin_headers);

        // FINAL RESPONSE (only one)
        wp_send_json([
            'success' => true,
            'message' => 'Your membership has been successfully cancelled.'
        ]);

    }



}



// Initialize the class

new MemberajaxHandler();
