<?php

/**
 *  -----------------------------------------------
 *  WeddingDir - Couple Profile Tab Fields - Object
 *  -----------------------------------------------
 */
if (!class_exists('WeddingDir_Couple_Transaction_Couple_Tab') && class_exists('WeddingDir_Couple_Profile_Database')) {

    /**
     *  -----------------------------------------------
     *  WeddingDir - Couple Profile Tab Fields - Object
     *  -----------------------------------------------
     */
    class WeddingDir_Couple_Transaction_Couple_Tab extends WeddingDir_Couple_Profile_Database
    {

        /**
         *  A reference to an instance of this class
         *  ----------------------------------------
         */
        private static $instance;

        /**
         *  Returns an instance of this class.
         *  ----------------------------------
         */
        public static function get_instance()
        {

            if (null == self::$instance) {

                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         *  Construct
         *  ---------
         */
        public function __construct()
        {

            /**
             *  Add Filter
             *  ----------
             */
            add_filter('weddingdir/couple-profile/tabs', function ($args = []) {

                return  array_merge($args, [

                    'subscription'   =>  [

                        'id'        =>  esc_attr(parent::_rand()),

                        'name'      =>  esc_attr__('Subscription', 'weddingdir'),

                        'callback'  =>  ['class' => __CLASS__, 'member' => 'tab_content'],

                        // 'create_form'      =>  [

                        //     'form_before'   =>  '',

                        //     'form_after'    =>  '',

                        //     'form_id'       =>  esc_attr('weddingdir_couple_social_notification'),

                        //     'form_class'    =>  '',

                        //     'button_before' =>  '',

                        //     'button_after'  =>  '',

                        //     'button_id'     =>  esc_attr('couple_social_media_submit'),

                        //     'button_class'  =>  '',

                        //     'button_name'   =>  esc_attr__('Update Social Profile', 'weddingdir'),

                        //     'security'      =>  esc_attr('social_media_update'),
                        // ]
                    ]

                ]);
            }, absint('40'));
        }

        /**
         *  Social Media
         *  ------------
         */
         public static function tab_content()
        {
            $current_user_id = get_current_user_id();
           $dashboardUrl = apply_filters('weddingdir/couple-menu/page-link', esc_attr('couple-dashboard'));
            print '<div class="card-shadow-body">';
            print '<div>';
            $current_user = wp_get_current_user();

            // Get user details
            $user_id = $current_user->ID;
            $user_pan = get_user_meta($user_id, 'plan_name', true);
            $subscription_id = get_user_meta($user_id, 'subscription_id', true);
            $user_start_date = get_user_meta($user_id, 'plan_start_date', true);
            $user_end_date = get_user_meta($user_id, 'plan_end_date', true);
            $status = get_user_meta($user_id, 'plan_status', true);

            $badge = 'btn-danger';
            if ($status == 'Active') {
                $badge = 'btn-success';
            }
            $userStartDate = !empty($user_start_date) ? date('Y-m-d', $user_start_date) : '';
            $userEndDate = !empty($user_end_date) ?  date('Y-m-d', $user_end_date) : '';
            if ($user_pan == '' && $userStartDate) {
                print '<p class="fw-bold">No subscription plan found.</p>';
                print '<a href="' . esc_url(home_url('/subscription-plan')) . '" class="btn btn-sm btn-primary btn-rounded">Subscription Plan</a> ';
                print '</div>';
                print '</div>';

                return;
            }
            print '<div class="card-shadow-body row">';
            print '<p class="col-12 col-md-6 col-xl-3 fw-bold">Plan Name: ' . esc_html($user_pan) . '</p>';
            print '<p class="col-12 col-md-6 col-xl-3 fw-bold">Plan Status: <span class="badge ' . $badge . '">' . $status . '</span></p>';
            print '<p class="col-12 col-md-6 col-xl-3 fw-bold">Start Date: ' . esc_html($userStartDate) . '</p>';
            print '<p class="col-12 col-md-6 col-xl-3 fw-bold">Expiry Date: ' . esc_html($userEndDate) . '</p>';
            print '</div>';
            print '</div>';
            print '<div class="card-body border-top"><div class="row"><div class="col-md-12">';
            print '<a href="' . $dashboardUrl . '" class="btn btn-sm btn-primary btn-rounded">Upgrade Plan</a> ';

            // Corrected the cancel link
            //  $plan_id = esc_attr($plan['price_id']); // Make sure $plan['price_id'] is available in this scope
            if(!empty($subscription_id)) {
            print '<a href="javascript:void(0);" class="btn btn-sm btn-danger btn-rounded" id="cancel-btn" data-url="' . esc_url(home_url('/subscription-cancel?cancel_subscription=' . $subscription_id)) . '">Cancel Plan</a>';

            }

            print '</div></div></div>';
        }
    }

    /**
     *  -----------------------------------------------
     *  WeddingDir - Couple Profile Tab Fields - Object
     *  -----------------------------------------------
     */
    WeddingDir_Couple_Transaction_Couple_Tab::get_instance();
}
