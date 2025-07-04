<?php
get_header();
?><div class="main-container mt-2">
    <div class="container mt-4">
        <div class="row my-5">
            <div class="m-md-100 m-75 m-auto">
                <div class="">
                    <div class="p-2">
                        <div class="row justify-content-around gap-2">
                            <h1 class="col col- directory-pkg">Directory package</h1>
                            <?php

                            if (function_exists('get_all_stripe_plans_couple_or_vendor')) {
                                $stripe_plans = get_all_stripe_plans_couple_or_vendor('vendor');
                                $testArray = array();
                                foreach ($stripe_plans as $key => $plan) {
                                    $user_id = get_current_user_id();
                                    $planId = $plan['plan_id'];
                                    $currentUserPlanId = get_user_meta($user_id, 'plan_id', true);
                                    $plan_end_date = get_user_meta($user_id, 'plan_end_date', true);
                                    $plan_status = get_user_meta($user_id, 'plan_status', true);
                                    $class = "";
                                    $button_name = "Subscribe";
                                    if ($plan_status === 'Active' && strtotime($plan_end_date) < time()) {
                                        $button_name = "Change Plan";
                                    }
                                    if ($planId === $currentUserPlanId) {
                                        $isPlanMatch = ($currentUserPlanId === $planId);

                                        $isConditionTrue = ($plan_status === 'Active' && strtotime($plan_end_date) > time() && $isPlanMatch);
                                        $class = $isConditionTrue ? 'd-block' : 'd-none';
                                    }
                                    $plan_amount = number_format((float) $plan['amount'], 2);
                                    $plan_currency = strtoupper($plan['currency']);
                                    $plan_description = !empty($plan['description']) ? esc_html($plan['description']) : 'No description available'; // Default text if description is empty
                                    $plan_interval = esc_html($plan['plan_interval']);
                                    $interval_count = esc_html($plan['interval_count']);
                                    $video = esc_html($plan['how_many_videos']);
                                    $photos = esc_html($plan['how_many_photos']);
                                    if ($plan['add_sponsors_facility'] != 'yes') {
                                        $selected_services = explode(',', $plan['services']);
                                        $testArray[] = array(
                                            'id' => $plan['id'],
                                            'services' => $selected_services,
                                            'price_id' => $plan['price_id'],
                                             'number_of_listing' => $plan['number_of_listing'],
                                             'class' => $class,
                                            'button_name' => $button_name,
                                        );

                            ?>
                                        <div class="col py-2 border rounded <?php if ($key == 1) {
                                                                                echo 'border-pink bg-pink';
                                                                            } ?> <?php echo $class; ?>">
                                            <div class="d-flex flex-column align-items-center gap-2">
                                                <h3 class="
                                                <?php if($key != 1){echo 'text-danger';}?> pkg-name <?php if ($key == 1) {
                                                                                    echo 'text-white';
                                                                                } ?>"><?php echo esc_html($plan['name']); ?></h3>
                                                <div class="d-flex flex-column">
                                                    <span class="text-center h4 mb-0 <?php if ($key == 1) {
                                                                                            echo 'text-white';
                                                                                        } ?>">£<?php echo  $plan_amount; ?></span>
                                                    <small class="text-center  <?php if ($key == 1) {
                                                                                    echo 'text-white';
                                                                                } else {
                                                                                    echo 'text-muted';
                                                                                } ?>">/<?php echo $plan_interval; ?></small>
                                                </div>
                                            </div>
                                        </div>
                            <?php
                                    }
                                }
                            } else {
                                echo '<p>No plans available at the moment.</p>';
                            }
                            ?>
                            <!-- <div class="col py-2 border rounded border-pink bg-pink">
                                <div class="d-flex flex-column align-items-center gap-2">
                                    <h3 class="text-white pkg-name">Platinum</h3>
                                    <div class="d-flex flex-column text-white">
                                        <span class="text-center h4 mb-0">£197</span>
                                        <small class="text-center text-white">/year</small>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <?php foreach ($testArray as $service) {
                            // echo "<pre>";
                            // print_r($service);
                        ?>

                        <?php } ?>
                        <?php
                        $available_services = array(
                            'business_name' => 'Business Name',
                            'logo' => 'Logo',
                            'location' => 'Location',
                            'photos' => 'Photos',
                            'videos' => 'Videos',
                            'number_of_listings' => 'Number of Listings',
                            'wedding_builder_enrolment' => 'Wedding Builder Enrolment',
                            
                        );
                        ?>
                        <?php
                        foreach ($available_services as $key => $value) { ?>
                            <div class="row justify-content-around gap-2 mt-2">
                                <div class="col rounded p-3 fw-semibold bg-grey"><?php echo $value; ?></div>
                                <?php

                               foreach ($testArray as $test): ?>
                                    <div class="col rounded text-center p-3 bg-grey <?php echo $test['class']; ?>">
                                        <?php
                                        if ($value == 'Number of Listings') {
                                            echo (!empty($test['number_of_listing'])) ? '<span>' . $test['number_of_listing'] . '</span>' : svgFalse();
                                        } else {
                                            echo is_service_available($key, $test) ? svgTrue() : svgFalse();
                                        }
                                        ?>
                                    </div>
                                <?php endforeach; ?>
                                <!-- <div class="col rounded text-center p-3 bg-grey">
                                 
                                </div> -->
                            </div>
                        <?php
                        } ?>
                        <div class="row justify-content-around gap-2 flex-nowrap mt-2">

                            <div class="col p-3"></div>
                            <?php
                            foreach ($testArray as $key => $test): ?>
                                <?php if ($key == 0) : ?>
                                    <div class="col rounded text-center border p-md-3 py-3 <?php echo $test['class']; ?>">
                                        <button id="checkout-button" class="checkout-button rounded-pill py-1 py-md-2 px-2 px-md-4 border-1 fw-semibold border-pink text-pink bg-white" data-type="vendor" data-price-id="<?php echo esc_attr($test['price_id']); ?>"><?php echo $test['button_name']; ?></button>
                                    </div>
                                <?php else : ?>
                                    <div class="col rounded text-center p-md-3 py-3 bg-pink <?php echo $test['class']; ?>">
                                        <button id="checkout-button" class="checkout-button rounded-pill py-1 py-md-2 px-2 px-md-4 border-1 fw-semibold bg-white border-pink text-pink" data-type="vendor" data-price-id="<?php echo esc_attr($test['price_id']); ?>"><?php echo $test['button_name']; ?></button>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <hr class="my-4 bg-grey border">
                <?php
                if (function_exists('get_all_stripe_plans_couple_or_vendor_new')) {
                    $stripe_plans = get_all_stripe_plans_couple_or_vendor_new('vendor', 'yes');
                    foreach ($stripe_plans as $plan) {
                         $user_id = get_current_user_id();
                                    get_user_meta($user_id, 'is_sponsor', true);
                                    get_user_meta($user_id, 'is_sponsor_plan_id', true);
                                    get_user_meta($user_id, 'is_sponsor_plan_name', true);
                                    get_user_meta($user_id, 'is_sponsor_price_id', true);
                                    $plan_status = get_user_meta($user_id, 'is_sponsor_plan_status', 'Active');
                                    
                                    get_user_meta($user_id, 'is_sponsor_subscription_id', true);
                                    get_user_meta($user_id, 'is_sponsor_plan_start_date', true);
                                    $plan_end_date = get_user_meta($user_id, 'is_sponsor_plan_end_date', true);
                                    $isConditionTrue = ($plan_status === 'Active' && strtotime($plan_end_date) > time());
                                   $display_class = $isConditionTrue ? 'display:none;' : 'display:block;';
                        $plan_amount = number_format((float) $plan['amount'], 2);
                        $plan_currency = strtoupper($plan['currency']);
                        $plan_description = !empty($plan['description']) ? esc_html($plan['description']) : 'No description available'; // Default text if description is empty
                        $plan_interval = esc_html($plan['plan_interval']);
                        $interval_count = esc_html($plan['interval_count']);

                ?>
                        <div class="Sponsored Listing-section" style="<?php echo $display_class; ?>">
                            <div class="heading">
                                <h1><?php echo esc_html($plan['name']); ?></h1>
                            </div>

                            <div class="detail">
                                <div class="details">
                                    <h6><?php echo $plan_description; ?></h6>
                                    <h3>£10 <span class="month"> /<?php echo $plan_interval; ?></span></h3>
                                </div>
                                <div class="button">
                                    <button id="checkout-button" class="checkout-button rounded-pill py-1 py-md-2 px-2 px-md-4 border-1 fw-semibold border-pink text-pink bg-white" data-type="vendor" data-price-id="<?php echo esc_attr($plan['price_id']); ?>">Subscribe</button>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } ?>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
