<?php

/**
 *  Global Var
 *  ----------
 */
global $post, $wp_query;
// if (!session_id()) {
//     session_start();
// }
// $current_user_id = get_current_user_id();

// unset($_SESSION['login_error']);
// unset($_SESSION['subscription_error']);
// unset($_SESSION['subscription_couple_error']);

// if (!$current_user_id) {
//     session_start();
//     $_SESSION['login_error'] = true;
//     $url = home_url();
//     wp_safe_redirect($url);
//     exit;
// }
// if (is_my_listing_page_couple()) {
//     $url = home_url('subscription-plan');
//     $_SESSION['subscription_couple_error'] = true;
//     wp_redirect($url);
//     exit;
// }
/**
 *  Container Start
 *  ---------------
 */
if (is_tax('listing-category')) {
    $_taxonomy_slug     =    esc_attr(WeddingDir_Taxonomy_Database::listing_category_taxonomy());
    $categoryByTax      =   get_term_by(esc_attr('name'), single_cat_title('', false), esc_attr($_taxonomy_slug));
   
    $_GET['cat_id'] = $categoryByTax->term_id;
} else {

    // $_GET['cat_id'] = 6565;
}
do_action('weddingdir_main_container');
do_action('weddingdir/find-listing');
/**
 *  Load Taxonomy Post
 *  ------------------
 */
// if (class_exists('WeddingDir_Loader')) {

//     /**
//      *  Taxonomy Slug
//      *  -------------
//      */
//     $slug     =     esc_attr(WeddingDir_Taxonomy_Database::listing_category_taxonomy());

//     $obj      =     get_term_by(

//         /**
//          *  1. Listing Name
//          *  ---------------
//          */
//         esc_attr('name'),

//         /**
//          *  2. Get Title
//          *  ------------
//          */
//         single_cat_title('', false),

//         /**
//          *  3. Categroy Slug
//          *  ----------------
//          */
//         esc_attr($slug)
//     );
//     /**
//      *  Category ID
//      *  -----------
//      */
//     $term_id    =   absint($obj->term_id);

//     /**
//      *  Have Child Taxonomy ?
//      *  ---------------------
//      */
//     $_have_child    =   get_term_children($term_id, $slug);

//     $terms          =   get_terms($slug, array(

//         'hide_empty'    => false,

//         'orderby'       => 'name',

//         'order'         => 'ASC',

//         'parent'        => ''

//     ));

//     /**
//      *   Have Term ?
//      *   -----------
//      */
//     $args   =   [];

//     if (WeddingDir_Loader::_is_array($terms)) {

//         foreach ($terms as $key) {

//             if ($key->parent == $obj->term_id && $key->count >= absint('1')) {

//                 $args[] =  absint($key->term_id);
//             }
//         }
//     }

//     /**
//      *  Is Array ?
//      *  ----------
//      */
//     // if (\WeddingDir_Loader::_is_array($args)) {

//     //     /**
//     //      *  Load Post
//     //      *  ---------
//     //      */
//     //     printf(
//     //         '<div class="row row-cols-xxl-4 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1">%1$s</div>',

//     //         /**
//     //          *  Load Post
//     //          *  ---------
//     //          */
//     //         do_shortcode(

//     //             /**
//     //              *  ShortCode Args
//     //              *  --------------
//     //              */
//     //             sprintf(
//     //                 '[weddingdir_listing_category style="%1$s" post_ids="%2$s"][/weddingdir_listing_category]',

//     //                 /**
//     //                  *  1. Style
//     //                  *  ---------
//     //                  */
//     //                 absint('1'),

//     //                 /**
//     //                  *  2. Term IDs
//     //                  *  -----------
//     //                  */
//     //                 implode(',', $args)
//     //             )
//     //         )
//     //     );
//     // } else { 

//     /**
//      *  WeddingDir - Listing Term Page
//      *  ------------------------------
//      *  Layout = 1 [ Load Simple Listing on Page ]
//      *  ------------------------------------------
//      *  Layout = 2 [ Find Listing Features on Page ]
//      *  --------------------------------------------
//      */
//     do_action('weddingdir/term-page/listing-category', [

//         'term_id'   =>  $term_id,

//         'tax'       =>  $slug,

//         'layout'    =>  absint('2')

//     ]);
//     // }
// }

// /**
//  *  Container End
//  *  -------------
//  */
do_action('weddingdir_main_container_end');
