

<?php

/**
 *  -------------------------------------
 *  OptionTree ( Theme Option Framework )
 *  -------------------------------------
 *  @author : By - Derek Herman
 *  ---------------------------
 *  @link - https://wordpress.org/plugins/option-tree/
 *  --------------------------------------------------
 *  Fields : https://github.com/valendesigns/option-tree-theme/blob/master/inc/theme-options.php
 *  --------------------------------------------------------------------------------------------
 *  WeddingDir - Framework - Section - Email Section
 *  ------------------------------------------------
 */
if (!class_exists('WeddingDir_FrameWork_My_Email_Setting') && class_exists('WeddingDir_FrameWork')) {

    /**
     *  WeddingDir - Framework - Section - Email Section
     *  ------------------------------------------------
     */
    class WeddingDir_FrameWork_My_Email_Setting extends WeddingDir_FrameWork
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
        /**
         *  Initiator
         *  ---------
         */
        public static function get_instance()
        {

            if (!isset(self::$instance)) {

                self::$instance = new self;
            }

            return  self::$instance;
        }


        /**
         *  Construct
         *  ---------
         */
        public function __construct()
        {



            /**
             *  1. Vendor Pending Approval
             *  ---------------------------------------
             */
            add_filter(

                sprintf('weddingdir_framework_{%1$s}_settings', 'weddingdir_vendor_email_section'),

                [$this, 'approval_email_vendor'],

                absint('20'),

                absint('8')
            );

            add_filter(

                sprintf('weddingdir_framework_{%1$s}_settings', 'weddingdir_vendor_email_section'),

                [$this, 'pending_approval_email_admin'],

                absint('20'),

                absint('9')
            );

            add_filter(

                sprintf('weddingdir_framework_{%1$s}_settings', 'weddingdir_vendor_email_section'),

                [$this, 'pending_approval_email_vendor'],

                absint('20'),

                absint('10')
            );
            
            add_filter(

                sprintf('weddingdir_framework_{%1$s}_settings', 'weddingdir_vendor_email_section'),

                [$this, 'vendor_subscription_end'],

                absint('20'),

                absint('10')
            );

            add_filter(

                sprintf('weddingdir_framework_{%1$s}_settings', 'weddingdir_couple_email_section'),

                [$this, 'couple_plan_expiry'],

                absint('11'),

                absint('2')
            );
            
            add_filter(

                sprintf('weddingdir_framework_{%1$s}_settings', 'weddingdir_couple_email_section'),

                [$this, 'couple_plan_already_expire'],

                absint('11'),

                absint('3')
            );

            add_filter(

                sprintf('weddingdir_framework_{%1$s}_settings', 'weddingdir_vendor_email_section'),

                [$this, 'vendor_plan_already_expire'],

                absint('20'),

                absint('12')
            );
             add_filter(

                sprintf('weddingdir_framework_{%1$s}_settings', 'weddingdir_vendor_email_section'),

                [$this, 'vendor_plan_renew_soon'],

                absint('20'),

                absint('13')
            );
            add_filter(

                sprintf('weddingdir_framework_{%1$s}_settings', 'weddingdir_vendor_email_section'),
                [$this, 'vendor_addon'],

                absint('20'),

                absint('13')
            );
            add_filter(

                sprintf('weddingdir_framework_{%1$s}_settings', 'weddingdir_couple_email_section'),

                [$this, 'couple_plan_renew_soon'],

                absint('11'),

                absint('4')
            );
            
            add_filter(

                sprintf('weddingdir_framework_{%1$s}_settings', 'weddingdir_couple_email_section'),

                [$this, 'review_mail'],

                absint('11'),

                absint('5')
            );
            add_filter(

                sprintf('weddingdir_framework_{%1$s}_settings', 'weddingdir_couple_email_section'),

                [$this, 'add_review'],

                absint('11'),

                absint('7')
            );
             add_filter(

                sprintf('weddingdir_framework_{%1$s}_settings', 'weddingdir_couple_email_section'),

                [$this, 'subscription'],

                absint('11'),

                absint('8')
            );
            add_filter(

                sprintf('weddingdir_framework_{%1$s}_settings', 'weddingdir_couple_email_section'),

                [$this, 'approve_review'],

                absint('11'),

                absint('9')
            );
        }



        /**
         *  1. Vendor Email Approval
         *  ---------------------------------------
         */
        public static function approval_email_vendor($have_setting = [], $have_section = '')
        {

            $email_title    =   esc_attr('approval-email-vendor');

            $add_setting    =   array(

                array(

                    'id'          => esc_attr('email-tab-' . $email_title),

                    'label'       => esc_attr__('Approval Email Vendor', 'weddingdir'),

                    'type'        => esc_attr('tab'),

                    'section'     => esc_attr($have_section)
                ),

                array(

                    'id'          =>  esc_attr('email-subject-' . $email_title),

                    'label'       =>  esc_attr__('Email Subject', 'weddingdir'),

                    'std'         =>  esc_attr__('Listing approved - {{title}}', 'weddingdir'),

                    'type'        =>  esc_attr('text'),

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('8'),
                ),

                array(

                    'id'          =>  esc_attr('email-body-' . $email_title),

                    'label'       =>  esc_attr__('Vendor Get Email Body Content', 'weddingdir'),

                    'type'        =>  esc_attr('textarea-simple'),

                    'std'         =>  '<p>Hello {{vendor_username}},</p><p>Your listing {{title}}</p><p>is now posted. View listing here</p><p><a href={{link}}>here</a></p><p>Thank you</p>',

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('6'),
                ),
            );

            /**
             *  Merge Admin Email Setting
             *  -------------------------
             */
            return      array_merge(

                $have_setting,

                // array_merge(

                    $add_setting,

                //     parent::weddingdir_setting_option_admin_emails($email_title, $have_section),
                // )
            );
        }
        
        public static function pending_approval_email_admin($have_setting = [], $have_section = '')
        {

            $email_title    =   esc_attr('pending-approval-admin');

            $add_setting    =   array(

                array(

                    'id'          => esc_attr('email-tab-' . $email_title),

                    'label'       => esc_attr__('Pending Approval Admin', 'weddingdir'),

                    'type'        => esc_attr('tab'),

                    'section'     => esc_attr($have_section)
                ),

                array(

                    'id'          =>  esc_attr('email-subject-' . $email_title),

                    'label'       =>  esc_attr__('Email Subject', 'weddingdir'),

                    'std'         =>  esc_attr__('New listing from {{vendor_username}}', 'weddingdir'),

                    'type'        =>  esc_attr('text'),

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('8'),
                ),

                array(

                    'id'          =>  esc_attr('email-body-' . $email_title),

                    'label'       =>  esc_attr__('Admin Email Body Content', 'weddingdir'),

                    'type'        =>  esc_attr('textarea-simple'),

                    'std'         =>  '<p>Hello {{vendor_username}},</p><p>New listing from {{vendor_username}}</p><p>pending approval. Approved</p><p><a href={{permalink_admin}}>here</a></p><p>Thank you</p>',

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('6'),
                ),
            );

            /**
             *  Merge Admin Email Setting
             *  -------------------------
             */
             return      array_merge(

                $have_setting,

                array_merge(

                    $add_setting,

                    parent::weddingdir_setting_option_admin_emails($email_title, $have_section),
                )
            );
        }
        public static function pending_approval_email_vendor($have_setting = [], $have_section = '')
        {

            $email_title    =   esc_attr('pending-approval-vendor');

            $add_setting    =   array(

                array(

                    'id'          => esc_attr('email-tab-' . $email_title),

                    'label'       => esc_attr__('Pending Approval Vendor', 'weddingdir'),

                    'type'        => esc_attr('tab'),

                    'section'     => esc_attr($have_section)
                ),

                array(

                    'id'          =>  esc_attr('email-subject-' . $email_title),

                    'label'       =>  esc_attr__('Email Subject', 'weddingdir'),

                    'std'         =>  esc_attr__('You have submitted a new listing', 'weddingdir'),

                    'type'        =>  esc_attr('text'),

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('8'),
                ),

                array(

                    'id'          =>  esc_attr('email-body-' . $email_title),

                    'label'       =>  esc_attr__('Admin Email Body Content', 'weddingdir'),

                    'type'        =>  esc_attr('textarea-simple'),

                    'std'         =>  '<p>Hello {{vendor_username}},</p><p>Listing {{title}}</p><p>submitted and is awating approval.</p><p>Thank you</p>',

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('6'),
                ),
            );

            /**
             *  Merge Admin Email Setting
             *  -------------------------
             */
            return      array_merge(

                $have_setting,

                // array_merge(

                    $add_setting

                //     parent::weddingdir_setting_option_admin_emails($email_title, $have_section),
                // )
            );
        }
        
        public static function vendor_subscription_end($have_setting = [], $have_section = '')
        {

            $email_title    =   esc_attr('vendor-subscription-end');

            $add_setting    =   array(

                array(

                    'id'          => esc_attr('email-tab-' . $email_title),

                    'label'       => esc_attr__('Subscription is Expiring Soon', 'weddingdir'),

                    'type'        => esc_attr('tab'),

                    'section'     => esc_attr($have_section)
                ),

                array(

                    'id'          =>  esc_attr('email-subject-' . $email_title),

                    'label'       =>  esc_attr__('Email Subject', 'weddingdir'),

                    'std'         =>  esc_attr__('Your Subscription is Expiring Soon', 'weddingdir'),

                    'type'        =>  esc_attr('text'),

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('8'),
                ),

                array(

                    'id'          =>  esc_attr('email-body-' . $email_title),

                    'label'       =>  esc_attr__('Email Content', 'weddingdir'),

                    'type'        =>  esc_attr('textarea-simple'),

                    'std'         =>  '<p>Hello {{vendor_username}},</p><p>Your subscription {{plan_name}} will expire {{date}}. Please renew to maintain uninterrupted access to our services.</p><p>Thank you</p>',

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('6'),
                ),
            );

            /**
             *  Merge Admin Email Setting
             *  -------------------------
             */
            return      array_merge(

                $have_setting,

                // array_merge(

                $add_setting

                //     parent::weddingdir_setting_option_admin_emails($email_title, $have_section),
                // )
            );
        }

        public static function couple_plan_expiry($have_setting = [], $have_section = '')
        {

            $email_title    =   esc_attr('couple-plan-expiry');

            $add_setting    =   array(

                array(

                    'id'          => esc_attr('email-tab-' . $email_title),

                    'label'     =>  esc_attr__('Your Subscription is Expiring Soon', 'weddingdir'),

                    'type'      =>  esc_attr('tab'),

                    'section'   =>  esc_attr($have_section),
                ),

                array(

                    'id'          =>  esc_attr('email-subject-' . $email_title),

                    'label'     =>  esc_attr__('Email Subject', 'weddingdir'),

                      'std'         =>  esc_attr__('Your Subscription is Expiring Soon', 'weddingdir'),

                    'type'      =>  esc_attr('text'),

                    'section'   =>  esc_attr($have_section),
                ),

                array(

                    'id'          =>  esc_attr('email-body-' . $email_title),

                    'label'       =>  esc_attr__('Couple Get Email Body Content', 'weddingdir'),

                    'type'        =>  esc_attr('textarea-simple'),

                    'std'         =>  '<p>Hello {{couple_username}},</p><p>Your subscription {{plan_name}} will expire {{date}}. Please renew to maintain uninterrupted access to our services.</p><p>Thank you</p>',

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('4'),
                ),
            );

            /**
             *  Merge Admin Email Setting
             *  -------------------------
             */
            return      array_merge(

                $have_setting,

                array_merge(

                    $add_setting,

                    parent::weddingdir_setting_option_admin_emails($email_title, $have_section),
                )
            );
        }
        public static function couple_plan_already_expire($have_setting = [], $have_section = '')
        {

            $email_title    =   esc_attr('couple-plan-already-expire');

            $add_setting    =   array(

                array(

                    'id'          => esc_attr('email-tab-' . $email_title),

                    'label'     =>  esc_attr__('Your Subscription Plan Has Expired', 'weddingdir'),

                    'type'      =>  esc_attr('tab'),

                    'section'   =>  esc_attr($have_section),
                ),

                array(

                    'id'          =>  esc_attr('email-subject-' . $email_title),

                    'label'     =>  esc_attr__('Email Subject', 'weddingdir'),

                    'std'         =>  esc_attr__('Your Subscription Plan Has Expired', 'weddingdir'),

                    'type'      =>  esc_attr('text'),

                    'section'   =>  esc_attr($have_section),
                ),

                array(

                    'id'          =>  esc_attr('email-body-' . $email_title),

                    'label'       =>  esc_attr__('Couple Get Email Body Content', 'weddingdir'),

                    'type'        =>  esc_attr('textarea-simple'),

                    'std'         =>  '<p>Hello {{couple_username}},</p><p>We wanted to let you know that your subscription to {{plan_name}} has expired on {{date}}. Please renew to maintain uninterrupted access to our services.</p><p>Thank you</p>',

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('4'),
                ),
            );

            /**
             *  Merge Admin Email Setting
             *  -------------------------
             */
            return      array_merge(

                $have_setting,

                // array_merge(

                $add_setting,

                // parent::weddingdir_setting_option_admin_emails($email_title, $have_section),
                // )
            );
        }
        public static function vendor_plan_already_expire($have_setting = [], $have_section = '')
        {

            $email_title    =   esc_attr('vendor-plan-already-expire');

            $add_setting    =   array(

                array(

                    'id'          => esc_attr('email-tab-' . $email_title),

                    'label'       => esc_attr__('Your Subscription Plan Has Expired', 'weddingdir'),

                    'type'        => esc_attr('tab'),

                    'section'     => esc_attr($have_section)
                ),

                array(

                    'id'          =>  esc_attr('email-subject-' . $email_title),

                    'label'       =>  esc_attr__('Email Subject', 'weddingdir'),

                    'std'         =>  esc_attr__('Your Subscription Plan Has Expired', 'weddingdir'),

                    'type'        =>  esc_attr('text'),

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('8'),
                ),

                array(

                    'id'          =>  esc_attr('email-body-' . $email_title),

                    'label'       =>  esc_attr__('Email Content', 'weddingdir'),

                    'type'        =>  esc_attr('textarea-simple'),

                    'std'         =>  '<p>Hello {{vendor_username}},</p><p>We wanted to let you know that your subscription to {{plan_name}} has expired on {{date}}. Please renew to maintain uninterrupted access to our services.</p><p>Thank you</p>',

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('6'),
                ),
            );

            /**
             *  Merge Admin Email Setting
             *  -------------------------
             */
            return      array_merge(

                $have_setting,

                // array_merge(

                $add_setting

                //     parent::weddingdir_setting_option_admin_emails($email_title, $have_section),
                // )
            );
        }
         public static function vendor_plan_renew_soon($have_setting = [], $have_section = '')
        {

            $email_title    =   esc_attr('vendor-subscription-end-recurring');

            $add_setting    =   array(

                array(

                    'id'          => esc_attr('email-tab-' . $email_title),

                    'label'       => esc_attr__('Auto-Renew Soon', 'weddingdir'),

                    'type'        => esc_attr('tab'),

                    'section'     => esc_attr($have_section)
                ),

                array(

                    'id'          =>  esc_attr('email-subject-' . $email_title),

                    'label'       =>  esc_attr__('Email Subject', 'weddingdir'),

                    'std'         =>  esc_attr__('Your Subscription Will Auto-Renew Soon', 'weddingdir'),

                    'type'        =>  esc_attr('text'),

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('8'),
                ),

                array(

                    'id'          =>  esc_attr('email-body-' . $email_title),

                    'label'       =>  esc_attr__('Email Content', 'weddingdir'),

                    'type'        =>  esc_attr('textarea-simple'),

                    'std'         =>  "<p>Hello {{vendor_username}},</p><p>We hope you're enjoying your {{plan_name}} subscription! We wanted to remind you that your subscription is set to automatically renew on {{date}}.</p><p>Thank you</p>",

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('6'),
                ),
            );

            /**
             *  Merge Admin Email Setting
             *  -------------------------
             */
            return      array_merge(

                $have_setting,

                // array_merge(

                $add_setting

                //     parent::weddingdir_setting_option_admin_emails($email_title, $have_section),
                // )
            );
        }
        public static function couple_plan_renew_soon($have_setting = [], $have_section = '')
        {

            $email_title    =   esc_attr('couple-subscription-end-recurring');

            $add_setting    =   array(

                array(

                    'id'          => esc_attr('email-tab-' . $email_title),

                    'label'     =>  esc_attr__('Auto-Renew Soon', 'weddingdir'),

                    'type'      =>  esc_attr('tab'),

                    'section'   =>  esc_attr($have_section),
                ),

                array(

                    'id'          =>  esc_attr('email-subject-' . $email_title),

                    'label'     =>  esc_attr__('Email Subject', 'weddingdir'),

                    'std'         =>  esc_attr__('Your Subscription Will Auto-Renew Soon', 'weddingdir'),

                    'type'      =>  esc_attr('text'),

                    'section'   =>  esc_attr($have_section),
                ),

                array(

                    'id'          =>  esc_attr('email-body-' . $email_title),

                    'label'       =>  esc_attr__('Couple Get Email Body Content', 'weddingdir'),

                    'type'        =>  esc_attr('textarea-simple'),

                    'std'         =>  "<p>Hello {{couple_username}},</p><p>We hope you're enjoying your {{plan_name}} subscription! We wanted to remind you that your subscription is set to automatically renew on {{date}}.</p><p>Thank you</p>",

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('4'),
                ),
            );

            /**
             *  Merge Admin Email Setting
             *  -------------------------
             */
            return      array_merge(

                $have_setting,

                // array_merge(

                $add_setting,

                // parent::weddingdir_setting_option_admin_emails($email_title, $have_section),
                // )
            );
        }
        public static function vendor_addon($have_setting = [], $have_section = '')
        {

            $email_title    =   esc_attr('vendor-addon');

            $add_setting    =   array(

                array(

                    'id'          => esc_attr('email-tab-' . $email_title),

                    'label'       => esc_attr__('Vendor Addon', 'weddingdir'),

                    'type'        => esc_attr('tab'),

                    'section'     => esc_attr($have_section)
                ),

                array(

                    'id'          =>  esc_attr('email-subject-' . $email_title),

                    'label'       =>  esc_attr__('Email Subject', 'weddingdir'),

                    'std'         =>  esc_attr__('Purchase Your Additional Subscription', 'weddingdir'),

                    'type'        =>  esc_attr('text'),

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('8'),
                ),

                array(

                    'id'          =>  esc_attr('email-body-' . $email_title),

                    'label'       =>  esc_attr__('Email Content', 'weddingdir'),

                    'type'        =>  esc_attr('textarea-simple'),

                    'std'         =>  "<p>Hello {{vendor_username}},</p><p>Thank you for purchasing the {{ plan_name }} Add-On! Your listing has been upgraded to a featured status, enhancing its visibility.</p><p>Thank you</p>",

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('6'),
                ),
            );

            /**
             *  Merge Admin Email Setting
             *  -------------------------
             */
            return      array_merge(

                $have_setting,

                array_merge(

                    $add_setting,

                    parent::weddingdir_setting_option_admin_emails($email_title, $have_section),
                )
            );
        }
        public static function review_mail($have_setting = [], $have_section = '')
        {

            $email_title    =   esc_attr('new-review-admin');

            $add_setting    =   array(

                array(

                    'id'          => esc_attr('email-tab-' . $email_title),

                    'label'     =>  esc_attr__('Review Mail', 'weddingdir'),

                    'type'      =>  esc_attr('tab'),

                    'section'   =>  esc_attr($have_section),
                ),

                array(

                    'id'          =>  esc_attr('email-subject-' . $email_title),

                    'label'     =>  esc_attr__('Email Subject', 'weddingdir'),

                    'std'         =>  esc_attr__('New Review from {{couple_username}}', 'weddingdir'),

                    'type'      =>  esc_attr('text'),

                    'section'   =>  esc_attr($have_section),
                ),

                array(

                    'id'          =>  esc_attr('email-body-' . $email_title),

                    'label'       =>  esc_attr__('Couple Get Email Body Content', 'weddingdir'),

                    'type'        =>  esc_attr('textarea-simple'),

                    'std'         =>  "<p>Hello {{couple_username}},</p><p>A new review from {{couple_username}} has been submitted.</p><p>It is currently pending approval.</p><p><a href={{permalink_admin}}>here</a></p><p>Thank you</p>",

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('4'),
                ),
            );

            /**
             *  Merge Admin Email Setting
             *  -------------------------
             */
            return      array_merge(

                $have_setting,

                array_merge(

                    $add_setting,

                    parent::weddingdir_setting_option_admin_emails($email_title, $have_section),
                )
            );
        }
        public static function add_review($have_setting = [], $have_section = '')
        {

            $email_title    =   esc_attr('new-review');

            $add_setting    =   array(

                array(

                    'id'          => esc_attr('email-tab-' . $email_title),

                    'label'     =>  esc_attr__('Review Mail Couple', 'weddingdir'),

                    'type'      =>  esc_attr('tab'),

                    'section'   =>  esc_attr($have_section),
                ),

                array(

                    'id'          =>  esc_attr('email-subject-' . $email_title),

                    'label'     =>  esc_attr__('Email Subject', 'weddingdir'),

                    'std'         =>  esc_attr__('Your Review Has Been Submitted', 'weddingdir'),

                    'type'      =>  esc_attr('text'),

                    'section'   =>  esc_attr($have_section),
                ),

                array(

                    'id'          =>  esc_attr('email-body-' . $email_title),

                    'label'       =>  esc_attr__('Couple Get Email Body Content', 'weddingdir'),

                    'type'        =>  esc_attr('textarea-simple'),

                    'std'         =>  "<p>Hello {{couple_username}},</p><p>Your message has been successfully submitted for review.</p><p>Thank you</p>",

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('4'),
                ),
            );

            /**
             *  Merge Admin Email Setting
             *  -------------------------
             */
            return      array_merge(

                $have_setting,

                // array_merge(

                $add_setting,

                // parent::weddingdir_setting_option_admin_emails($email_title, $have_section),
                // )
            );
        }
        public static function subscription($have_setting = [], $have_section = '')
        {

            $email_title    =   esc_attr('new-subscribe-couple');

            $add_setting    =   array(

                array(

                    'id'          => esc_attr('email-tab-' . $email_title),

                    'label'     =>  esc_attr__('Subscription', 'weddingdir'),

                    'type'      =>  esc_attr('tab'),

                    'section'   =>  esc_attr($have_section),
                ),

                array(

                    'id'          =>  esc_attr('email-subject-' . $email_title),

                    'label'     =>  esc_attr__('Email Subject', 'weddingdir'),

                    'std'         =>  esc_attr__('Your {{plan_name}} Plan Activated on {{site_name}}!', 'weddingdir'),

                    'type'      =>  esc_attr('text'),

                    'section'   =>  esc_attr($have_section),
                ),

                array(

                    'id'          =>  esc_attr('email-body-' . $email_title),

                    'label'       =>  esc_attr__('Couple Get Email Body Content', 'weddingdir'),

                    'type'        =>  esc_attr('textarea-simple'),

                    'std'         =>  "<p>Hello {{couple_username}},</p><h1>Thank you for subscribing to our <strong>{{plan_name}}</strong> plan!</h1><p>We are excited to have you on board. Your subscription is now active, and you can start enjoying all the benefits and exclusive features available under your plan.</p><div class='details'><p><strong>Plan Name:</strong> {{plan_name}}</p><p><strong>Amount:</strong> {{price}}</p><p><strong>Start Date:</strong> {{subscription_start_date}}</p><p><strong>Next Billing Date:</strong> {{next_billing_date}}</p></div><p>If you have any questions or need assistance, feel free to reach out to us.</p>",

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('4'),
                ),
            );

            /**
             *  Merge Admin Email Setting
             *  -------------------------
             */
            return      array_merge(

                $have_setting,

                array_merge(

                    $add_setting,

                    parent::weddingdir_setting_option_admin_emails($email_title, $have_section),
                )
            );
        }
        public static function approve_review($have_setting = [], $have_section = '')
        {

            $email_title    =   esc_attr('review-approve');

            $add_setting    =   array(

                array(

                    'id'          => esc_attr('email-tab-' . $email_title),

                    'label'     =>  esc_attr__('Review Approve', 'weddingdir'),

                    'type'      =>  esc_attr('tab'),

                    'section'   =>  esc_attr($have_section),
                ),

                array(

                    'id'          =>  esc_attr('email-subject-' . $email_title),

                    'label'     =>  esc_attr__('Email Subject', 'weddingdir'),

                    'std'         =>  esc_attr__('Your Review Has Been Approved!', 'weddingdir'),

                    'type'      =>  esc_attr('text'),

                    'section'   =>  esc_attr($have_section),
                ),

                array(

                    'id'          =>  esc_attr('email-body-' . $email_title),

                    'label'       =>  esc_attr__('Couple Get Email Body Content', 'weddingdir'),

                    'type'        =>  esc_attr('textarea-simple'),

                    'std'         =>  "<p>Hello {{couple_username}},</p><p>Your review {{title}} has been successfully approved.</p><p>is now posted. View review <a href='{{permalink}}'>here</a></p><p>If you have any questions or need assistance, feel free to reach out to us.</p><p>Thank you</p>",

                    'section'     =>  esc_attr($have_section),

                    'rows'        =>  absint('4'),
                ),
            );

            /**
             *  Merge Admin Email Setting
             *  -------------------------
             */
            return      array_merge(

                $have_setting,

                array_merge(

                    $add_setting,

                    parent::weddingdir_setting_option_admin_emails($email_title, $have_section),
                )
            );
        }
    }

    /**
     *  WeddingDir - Framework - Section - Email Setting
     *  ------------------------------------------------
     */
    WeddingDir_FrameWork_My_Email_Setting::get_instance();
}
