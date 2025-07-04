<?php

/**
 *  WeddingDir Vendor My Profile AJAX Script Action HERE
 *  ----------------------------------------------------
 */
if (!class_exists('WeddingDir_Vendor_Profile_AJAX_Pricing') && class_exists('WeddingDir_Vendor_Profile_Database')) {

    /**
     *  WeddingDir Vendor My Profile AJAX Script Action HERE
     *  ----------------------------------------------------
     */
    class WeddingDir_Vendor_Profile_AJAX_Pricing extends WeddingDir_Vendor_Profile_Database
    {

        /**
         *  Member Variable
         *  ---------------
         */
        private static $instance;

        /**
         *  Initiator
         *  ---------
         */
        public static function get_instance()
        {

            if (!isset(self::$instance)) {

                self::$instance = new self;
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
             *  1. Have AJAX action ?
             *  ---------------------
             */
            if (wp_doing_ajax()) {

                /**
                 *  Have AJAX action ?
                 *  ------------------
                 */
                if (isset($_POST['action']) && $_POST['action'] !== '') {

                    /**
                     *  Have AJAX action ?
                     *  ------------------
                     */
                    $action     =   esc_attr(trim($_POST['action']));

                    /**
                     *  1.  Bit of security
                     *  -------------------
                     */
                    $allowed_actions    =   array(

                        /**
                         *  1. Vendor Profile Update
                         *  ------------------------
                         */
                        esc_attr('weddingdir_vendor_pricing_offers_action'),
                    );

                    /**
                     *  If have action then load this object members
                     *  --------------------------------------------
                     */
                    if (in_array($action, $allowed_actions)) {

                        /**
                         *  Check the AJAX action with login user
                         *  -------------------------------------
                         */
                        if (is_user_logged_in()) {

                            /**
                             *  1. If user already login then AJAX action
                             *  -----------------------------------------
                             */
                            add_action('wp_ajax_' . $action, [$this, $action]);
                        } else {

                            /**
                             *  2. If user not login that mean is front end AJAX action
                             *  -------------------------------------------------------
                             */
                            add_action('wp_ajax_nopriv_' . $action, [$this, $action]);
                        }
                    }
                }
            }
        }

        /**
         *  If Found security issue
         *  -----------------------
         */
        public static function security_issue_found()
        {

            die(json_encode(array(

                'message'   => esc_attr__('Security issue!', 'weddingdir'),

                'notice'    => absint('2')

            )));
        }

        /**
         *  1. Vendor Profile Update
         *  ------------------------
         */
        public static function weddingdir_vendor_pricing_offers_action()
        {

            $_condition_1   = isset($_POST['security']) && $_POST['security'] !== '';

            $_condition_2   = wp_verify_nonce($_POST['security'], esc_attr('vendor_pricing_offers'));

            /**
             *  Security Check
             *  --------------
             */
            if ($_condition_1 && $_condition_2) {

                /**
                 *  Form Data
                 *  ---------
                 */
                $_FORM_DATA   = array(

                    'price_range_min'    =>  absint($_POST['price_range_min']),

                    'price_range_max'     =>  absint($_POST['price_range_max']),

                    'price_per_hour'  =>  absint($_POST['price_per_hour']),

                    'special_offer'  =>  absint($_POST['special_offer']),
                );

                /**
                 *  Have Data ?
                 *  -----------
                 */
                if (parent::_is_array($_FORM_DATA)) {

                    foreach ($_FORM_DATA as $key => $value) {

                        /**
                         *  Update Key + Value
                         *  ------------------
                         */
                        update_post_meta(absint(parent::post_id()), sanitize_key($key), $value);
                    }

                    /**
                     *  Successfully Updated Profile
                     *  ----------------------------
                     */
                    die(json_encode(array(

                        'notice'    =>  absint('1'),

                        'message'   =>  esc_attr__('Pricing Updated Successfully', 'weddingdir'),

                    )));
                }
            } else {

                die(json_encode(array(

                    'notice'    =>  absint('2'),

                    'message'   =>  esc_attr__('Profile Updated Error... Please login again then update your profile.', 'weddingdir')

                )));
            }
        }
    } /* class end **/

    /**
     *  Kicking this off by calling 'get_instance()' method
     *  ---------------------------------------------------
     */
    WeddingDir_Vendor_Profile_AJAX_Pricing::get_instance();
}
