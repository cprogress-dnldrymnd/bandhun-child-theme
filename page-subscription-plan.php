<?php
get_header();
if (!is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
}
if (!session_id()) {
    session_start();
}
$user = wp_get_current_user();
unset($_SESSION['subscription_couple_error']);
if (!in_array('couple', (array) $user->roles)) {
    wp_redirect(home_url());
    exit;
}
?>
<div class="main-container mt-2">
    <div class="container mt-4">
        <div class="section-title">
        </div>
        <div class="card-shadow">
            <?php
            $user_id = get_current_user_id();
            $plan_name = get_user_meta($user_id, 'plan_name', true);
            $plan_start_date = get_user_meta($user_id, 'plan_start_date', true);
            $plan_end_date = get_user_meta($user_id, 'plan_end_date', true);
            $plan_status = get_user_meta($user_id, 'plan_status', true);
            $badge = 'bg-danger';
            if ($plan_status == 'Active') {
                $badge = 'bg-success';
            }
            if ($plan_start_date && $plan_end_date) {
                $plan_start_date_formatted = date('Y-m-d', $plan_start_date);
                $plan_end_date_formatted = date('Y-m-d', $plan_end_date);
            ?>
                <?php if ($plan_name != '' && $plan_end_date != '') : ?>
                    <div class="card-shadow-body">

                        <div class="row align-items-center">
                            <div class="mb-0 col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <div class="pricing-plan">
                                    <span class="sub-head">Plan Name</span>
                                    <h3><?php echo esc_html($plan_name); ?></h3>
                                </div>
                            </div>

                            <div class="mb-0 col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                <div class="pricing-plan">
                                    <span class="sub-head">Plan Started</span>
                                    <h3><?php echo esc_html($plan_start_date_formatted); ?></h3>
                                </div>
                            </div>

                            <div class="mb-0 col-xl-4 col-lg-4 col-sm-6">
                                <div class="pricing-plan">
                                    <span class="sub-head">Plan Expires</span>
                                    <h3 class="txt-danger"><?php echo esc_html($plan_end_date_formatted); ?></h3>
                                </div>
                            </div>

                            <div class="mb-0 col-xl-1 col-lg-4 col-sm-6 mx-auto">
                                <div class="pricing-plan p-0 text-xl-right text-md-left pl-md-3 text-center">
                                    <div class="badge <?php echo esc_attr($badge); ?>">&nbsp;</div> <small><?php echo esc_html($plan_status); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php
            }
            ?>
        </div>
        <div class="row my-5">
            <?php
            if (function_exists('get_all_stripe_plans_couple_or_vendor')) {
                $stripe_plans = get_all_stripe_plans_couple_or_vendor('couple');
                foreach ($stripe_plans as $plan) {
                    $plan_amount = number_format((float) $plan['amount'], 2);
                    $plan_currency = strtoupper($plan['currency']);
                    $plan_description = !empty($plan['description']) ? esc_html($plan['description']) : 'No description available'; // Default text if description is empty
                    $plan_interval = esc_html($plan['plan_interval']);
                    $interval_count = esc_html($plan['interval_count']);
            ?>
                    <div class="col-lg-6 col-md-6 col-xl-4">
                        <div class="pricing-table-wrap">
                            <h3><?php echo esc_html($plan['name']); ?></h3>
                            <div class="plan-price"><sup>£</sup><?php echo esc_html($plan_amount); ?></div>
                            <ul class="list-unstyled">
                                <li>Validity: <?php echo $interval_count . ' ' . $plan_interval . (intval($interval_count) > 1 ? 's' : ''); ?></li> <!-- Use plan_interval and interval_count here -->
                            </ul>
                            <p class="plan-description"><?php echo $plan_description; ?></p>
                            <div class="pricing-buttons">
                                <button id="checkout-button" class="checkout-button btn btn-default btn-rounded mb-2" data-type="couple" data-price-id="<?php echo esc_attr($plan['price_id']); ?>">Choose Plan</button>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p>No plans available at the moment.</p>';
            }
            ?>
        </div>


    </div>
</div>
<?php

get_footer();
?>