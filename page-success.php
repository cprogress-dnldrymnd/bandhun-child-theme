<?php

get_header();
if (!is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
}
$user = wp_get_current_user();
if (!in_array('couple', (array) $user->roles)) {
    wp_redirect(home_url());
    exit;
}

if (!isset($_GET['session_id'])) {
    wp_send_json_error('Session ID not provided');
    return;
}
$stripeKey = [
    'public' => get_option('cmp_stripe_public_key', ''),
    'secret' => get_option('cmp_stripe_secret_key', '')
];

try {
    $session_id = $_GET['session_id'];
    $user_id = get_current_user_id();
    $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
    $subscription_id = $checkout_session->subscription ?? null;

    $payment_intent_id = $checkout_session->payment_intent ?? null;


    if ($subscription_id) {
        $subscription = \Stripe\Subscription::retrieve($subscription_id);
    } elseif ($payment_intent_id) {
        $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
    } else {
        throw new Exception('No subscription or payment intent found.');
    }
    $customer_id = $checkout_session->customer;

    $customer = \Stripe\Customer::retrieve($customer_id);
    $metadata = $checkout_session->metadata;


    if ($customer && isset($customer->email)) {
        if ($subscription_id) {
            update_user_meta($user_id, 'subscription_id', $subscription_id);
            update_user_meta($user_id, 'plan_start_date', $subscription->current_period_start);
            update_user_meta($user_id, 'plan_end_date', $subscription->current_period_end);

            if (isset($subscription->items->data[0])) {
                $productId = $subscription->items->data[0]->plan->product;
                $price_id = $subscription->items->data[0]->price->id;
                $product = \Stripe\Product::retrieve($productId);

                update_user_meta($user_id, 'plan_id', $productId);
                update_user_meta($user_id, 'plan_name', $product->name);
                update_user_meta($user_id, 'price_id', $price_id);
                update_user_meta($user_id, 'plan_status', 'Active');
            }
            
            // if ($addonCheck !== 'yes') {
            //     $current_user_id = get_current_user_id();
            //     $existingSub = get_user_meta($current_user_id, 'subscription_id', true);
            //     if ($existingSub !== "" && !empty($existingSub)) {
            //         $existing_subscription = \Stripe\Subscription::retrieve($subscription_id);
            //         if ($existing_subscription->status === 'active') {
            //             $existing_subscription->cancel();
            //             global $wpdb;
            //             $table_name = $wpdb->prefix . 'cms_stripe_subscription';
            //             $wpdb->update(
            //                 $table_name,
            //                 array(
            //                     'status' => 'canceled',
            //                     'updated_at' => current_time('mysql', 1)
            //                 ),
            //                 array('subscription_id' => $existingSub),
            //                 array(
            //                     '%s',
            //                     '%s'
            //                 ),
            //                 array('%s')
            //             );
            //         }
            //     }
            // }
            /**
             *Store Cus Data
             */
            store_customer_data($user_id, $customer_id, $productId, 'Active', $product->name, $price_id, $subscription->current_period_start, $subscription->current_period_end, $subscription_id);
            /**
             *Store Sub Data
             */
            
           $plan_id = $price_id;
            $planName = get_price_details('name', $plan_id);
            $planAmount = get_price_details('amount', $plan_id);
            $site_name = get_bloginfo('name');
            $subscription_start_date = date('d-m-Y', $subscription->current_period_start);
            $next_billing_date = date('d-m-Y', $subscription->current_period_end);
            $coupleUsername = $current_user->user_login;
            $_EMAIL_ARGS = [
                'next_billing_date' => $next_billing_date,
                'subscription_start_date' => $subscription_start_date,
                'price' => $planAmount,
                'plan_name' => $planName,
                'couple_username' => $coupleUsername,
                'site_name' => $site_name,
            ];
            sendSubscriptionMail($_EMAIL_ARGS, $customer->email);
            
            cmp_insert_subscription($customer_id, $subscription_id, '', $productId, $price_id, $product->name, $subscription->current_period_start, $subscription->current_period_end, 'Active', 'couple');

            /**
             *Store Invoice Data
             */
            cancel_old_subscriptions($customer_id, $subscription_id);
        } else {
            $priceId = isset($_SESSION['price_id_couple']) ? $_SESSION['price_id_couple'] : '';

            $stripe = new \Stripe\StripeClient(get_option('cmp_stripe_secret_key', ''));

            $priceData = $stripe->prices->retrieve($priceId, []);

            $pId = get_price_details('plan_id', $priceId);

            $plan_name = get_price_details('name', $priceId);

            $productId = isset($priceData->product) ? $priceData->product : $pId;



            $plan_interval = get_price_details('plan_interval', $priceId);
            $interval_count = get_price_details('interval_count', $priceId);
            $start_date = date('Y-m-d H:i:s');
            $end_date = calculate_end_date($start_date, $plan_interval, $interval_count);

            $planStartDate = strtotime($start_date);
            $planEndDate = strtotime($end_date);

            update_user_meta($user_id, 'payment_id', $payment_intent_id);
            update_user_meta($user_id, 'plan_start_date', $planStartDate);
            update_user_meta($user_id, 'plan_end_date', $planEndDate);
            update_user_meta($user_id, 'plan_id', $productId);
            update_user_meta($user_id, 'plan_name', $plan_name);
            update_user_meta($user_id, 'price_id', $priceId);
            update_user_meta($user_id, 'plan_status', 'Active');

            /**
             *Store Cus Data
             */
            store_customer_data($user_id, $customer_id, $productId, 'Active', $plan_name, $priceId, $planStartDate, $planEndDate, $payment_intent_id);

            cmp_insert_subscription($customer_id, '', $payment_intent_id, $productId, $priceId, $plan_name, $planStartDate, $planEndDate, 'Active', 'couple');

            unset($_SESSION['price_id_couple']);
        }

        if (!session_id()) {
            session_start();
        }
        $_SESSION['subscription_success'] = true;
        $_redirect_link   =   apply_filters('weddingdir/couple-menu/page-link', esc_attr('couple-dashboard'));
        wp_redirect($_redirect_link);
    } else {
        // wp_redirect(home_url('subscription-plan'));
         $_redirect_link   =   apply_filters('weddingdir/couple-menu/page-link', esc_attr('couple-dashboard'));
        wp_redirect($_redirect_link);
    }
} catch (Exception $e) {
}

/**
 * Cancels any other active subscriptions for the given customer, except for the current subscription.
 *
 * @param string $customer_id The ID of the customer whose subscriptions should be canceled.
 * @param string $current_subscription_id The ID of the current subscription that should not be canceled.
 */
function cancel_old_subscriptions($customer_id, $current_subscription_id)
{
    try {
        $subscriptions = \Stripe\Subscription::all([
            'customer' => $customer_id,
            'status' => 'active',
        ]);
        foreach ($subscriptions->data as $subscription) {
            if ($subscription->id !== $current_subscription_id) {
                $subscription->cancel();
                // \Stripe\Subscription::update($subscription->id, ['cancel_at_period_end' => true]);
            }
        }
    } catch (Exception $e) {
    }
}
function sendSubscriptionMail($_EMAIL_ARGS, $coupleEmail)
{
    WeddingDir_Email::sending_email(array(

        /**
         *  1. Setting ID : Email PREFIX_
         *  -----------------------------
         */
        'setting_id'        =>      esc_attr('new-subscribe-couple'),

        /**
         *  2. Sending Email ID
         *  -------------------
         */
        'sender_email'      =>      sanitize_email($coupleEmail),

        /**
         *  3. Email Data Key and Value as Setting Body Have {{...}} all
         *  ------------------------------------------------------------
         */
        'email_data'        =>     $_EMAIL_ARGS

    ));
}
?>
<?php

get_footer();

?>
<script>

</script>