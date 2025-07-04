<?php
class WeddingDirectory
{

    public function __construct()
    {
        // if (!is_my_listing_page_couple()) {
        //      
        // }
      add_filter('weddingdir/couple/dashboard/menu', [$this, 'wishlist'], 10, 1); 
    }


    function wishlist($args = [])
    {

        /**
         *  Merge Menu
         *  ----------
         */
        return  array_merge($args, array(

            'wishlist'   =>  array(

                'menu_show'     =>  apply_filters('weddingdir/couple-menu/wishlist/menu-show', true),

                'menu_class'    =>  apply_filters('weddingdir/couple-menu/wishlist/menu-class',  ''),

                'menu_id'       =>  apply_filters('weddingdir/couple-menu/wishlist/menu-id',  ''),

                'menu_name'     =>  apply_filters(
                    'weddingdir/couple-menu/wishlist/menu-name',

                    esc_attr__('My Wishlist', 'weddingdir-wishlist')
                ),

                'menu_icon'     =>  apply_filters(
                    'weddingdir/couple-menu/wishlist/menu-icon',

                    esc_attr('weddingdir-vendor-manager')
                ),

                'menu_active'   =>  self::is_active()  ?   sanitize_html_class('active')  :   null,

                'menu_link'     =>  apply_filters('weddingdir/couple-menu/page-link', esc_attr('couple-wishlist'))
            )

        ));
    }
    function is_active()
    {

        return  WeddingDir_Config::dashboard_page_set('couple-wishlist') ||

            WeddingDir_Config::dashboard_page_set('vendor-category');
    }
}
new WeddingDirectory();
