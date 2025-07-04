<?php
get_header();
?>
<style>
    label.error {
        float: inline-start;
        margin-top: 6px;
    }
</style>
<?php
if (!is_user_logged_in()) {

?>
    <div class="">

        <div class="row g-0">

            <!-- col-md-5 -->
            <div class="col-lg-5 d-none d-lg-block d-xl-block sidebar-img" <?php

                                                                            /**
                                                                             *  Background Image
                                                                             *  ----------------
                                                                             */
                                                                            printf(
                                                                                'style="background: url(%1$s) no-repeat center;background-size: cover;"',

                                                                                esc_url(WeddingDir_Config::placeholder('vendor-login-register-popup'))
                                                                            );

                                                                            ?>>
            </div>
            <!-- / col-md-5 -->

            <!-- col-md-7 -->
            <div class="col-lg-7 col-md-12 col-12">


                <!-- login section -->
                <div class="login-sidebar-pad text-center register-form">

                    <div class="or-text">

                        <?php esc_attr_e('Register Vendor / Supplier Account', 'weddingdir'); ?>

                    </div>

                    <?php $required = esc_attr('required'); ?>


                    <form id="weddingdir_vendor_registration_form" method="post" autocomplete="off" enctype="multipart/form-data">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-sm-2">
                            <input type="hidden" name="save_form" value="1">
                            <?php

                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('input'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_first_name'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_first_name'),

                                'placeholder'   =>      esc_attr__('First Name', 'weddingdir'),

                                'label' =>  esc_attr__('First Name', 'weddingdir'),

                            ]);

                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('input'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_last_name'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_last_name'),

                                'placeholder'   =>      esc_attr__('Last Name', 'weddingdir'),

                                'label' => esc_attr__('Last Name', 'weddingdir'),
                            ]);

                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('input'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_username'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_username'),

                                'placeholder'   =>      esc_attr__('Username', 'weddingdir'),

                                'label'   =>      esc_attr__('Username', 'weddingdir'),

                            ]);

                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('input'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_email'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_email'),

                                'placeholder'   =>      esc_attr__('Email', 'weddingdir'),

                                'label'   =>      esc_attr__('Email', 'weddingdir'),

                                'type'          =>      esc_attr('email')

                            ]);

                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('password'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_password'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_password'),

                                'placeholder'   =>      esc_attr__('Password', 'weddingdir'),

                                'label'   =>      esc_attr__('Password', 'weddingdir'),

                                'type'          =>      esc_attr('password')

                            ]);

                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('input'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_company_name'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_company_name'),

                                'placeholder'   =>      esc_attr__('Business Name', 'weddingdir'),

                                'label'   =>      esc_attr__('Business Name', 'weddingdir'),

                            ]);

                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('input'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_company_address'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_company_address'),

                                'placeholder'   =>      esc_attr__('Business Address', 'weddingdir'),

                                'label'   =>      esc_attr__('Business Address', 'weddingdir'),

                                'required'      =>      false,


                            ]);

                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('input'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_company_website'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_company_website'),

                                'placeholder'   =>      esc_attr__('Website', 'weddingdir'),

                                'label'   =>      esc_attr__('Website', 'weddingdir'),

                                'type'          =>      esc_attr('text'),

                                'required'      =>      false,

                            ]);

                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('input'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_zip_code'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_zip_code'),

                                'placeholder'   =>      esc_attr__('Postcode', 'weddingdir'),

                                'label'   =>      esc_attr__('Postcode', 'weddingdir'),

                                'required'      =>      false,

                            ]);

                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('input'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_contact_number'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_contact_number'),

                                'placeholder'   =>      esc_attr__('Phone Number', 'weddingdir'),

                                'label'   =>      esc_attr__('Phone Number', 'weddingdir'),

                                'type'          =>      esc_attr('tel'),

                                'required'      =>      false,

                            ]);



                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('input'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_instagram'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_instagram'),

                                'placeholder'   =>      esc_attr__('Instagram', 'weddingdir'),

                                'label'   =>      esc_attr__('Instagram', 'weddingdir'),

                                'type'          =>      esc_attr('text'),

                                'required'      =>      false,

                            ]);


                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('select'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_category'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_category'),

                                'required'      =>      false,

                                'label'   =>      esc_attr__('Choose Category', 'weddingdir'),

                                'options'       =>      WeddingDir_Taxonomy::create_select_option(

                                    /**
                                     *  Taxonomy WeddingDir_Form_Fields Values
                                     *  ----------------------
                                     */
                                    WeddingDir_Taxonomy::get_taxonomy_parent('vendor-category'),

                                    /**
                                     *  Placeholder
                                     *  -----------
                                     */
                                    ['0'   =>  esc_attr__('Choose Category', 'weddingdir')],

                                    /**
                                     *  Default select
                                     *  --------------
                                     */
                                    '',

                                    /**
                                     *  Return Value
                                     *  ------------
                                     */
                                    false
                                )
                            ]);



                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('input'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_tik_tok'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_tik_tok'),

                                'placeholder'   =>      esc_attr__('Tik Tok', 'weddingdir'),

                                'label'   =>      esc_attr__('Tik Tok', 'weddingdir'),

                                'type'          =>      esc_attr('text'),

                                'required'      =>      false,

                            ]);


                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('select'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_price_range_max'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_price_range_max'),

                                'required'      =>      false,

                                'label'   =>      esc_attr__('Maximum Price Range', 'weddingdir'),

                                'options' => ChildPluginFunction::create_select_option_price_max(
                                    ['' => esc_attr__('Choose Maximum Price Range', 'weddingdir')],
                                    ''
                                )
                            ]);

                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('input'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_facebook'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_facebook'),

                                'placeholder'   =>      esc_attr__('Facebook', 'weddingdir'),

                                'label'   =>      esc_attr__('Facebook', 'weddingdir'),

                                'type'          =>      esc_attr('text'),

                                'required'      =>      false,

                            ]);


                            echo '<div class="input-currency">';
                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('select'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_price_range_min'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_price_range_min'),

                                'required'      =>      false,

                                'label'   =>      esc_attr__('Minimum Price Range', 'weddingdir'),

                                'options' => ChildPluginFunction::create_select_option_price_min(
                                    ['' => esc_attr__('Choose Minimum Price Range', 'weddingdir')],
                                    ''
                                )
                            ]);
                            echo '</div>';





                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('input'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_x'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_x'),

                                'placeholder'   =>      esc_attr__('X', 'weddingdir'),

                                'label'   =>      esc_attr__('X', 'weddingdir'),

                                'type'          =>      esc_attr('text'),

                                'required'      =>      false,

                            ]);


                            echo '<div class="input-currency">';
                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    =>      esc_attr('input'),

                                'echo'          =>      true,

                                'id'            =>      esc_attr('weddingdir_vendor_register_price_per_hour'),

                                'name'          =>      esc_attr('weddingdir_vendor_register_price_per_hour'),

                                'placeholder'   =>      esc_attr__('Price Per Hour', 'weddingdir'),

                                'label'   =>      esc_attr__('Price Per Hour', 'weddingdir'),

                                'type'          =>      esc_attr('number')

                            ]);
                            echo '</div>';


                            WeddingDir_Form_Fields::call_field_type([

                                'field_type'    => esc_attr('textarea-simple'),

                                'echo'          => true,

                                'id'            => esc_attr('weddingdir_vendor_register_description_about_your_company'),

                                'name'          => esc_attr('weddingdir_vendor_register_description_about_your_company'),

                                'placeholder'   => esc_attr__('Brief description about your company', 'weddingdir'),

                                'label'   => esc_attr__('Brief description about your company', 'weddingdir'),

                            ]);

                            ?>

                            <!-- Privacy and policy -->
                            <div class="col-12 text-start">
                                <?php

                                /**
                                 *  Privacy Policy Note
                                 *  -------------------
                                 */
                                echo    apply_filters('weddingdir/term_and_condition_note', [

                                    'name'          =>      esc_attr__('Sign Up', 'weddingdir')

                                ]);
                                ?>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">

                                <div class="mb-3">

                                    <?php

                                    printf(
                                        '<div class="d-grid">

                                                            <button type="submit" name="%1$s" id="%1$s" class="loader btn btn-default btn-rounded mt-3 btn-block">%2$s</button>

                                                            </div>

                                                            <!-- Security -->%3$s<!-- / Security -->',

                                        /**
                                         *  1. Form Button ID
                                         *  -----------------
                                         */
                                        esc_attr('weddingdir_vendor_register_form_button'),

                                        /**
                                         *  2. Form Button Text
                                         *  -------------------
                                         */
                                        esc_attr__('Sign Up', 'weddingdir'),

                                        /**
                                         *  3. Vendor Registration Form Security
                                         *  ------------------------------------
                                         */
                                        wp_nonce_field('weddingdir_vendor_registration_form_security', 'weddingdir_vendor_registration_form_security', true, false)
                                    );

                                    ?>

                                </div>
                            </div>
                            <!-- / Submit Button -->

                        </div>

                        <?php

                        printf(
                            '%1$s <a class="btn-link-primary" href="javascript:" role="button" data-bs-toggle="modal" data-bs-target="#%2$s" data-bs-dismiss="modal">%3$s</a>',

                            /**
                             *  1. Translation Ready String
                             *  ---------------------------
                             */
                            esc_attr__('Already have an account?', 'weddingdir'),

                            /**
                             *  2. Vendor Login Model ID
                             *  ------------------------
                             */
                            esc_attr(WeddingDir_Config::popup_id('vendor_login')),

                            /**
                             *  3. Translation Ready String
                             *  ---------------------------
                             */
                            esc_attr__('Log in', 'weddingdir')
                        );

                        ?>

                    </form>

                </div>
                <!-- / login section -->


            </div>
        </div>
    </div>
<?php
}

?>
<?php
get_footer();
?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>
<script>
    $(document).ready(function() {
        $('#weddingdir_vendor_registration_form').validate({
            rules: {
                weddingdir_vendor_register_first_name: {
                    required: true,
                },
                weddingdir_vendor_register_last_name: {
                    required: true
                },
                weddingdir_vendor_register_username: {
                    required: true,
                    remote: {
                        url: WEDDINGDIR_AJAX_OBJ.ajaxurl,
                        type: 'post',
                        data: {
                            'action': 'check_username_exists',
                            vendor_username: function() {
                                return $('#weddingdir_vendor_register_username').val();
                            }
                        },
                        dataFilter: function(response) {
                            if (response === 'true') {
                                return 'false';
                            } else {
                                return 'true';
                            }
                        }
                    }
                },
                weddingdir_vendor_register_email: {
                    required: true,
                    email: true,
                    remote: {
                        url: WEDDINGDIR_AJAX_OBJ.ajaxurl,
                        type: 'post',
                        data: {
                            'action': 'check_email_exists',
                            vendor_email_id: function() {
                                return $('#weddingdir_vendor_register_email').val();
                            }
                        },
                        dataFilter: function(response) {
                            if (response === 'true') {
                                return 'false';
                            } else {
                                return 'true';
                            }
                        }
                    }
                },
                weddingdir_vendor_register_password: {
                    required: true
                },
                weddingdir_vendor_register_company_name: {
                    required: true
                },
                weddingdir_vendor_register_company_address: {
                    required: true
                },
                weddingdir_vendor_register_company_website: {
                    required: true
                },
                weddingdir_vendor_register_zip_code: {
                    required: true
                },
                weddingdir_vendor_register_contact_number: {
                    required: true
                }
            },
            messages: {
                weddingdir_vendor_register_first_name: {
                    required: "Please enter your firstname",
                },
                weddingdir_vendor_register_last_name: {
                    required: "Please enter your lastname"
                },
                weddingdir_vendor_register_username: {
                    required: "Please enter your username",
                    remote: "This username is already exits"
                },
                weddingdir_vendor_register_email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address",
                    remote: "This email is already in use"
                },
                weddingdir_vendor_register_password: {
                    required: "Please enter your password",
                },
                weddingdir_vendor_register_company_name: {
                    required: "Please enter your bussiness name",
                },
                weddingdir_vendor_register_company_address: {
                    required: "Please enter your bussiness address",
                },
                weddingdir_vendor_register_zip_code: {
                    required: "Please enter your postcode",
                },
                weddingdir_vendor_register_contact_number: {
                    required: "Please enter your contact number",
                },
            },
            errorElement: "label",
            errorPlacement: function(error, element) {
                error.addClass("text-danger");
                error.insertAfter(element);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {

                $(element).removeClass(errorClass).addClass(validClass);
            },
            submitHandler: function(form) {
                // If the form is valid, this function will be called on form submission
                alert('Form submitted successfully!');
                // You can submit the form via AJAX here if needed
            }
        });
    });
</script> -->
<script>
    jQuery('.input-currency input').keyup(function(event) {
        // skip for arrow keys
        jQuery(this).val(this.value.match(/[0-9.,]*/));

        if (event.which >= 37 && event.which <= 40) {
            event.preventDefault();
        }

        jQuery(this).val(function(index, value) {
            value = value.replace(/,/g, ''); // remove commas from existing input
            return numberWithCommas(value); // add commas back in
        });
    });

    function numberWithCommas(x) {
        var parts = x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    }
</script>