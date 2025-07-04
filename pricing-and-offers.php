<?php

/**
 *  -----------------------------------------------
 *  WeddingDir - Vendor Profile Tab Fields - Object
 *  -----------------------------------------------
 */
if (!class_exists('WeddingDir_Vendor_Pricing_Offers_Change_Tab') && class_exists('WeddingDir_Vendor_Profile_Database')) {


    /**
     *  -----------------------------------------------
     *  WeddingDir - Vendor Profile Tab Fields - Object
     *  -----------------------------------------------
     */
    class WeddingDir_Vendor_Pricing_Offers_Change_Tab extends WeddingDir_Vendor_Profile_Database
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

                    'pricing-offers'        =>  [

                        'id'        =>  esc_attr(parent::_rand()),

                        'name'      =>  esc_attr__('Service Pricing', 'weddingdir'),

                        'callback'  =>  ['class' => __CLASS__, 'member' => 'tab_content'],

                        'create_form'      =>  [

                            'form_before'   =>  '',

                            'form_after'    =>  '',

                            'form_id'       =>  esc_attr('weddingdir_vendor_pricing_offers'),

                            'form_class'    =>  '',

                            'button_before' =>  '',

                            'button_after'  =>  '',

                            'button_id'     =>  esc_attr('vendor_pricing_offers_submit'),

                            'button_class'  =>  '',

                            'button_name'   =>  esc_attr__('Update Service Pricing', 'weddingdir'),

                            'security'      =>  esc_attr('vendor_pricing_offers'),
                        ]
                    ]

                ]);
            }, absint('80'));
        }

        /**
         *.  Tab Content
         *   -----------
         */
        public static function tab_content()
        {

            /**
             *  Minimum Price Range
             *  --------------
             */
        
            parent::create_section(array(

                /**
                 *  Div Managment
                 *  -------------
                 */
                'div'     =>   array(

                    'start'       =>   true,

                    'end'         =>   false,

                    'class'       =>   esc_attr(join(' ', array_map('sanitize_html_class', explode(' ', 'card-body'))))
                ),

                /**
                 *  Row Managment
                 *  -------------
                 */
                'row'     =>   array(

                    'start'       =>   true,

                    'end'         =>   false,
                ),

                /**
                 *  Column Managment
                 *  ----------------
                 */
                /**
                 *  Column Managment
                 *  ----------------
                 */
                'column'     =>   array(

                    'grid'        =>   absint('6'),

                    'id'          =>   '',

                    'class'       =>   '',

                    'start'       =>   true,

                    'end'         =>   true,
                ),

                /**
                 *  Fields Arguments
                 *  ----------------
                 */
                'field'      =>   array(

                    'label'         =>    esc_attr__('Minimum Price Range', 'weddingdir'),

                    'field_type'    =>      esc_attr('select'),

                    'id'            =>      esc_attr('price_range_min'),

                    'name'          =>      esc_attr('price_range_min'),

                    'options' => ChildPluginFunction::create_select_option_price_min(
                        ['0' => esc_attr__('Choose Minimum Price Range', 'weddingdir')],
                        parent:: get_data( esc_attr( 'price_range_min' ) ) // Pass the old value here
                    ),
                )

            ));

            /**
             *    Maximum Price Range
             *    -------------
             */
            parent::create_section(array(

                /**
                 *  Column Managment
                 *  ----------------
                 */
                'column'     =>   array(

                    'grid'        =>   absint('6'),

                    'id'          =>   '',

                    'class'       =>   '',

                    'start'       =>   true,

                    'end'         =>   true,
                ),

                 /**
                 *  Fields Arguments
                 *  ----------------
                 */
                'field'      =>   array(

                    'label'         =>    esc_attr__('Maximum Price Range', 'weddingdir'),

                    'field_type'    =>      esc_attr('select'),

                    'id'            =>      esc_attr('price_range_max'),

                    'name'          =>      esc_attr('price_range_max'),

                    'options' => ChildPluginFunction::create_select_option_price_min(
                        ['0' => esc_attr__('Choose Maximum Price Range', 'weddingdir')],
                        parent:: get_data( esc_attr( 'price_range_max' ) ) // Pass the old value here
                    ),
                )

            ));
            /**
             *  Price Per Hour
             *  --------------
             */
            parent:: create_section( array(

                /**
                 *  Column Managment
                 *  ----------------
                 */
                'column'     =>   array(

                    'grid'        =>   absint( '6' ),

                    'id'          =>   '',

                    'class'       =>   '',

                    'start'       =>   true,

                    'end'         =>   true,
                ),

                /**
                 *  Fields Arguments
                 *  ----------------
                 */
                'field'    =>  array(

                    'field_type'        =>  esc_attr( 'input' ),

                    'type'              =>  esc_attr( 'number' ),

                    'label'             =>  esc_attr__( 'Price Per Hour', 'weddingdir' ),

                    'placeholder'       =>  esc_attr__( 'e.g. 123 456 7890', 'weddingdir' ),

                    'id'                =>  esc_attr( 'price_per_hour' ),

                    'name'              =>  esc_attr( 'price_per_hour' ),

                    'value'             =>  parent:: get_data( esc_attr( 'price_per_hour' ) ),
                )

            ) );
            /**
             *  Special Offers
             *  --------------
             */
            parent:: create_section( array(
               'div'     =>   array(

                    'start'       =>   false,

                    'end'         =>   true,
                ),

                /**
                 *  Row Managment
                 *  -------------
                 */
                'row'     =>   array(

                    'start'       =>   false,

                    'end'         =>   true,
                ),
                /**
                 *  Column Managment
                 *  ----------------
                 */
                'column'     =>   array(

                    'grid'        =>   absint( '6' ),

                    'id'          =>   '',

                    'class'       =>   '',

                    'start'       =>   true,

                    'end'         =>   true,
                ),

                /**
                 *  Fields Arguments
                 *  ----------------
                 */
                'field'    =>  array(

                    'field_type'        =>  esc_attr( 'input' ),

                    'type'              =>  esc_attr( 'number' ),

                    'label'             =>  esc_attr__( 'Special Offer', 'weddingdir' ),

                    'placeholder'       =>  esc_attr__( 'Special Offer', 'weddingdir' ),

                    'id'                =>  esc_attr( 'special_offer' ),

                    'name'              =>  esc_attr( 'special_offer' ),

                    'value'             =>  parent:: get_data( esc_attr( 'special_offer' ) ),
                )

            ) );
        }
    }

    /**
     *  -----------------------------------------------
     *  WeddingDir - Vendor Profile Tab Fields - Object
     *  -----------------------------------------------
     */
    WeddingDir_Vendor_Pricing_Offers_Change_Tab::get_instance();
}
