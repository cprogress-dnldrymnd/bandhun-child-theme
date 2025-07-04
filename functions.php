<?php

/**
 *  ------------------------
 *  WeddingDir - Child Theme
 *  -------------------------------------
 *  Child-Theme functions and definitions
 *  -------------------------------------
 *  @credit - https://codex.wordpress.org/Child_Themes
 *  --------------------------------------------------
 */
if (!class_exists('WeddingDir_Child_Theme')) {

    /**
     *  WeddingDir - Child Theme
     *  ------------------------
     */
    class WeddingDir_Child_Theme
    {

        /**
         *  Member Variable
         *  ---------------
         *  @var instance
         *  -------------
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
             *  1. Load Enqueue Script
             *  ----------------------
             */
            add_action('wp_enqueue_scripts', [$this, 'weddingdir_child_styles']);
        }

        /**
         *  1. Load Enqueue Script
         *  ----------------------
         */
        public static function weddingdir_child_styles()
        {

            /**
             *  WeddingDir - Child Theme ( style.css ) Loaded After parent style
             *  ----------------------------------------------------------------
             */
            wp_enqueue_style(

                /**
                 *  File Name
                 *  ---------
                 */
                esc_attr('weddingdir-child-style'),

                /**
                 *  File Path
                 *  ---------
                 */
                esc_url(get_stylesheet_directory_uri() . '/style.css'),

                /**
                 *  Load WeddingDir - Style After Bootsrap Library
                 *  ----------------------------------------------
                 */
                array('weddingdir-parent-style'),

                /**
                 *  WeddingDir - Theme Version
                 *  --------------------------
                 */
                esc_attr(wp_get_theme()->get('Version')),

                /**
                 *  Load Media in All
                 *  -----------------
                 */
                esc_attr('all')
            );
        }
    }

    /**
     *  WeddingDir - Child Theme
     *  ------------------------
     */
    WeddingDir_Child_Theme::get_instance();
}

function action_header_right_side()
{
    if (!is_user_logged_in()) {
?>
        <div class="button-box">
            <a class="btn btn-secondary" href="javascript:" role="button" data-bs-toggle="modal" data-bs-target="#weddingdir_couple_login_model_popup"><i class="fa fa-user-o d-xs-block d-lg-none d-xl-none d-sm-none"></i>
                <span class="">
                    <strong>Wedding Builder</strong>
                </span>
            </a>
            <a class="btn btn-primary" href="javascript:" role="button" data-bs-toggle="modal" data-bs-target="#weddingdir_vendor_login_model_popup"><i class="fa fa-user-o d-xs-block d-lg-none d-xl-none d-sm-none"></i>
                <span class="">
                    <strong>Vendor Portal</strong>
                </span>
            </a>
        </div>
    <?php
    }
}


add_filter('nav_menu_link_attributes', 'action_nav_menu_link_attributes', 10, 3);
function action_nav_menu_link_attributes($atts, $item, $args)
{
    // The ID of the target menu item 
    if ($item->ID == 4642) {
        $atts['href'] = 'javascript:';
        $atts['data-bs-toggle'] = 'modal';
        $atts['data-bs-target'] = '#weddingdir_couple_registration_model_popup';
    }

    if ($item->ID == 4741) {
        $atts['href'] = 'javascript:';
        $atts['data-bs-toggle'] = 'modal';
        $atts['data-bs-target'] = '#weddingdir_vendor_login_model_popup';
    } {
        if ($item->ID == 4643) {
            $atts['href'] = 'javascript:';
            $atts['data-bs-toggle'] = 'modal';
            $atts['data-bs-target'] = '#weddingdir_vendor_registration_model_popup';
        }
    }
    return $atts;
}

add_action('header_right_side', 'action_header_right_side');


add_filter('gettext', 'translate_text');
add_filter('ngettext', 'translate_text');

add_filter('gettext', 'translate_my_wishlish');
add_filter('ngettext', 'translate_my_wishlish');
function translate_text($translated)
{
    $translated = str_ireplace('Value of money', 'Value for money', $translated);
    return $translated;
}
function translate_my_wishlish($translated)
{
    $translated = str_ireplace('My Wishlist', 'Wedding Builder', $translated);
    return $translated;
}

function action_wp_footer()
{
    if (is_front_page()) {
    ?>
        <script>
            // if (jQuery('.password-eye').length) {
            //     jQuery('.password-eye span').click(function() {

            //         /**
            //          *  Toggle Two Class
            //          *  ----------------
            //          */
            //         jQuery(this).toggleClass('fa-eye fa-eye-slash');

            //         /**
            //          *  Get Input Type
            //          *  --------------
            //          */
            //         var input = jQuery(this).closest('.password-eye').find('input');

            //         /**
            //          *  Show Password
            //          *  -------------
            //          */
            //         if (jQuery(input).attr('type') == 'password') {

            //             jQuery(input).attr('type', 'text');
            //         }

            //         /**
            //          *  Hide Password
            //          *  -------------
            //          */
            //         else {

            //             jQuery(input).attr('type', 'password');
            //         }
            //     });
            // }
            jQuery(document).ready(function() {
                $search_term = jQuery('<div class="col-12 col-md-3 fake-input"> <div class="weddingdir-dropdown-handler "> <div class="input-group"> <span class="d-flex align-items-center px-3 before-input-box"> <i class="fa fa-search"></i> </span> <input autocomplete="off" type="text" placeholder="Search By Vendor or Service" id="search-term" data-page-template="1" name="search-term" class="form-control form-light search-term search-by-term" data-value-id="297"> </div> </div> </div>')

                $search_term.prependTo('.slider-form > .row');

                jQuery('input[name="listing-category-fake"]:not(.search-by-term)').attr('placeholder', 'Choose a category')

                jQuery('.slider-content .slider-form > .row > div').removeClass('col-md-5').addClass('col-md-3');
            });
        </script>
    <?php
    }
    ?>
    <script>
        jQuery(document).ready(function() {
            listings();
            <?php if (get_page_template_slug() == 'user-template/couple-dashboard.php') { ?>
                dashboard();
            <?php } ?>
        });

        function listings() {
            $filter_backdrop = jQuery('<div class="filter-backdrop"></div>');
            $filter_backdrop.appendTo('body');
            $map_button = jQuery('<li class="nav-item nav-map"> <a class="nav-link" id="listing-map" data-bs-toggle="pill" href="#" role="tab" aria-selected="false"> <i class="fa fa-map-marker"></i> Map </a> </li>');
            $map_button.appendTo('.map-tabbing');
            $map_close = jQuery('<svg class="close-map" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16"> <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path> </svg>');

            $map_close.prependTo('#weddingdir_find_listing_section');

            jQuery('button[data-bs-target=".find-listing-widget"]').click(function(e) {
                jQuery('#weddingdir_find_listing_form .collapse').removeClass('show');
                setTimeout(function() {
                    jQuery('#weddingdir_find_listing_form .row:nth-child(2)').toggleClass('show-filter');
                    jQuery('.filter-backdrop').toggleClass('filter-backdrop-active');
                }, 300);
                e.preventDefault();
            });

            jQuery('.close-filter').click(function(e) {
                jQuery('#weddingdir_find_listing_form .row:nth-child(2)').toggleClass('show-filter');
                jQuery('.filter-backdrop').toggleClass('filter-backdrop-active');
                e.preventDefault();
            });

            jQuery('.filter-backdrop').click(function(e) {
                jQuery('#weddingdir_find_listing_form .row:nth-child(2)').removeClass('show-filter');
                jQuery('#map_handler').removeClass('show-map');
                jQuery('body').removeClass('body-show-map');
                jQuery('.filter-backdrop').removeClass('filter-backdrop-active');
                e.preventDefault();
            });
            jQuery('#listing-map').click(function(e) {
                jQuery('#map_handler').toggleClass('show-map');
                jQuery('body').toggleClass('body-show-map');
                jQuery('.filter-backdrop').toggleClass('filter-backdrop-active');
                e.preventDefault();
                return false;
            });
            jQuery('.close-map').click(function(e) {
                jQuery('#map_handler').toggleClass('show-map');
                jQuery('body').toggleClass('body-show-map');
                jQuery('.filter-backdrop').toggleClass('filter-backdrop-active');
                return false;
            });

        }
        <?php if (get_page_template_slug() == 'user-template/couple-dashboard.php') { ?>

            function dashboard() {
                jQuery('.dashboard-body .card-shadow').each(function(index, element) {
                    $section_name = jQuery(this).find('h3').text();
                    jQuery(this).addClass($section_name);
                });

                $top = jQuery('<div class="top-holder"><div class="row"><div class="col-lg-6 col-task"></div><div class="col-lg-6 col-budget"></div><div class="col-lg-12 col-guest"></div></div>');

                $top.prependTo('.col-xl-8');

                jQuery('.Upcoming.tasks').appendTo('.col-task');
                jQuery('.Budget').appendTo('.col-budget');
                jQuery('.Guest.List.Overview').appendTo('.col-guest');

            }
        <?php } ?>
         <?php
        if (is_singular('listing')) {
        ?>

            function setMarkerTitle() {
                var locationMap = jQuery('.marker_show_on_map').attr('data-location');

                if (locationMap) {
                    var markers = document.querySelectorAll('.leaflet-marker-icon');
                    markers.forEach(function(marker) {
                        marker.setAttribute('title', locationMap);
                    });
                }
            }
            var observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.addedNodes.length > 0) {
                        mutation.addedNodes.forEach(function(node) {
                            if (node.classList && node.classList.contains('leaflet-marker-icon')) {
                                setMarkerTitle();
                            }
                        });
                    }
                });
            });
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
            window.onload = function() {
                setMarkerTitle();
            };
        <?php } ?>
    </script>
<?php
}


add_action('wp_footer', 'action_wp_footer');

function action_admin_head()
{
?>
    <style>
        #weddingdir-name,
        #weddingdir-child-name {
            font-size: 0;
        }

        #weddingdir-name:after {
            content: 'Bandhun';
            font-size: 15px;
        }

        #weddingdir-child-name:after {
            content: 'Bandhun Child';
            font-size: 15px;
        }

        #weddingdir-name span,
        #weddingdir-child-name span {
            font-size: 15px;
        }
	
        .weddingdir-page-settings h1,
        .weddingdir-page-settings .about-text {
            display: none !important;
        }

        .weddingdir-page-settings .nav-tab-wrapper a:nth-child(1),
        .weddingdir-page-settings .nav-tab-wrapper a:nth-child(2) {
            display: none !important;
        }
		#menu-posts-website, #menu-posts-real-wedding, #menu-posts-claim-listing  {
			display: none !important;
		}
    </style>
    <?php
    if (get_current_user_id() != 1) {
    ?>
        <style>
            #toplevel_page_weddingdir {
                display: none !important;
            }
        </style>
    <?php
    }
}

add_action('admin_head', 'action_admin_head');

/**
 * Change text strings
 *
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/gettext
 */
function my_text_strings($translated_text, $text, $domain)
{
    switch ($translated_text) {
        case 'WeddingDir':
            $translated_text = __('Bandhun', 'bandhun');
            break;
    }
    return $translated_text;
}
add_filter('gettext', 'my_text_strings', 20, 3);


function import_vendors()
{
    add_submenu_page(
        'edit.php?post_type=vendor',
        __('Import Vendors', 'textdomain'),
        __('Import Vendors', 'textdomain'),
        'manage_options',
        'import-vendors',
        'import_vendors_contents'
    );
}

add_action('admin_menu', 'import_vendors');


function import_vendors_contents()
{
    ?>
    <style>
        .import-form {
            max-width: 500px;
        }

        .import-form .form-control:not(:last-child) {
            margin-bottom: 1.5rem;
        }

        .import-form input {
            width: 100%;
        }

        .import-form .submit {
            font-weight: bold;
            font-size: 16px;
        }

        .import-table {
            overflow: auto;
        }

        .import-table th,
        .import-table td {
            padding: 5px 5px;
        }

        .import-table>table>tbody {
            display: flex;
            flex-wrap: wrap;

        }

        .import-table table {
            width: 100%;
        }

        .import-table>table>tbody>tr {
            padding: 5px;
            flex: 0 0 auto;
            width: 28%;
            border: 1px solid #ececec;
            background-color: #ececec;
        }

        .import-table>table>tbody>tr:nth-child(even) {
            background-color: #fff;
        }

        .login-details {
            background-color: #adf5ad;
            padding: 10px;
            border-radius: 10px;
            border: 1px dashed;
        }
    </style>
    <h1>
        <?php esc_html_e('Import vendors', 'my-plugin-textdomain'); ?>
    </h1>

    <?php if (!$_GET['csv']) { ?>
        <form action="/wp-admin/edit.php" method="GET" class="import-form">
            <div class="form-control">
                <label for="">
                    <h4>Please upload csv in media library and put csv link below.</h4>
                    <input type="hidden" name="post_type" value="vendor">
                    <input type="hidden" name="page" value="import-vendors">
                    <input type="text" name="csv" placeholder="CSV URL" required>
                </label>
            </div>
            <div class="form-control">
                <input type="submit" value="SUBMIT" class="submit button button-primary">
            </div>
        </form>
    <?php } else { ?>
        <h3>CSV URL: <?= $_GET['csv'] ?></h3>
    <?php } ?>
    <?php

    if ($_GET['csv']) {
        $CSVfp = fopen($_GET['csv'], "r");
        if ($CSVfp !== FALSE) {
    ?>
            <div class="import-table">
                <table>
                    <?php
                    $row = 0;
                    $meta_name = array();
                    $meta_input = array();

                    while (!feof($CSVfp)) {
                        $data = fgetcsv($CSVfp, 1000, ",");
                        if (!empty($data)) {
                            if ($row == 0) {
                                foreach ($data as $key => $d) {
                                    $meta_name[] = $d;
                                }
                            } else {
                                foreach ($data as $key => $d) {
                                    if ($d != 'categories') {
                                        $meta_input[$meta_name[$key]] = $d;
                                    }
                                }
                                $fname = preg_replace('/[^a-zA-Z0-9_.]/', '_', $meta_input['first_name']);
                                $lname = preg_replace('/[^a-zA-Z0-9_.]/', '_', $meta_input['last_name']);
                                $username = strtolower($meta_input['author_username']);
                                $password = $username;
                                $email = $meta_input['user_email'];
                                $user_id = create_new_vedor_user($username, $password, $email);
                                $meta_input['user_id'] = $user_id;
                                $post_exist = post_exists($meta_input['company_name']);
                                if ($post_exist) {
                                    $status = 'VENDOR EXIST ALREADY';
                                    $new_post_id = $post_exist;
                                } else {
                                    $new_post_id = create_new_vendor_post($meta_input);
                                    if ($new_post_id) {
                                        $status = 'IMPORTED';
                                    } else {
                                        $status = 'FAILED';
                                    }
                                }



                    ?>
                                <tr>
                                    <td>
                                        <h2 style="margin-top: 0; margin-bottom: 15px"><?= $meta_input['company_name'] ?> [<?= $status ?>]</h2>
                                        <table style="text-align: left">
                                            <tr>
                                                <th>
                                                    post_id
                                                </th>
                                                <td>
                                                    <?= $new_post_id ?>
                                                    <a href="<?= get_edit_post_link($new_post_id) ?>">[EDIT]</a>
                                                    <a href="<?= get_permalink($new_post_id) ?>">[VIEW]</a>
                                                </td>
                                            </tr>
                                            <?php foreach ($meta_input as $key => $d) { ?>
                                                <?php if ($key != '') { ?>
                                                    <tr>
                                                        <th>
                                                            <?= $key ?>
                                                        </th>
                                                        <td>
                                                            <?= $d ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                            <tr>
                                                <th>
                                                    categories
                                                </th>
                                                <td>
                                                    <?= $data[11] ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">
                                                    <div class="login-details">
                                                        <div>
                                                            <strong>username:</strong> <?= $username ?>
                                                        </div>
                                                        <div>
                                                            <strong>password:</strong> <?= $password ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        <?php } ?>
                        <?php $row++; ?>
                    <?php
                    }
                    ?>
                </table>
            </div>
    <?php
        }
        fclose($CSVfp);
    }
}



function create_new_vendor_post($meta_input)
{
    $category = get_term_by('name', trim($meta_input['categories']), 'vendor-category');

    if ($category) {
        $term = $category->term_id;
    } else {
        $term_id = wp_create_term(trim($meta_input['categories']), 'vendor-category');
        $category = get_term_by('name', trim($meta_input['categories']), 'vendor-category');
        $term = $category->term_id;
    }

    $wordpress_post = array(
        'post_title'  => $meta_input['company_name'],
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type'   => 'vendor',
        'tax_input'   => array(
            "vendor-category" => array($term)
        ),
        'meta_input'  => $meta_input
    );
    return wp_insert_post($wordpress_post);
}


function create_new_vedor_user($username, $password, $email)
{

    if (username_exists($username) || email_exists($email)) {
        $id_by_username = get_user_by('login', $username)->ID;
        $id_by_email = get_user_by('email', $email)->ID;
        $user_id = $id_by_username ? $id_by_username : $id_by_email;
        return $user_id;
    } else {
        $user_id = wp_create_user($username, $password, $email);

        if (is_wp_error($user_id)) {

            die($user_id->get_error_message());
        }
        $user = get_user_by('id', $user_id);
        $user->remove_role('subscriber');
        $user->add_role('vendor');
        return $user_id;
    }
}



function import_listing()
{
    add_submenu_page(
        'edit.php?post_type=listing',
        __('Import listing', 'textdomain'),
        __('Import listing', 'textdomain'),
        'manage_options',
        'import-listing',
        'import_listing_contents'
    );
}

add_action('admin_menu', 'import_listing');


function import_listing_contents()
{
    ?>
    <style>
        .import-form {
            max-width: 500px;
        }

        .import-form .form-control:not(:last-child) {
            margin-bottom: 1.5rem;
        }

        .import-form input {
            width: 100%;
        }

        .import-form .submit {
            font-weight: bold;
            font-size: 16px;
        }

        .import-table {
            overflow: auto;
        }

        .import-table th,
        .import-table td {
            padding: 5px 5px;
        }

        .import-table>table>tbody {
            display: flex;
            flex-wrap: wrap;

        }

        .import-table table {
            width: 100%;
        }

        .import-table>table>tbody>tr {
            padding: 5px;
            flex: 0 0 auto;
            width: 28%;
            border: 1px solid #ececec;
            background-color: #ececec;
        }

        .import-table>table>tbody>tr:nth-child(even) {
            background-color: #fff;
        }

        .login-details {
            background-color: #adf5ad;
            padding: 10px;
            border-radius: 10px;
            border: 1px dashed;
        }
    </style>
    <h1>
        <?php esc_html_e('Import listing', 'my-plugin-textdomain'); ?>
    </h1>



    <?php if (!$_GET['csv']) { ?>
        <form action="/wp-admin/edit.php" method="GET" class="import-form">
            <div class="form-control">
                <label for="">
                    <h4>Please upload csv in media library and put csv link below.</h4>
                    <input type="hidden" name="post_type" value="listing">
                    <input type="hidden" name="page" value="import-listing">
                    <input type="text" name="csv" placeholder="CSV URL" required>
                </label>
            </div>
            <div class="form-control">
                <input type="submit" value="SUBMIT" class="submit button button-primary">
            </div>
        </form>
    <?php } else { ?>
        <h3>CSV URL: <?= $_GET['csv'] ?></h3>
    <?php } ?>
    <?php

    if ($_GET['csv']) {
        $CSVfp = fopen($_GET['csv'], "r");
        if ($CSVfp !== FALSE) {
    ?>
            <div class="import-table">
                <table>
                    <?php
                    $row = 0;
                    $meta_name = array();
                    $meta_input = array();

                    while (!feof($CSVfp)) {
                        $data = fgetcsv($CSVfp, 1000, ",");
                        if (!empty($data)) {
                            if ($row == 0) {
                                foreach ($data as $key => $d) {
                                    $meta_name[] = $d;
                                }
                            } else {
                                foreach ($data as $key => $d) {
                                    $meta_input[$meta_name[$key]] = $d;
                                }
                                $new_post_id = create_new_listing_post($meta_input);
                                if ($new_post_id) {
                                    $status = 'IMPORTED';
                                } else {
                                    $status = 'FAILED';
                                }

                    ?>
                                <tr>
                                    <td>
                                        <h2 style="margin-top: 0; margin-bottom: 15px"><?= $meta_input['company_name'] ?> [<?= $status ?>]</h2>
                                        <table style="text-align: left">
                                            <tr>
                                                <th>
                                                    post_id
                                                </th>
                                                <td>
                                                    <?= $new_post_id ?>
                                                    <a href="<?= get_edit_post_link($new_post_id) ?>">[EDIT]</a>
                                                    <a href="<?= get_permalink($new_post_id) ?>">[VIEW]</a>
                                                </td>
                                            </tr>
                                            <?php foreach ($meta_input as $key => $d) { ?>
                                                <?php if ($key != '') { ?>
                                                    <tr>
                                                        <th>
                                                            <?= $key ?>
                                                        </th>
                                                        <td>
                                                            <?= $d ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        </table>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        <?php } ?>
                        <?php $row++; ?>
                    <?php
                    }
                    ?>
                </table>
            </div>
<?php
        }
        fclose($CSVfp);
    }
}



function create_new_listing_post($meta_input)
{
    $categories = explode(",", $meta_input['category']);
    // print_r($categories);
    $category = array();
    foreach ($categories as $categ) {
        if (term_exists($categ, 'listing-category')) {
            $category[] = get_term_by('name', $categ, 'listing-category')->term_id;
        } else {
            $new_term = wp_insert_term($categ, 'listing-category');
            $category[] = $new_term->term_id;
        }
    }

    $user_id = get_user_by('login', $meta_input['author_username'])->ID;

    $found_post = post_exists($meta_input['listing_name']);

    $wordpress_post = array(
        'post_title'  => $meta_input['listing_name'],
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type'   => 'listing',
        'tax_input'   => array(
            "listing-category" => $category
        ),
        'meta_input'  => $meta_input,
        'post_author' => $user_id
    );
    if ($found_post) {
        $wordpress_post['ID'] = $found_post;
        return wp_update_post($wordpress_post);
    } else {

        return wp_insert_post($wordpress_post);
    }
}

//check if user is logged in
add_filter('body_class', 'custom_class');
function custom_class($classes)
{
    if (is_user_logged_in()) {
        $classes[] = 'user-is-logged-in';
    } else {
        $classes[] = 'user-is-not-logged-in';
    }
    return $classes;
}



function action_hidden_inputs_fields($args = [])
{

    $_hidden_input  =   [
        'search_term'           =>      'search_terms',
    ];
    $_collection        =       [];

    foreach ($_hidden_input as $key => $value) {

        /**
         *  Update Value
         *  ------------
         */
        $_collection[$key]    =   isset($_GET[$key]) && !empty($_GET[$key])

            ?   $_GET[$key]

            :   '';
    }

    return array_merge($args, $_collection);
}

add_filter('weddingdir/find-listing/hidden-inputs', 'action_hidden_inputs_fields');

function custom_query_vars_filter($vars)
{
    $vars[] = 'search_term';

    return $vars;
}
add_filter('query_vars', 'custom_query_vars_filter');

function PLUGIN_modify_query($query)
{
    $search_term = get_query_var('search_term');
    if ($query->query['post_type'] == 'listing') {
        //Apply the order by options
        $query->set('s', $search_term);
    }
}

add_action('pre_get_posts', 'PLUGIN_modify_query');

function custom_find_listing_action()
{
    // Your custom code or function to handle the 'weddingdir/find-listing' action
    // This could be displaying a specific content, running a function, etc.
    echo "Triggering the weddingdir/find-listing action!";
}
add_action('weddingdir/find-test', 'custom_find_listing_action');

// function custom_url_redirect()
// {
//     // Check if the current URL is '/bridge/test'
//     if (is_tax('vendor-category')) {
//         wp_redirect(home_url('/listing-category'));
//         exit();
//     }
// }
// add_action('template_redirect', 'custom_url_redirect');

// function update_custom_post_type_args()
// {
//     $args = get_post_type_object('listing');
//     // print_r($args);
//     // die;
//     $args->show_in_menu = true; // Set show_in_menu to true

//     // Update the post type with the modified arguments
//     register_post_type('listing', $args);
// }
// add_action('init', 'update_custom_post_type_args', 11);

function update_custom_taxonomy_args()
{
    $args = get_taxonomy('listing-category');
    $args->show_in_menu = true; // Set show_in_menu to true

    // Update the taxonomy with the modified arguments
    register_taxonomy('listing-category', 'listing', $args);
}
add_action('init', 'update_custom_taxonomy_args', 11);


// function convert_meta_value_on_post_save($post_id)
// {
//     // Check if this is not an autosave
//     if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
//         return;
//     }
//     if (get_post_type($post_id) === 'listing') {
//         // Check if the post is being created (first save)
//         if (wp_is_post_revision($post_id)) {
//             return;
//         }

//         // Get the current meta value
//         $current_meta_value = get_post_meta($post_id, 'listing_dining_options', true);

//         // Unserialize the meta value
//         $unserialized_value = maybe_unserialize($current_meta_value);

//         // Check if unserialization was successful
//         if ($unserialized_value !== false) {
//             // Convert the array to a comma-separated string
//             $new_meta_value = implode(',', $unserialized_value);

//             // Update the meta value with the new format
//             update_post_meta($post_id, 'listing_dining_options_new', $new_meta_value);
//         } else {
//             // Handle the case where unserialization fails
//             // This could be due to an invalid serialized string
//             // You may want to log an error or handle it in some way
//         }
//     }
// }

// // Hook the function to the save_post action with a priority of 10
// add_action('save_post', 'convert_meta_value_on_post_save', 10);

function convert_meta_values_on_post_save($post_id)
{
    // Check if this is not an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (get_post_type($post_id) === 'listing') {
        // Check if the post is being created (first save)
        if (wp_is_post_revision($post_id)) {
            return;
        }

        // Define an array of meta keys to update
        $meta_keys_to_update = array(
            'listing_dining_options',
            'listing_ceremony_options',
            'listing_overnight_accommodation',
            'listing_evening_ent',
            'listing_style',
            'listing_amenities',
            'listing_venue_facilities',
            // Add more meta keys as needed
        );

        foreach ($meta_keys_to_update as $meta_key) {
            // Get the current meta value
            $current_meta_value = get_post_meta($post_id, $meta_key, true);

            // Unserialize the meta value
            $unserialized_value = maybe_unserialize($current_meta_value);

            // Check if unserialization was successful
            if ($unserialized_value !== false) {
                // Convert the array to a comma-separated string
                $new_meta_value = implode(',', $unserialized_value);

                // Update the meta value with the new format
                update_post_meta($post_id, $meta_key . '_new', $new_meta_value);
            } else {
                // Handle the case where unserialization fails
                // This could be due to an invalid serialized string
                // You may want to log an error or handle it in some way
            }
        }
    }
}

// Hook the function to the save_post action
add_action('save_post', 'convert_meta_values_on_post_save');

function register_dining_options_post_type()
{
    $labels = array(
        'name'               => _x('Dining Options', 'post type general name', 'text_domain'),
        'singular_name'      => _x('Dining Option', 'post type singular name', 'text_domain'),
        'menu_name'          => _x('Dining Options', 'admin menu', 'text_domain'),
        'name_admin_bar'     => _x('Dining Option', 'add new on admin bar', 'text_domain'),
        'add_new'            => _x('Add New', 'dining option', 'text_domain'),
        'add_new_item'       => __('Add New Dining Option', 'text_domain'),
        'new_item'           => __('New Dining Option', 'text_domain'),
        'edit_item'          => __('Edit Dining Option', 'text_domain'),
        'view_item'          => __('View Dining Option', 'text_domain'),
        'all_items'          => __('All Dining Options', 'text_domain'),
        'search_items'       => __('Search Dining Options', 'text_domain'),
        'parent_item_colon'  => __('Parent Dining Options:', 'text_domain'),
        'not_found'          => __('No dining options found.', 'text_domain'),
        'not_found_in_trash' => __('No dining options found in Trash.', 'text_domain')
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __('Description.', 'text_domain'),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'dining-options'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
    );

    register_post_type('dining-options', $args);
}

add_action('init', 'register_dining_options_post_type');


function enqueue_scripts_new()
{
    wp_dequeue_script('weddingdir_todo');
    wp_deregister_script('weddingdir_todo');
}
add_action('wp_enqueue_scripts', 'enqueue_scripts_new', 100);

add_action('wp_enqueue_scripts', 'enqueue_scripts');

function enqueue_scripts()
{
    wp_dequeue_script('weddingdir_search_result');
    wp_dequeue_script('weddingdir_couple_login_register_form');
    // wp_deregister_script('weddingdir_couple_login_register_form');
    wp_dequeue_script('weddingdir_vendor_login_register_form');


    wp_dequeue_script('weddingdir_listing_category_term_page');
    wp_deregister_script('weddingdir_listing_category_term_page');
}

/**Filtering Option Customization CC Devloper ADDED */
include_once 'accommodation-filter.php';
include_once 'ceremony-filter.php';
include_once 'dining-filter.php';
include_once 'evening-ent-filter.php';
include_once 'venue-filter.php';
include_once 'sort-by.php';
include_once 'form-filds.php';
include_once 'pricing-and-offers.php';
include_once 'ajax-vendor-profile.php';
include_once 'emails-tabs.php';
include_once 'stripe-functions.php';
include_once 'transaction-couple.php';
include_once 'subscription-details.php';
// include_once 'vendor-list-menu.php';
// add_action('init', 'remove_actions_filters_init');

// function remove_actions_filters_init()
// {
//     remove_action('weddingdir/find-listing/filter-widget', ['WeddingDir_Search_Result_Filter_Widget_Sorted_By', 'widget'], absint('50'));
//     remove_filter('weddingdir/find-listing/active-filters', ['WeddingDir_Search_Result_Filter_Widget_Sorted_By', 'active_filter'], absint('50'));
// }
add_action('init', 'handle_import_form_submission');

function handle_import_form_submission()
{


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csv_file"])) {
        $file = $_FILES["csv_file"];
        // Check for errors in the uploaded file
        if ($file['error'] === UPLOAD_ERR_OK) {
            $csv_file = fopen($file['tmp_name'], 'r');

            if ($csv_file !== false) {
                // Read the first row to get headers
                $headers = fgetcsv($csv_file);
                $header_map = array(
                    'first_name' => $headers[0],

                    'last_name' => $headers[1],

                    'guest_event' => $headers[2],

                    'guest_age' => $headers[3],

                    'guest_group' => $headers[4],

                    'guest_email' => $headers[6],

                    'guest_contact' => $headers[7],

                    'guest_address' => $headers[8],

                    'guest_city' => $headers[9],

                    'guest_state' => $headers[10],

                    'guest_zip_code' => $headers[11],

                    'guest_comment' => $headers[12],

                    'adult' => $headers[13],

                    'child' => $headers[14]

                );

                // Find the index of each header in the CSV file
                $header_indices = array();
                foreach ($header_map as $field => $header) {
                    $index = array_search($header, $headers);
                    if ($index !== false) {
                        $header_indices[$field] = $index;
                    }
                }

                /**
                 * Get All Event Guest
                 */
                $eventList = WeddingDir_Guest_List_Database::event_list();
                $_member_group_id  = absint(rand());
                while (($data = fgetcsv($csv_file)) !== false) {
                    $invited_events = explode(",", $data[$header_indices['guest_event']]);
                    $guest_event = array();
                    foreach ($eventList as $key => $value) {
                        $guest_event[$key]['event_name'] = $value['title'];
                        $guest_event[$key]['guest_invited'] = 0;
                        $guest_event[$key]['meal'] = ' ';
                        $guest_event[$key]['event_unique_id'] = $value['event_unique_id'];
                        if (in_array($value['title'], $invited_events)) {
                            $guest_event[$key]['guest_invited'] = 1;
                        }
                    }
                    $_form_data[] = array(
                        'title' => sprintf(
                            '%s %s',
                            esc_attr($data[$header_indices['first_name']]),
                            esc_attr($data[$header_indices['last_name']])
                        ),
                        'first_name' => !empty($data[$header_indices['first_name']]) ? esc_attr($data[$header_indices['first_name']]) : '',
                        'last_name' => !empty($data[$header_indices['last_name']]) ? esc_attr($data[$header_indices['last_name']]) : '',
                        'guest_event' => json_encode($guest_event), // Correctly access data before encoding
                        'guest_age' =>  !!empty($data[$header_indices['guest_age']]) ? esc_attr($data[$header_indices['guest_age']]) : '',
                        'guest_group' => !empty($data[$header_indices['guest_group']]) ? esc_attr($data[$header_indices['guest_group']]) : '',
                        'guest_need_hotel' => 'off', // Assuming this is a constant value
                        'guest_email' => !empty($data[$header_indices['guest_email']]) ? $data[$header_indices['guest_email']] : '',
                        'guest_contact' => !empty($data[$header_indices['guest_contact']]) ? $data[$header_indices['guest_contact']] : '',
                        'guest_address' => !empty($data[$header_indices['guest_address']]) ? $data[$header_indices['guest_address']] : '',
                        'guest_city' => !empty($data[$header_indices['guest_city']]) ? $data[$header_indices['guest_city']] : '',
                        'guest_state' => !empty($data[$header_indices['guest_state']]) ? $data[$header_indices['guest_zip_code']] : '',
                        'guest_zip_code' => !empty($data[$header_indices['guest_zip_code']]) ? $data[$header_indices['guest_zip_code']] : '',
                        'guest_comment' => !empty($data[$header_indices['guest_comment']]) ? $data[$header_indices['guest_comment']] : '',
                        'invitation_status' => 0,
                        'request_missing_info' => 0,
                        'adult' => !empty($data[$header_indices['adult']]) ? $data[$header_indices['adult']] : 0,
                        'child' => !empty($data[$header_indices['child']]) ? $data[$header_indices['child']] : 0,
                        'request_missing_info' => 0,
                        'guest_unique_id' => absint(rand()),
                        'guest_member_id' => $_member_group_id
                    );
                }
            }

            /**
             *  Backend Data
             *  ------------
             */
            $_backend_data  = WeddingDir_Guest_List_Database::guest_list();

            $_merget_guest     = [];

            if (WeddingDir_Guest_List_Database::_is_array($_backend_data)) {

                $_merget_guest     =   array_merge_recursive($_form_data, $_backend_data);
            } else {

                $_merget_guest     =   $_form_data;
            }
            // ;
            // unset($file);
            if (update_post_meta(absint(WeddingDir_Guest_List_Database::post_id()), sanitize_key('guest_list_data'), $_merget_guest)) {
                header("Location: " . apply_filters('weddingdir/couple-menu/page-link', esc_attr('couple-guestlist')));
                exit();
            }
            // wp_safe_redirect(apply_filters( 'weddingdir/couple-menu/page-link', esc_attr( 'couple-guestlist' )));
            fclose($csv_file);
        }
    }
}
function sidebar_panel_edit_form()
{
    WeddingDir_Guest_Edit_Form_Modified::sidebar_panel();
}


if (!WeddingDir_Config::dashboard_page_set(esc_attr('couple-wishlist')) && ChildPluginFunction::is_couple()) {
} else {
    function custom_head_css()
    {
        // Output your custom CSS within <style> tags
        echo '<style>
        .favorite {
            display: none !important;
        }
    </style>';
    }
    // Hook the function into the wp_head action
    add_action('wp_head', 'custom_head_css');
}


//Notification when vendor listing added.
function action_wp_mail_content_type()
{
    return "text/html";
}
add_filter('wp_mail_content_type', 'action_wp_mail_content_type');
add_action('transition_post_status', 'send_mails_on_publish', 10, 3);

function send_mails_on_publish($new_status, $old_status, $post)
{

    if ('listing' === get_post_type($post)) {
        if ('pending' === $new_status && 'publish' !== $old_status) {
			//New Listing Submitted
            $admin_email = get_option('admin_email');
            $author_id = get_post_field('post_author', $post); // Get author ID
            $author_name = get_the_author_meta('display_name', $author_id);
            $permalink_admin = get_edit_post_link($post);

            $subject_admin = "New listing from $author_name";
            $body_admin = "New listing from <b>$author_name</b> pending approval. Approved <a href='$permalink_admin'>here</a>";
            // wp_mail($admin_email, $subject_admin, $body_admin);
             $_EMAIL_ARGS_Admin = [
                'vendor_username' => $author_name,
                'permalink_admin' => $permalink_admin,

            ];
            WeddingDir_Email::sending_email(array(

                /**
                 *  1. Setting ID : Email PREFIX_
                 *  -----------------------------
                 */
                'setting_id'        =>      esc_attr('pending-approval-admin'),

                /**
                 *  2. Sending Email ID
                 *  -------------------
                 */
                'sender_email'      =>      sanitize_email($admin_email),

                /**
                 *  3. Email Data Key and Value as Setting Body Have {{...}} all
                 *  ------------------------------------------------------------
                 */
                'email_data'        =>      $_EMAIL_ARGS_Admin

            ));
			
			$title = get_the_title($post);
			$subject_vendor = "You have submitted a new listing";
            $body_vendor = "Listing <b>$title</b> submitted and is awating approval.";
            $user_email = get_the_author_meta('user_email', $author_id);
             $_EMAIL_ARGS = [
                'vendor_username' => $author_name,
                'title' => $title,

            ];

            WeddingDir_Email::sending_email(array(

                /**
                 *  1. Setting ID : Email PREFIX_
                 *  -----------------------------
                 */
                'setting_id'        =>      esc_attr('pending-approval-vendor'),

                /**
                 *  2. Sending Email ID
                 *  -------------------
                 */
                'sender_email'      =>      sanitize_email($user_email),

                /**
                 *  3. Email Data Key and Value as Setting Body Have {{...}} all
                 *  ------------------------------------------------------------
                 */
                'email_data'        =>      $_EMAIL_ARGS

            ));
            // wp_mail($user_email, $subject_vendor, $body_vendor);

        } else if ('publish' === $new_status && 'publish' !== $old_status) {
			//New Listing Approved
			
			$title = get_the_title($post);

            $author_id = get_post_field('post_author', $post); // Get author ID
            $user_email = get_the_author_meta('user_email', $author_id);
			
            $permalink = get_permalink($post);

            /**New Code */
            $current_plan_status = get_user_meta($author_id, 'is_sponsor_plan_status', true);
            $plan_end_date = get_user_meta($author_id, 'is_sponsor_plan_end_date', true);
            $is_sponsor = get_user_meta($author_id, 'is_sponsor', true);
            if ($is_sponsor && $current_plan_status === 'Active' && $plan_end_date > time()) {
                update_post_meta($post->ID, 'listing_badge', 'featured');
            }
            
            $subject = "Listing approved - $title";

            $body = "Your listing <b>$title</b> is now posted. View listing here <a href='$permalink'>here</a>";

 $_EMAIL_ARGS = [
                'vendor_username' => $author_name,
                'title' => $title,
                'link' => $permalink,

            ];
            // wp_mail($user_email, $subject, $body);
            WeddingDir_Email::sending_email(array(

                /**
                 *  1. Setting ID : Email PREFIX_
                 *  -----------------------------
                 */
                'setting_id'        =>      esc_attr('approval-email-vendor'),

                /**
                 *  2. Sending Email ID
                 *  -------------------
                 */
                'sender_email'      =>      sanitize_email($user_email),

                /**
                 *  3. Email Data Key and Value as Setting Body Have {{...}} all
                 *  ------------------------------------------------------------
                 */
                'email_data'        =>      $_EMAIL_ARGS

            ));
		}
    }
    if ('listing-review' === get_post_type($post)) {
        if ('pending' === $new_status && 'publish' !== $old_status) {
        } else if ('publish' === $new_status && 'publish' !== $old_status) {
         $listingId = get_field('listing_id', $post, true);
            $coupleId = get_field('couple_id', $post, true);
            $title = get_the_title($post);
            $user_email = get_post_meta($coupleId, sanitize_key('user_email'), true);
            $author_name = get_the_title($coupleId);
            
            $permalink = get_permalink($listingId);
            $_EMAIL_ARGS = [
                'couple_username' => $author_name,
                'title' => $title,
                'permalink' => $permalink,
            ];

            WeddingDir_Email::sending_email(array(

                /**
                 *  1. Setting ID : Email PREFIX_
                 *  -----------------------------
                 */
                'setting_id'        =>      esc_attr('review-approve'),

                /**
                 *  2. Sending Email ID
                 *  -------------------
                 */
                'sender_email'      =>      sanitize_email($user_email),

                /**
                 *  3. Email Data Key and Value as Setting Body Have {{...}} all
                 *  ------------------------------------------------------------
                 */
                'email_data'        =>      $_EMAIL_ARGS

            ));
        }
    }
}

function handle_subscription_cancel()
{
     if (isset($_GET['cancel_subscription']) && !empty($_GET['cancel_subscription'])) {
        $subscription_id = sanitize_text_field($_GET['cancel_subscription']);
    if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $stripeKey = [
                'public' => get_option('cmp_stripe_public_key', ''),
                'secret' => get_option('cmp_stripe_secret_key', '')
            ];
            \Stripe\Stripe::setApiKey($stripeKey['secret']);

            try {
                $subscription = \Stripe\Subscription::retrieve($subscription_id);
                $subscription->cancel();
                update_user_meta($user_id, 'subscription_id', '');
                update_user_meta($user_id, 'plan_start_date', '');
                update_user_meta($user_id, 'plan_end_date', '');
                update_user_meta($user_id, 'plan_id', '');
                update_user_meta($user_id, 'plan_name', '');
                update_user_meta($user_id, 'price_id', '');
                update_user_meta($user_id, 'plan_status', '');
                 $_SESSION['sub_can_err'] = true;
                $redirectUrl = apply_filters('weddingdir/couple-menu/page-link', esc_attr('couple-dashboard'));
                wp_redirect($redirectUrl);
                
                exit;
            } catch (Exception $e) {
                // wp_redirect(home_url('/subscription-cancel-error'));
                // exit;
            }
        } else {
            // wp_redirect(home_url('/subscription-cancel-error'));
            // exit;
        }
     }
}
add_action('init', 'handle_subscription_cancel');

function handle_vendor_subscription_cancel()
{
     if (isset($_GET['vendor_cancel_subscription']) && !empty($_GET['vendor_cancel_subscription'])) {
        $subscription_id = sanitize_text_field($_GET['vendor_cancel_subscription']);
    if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $stripeKey = [
                'public' => get_option('cmp_stripe_public_key', ''),
                'secret' => get_option('cmp_stripe_secret_key', '')
            ];
            \Stripe\Stripe::setApiKey($stripeKey['secret']);

            try {
                $subscription = \Stripe\Subscription::retrieve($subscription_id);
                $subscription->cancel();
                update_user_meta($user_id, 'subscription_id', '');
                update_user_meta($user_id, 'plan_start_date', '');
                update_user_meta($user_id, 'plan_end_date', '');
                update_user_meta($user_id, 'plan_id', '');
                update_user_meta($user_id, 'plan_name', '');
                update_user_meta($user_id, 'price_id', '');
                update_user_meta($user_id, 'plan_status', '');
                 $_SESSION['sub_can_ven_err'] = true;
                $redirectUrl = apply_filters('weddingdir/vendor-menu/page-link', esc_attr('vendor-pricing'));
                wp_redirect($redirectUrl);
                
                exit;
            } catch (Exception $e) {
                // wp_redirect(home_url('/subscription-cancel-error'));
                // exit;
            }
        } else {
            // wp_redirect(home_url('/subscription-cancel-error'));
            // exit;
        }
     }
}
add_action('init', 'handle_vendor_subscription_cancel');
function is_my_listing_page()
{
    $current_user_id = get_current_user_id();

    if (WeddingDir_Config::is_vendor() && WeddingDir_Config::dashboard_page_set(esc_attr('add-listing'))) {
        if (is_user_plan_valid($current_user_id)) {
            return false;
        }
        return true;
    }
}
function is_user_plan_valid($user_id)
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
if (is_my_listing_page()) {
    $url = apply_filters('weddingdir/vendor-menu/page-link', esc_attr('vendor-pricing'));
    $_SESSION['subscription_error'] = true;
    wp_redirect($url);
    exit;
}
if (isset($_SESSION['sub_can_err']) && $_SESSION['sub_can_err']) {
    unset($_SESSION['sub_can_err']);

    function enqueue_custom_inline_script_error()
    {
        if (!is_admin()) {
            $custom_script = "
            jQuery(document).ready(function ($) {
                // Display alert message on page load
                  weddingdir_alert( {

                                'notice'  :  1,

                                'message' :  'Your subscription has been successfully canceled.'

                            } );
            });
        ";
            wp_add_inline_script('jquery', $custom_script);
        }
    }
    add_action('wp_enqueue_scripts', 'enqueue_custom_inline_script_error');
}
if (isset($_SESSION['sub_can_ven_err']) && $_SESSION['sub_can_ven_err']) {
    unset($_SESSION['sub_can_ven_err']);

    function enqueue_custom_inline_script_error_ven()
    {
        if (!is_admin()) {
            $custom_script = "
            jQuery(document).ready(function ($) {
                // Display alert message on page load
                  weddingdir_alert( {

                                'notice'  :  1,

                                'message' :  'Your subscription has been successfully canceled.'

                            } );
            });
        ";
            wp_add_inline_script('jquery', $custom_script);
        }
    }
    add_action('wp_enqueue_scripts', 'enqueue_custom_inline_script_error_ven');
}
if (isset($_SESSION['subscription_error']) && $_SESSION['subscription_error']) {
    unset($_SESSION['subscription_error']);

    function enqueue_custom_inline_script()
    {
        if (!is_admin()) {
            $custom_script = "
            jQuery(document).ready(function ($) {
                // Display alert message on page load
                  weddingdir_alert( {

                                'notice'  :  0,

                                'message' :  'Please subscribe to a plan to access this page.!'

                            } );
            });
        ";
            wp_add_inline_script('jquery', $custom_script);
        }
    }
    add_action('wp_enqueue_scripts', 'enqueue_custom_inline_script');
}
if (isset($_SESSION['subscription_couple_error']) && $_SESSION['subscription_couple_error']) {
    // print_r($_SESSION);
    // exit;
    
    function enqueue_custom_inline_script()
    {
        if (!is_admin()) {
            $custom_script = "
            jQuery(document).ready(function ($) {
                // Display alert message on page load
                  weddingdir_alert( {

                                'notice'  :  0,

                                'message' :  'Please subscribe to a plan to access this page.!'

                                } );
                                });
                                ";
            wp_add_inline_script('jquery', $custom_script);
        }
    }
    
    add_action('wp_enqueue_scripts', 'enqueue_custom_inline_script');
}

if (isset($_SESSION['login_error']) && $_SESSION['login_error']) {
    // print_r($_SESSION);
    // exit;
    unset($_SESSION['login_error']);
    function enqueue_custom_inline_script()
    {
        if (!is_admin()) {
            $custom_script = "
            jQuery(document).ready(function ($) {
                // Display alert message on page load
                  weddingdir_alert( {

                                'notice'  :  0,

                                'message' :  'Please log in && subscribe to a plan to access this page'

                                } );
                                });
                                ";
            wp_add_inline_script('jquery', $custom_script);
        }
    }

    add_action('wp_enqueue_scripts', 'enqueue_custom_inline_script');
}
function enqueue_custom_styles()
{
    wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array('jquery'), null, true);

    if (ChildPluginFunction::is_vendor()) {
        wp_enqueue_style(
            'package-style',
            get_stylesheet_directory_uri() . '/css/package-style.css',
            array(),
            '1.0',
            'all'
        );
        
    }
     if (is_page('packages-pricing')) {
        wp_enqueue_style(
            'package-style',
            get_stylesheet_directory_uri() . '/css/package-style.css',
            array(),
            '1.0',
            'all'
        );
    }
    if (ChildPluginFunction::is_couple()) {
        wp_enqueue_style(
            'package-style-couple',
            get_stylesheet_directory_uri() . '/css/package-style-couple.css',
            array(),
            '1.0',
            'all'
        );
        
        wp_enqueue_script('cancle-alert',get_stylesheet_directory_uri() .'/js/cancle-alert.js', array('jquery'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');

add_action('woocommerce_customer_reset_password', 'custom_woocommerce_password_reset_redirect');
function custom_woocommerce_password_reset_redirect() {
    $_SESSION['wc_reset_password'] = true;
    wp_safe_redirect(home_url());
    exit;
}

if (isset($_SESSION['wc_reset_password']) && $_SESSION['wc_reset_password']) {
    function enqueue_custom_inline_script_new()
    {
        if (!is_admin()) {
            $custom_script = "
            jQuery(document).ready(function ($) {
                  weddingdir_alert( {

                                'notice'  :  1,

                                'message' :  'Your password has been reset successfully.'

                                } );
                                });
                                ";
            wp_add_inline_script('jquery', $custom_script);
            unset($_SESSION['wc_reset_password']);
        }
        unset($_SESSION['wc_reset_password']);
    }
    unset($_SESSION['wc_reset_password']);

    add_action('wp_enqueue_scripts', 'enqueue_custom_inline_script_new');
}



function custom_dynamic_title($title) {
    if (is_user_logged_in() && is_page('couple-dashboard-2')) { // Check if user is logged in and on the specific page
        $current_user = wp_get_current_user();
        $username = $current_user->user_login;
        $username = ucfirst($username); // Capitalize the first letter of the username
        $title['title'] = $username . ' Dashboard &#8211; Bandhun';
    }
    return $title;
}
add_filter('document_title_parts', 'custom_dynamic_title');
