<?php

/**
 *  -----------------------------------------------
 *  WeddingDir - Vendor Profile Tab Fields - Object
 *  -----------------------------------------------
 */
if (!class_exists('WeddingDir_Vendor_SubDetails') && class_exists('WeddingDir_Vendor_Profile_Database')) {


    /**
     *  -----------------------------------------------
     *  WeddingDir - Vendor Profile Tab Fields - Object
     *  -----------------------------------------------
     */
    class WeddingDir_Vendor_SubDetails extends WeddingDir_Vendor_Profile_Database
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
            add_filter('weddingdir/vendor-profile/tabs', function ($args = []) {

                return  array_merge($args, [

                    'subscription'        =>  [

                        'id'        =>  esc_attr(parent::_rand()),

                        'name'      =>  esc_attr__('Subscription', 'weddingdir'),

                        'callback'  =>  ['class' => __CLASS__, 'member' => 'tab_content'],


                    ]

                ]);
            }, absint('90'));
        }

        /**
         *.  Tab Content
         *   -----------
         */
        public static function tab_content()
        {
            $current_user_id = get_current_user_id();

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
            $changeUrl = apply_filters('weddingdir/vendor-menu/page-link', esc_attr('vendor-pricing'));
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
            print '<a href="' . esc_url($changeUrl) . '" class="btn btn-sm btn-primary btn-rounded">Upgrade Plan</a> ';

            // Corrected the cancel link
            print '<a href="' . esc_url(home_url('') . '?vendor_cancel_subscription="' . $subscription_id) . '" class="btn btn-sm btn-danger btn-rounded">Cancel Plan</a>';

            print '</div></div></div>';
        }
    }

    /**
     *  -----------------------------------------------
     *  WeddingDir - Vendor Profile Tab Fields - Object
     *  -----------------------------------------------
     */
    WeddingDir_Vendor_SubDetails::get_instance();
}
