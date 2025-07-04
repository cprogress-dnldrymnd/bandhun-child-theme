<?php

require 'vendor/autoload.php';

$stripeKey = [
    'public' => get_option('cmp_stripe_public_key', ''),
    'secret' => get_option('cmp_stripe_secret_key', '')
];

\Stripe\Stripe::setApiKey(get_option('cmp_stripe_secret_key', ''));

/**
 * Gets or creates a Stripe customer ID for the given user.
 *
 * This function checks if the given user has a Stripe customer ID stored in their user meta. If not, it creates a new Stripe customer and stores the ID in the user meta.
 *
 * @param int $user_id The ID of the WordPress user.
 * @param string $user_email The email address of the WordPress user.
 * @return string The Stripe customer ID for the given user.
 */

function get_or_create_stripe_customer_id($user_id, $user_email)
{
    $customer_id = get_user_meta($user_id, 'stripe_customer_id', true);

    // $customer = \Stripe\Customer::retrieve($customer_id);

    if (!$customer_id) {

        $customer = \Stripe\Customer::create([
            'email' => $user_email,
        ]);
        update_user_meta($user_id, 'stripe_customer_id', $customer->id);
        $customer_id = $customer->id;
    }

    return $customer_id;
}

/**
 * Creates a Stripe checkout session with the provided details.
 *
 * This function creates a Stripe checkout session with the given price ID, customer ID, customer name, and customer address.
 * The created checkout session URL is returned, which can be used to redirect the user to the Stripe checkout page.
 *
 * @param string $price_id The ID of the price to be used in the checkout session.
 * @param string $customer_id The ID of the Stripe customer to be used in the checkout session.
 * @param string $customer_name The name of the customer to be used in the checkout session metadata.
 * @param array $customer_address The address of the customer to be used in the checkout session metadata.
 * @return string The URL of the created Stripe checkout session.
 */
function create_stripe_checkout_session($price_id, $customer_id, $customer_name, $customer_address, $type)
{

    $baseUrl = home_url();
     $tax_rate_id = get_field('stripe_tax_rate_id', 'option');
    if ($type == 'vendor') {
        if (!session_id()) {
            session_start();
        }
        $_SESSION['price_id_vendor'] = $price_id;
        $url = apply_filters('weddingdir/vendor-menu/page-link', esc_attr('vendor-pricing'));
        \Stripe\Stripe::setApiKey(get_option('cmp_stripe_secret_key', ''));
        $recurring = get_price_details('recurring', $price_id);

        $checkout_session_params = [
            'customer' => $customer_id,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => $price_id,
                'quantity' => 1,
                 'tax_rates' => [$tax_rate_id], 
            ]],
            'success_url' => $baseUrl . '/success-vendor?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $url,
            'billing_address_collection' => 'required',
            'metadata' => [
                'customer_name' => $customer_name,
                'customer_address' => json_encode($customer_address),
            ],
        ];

        if ($recurring === 'yes') {
            $checkout_session_params['mode'] = 'subscription';
        } else {
            $checkout_session_params['mode'] = 'payment';
        }
        $checkout_session = \Stripe\Checkout\Session::create($checkout_session_params);
    } else {
        $canUrl = apply_filters('weddingdir/couple-menu/page-link', esc_attr('couple-dashboard'));
        \Stripe\Stripe::setApiKey(get_option('cmp_stripe_secret_key', ''));
        $_SESSION['price_id_couple'] = $price_id;
        $recurring = get_price_details('recurring', $price_id);
        $checkout_session_params = [
            'customer' => $customer_id,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => $price_id,
                'quantity' => 1,
                 'tax_rates' => [$tax_rate_id], 
            ]],
            'success_url' => $baseUrl . '/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $canUrl,
            'billing_address_collection' => 'required',
            'metadata' => [
                'customer_name' => $customer_name,
                'customer_address' => json_encode($customer_address),
            ],
         
        ];

        if ($recurring === 'yes') {
            $checkout_session_params['mode'] = 'subscription';
        } else {
            $checkout_session_params['mode'] = 'payment';
        }
        $checkout_session = \Stripe\Checkout\Session::create($checkout_session_params);
    }

    return $checkout_session->url;
}
add_action('wp_ajax_create_checkout_session', 'handle_create_checkout_session');
add_action('wp_ajax_nopriv_create_checkout_session', 'handle_create_checkout_session');

/**
 * Handles the creation of a Stripe checkout session.
 *
 * This function is called when the user initiates a checkout process. It retrieves the current user's information,
 * creates or retrieves the Stripe customer ID, and then creates a Stripe checkout session with the appropriate
 * details. The URL of the created checkout session is then returned as a JSON response.
 *
 * @return void
 */
function handle_create_checkout_session()
{
    if (!is_user_logged_in()) {
        wp_send_json_error('User not logged in');
        return;
    }
    $current_user = wp_get_current_user();

    $customer_id = get_or_create_stripe_customer_id($current_user->ID, $current_user->user_email);
    $price_id = $_POST['price_id'];
    $type = isset($_POST['type']) ? $_POST['type'] : 'couple';
    $customer_name = $current_user->display_name;
    $customer_address = [
        'line1' => get_user_meta($current_user->ID, 'address_line_1', true),
        'city' => get_user_meta($current_user->ID, 'city', true),
        'state' => get_user_meta($current_user->ID, 'state', true),
        'postal_code' => get_user_meta($current_user->ID, 'postal_code', true),
        'country' => 'IN',
    ];

    try {
        $checkout_session_url = create_stripe_checkout_session($price_id, $customer_id, $customer_name, $customer_address, $type);
        wp_send_json_success(['url' => $checkout_session_url, 'message' => 'Subscription created successfully!']);
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage());
    }
}

function enqueue_my_scripts()
{
    wp_enqueue_script('my-custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), '1.0', true);
    wp_localize_script('my-custom-js', 'myAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('my-custom-nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_my_scripts');


function update_customer_transactions()
{
    error_log('Cron job started at ' . date('Y-m-d H:i:s'));

    $users = get_users([
        'meta_key' => 'stripe_customer_id',
        'meta_compare' => 'EXISTS'
    ]);

    foreach ($users as $user) {
        $customer_id = get_user_meta($user->ID, 'stripe_customer_id', true);
         if (!empty($customer_id) && $customer_id != '') {
        \Stripe\Stripe::setApiKey(get_option('cmp_stripe_secret_key', ''));
        
        $subscriptions = \Stripe\Subscription::all([
            'customer' => $customer_id,
            'status' => 'active',
            'limit' => 1,
        ]);
         $user_data = get_userdata($user->ID);
                $user_roles = $user_data->roles;
        if (!empty($subscriptions->data)) {
            $subscription = $subscriptions->data[0];
            $start_date = $subscription->current_period_start;
            $end_date = $subscription->current_period_end;
            $plan_id = $subscription->items->data[0]->plan->product;
            $status = $subscription->status;
            $product = \Stripe\Product::retrieve($plan_id);
            $price_id = $subscription->items->data[0]->price->id;
            $sponsorsFacility = get_price_details('add_sponsors_facility', $price_id);
            $subscription_id = $subscription->id;
$current_date = date('Y-m-d');
            global $wpdb;
            $table_name = $wpdb->prefix . 'cms_stripe_subscription';
            $query = $wpdb->prepare(
                "SELECT COUNT(*) FROM $table_name 
                 WHERE member_id = %s 
                 AND subscription_id = %s 
                 AND DATE(created_at) = %s",
                $customer_id,
                $subscription_id,
                $current_date
            );
            $transaction_count = $wpdb->get_var($query);
            if ($transaction_count <= 0) {
               $user_data = get_userdata($user->ID);
                    $user_roles = $user_data->roles;
                    if ($sponsorsFacility === 'yes') {
                        update_user_meta($user->ID, 'is_sponsor', true);
                        update_user_meta($user->ID, 'is_sponsor_plan_id', $plan_id);
                        update_user_meta($user->ID, 'is_sponsor_plan_name', $product->name);
                        update_user_meta($user->ID, 'is_sponsor_price_id', $price_id);
                        update_user_meta($user->ID, 'is_sponsor_plan_status', $status);
                        update_user_meta($user->ID, 'is_sponsor_subscription_id', $subscription_id);
                        update_user_meta($user->ID, 'is_sponsor_plan_start_date', $start_date);
                        update_user_meta($user->ID, 'is_sponsor_plan_end_date', $end_date);
                        cmp_insert_subscription($customer_id, $subscription_id, '', $plan_id, $price_id, $product->name, $start_date, $end_date, $status, $user_roles);
                    } else {
                        update_user_meta($user->ID, 'plan_start_date', $start_date);
                        update_user_meta($user->ID, 'plan_end_date', $end_date);
                        store_customer_data($user->ID, $customer_id, $plan_id, $status, $product->name, $price_id, $start_date, $end_date, $subscription_id);
                        cmp_insert_subscription($customer_id, $subscription_id, '', $plan_id, $price_id, $product->name, $start_date, $end_date, $status, $user_roles);
                    }
            }
        }
         }
    }
    error_log('Cron job completed at ' . date('Y-m-d H:i:s'));
}
add_action('update_customer_transactions_daily', 'update_customer_transactions');



function update_customer_transactions_without_recuring()
{
    $current_time = time();

    $users = get_users([
        'meta_key' => 'stripe_customer_id',
        'meta_compare' => 'EXISTS'
    ]);
    foreach ($users as $user) {
       $plan_end_date = get_user_meta($user->ID, 'plan_end_date', true);
        if ($plan_end_date && $plan_end_date < $current_time) {
            update_user_meta($user->ID, 'plan_status', 'Expire');
            update_cms_member_status($user->ID, 'Expire');
        }
        // if ($plan_end_date && $plan_end_date > $current_time) {
        //     update_user_meta($user->ID, 'plan_status', 'Active');
        //     update_cms_member_status($user->ID, 'Active');
        // }
    }
}
add_action('update_customer_transactions_without_recuring', 'update_customer_transactions_without_recuring');

function update_cms_member_status($user_id, $new_status)
{
    global $wpdb;

    $table_member = $wpdb->prefix . 'cms_member';

    // Update the status in the cms_member table
    $wpdb->update(
        $table_member,
        array('status' => sanitize_text_field($new_status)), // Data to update
        array('user_id' => intval($user_id)), // Where clause
        array('%s'), // Data format
        array('%d')  // Where clause format
    );
}

if (!session_id()) {
    session_start();
}
if (isset($_SESSION['subscription_success']) && $_SESSION['subscription_success']) {
    unset($_SESSION['subscription_success']);

    function enqueue_custom_inline_script()
    {
        if (!is_admin()) {
            $custom_script = "
            jQuery(document).ready(function ($) {
                // Display alert message on page load
                  weddingdir_alert( {

                                'notice'  :  1,

                                'message' :  'Subscription created successfully!'

                            } );
            });
        ";
            wp_add_inline_script('jquery', $custom_script);
        }
    }
    add_action('wp_enqueue_scripts', 'enqueue_custom_inline_script');
}

if (isset($_SESSION['subscription_success_vendor']) && $_SESSION['subscription_success_vendor']) {
    unset($_SESSION['subscription_success_vendor']);

    function enqueue_custom_inline_script()
    {
        if (!is_admin()) {
            $custom_script = "
            jQuery(document).ready(function ($) {
                // Display alert message on page load
                  weddingdir_alert( {

                                'notice'  :  1,

                                'message' :  'Subscription created successfully!'

                            } );
            });
        ";
            wp_add_inline_script('jquery', $custom_script);
        }
    }
    add_action('wp_enqueue_scripts', 'enqueue_custom_inline_script');
}

function get_plan_name_from_subscription($subscription_id)
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'cms_stripe_subscription';
    $query = $wpdb->prepare("SELECT plan_name FROM $table_name WHERE subscription_id = %s", $subscription_id);
    $plan_name = $wpdb->get_var($query);

    return $plan_name ? esc_attr($plan_name) : esc_attr__('Free', 'weddingdir-pricing');
}

// function is_my_listing_page_couple()
// {
//     $current_user_id = get_current_user_id();
//     if (WeddingDir_Config::is_couple()) {
//         if (is_user_plan_valid_couple($current_user_id)) {
//             return false;
//         }
//         return true;
//     }
// }
// function is_user_plan_valid_couple($user_id)
// {
//     $plan_name = get_user_meta($user_id, 'plan_name', true);
//     $plan_end_date = get_user_meta($user_id, 'plan_end_date', true);
//     $plan_status = get_user_meta($user_id, 'plan_status', true);

//     if ($plan_status === 'Active' && $plan_end_date > time()) {
//         return true;
//     }

//     return false;
// }
// if (!session_id()) {
//     session_start();
// }
// function is_my_listing_page_couple()
// {
//     $current_user_id = get_current_user_id();
//     if (WeddingDir_Config::is_couple() && isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'couple-wishlist') !== false) {
//         if (is_user_plan_valid_couple($current_user_id)) {
//             return false;
//         }
//         return true;
//     }
// }
function is_my_listing_page_couple()
{
    $current_user_id = get_current_user_id();

    // Check if the user is a couple and if the URL contains either 'couple-wishlist' or 'listing-category'
    if (WeddingDir_Config::is_couple() && isset($_SERVER['REQUEST_URI'])) {
        $current_url = $_SERVER['REQUEST_URI'];

        // If the URL contains 'couple-wishlist' or 'listing-category', restrict access
        if ((strpos($current_url, 'couple-wishlist') !== false || strpos($current_url, 'listing-category') !== false)) {
            // Check if the user has a valid plan for couples
            if (is_user_plan_valid_couple($current_user_id)) {
                return false; // Allow access if the user's plan is valid
            }
            return true; // Restrict access if the user's plan is not valid
        }
    }

    return false; // By default, allow access if none of the conditions are met
}
function is_user_plan_valid_couple($user_id)
{
    $plan_name = get_user_meta($user_id, 'plan_name', true);
    $plan_end_date = get_user_meta($user_id, 'plan_end_date', true);
    $plan_status = get_user_meta($user_id, 'plan_status', true);

    if ($plan_status === 'Active' && $plan_end_date > time()) {
        return true;
    }

    return false;
}
if (!session_id()) {
    session_start();
}
if (is_my_listing_page_couple()) {
    $url = apply_filters('weddingdir/couple-menu/page-link', esc_attr('couple-dashboard'));
    // unset($_SESSION['subscription_couple_error']);
    // print_r($_SESSION['subscription_couple_error']);
    // exit;
    wp_redirect($url);
    exit;
}
/**2024-08-02 */
function subscription_ending_soon()
{
    $current_time = time();
    $one_day_in_seconds = 86400;
    $users = get_users([
        'meta_key' => 'stripe_customer_id',
        'meta_compare' => 'EXISTS'
    ]);

    foreach ($users as $user) {
        $user_data = get_userdata($user->ID);
        $user_roles = $user_data->roles;
        $plan_end_date = get_user_meta($user->ID, 'plan_end_date', true);
        $plan_name = get_user_meta($user->ID, 'plan_name', true);
        $send_mail = get_user_meta($user->ID, 'send_mail', true);
        $plan_id = get_user_meta($user->ID, 'plan_id', true);
// update_user_meta($user->ID, 'send_mail', '');
        if ($plan_end_date) {
            $plan_end_timestamp = (int)$plan_end_date;
            $time_until_end = $plan_end_timestamp - $current_time;

            if ($time_until_end <= $one_day_in_seconds && $time_until_end > 0 && $send_mail !== 'success') {
                $username = $user->user_login;
                $user_email = $user->user_email;

                if (in_array('vendor', $user_roles, true)) {
                    $_EMAIL_ARGS = [
                        'vendor_username' => $username,
                        'plan_name' => $plan_name,
                        'date' => date('F j, Y', $plan_end_timestamp),
                    ];
                    $checkRecurring = get_plan_name('recurring', $plan_id);
                    if ($checkRecurring !== 'yes') {
                        WeddingDir_Email::sending_email([
                            'setting_id'   => esc_attr('vendor-subscription-end'),
                            'sender_email' => sanitize_email($user_email),
                            'email_data'   => $_EMAIL_ARGS,
                        ]);
                    } else {
                        WeddingDir_Email::sending_email([
                            'setting_id'   => esc_attr('vendor-subscription-end-recurring'),
                            'sender_email' => sanitize_email($user_email),
                            'email_data'   => $_EMAIL_ARGS,
                        ]);
                    }
                } else {
                    $_EMAIL_ARGS = [
                        'couple_username' => $username,
                        'plan_name' => $plan_name,
                        'date' => date('F j, Y', $plan_end_timestamp),
                    ];
                    $checkRecurring = get_plan_name('recurring', $plan_id);
                    if ($checkRecurring !== 'yes') {
                        WeddingDir_Email::sending_email([
                            'setting_id'   => esc_attr('couple-plan-expiry'),
                            'sender_email' => sanitize_email($user_email),
                            'email_data'   => $_EMAIL_ARGS,
                        ]);
                    } else {
                        WeddingDir_Email::sending_email([
                            'setting_id'   => esc_attr('couple-subscription-end-recurring'),
                            'sender_email' => sanitize_email($user_email),
                            'email_data'   => $_EMAIL_ARGS,
                        ]);
                    }
                }
                update_user_meta($user->ID, 'send_mail', 'success');
            }
        }
    }
}
add_action('subscription_ending_soon', 'subscription_ending_soon');

function subscription_expired()
{
    $current_time = time();
    $users = get_users([
        'meta_key' => 'stripe_customer_id',
        'meta_compare' => 'EXISTS'
    ]);

    foreach ($users as $user) {
        $user_data = get_userdata($user->ID);
        $user_roles = $user_data->roles;
        $plan_end_date = get_user_meta($user->ID, 'plan_end_date', true);
        $planName = get_user_meta($user->ID, 'plan_name', true);
        if ($plan_end_date) {
            $plan_end_timestamp = (int)$plan_end_date;
            if ($plan_end_timestamp < $current_time) {
                $username = $user->user_login;
                $user_email = $user->user_email;
                
                if (in_array('vendor', $user_roles, true)) {
                    $_EMAIL_ARGS = [
                        'vendor_username' => $username,
                        'date' => date('F j, Y', $plan_end_timestamp),
                        'plan_name' => $planName,
                    ];
                    WeddingDir_Email::sending_email([
                        'setting_id'   => esc_attr('vendor-plan-already-expire'),
                        'sender_email' => sanitize_email($user_email),
                        'email_data'   => $_EMAIL_ARGS,
                    ]);
                } else {
                    $_EMAIL_ARGS = [
                        'couple_username' => $username,
                        'plan_name' => $planName,
                        'date' => date('F j, Y', $plan_end_timestamp)
                    ];
                    WeddingDir_Email::sending_email([
                        'setting_id'   => esc_attr('couple-plan-already-expire'),
                        'sender_email' => sanitize_email($user_email),
                        'email_data'   => $_EMAIL_ARGS,
                    ]);
                }
            }
        }
    }
}
add_action('subscription_expired_check', 'subscription_expired');

function subscription_ending_soon_time_update()
{
    $users = get_users([
        'meta_key' => 'stripe_customer_id',
        'meta_compare' => 'EXISTS'
    ]);

    foreach ($users as $user) {
        update_user_meta($user->ID, 'send_mail', '');
    }
}
add_action('subscription_ending_soon_time_update', 'subscription_ending_soon_time_update');

add_action('acf/save_post', 'create_stripe_tax_rate', 20);

function create_stripe_tax_rate($post_id) {
    if ($post_id !== 'options') {
        return;
    }
    $tax_percentage = get_field('vat', 'option');
    $tax_rate_id = get_field('stripe_tax_rate_id', 'option');
  if (!empty($tax_percentage)) {
        create_tax_rate_in_stripe($tax_percentage, $tax_rate_id);
    }
}

function create_tax_rate_in_stripe($tax_percentage, $tax_rate_id) {
    \Stripe\Stripe::setApiKey(get_option('cmp_stripe_secret_key', ''));

    // try {
    //     $existing_tax_rate = \Stripe\TaxRate::retrieve($tax_rate_id);
    //     return;
    // } catch (\Stripe\Exception\InvalidRequestException $e) {
       
    // }
    $tax_rate = \Stripe\TaxRate::create([
        'display_name' => 'VAT', 
        'percentage' => (float)$tax_percentage,
        'inclusive' => false,
    ]);

    update_field('stripe_tax_rate_id', $tax_rate->id, 'option');
}