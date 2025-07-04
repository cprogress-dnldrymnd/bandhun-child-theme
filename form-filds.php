<?php
/**
 *  WeddingDir Form Fields
 *  ----------------------
 */
if ( ! class_exists('WeddingDir_Form_Fields_Modified') && class_exists( 'WeddingDir_Config' ) ) {

    /**
     *  WeddingDir Form Fields
     *  ----------------------
     */
    class WeddingDir_Form_Fields_Modified extends WeddingDir_Config {

        /**
         *  Member Variable
         *  ---------------
         */
        private static $instance;

        /**
         *  Initiator
         *  ---------
         */
        public static function get_instance() {

            if ( ! isset ( self::$instance ) ) {

                self::$instance = new self;
            }
            
            return self::$instance;
        }

        /**
         *  Construct
         *  ---------
         */
        public function __construct() {

        }

        /**
         *  Div Start
         *  ---------
         */
        public static function div_start( $args = [] ) {

            if( parent:: _is_array( $args ) && $args[ 'start' ] == true ){

                extract( $args );

                /**
                 *  Row Setup
                 *  ---------
                 */
                
                return  sprintf( '<div class="%1$s" %2$s>',

                            /**
                             *  1. Have Extra Class ?
                             *  ---------------------
                             */
                            ( isset( $class ) && $class !== '' )

                            ?   esc_attr( $class )

                            :   '',

                            /**
                             *  2. Have ID ?
                             *  ------------
                             */
                            ( isset( $id ) && $id !== '' )

                            ?   sprintf( 'id="%1$s"', esc_attr( $id ) )

                            :   ''
                        );
            }
        }

        /**
         *  Div End
         *  -------
         */
        public static function div_end( $args = [] ) {

            if( parent:: _is_array( $args ) && $args[ 'end' ] == true ){

                return  '</div>';
            }
        }

        /**
         *  Row Start
         *  ---------
         */
        public static function row_start( $args = [] ) {

            if( parent:: _is_array( $args ) && $args[ 'start' ] == true ){

                extract( $args );

                /**
                 *  Row Setup
                 *  ---------
                 */
                return  sprintf( '<div class="row %1$s" %2$s>',

                            /**
                             *  1. Have Extra Class ?
                             *  ---------------------
                             */
                            ( isset( $class ) && $class !== '' )

                            ?   esc_attr( $class )

                            :   '',

                            /**
                             *  2. Have ID ?
                             *  ------------
                             */
                            ( isset( $id ) && $id !== '' )

                            ?   sprintf( 'id="%1$s"', esc_attr( $id ) )

                            :   ''
                        );
            }
        }

        /**
         *  Row End
         *  -------
         */
        public static function row_end( $args = [] ) {

            if( parent:: _is_array( $args ) && $args[ 'end' ] == true ){

                return  '</div>';
            }
        }

        /**
         *  Column Start
         *  ------------
         */
        public static function column_start( $args = [] ) {

            if( parent:: _is_array( $args ) && $args[ 'start' ] == true ){

                /**
                 *  Row Setup
                 *  ---------
                 */
                return  sprintf( '<div class="%1$s %2$s" %3$s>',

                            /**
                             *  1. Have ID ?
                             *  ------------
                             */
                            ( isset( $args[ 'grid' ] ) && $args[ 'grid' ] !== '' )

                            ?   self:: grid_setup( $args[ 'grid' ] )

                            :   self:: grid_setup( absint( '12' ) ),

                            /**
                             *  1. Have Extra Class ?
                             *  ---------------------
                             */
                            ( isset( $args[ 'class' ] ) && $args[ 'class' ] !== '' )

                            ?   esc_attr( $args[ 'class' ] )

                            :   '',

                            /**
                             *  3. Have ID ?
                             *  ------------
                             */
                            ( isset( $args[ 'id' ] ) && $args[ 'id' ] !== '' )

                            ?   sprintf( 'id="%1$s"', esc_attr( $args[ 'id' ] ) )

                            :   ''
                        );
            }
        }

        /**
         *  Column End
         *  ----------
         */
        public static function column_end( $args = [] ) {

            if( parent:: _is_array( $args ) && $args[ 'end' ] == true ){

                return  '</div>';
            }
        }

        /**
         *  Grid - Column ( SETUP )
         *  -----------------------
         */
        public static function grid_setup( $args = '' ) {

            if ( $args == absint( '12' ) ) {

                return 'col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12';

            } elseif ( $args == absint( '6') )  {

                return 'col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12';

            } elseif ( $args == absint( '4') )  {

                return 'col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12';

            } else {

                if( parent:: _have_data( $args ) ){

                    return $args;

                }else{

                    return 'col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12';
                }
            }
        }

        /**
         *  Multiple Option
         *  ---------------
         */
        public static function create_multiple_option( $args = [] ){

            if( parent:: _is_array( $args ) ){

                $defaults = array(

                    'div'               =>  [],

                    'row'               =>  [],

                    'column'            =>  [],

                    'id'                =>  '',

                    'class'             =>  '',

                    'name'              =>  '',

                    'options'           =>  [],

                    'echo'              =>  false,

                    'selection_limit'   =>  absint( '0' ),

                    'placeholder'       =>  esc_attr__( 'Select Options', 'weddingdir' ),
                );

                $args   =   wp_parse_args( $args, $defaults );

                extract( $args );

                $data   =   '';

                $data   .=   self:: _div_start_setup( $args );

                /**
                 *  Select Option Setup
                 *  -------------------
                 */
                $data   .=

                sprintf('<div class="mb-3">

                            %3$s

                            <select id="%1$s" name="%2$s" multiple="multiple" data-placeholder="%9$s" 

                                    class="weddingdir-light-multiple-select mb20 %4$s" %10$s %5$s %6$s>

                                    <option></option>

                                    %7$s

                            </select>

                            %8$s

                        </div>',

                    /**
                     *  1. Have ID ?
                     *  ------------
                     */
                    ( isset( $id )  && $id !== '' )

                    ?   esc_attr( $id )

                    :   '',

                    /**
                     *  2. Have Name ?
                     *  --------------
                     */
                    ( isset( $name )  && $name !== '' )

                    ?   esc_attr( $name )

                    :   '',

                    /**
                     *  3. Have Label ?
                     *  ---------------
                     */
                    ( ! empty( $label ) && isset( $label ) && ! empty( $id ) && isset( $id ) )

                    ?   sprintf( '<label class="control-label mb-2" for="%2$s">%1$s</label>',

                            /**
                             *  1. Lable
                             *  --------
                             */
                            esc_attr( $label ),

                            /**
                             *  2. ID
                             *  -----
                             */
                            esc_attr( $id )
                        )

                    :   '',

                    /**
                     *  4. Have Class ?
                     *  ---------------
                     */
                    ( isset( $class ) && $class !== '' ) 

                    ?   esc_attr( $class )

                    :   '',

                    /**
                     *  5. Have Data Taxonomy Option ?
                     *  ------------------------------
                     */
                    ( isset( $data_taxonomy ) && $data_taxonomy !== '' )

                    ?   sprintf( 'data-taxonomy="%1$s"', $data_taxonomy )

                    :   '',

                    /**
                     *  6. Is Required Field ? 
                     *  ----------------------
                     */
                    ( isset( $require ) && $require == true ) 

                    ?   esc_attr( 'required' )

                    :   '',

                    /**
                     *  7. Have Option ?
                     *  ----------------
                     */
                    ( isset( $options ) && $options !== '' )

                    ?   $options

                    :   '',

                    /**
                     *  8. Have Description ?
                     *  ---------------------
                     */
                    ( isset( $description ) && $description !== '' )

                    ?   sprintf( '<small>%1$s</small>', $description )

                    :   '',

                    /**
                     *  9. Have Placeholder ?
                     *  ---------------------
                     */
                    esc_attr( $placeholder ),

                    /**
                     *  10. Selection Limit
                     *  -------------------
                     */
                    $selection_limit >= absint( '1' )

                    ?   sprintf( 'data-selection-limit="%1$s"', absint( $selection_limit ) )

                    :   ''
                );

                $data   .=   self:: _div_end_setup( $args );

                /**
                 *  Is print ?
                 *  ----------
                 */
                if( $echo ){

                    print  $data;

                }else{

                    return  $data;
                }
            }
        }

        /**
         *  Setup Select Option
         *  -------------------
         */
        public static function create_select_option( $args = [] ){

            $defaults = array(

                'div'               =>      [],

                'row'               =>      [],

                'column'            =>      [],

                'id'                =>      '',

                'class'             =>      '',

                'name'              =>      '',

                'options'           =>      '',

                'echo'              =>      false,

                'require'           =>      false,

                'formgroup'         =>      true,

                'layout'            =>      '',

                'label'             =>      '',
            );

            $args   =   wp_parse_args( $args, $defaults );

            extract( $args );

            $data   =   '';

            $data   .=   self:: _div_start_setup( $args );

            /**
             *  Select Option Setup
             *  -------------------
             */
            $data   .=

            sprintf('<div class="mb-3 %10$s">

                        %3$s

                        <select id="%1$s" name="%2$s" %9$s class="mb20 %4$s %11$s" %5$s %6$s>%7$s</select>

                        %8$s

                    </div>',

                /**
                 *  1. Have ID ?
                 *  ------------
                 */
                ( isset( $id )  && $id !== '' )

                ?   esc_attr( $id )

                :   '',

                /**
                 *  2. Have Name ?
                 *  --------------
                 */
                ( isset( $name )  && $name !== '' )

                ?   esc_attr( $name )

                :   '',

                /**
                 *  3. Have Label ?
                 *  ---------------
                 */
                ( ! empty( $label ) && isset( $label ) && ! empty( $id ) && isset( $id ) )

                ?   sprintf( '<label class="control-label mb-2" for="%2$s">%1$s</label>',

                        /**
                         *  1. Lable
                         *  --------
                         */
                        esc_attr( $label ),

                        /**
                         *  2. ID
                         *  -----
                         */
                        esc_attr( $id )
                    )

                :   '',

                /**
                 *  4. Have Class ?
                 *  ---------------
                 */
                ( isset( $class ) && $class !== '' ) 

                ?   esc_attr( $class )

                :   '',

                /**
                 *  5. Have Data Taxonomy Option ?
                 *  ------------------------------
                 */
                ( isset( $data_taxonomy ) && $data_taxonomy !== '' )

                ?   sprintf( 'data-taxonomy="%1$s"', $data_taxonomy )

                :   '',

                /**
                 *  6. Is Required Field ? 
                 *  ----------------------
                 */
                ( isset( $require ) && $require == true ) 

                ?   esc_attr( 'required' )

                :   '',

                /**
                 *  7. Have Option ?
                 *  ----------------
                 */
                ( isset( $options ) && $options !== '' )

                ?   $options

                :   '',

                /**
                 *  8. Have Description ?
                 *  ---------------------
                 */
                ( isset( $description ) && $description !== '' )

                ?   sprintf( '<small>%1$s</small>', $description )

                :   '',

                /**
                 *  9. Have Placeholder ?
                 *  ---------------------
                 */
                ( isset( $placeholder ) && $placeholder !== '' )

                ?   sprintf( 'data-placeholder="%1$s"', $placeholder )

                :   '',

                /**
                 *  10. Have Form Group ?
                 *  ---------------------
                 */
                isset( $formgroup ) && $formgroup !== ''

                ?   sanitize_html_class( 'formgroup' )

                :   '',

                /**
                 *  11. Layout
                 *  ----------
                 */
                self:: _select_option_layout( $layout )
            );

            $data   .=   self:: _div_end_setup( $args );

            /**
             *  Is print ?
             *  ----------
             */
            if( $echo ){

                print  $data;

            }else{

                return  $data;
            }
        }

        /**
         *  Select Option Layout
         *  --------------------
         */
        public static function _select_option_layout( $layout ){

            /**
             *  Make sure it's not empty!
             *  -------------------------
             */
            if( empty( $layout ) ){

                return;
            }

            elseif( $layout == absint( '1' ) ){

                return      sanitize_html_class( 'weddingdir-dark-select' );
            }

            elseif( $layout == absint( '2' ) ){

                return      sanitize_html_class( 'weddingdir-light-select ' );
            }
        }

        /**
         *  Input Field Start
         *  -----------------
         */
        public static function section_start( $args = [] ) {

            /**
             *  Default Array
             *  -------------
             */
            $defaults       = array(

                'lable'         => '',

                'icon'          => '',
            );

            $args = wp_parse_args( $args, $defaults);

            extract( $args );


            ?><div class="card-shadow"><?php

                /**
                 *  Create Title + Icon Section
                 *  ---------------------------
                 */
                if( isset( $label ) && $label !== '' ){

                    printf('<div class="card-shadow-header p-0 d-flex align-items-center">
                                %1$s <span class="head-simple">%2$s</span>
                            </div>',

                        /**
                         *  1. Section Icon
                         *  ---------------
                         */
                        ( isset( $icon ) && $icon !== '' )

                        ?   sprintf( '<span class="budget-head-icon"> <i class="%1$s"></i></span>',

                                /**
                                 *  1. Icon
                                 *  -------
                                 */
                                esc_attr( $icon )
                            )

                        :   '',

                        /**
                         *  2. Section Title
                         *  ----------------
                         */
                        esc_attr( $label )
                    );
                }

            ?><div class="card-shadow-body p-3"><?php
        }

        /**
         *  Input Field Start
         *  -----------------
         */
        public static function section_end() {

            ?></div></div><?php
        }

        /**
         *  Setup Section
         *  -------------
         */
        public static function setup_section_info( $args = [] ){

            if( parent:: _is_array( $args ) ){

                /**
                 *  Default Array
                 *  -------------
                 */
                $defaults       =   array(

                    'div'           =>  [],

                    'row'           =>  [],

                    'column'        =>  [],

                    'class'       =>   '',

                    'title'       =>   '',

                    'echo'        =>   false,
                );

                $args = wp_parse_args( $args, $defaults );

                extract( $args );

                $data   =   '';

                $data   .=   self:: _div_start_setup( $args );

                $data   .=   

                sprintf( '<div class="todo-subhead %1$s" %2$s><h3>%3$s</h3></div>',

                        /**
                         *  1. Have Extra Class ?
                         *  ---------------------
                         */
                        ( isset( $class ) && $class !== '' ) 

                        ?   esc_attr( $class )

                        :   '',

                        /**
                         *  2. Have ID ?
                         *  ------------
                         */
                        ( isset( $id )  && $id !== '' )

                        ?   sprintf( 'id="%1$s"', esc_attr( $id ) )

                        :   '',

                        /**
                         *  3. Have Title ?
                         *  ---------------
                         */
                        ( isset( $title ) && $title !== '' ) 

                        ?   esc_attr( $title )

                        :   ''
                );

                $data   .=   self:: _div_end_setup( $args );


                if( $echo ){

                    print  $data;

                }else{

                    return  $data;
                }
            }
        }

        /**
         *  Setup Checkbox
         *  --------------
         */
        public static function create_checkbox( $args = [] ){

            $defaults = array(

                'div'       =>  [],

                'row'       =>  [],

                'column'    =>  [],

                'id'            =>  '',

                'class'         =>  '',

                'name'          =>  '',

                'options'       =>  [],

                'selected'      =>  '',

                'echo'          =>  false,
            );

            $args   =   wp_parse_args( $args, $defaults );

            extract( $args );

            $data   =   '';

            $data   .=   self:: _div_start_setup( $args );

            if ( parent:: _is_array( $options ) ) {

                $i = absint('0');

                foreach ( $options as $key => $value ) {    if ( isset( $key ) && $key !== '' ) {

                        $data   .=

                        sprintf(    '<div class="col">

                                        <div class="mb-3">

                                            <input autocomplete="off" %1$s data-value="%2$s" value="%3$s" type="checkbox" name="%4$s"  class="form-check-input" id="%4$s_%5$s" />

                                            <label class="form-check-label" for="%4$s_%5$s">%6$s</label>

                                        </div>

                                    </div>',

                                /**
                                 *  1. Checkbox Checked
                                 *  -------------------
                                 */
                                ( parent:: _is_array( $selected ) && array_key_exists( $key, $selected ) )

                                ?   esc_attr( 'checked' )

                                :   '',

                                /**
                                 *  2. Checkbox Key
                                 *  ---------------
                                 */
                                esc_attr( $key ),

                                /**
                                 *  3. Checkbox Value
                                 *  -----------------
                                 */
                                esc_attr( sanitize_title( $value ) ),

                                /**
                                 *  4. Checkbox Name
                                 *  ----------------
                                 */
                                esc_attr( $name ),

                                /**
                                 *  5. Loop Count
                                 *  -------------
                                 */
                                absint( $i ),

                                /**
                                 *  6. Value
                                 *  --------
                                 */
                                esc_attr( $value )
                        );

                        $i++;

                } } // foreach // if
            }

            $data   .=   self:: _div_end_setup( $args );

            if( $echo ){

                print  $data;

            }else{

                return  $data;
            }
        }

        /**
         *  Profile Image Upload
         *  --------------------
         */
        public static function profile_img_upload( $args = [] ) {

            if( parent:: _is_array( $args ) ){

                /**
                 *  Default Set Parameter
                 *  ---------------------
                 */
                $defaults = array(

                    'div'           =>  [],

                    'row'           =>  [],

                    'column'        =>  [],

                    'class'         =>  '',

                    'btn_lable'     =>  '<i class="fa fa-pencil"></i>',

                    'is_ajax'       =>  false,

                    'post_id'       =>  '',

                    'database_key'  =>  '',

                    'image_size'    =>  esc_attr( 'full' ),

                    'default_img'   =>  '',

                    'echo'          =>  false,
                );

                $args = wp_parse_args( $args, $defaults );

                extract( $args );             

                $data   =   '';

                $data   .=   self:: _div_start_setup( $args );

                $data   .=   

                sprintf(    '<div class="custom-file-wrap">

                                <div class="custom-file-holder">

                                    <img class="rounded-circle w-100" id="img_preview_id_%1$s" src="%6$s">

                                    <div class="custom-file">

                                        <a  href="javascript:" id="button_id_%1$s" class="upload_single_media custom-file-label"

                                            data-ajax-save="%2$s" 

                                            data-post-id="%3$s" 

                                            data-key="%1$s" 

                                            data-media-size="%4$s" 

                                            data-preview="img_preview_id_%1$s" 

                                            data-value-update-text-id="%1$s_media_ids" 

                                        > %5$s</a>

                                        <input autocomplete="off" type="hidden" id="%1$s_media_ids" value="%7$s" />

                                    </div>

                                </div>

                            </div>',

                            /**
                             *  1. Button ID
                             *  ------------
                             */
                            esc_attr( $database_key ),

                            /**
                             *  2. AJAX to update in database ?
                             *  -------------------------------
                             */
                            esc_attr( $is_ajax ),

                            /**
                             *  3. Login User Access Post ID to update media
                             *  --------------------------------------------
                             */
                            ( isset( $post_id ) && $post_id !== '' )

                            ?   absint( $post_id )

                            :   absint( parent:: post_id() ),

                            /**
                             *  4. Image Size
                             *  -------------
                             */
                            esc_attr( $image_size ),

                            /**
                             *  5. Button Text Here
                             *  -------------------
                             */
                            $btn_lable,

                            /**
                             *  6. Image src
                             *  ------------
                             */
                            self:: have_post_id( array(

                                'post_id'           =>  $post_id,

                                'database_key'      =>  $database_key,

                                'image_size'        =>  $image_size,

                                'default_img'       =>  $default_img

                            ) ),

                            /**
                             *  7. Media ID
                             *  -----------
                             */
                            ( empty( $post_id ) )

                            ?   absint( parent:: get_data( sanitize_key( $database_key ) ) )

                            :   get_post_meta( absint( $post_id ), sanitize_key( $database_key ), true ),

                            /**
                             *  8. Extra Class
                             *  --------------
                             */
                            ( isset( $class ) && $class !== '' )

                            ?   esc_attr( $class )

                            :   ''
                );

                $data   .=   self:: _div_end_setup( $args );


                if( $echo ){

                    print   $data;

                }else{

                    return  $data;
                }
            }
        }

        /**
         *  Profile Upload Field
         *  --------------------
         */
        public static function profile_upload_field( $args = [] ) {

            if( parent:: _is_array( $args ) ){

                /**
                 *  Default Set Parameter
                 *  ---------------------
                 */
                $defaults = array(

                    'div'           =>  [],

                    'row'           =>  [],

                    'column'        =>  [],

                    'image_size'    =>  esc_attr( 'thumbnail' ),

                    'media_id'      =>  absint( '0' ),

                    'default_img'   =>  parent:: placeholder( 'couple-bride-image' ),

                    'echo'          =>  false,
                );

                $args = wp_parse_args( $args, $defaults );

                extract( $args );

                $data   =   '';

                $data   .=   self:: _div_start_setup( $args );

                $data   .=   

                sprintf('<div class="custom-file-wrap">

                            <div class="custom-file-holder">

                                <img class="rounded-circle w-100" id="img_preview_id_%1$s" src="%3$s">

                                <div class="custom-file">

                                    <a  href="javascript:" id="button_id_%1$s" class="btn upload_multiple_profile_fields custom-file-label"

                                        data-media-size="%2$s" 

                                        data-event-call="0"

                                        data-preview="img_preview_id_%1$s" 

                                        data-value-update-text-id="%1$s_media_ids" 

                                    ><i class="fa fa-pencil"></i></a>

                                    <input autocomplete="off" type="hidden" class="store_media_ids" id="%1$s_media_ids" value="%4$s" />

                                </div>

                            </div>

                        </div>',

                    /**
                     *  1. Button ID
                     *  ------------
                     */
                    esc_attr( parent:: _rand() ),

                    /**
                     *  2. Image Size
                     *  -------------
                     */
                    esc_attr( $image_size ),

                    /**
                     *  3. Image src
                     *  ------------
                     */
                    parent:: _have_media( $media_id )

                    ?   wp_get_attachment_image_src( $media_id, esc_attr( 'thumbnail' ) )[ absint( '0' ) ]
                    
                    :   esc_url( $default_img ),

                    /**
                     *  4. Media ID
                     *  -----------
                     */
                    parent:: _have_media( $media_id )

                    ?   absint( $media_id )

                    :   absint( '0' )
                );

                $data   .=   self:: _div_end_setup( $args );

                if( $echo ){

                    print   $data;

                }else{

                    return  $data;
                }
            }
        }

        /**
         *  Profile Upload Field
         *  --------------------
         */
        public static function image_upload_field( $args = [] ) {

            if( parent:: _is_array( $args ) ){

                /**
                 *  Default Set Parameter
                 *  ---------------------
                 */
                $defaults = array(

                    'div'           =>  [],

                    'row'           =>  [],

                    'column'        =>  [],

                    'image_size'    =>  esc_attr( 'thumbnail' ),

                    'media_id'      =>  absint( '0' ),

                    'placeholder'   =>  esc_attr( 'couple-bride-image' ),

                    'echo'          =>  false,

                    'frame_heading' =>  '',

                    'frame_button'  =>  '',
                );

                $args = wp_parse_args( $args, $defaults );

                extract( $args );

                $data   =   '';

                $data   .=   self:: _div_start_setup( $args );

                $data   .=   

                sprintf(   '<div class="custom-file-featured">

                                <img class="w-100" id="img_preview_id_%1$s" src="%3$s">

                                <div class="custom-file">

                                    <a  href="javascript:" id="button_id_%1$s" class="btn upload_multiple_profile_fields custom-file-label"

                                        data-media-size="%2$s" 

                                        data-event-call="0"

                                        data-preview="img_preview_id_%1$s" 

                                        data-value-update-text-id="%1$s_media_ids" 

                                        %5$s

                                        %6$s

                                    ><i class="fa fa-pencil"></i></a>

                                    <input autocomplete="off" type="hidden" class="store_media_ids" id="%1$s_media_ids" value="%4$s" />

                                </div>

                            </div>', 

                            /**
                             *  1. Button ID
                             *  ------------
                             */
                            esc_attr( parent:: _rand() ),

                            /**
                             *  2. Image Size
                             *  -------------
                             */
                            esc_attr( $image_size ),

                            /**
                             *  3. Image src
                             *  ------------
                             */
                            parent:: _have_media( $media_id )

                            ?   wp_get_attachment_image_src( $media_id, esc_attr( $image_size ) )[ absint( '0' ) ]
                            
                            :   parent:: placeholder( $placeholder ),

                            /**
                             *  4. Media ID
                             *  -----------
                             */
                            parent:: _have_media( $media_id )

                            ?   absint( $media_id )

                            :   absint( '0' ),

                            /**
                             *  5. Have Media Header ?
                             *  ----------------------
                             */
                            parent:: _have_data( $frame_heading )

                            ?   sprintf( 'data-media-frame-heading="%1$s"', $frame_heading )

                            :   '',
                            
                            /**
                             *  6. Have Media Button ?
                             *  ----------------------
                             */
                            parent:: _have_data( $frame_button )

                            ?   sprintf( 'data-media-frame-btn-text="%1$s"', $frame_button )

                            :   ''
                );

                $data   .=   self:: _div_end_setup( $args );

                if( $echo ){

                    print   $data;

                }else{

                    return  $data;
                }
            }
        }

        /**
         *  PDF File Upload Field
         *  ---------------------
         */
        public static function pdf_upload_field( $args = [] ) {

            if( parent:: _is_array( $args ) ){

                /**
                 *  Default Set Parameter
                 *  ---------------------
                 */
                $defaults = array(

                    'div'                   =>  [],

                    'row'                   =>  [],

                    'column'                =>  [],

                    'echo'                  =>  false,

                    'menu_file'             =>  absint( '0' ),

                    'media_frame_heading'   =>  esc_attr__( 'Upload PDF File', 'weddingdir' ),

                    'media_frame_button'    =>  esc_attr__( 'Select File', 'weddingdir' ),
                );

                $args = wp_parse_args( $args, $defaults );

                extract( $args );

                $data   =   '';

                $data   .=   self:: _div_start_setup( $args );

                $data   .=   

                sprintf('<div class="card upload-menu-file-section">

                            <div class="card-body text-center pt-4">

                                <a  href="javascript:" id="button_id_%1$s" class="btn upload-multiple-pdf-file upload-menu-file"

                                    data-file-id="file_id_%1$s" 

                                    data-file-name="file_name_%1$s"

                                    data-media-frame-btn-text="%4$s"

                                    data-event-call="0"

                                    data-media-frame-heading="%5$s"

                                ><i class="fa fa-pencil"></i></a>

                                <i class="fa fa-4x fa-file-pdf-o text-danger"></i>

                            </div>

                            <div class="card-footer text-center">

                                <span class="document-name" id="file_name_%1$s">%2$s</span> 

                                <input autocomplete="off" type="hidden" id="file_id_%1$s" class="pdf-file menu_file" value="%3$s" />

                            </div>

                        </div>',

                    /**
                     *  1. Button ID
                     *  ------------
                     */
                    esc_attr( parent:: _rand() ),

                    /**
                     *  2. Translation Ready String
                     *  ---------------------------
                     */
                    parent:: _have_data( $menu_file ) && parent:: _have_media( $menu_file )

                    ?   basename( get_attached_file( $menu_file ) )

                    :   esc_attr__( 'Upload File..', 'weddingdir' ),

                    /**
                     *  3. Media ID
                     *  -----------
                     */
                    absint( $menu_file ),

                    /**
                     *  4. Media Frame Heading
                     *  ----------------------
                     */
                    esc_attr( $media_frame_heading ),

                    /**
                     *  5. Media Frame Button Text
                     *  --------------------------
                     */
                    esc_attr( $media_frame_button )
                );

                $data   .=   self:: _div_end_setup( $args );

                if( $echo ){

                    print   $data;

                }else{

                    return  $data;
                }
            }
        }

        /**
         *  Multiple Gallery Upload Field
         *  -----------------------------
         */
        public static function gallery_upload_field( $args = [] ) {

            if( parent:: _is_array( $args ) ){

                /**
                 *  Default Set Parameter
                 *  ---------------------
                 */
                $defaults = array(

                    'div'                   =>  [],

                    'row'                   =>  [],

                    'column'                =>  [],

                    'media_ids'             =>  '',

                    'button_text'           =>  esc_attr__( 'Upload Gallery', 'weddingdir' ),

                    'media_frame_heading'   =>  esc_attr__( 'Upload Images', 'weddingdir' ),

                    'media_frame_button'    =>  esc_attr__( 'Select Gallery', 'weddingdir' ),

                    'echo'                  =>  false,

                    'icon'                  =>  ''
                );

                $args = wp_parse_args( $args, $defaults );

                extract( $args );

                $data   =   '';

                $data   .=   self:: _div_start_setup( $args );

                $data   .=   

                sprintf(   '<div class="col-md-12">

                                <div id="preview_media_%1$s" class="row row-cols-lg-5 row-cols-sm-3 row-cols-2">%2$s</div>

                                <input autocomplete="off" type="hidden" class="store_media_ids" id="store_media_id_%1$s" value="%3$s" />

                                <a  href="javascript:" 

                                    id="media_id_%1$s" 

                                    class="me-1 btn btn-primary upload_multiple_gallery_fields" 

                                    data-preview="preview_media_%1$s" 

                                    data-event-call="0"

                                    data-media-frame-heading="%5$s"

                                    data-media-frame-btn-text="%6$s"

                                    data-media-ids="store_media_id_%1$s">%7$s %4$s</a>

                            </div>',

                            /**
                             *  1. ID
                             *  -----
                             */
                            esc_attr( parent:: _rand() ),

                            /**
                             *  2. Have File Name ?
                             *  -------------------
                             */
                            parent:: _have_data( $media_ids )

                            ?   self:: gallery_thumb( $media_ids )

                            :   '',

                            /**
                             *  3. Have Gallery ?
                             *  -----------------
                             */
                            parent:: _have_data( $media_ids )

                            ?   esc_attr( $media_ids )

                            :   '',

                            /**
                             *  4. Translation Ready String
                             *  ---------------------------
                             */
                            esc_attr( $button_text ),

                            /**
                             *  5. Media Frame Heading
                             *  ----------------------
                             */
                            esc_attr( $media_frame_heading ),

                            /**
                             *  6. Media Frame Button Text
                             *  --------------------------
                             */
                            esc_attr( $media_frame_button ),

                            /**
                             *  7. Have icon ?
                             *  --------------
                             */
                            ! empty( $icon )

                            ?   $icon

                            :   ''
                );

                $data   .=   self:: _div_end_setup( $args );

                if( $echo ){

                    print   $data;

                }else{

                    return  $data;
                }
            }
        }

        /**
         *  Single Media Upload + Preview Image ID Not included in this function ( you can custom create it )
         *  -------------------------------------------------------------------------------------------------
         */
        public static function img_upload_button( $args = [] ) {

            if( parent:: _is_array( $args ) ){

                /**
                 *  Default Set Parameter
                 *  ---------------------
                 */
                $defaults = array(

                    'div'           =>  [],

                    'row'           =>  [],

                    'column'        =>  [],

                    'class'         =>  sanitize_html_class( 'btn-outline-white' ),

                    'btn_lable'     =>  esc_attr__( 'Photo', 'weddingdir' ),

                    'is_ajax'       =>  true,

                    'post_id'       =>  '',

                    'database_key'  =>  '',

                    'image_size'    =>  esc_attr( 'full' ),

                    'echo'          =>  false
                );

                $args = wp_parse_args( $args, $defaults );

                extract( $args );

                $data   =   '';

                $data   .=   self:: _div_start_setup( $args );

                $data   .=   

                sprintf('<a  href="javascript:" id="button_id_%1$s" class="btn %7$s upload_single_media" 

                            data-ajax-save="%2$s" 

                            data-post-id="%3$s" 

                            data-key="%1$s" 

                            data-media-size="%4$s" 

                            data-preview="img_preview_id_%1$s" 

                            data-value-update-text-id="%1$s_media_ids" 

                        > %5$s</a>

                        <input autocomplete="off" type="hidden" id="%1$s_media_ids" value="%6$s" />',

                    /**
                     *  1. Button ID
                     *  ------------
                     */
                    esc_attr( $database_key ),

                    /**
                     *  2. AJAX to update in database ?
                     *  -------------------------------
                     */
                    esc_attr( $is_ajax ),

                    /**
                     *  3. Login User Access Post ID to update media
                     *  --------------------------------------------
                     */
                    ( isset( $post_id ) && $post_id !== '' )

                    ?   absint( $post_id )

                    :   absint( parent:: post_id() ),

                    /**
                     *  4. Image Size
                     *  -------------
                     */
                    esc_attr( $image_size ),

                    /**
                     *  5. Button Text Here
                     *  -------------------
                     */
                    $btn_lable,

                    /**
                     *  6. Media ID
                     *  -----------
                     */
                    ( empty( $post_id ) )

                    ?   absint( parent:: get_data( sanitize_key( $database_key ) ) )

                    :   get_post_meta( absint( $post_id ), sanitize_key( $database_key ), true ),

                    /**
                     *  7. Extra Class
                     *  --------------
                     */
                    ( isset( $class ) && $class !== '' )

                    ?   esc_attr( $class )

                    :   ''
                );

                $data   .=   self:: _div_end_setup( $args );

                if( $echo ){

                    print   $data;

                }else{

                    return  $data;
                }
            }
        }

        /**
         *  Single Media Upload
         *  -------------------
         */
        public static function single_img_upload( $args = [] ) {

            if( parent:: _is_array( $args ) ){

                /**
                 *  Default Set Parameter
                 *  ---------------------
                 */
                $defaults = array(

                    'div'           =>  [],

                    'row'           =>  [],

                    'column'        =>  [],                    

                    'class'         =>  sanitize_html_class( 'btn-primary' ),

                    'btn_lable'     =>  '<i class="fa fa-pencil"></i>',

                    'is_ajax'       =>  "false",

                    'post_id'       =>  '',

                    'database_key'  =>  '',

                    'image_size'    =>  esc_attr( 'full' ),

                    'default_img'   =>  esc_url( parent:: placeholder( 'listing-banner' ) ),

                    'echo'          =>  false
                );

                $args = wp_parse_args( $args, $defaults );

                extract( $args );

                $data   =   '';

                $data   .=   self:: _div_start_setup( $args );

                $data   .=   

                sprintf('<div class="custom-file-featured">

                                <img class="w-100" id="img_preview_id_%1$s" src="%6$s">

                                <div class="custom-file">

                                    <a  href="javascript:" id="button_id_%1$s" class="upload_single_media custom-file-label"

                                        data-ajax-save="%2$s" 

                                        data-post-id="%3$s" 

                                        data-key="%1$s" 

                                        data-media-size="%4$s" 

                                        data-preview="img_preview_id_%1$s" 

                                        data-value-update-text-id="%1$s_media_ids" 

                                    > %5$s</a>

                                    <input autocomplete="off" type="hidden" id="%1$s_media_ids" value="%7$s" />

                                </div>

                        </div>',

                    /**
                     *  1. Button ID
                     *  ------------
                     */
                    esc_attr( $database_key ),

                    /**
                     *  2. AJAX to update in database ?
                     *  -------------------------------
                     */
                    esc_attr( $is_ajax ),

                    /**
                     *  3. Login User Access Post ID to update media
                     *  --------------------------------------------
                     */
                    ( isset( $post_id ) && $post_id !== '' )

                    ?   absint( $post_id )

                    :   absint( parent:: post_id() ),

                    /**
                     *  4. Image Size
                     *  -------------
                     */
                    esc_attr( $image_size ),

                    /**
                     *  5. Button Text Here
                     *  -------------------
                     */
                    $btn_lable,

                    /**
                     *  6. Image src
                     *  ------------
                     */
                    self:: have_post_id( array(

                        'post_id'           =>  $post_id,

                        'database_key'      =>  $database_key,

                        'image_size'        =>  $image_size,

                        'default_img'       =>  $default_img

                    ) ),

                    /**
                     *  7. Media ID
                     *  -----------
                     */
                    ( empty( $post_id ) )

                    ?   absint( parent:: get_data( sanitize_key( $database_key ) ) )

                    :   get_post_meta( absint( $post_id ), sanitize_key( $database_key ), true ),

                    /**
                     *  8. Extra Class
                     *  --------------
                     */
                    ( isset( $class ) && $class !== '' )

                    ?   esc_attr( $class )

                    :   ''
                );

                $data   .=   self:: _div_end_setup( $args );

                if( $echo ){

                    print   $data;

                }else{

                    return  $data;
                }
            }
        }

        /**
         *  Have Post ID ?
         *  --------------
         */
        public static function have_post_id( $args = [] ){

            if( parent:: _is_array( $args ) ){

                extract( $args );

                /** 
                 *  If Post ID Not Set so current user own post id set by default
                 *  -------------------------------------------------------------
                 */
                if( empty( $post_id ) ){

                    if( parent:: get_data( esc_attr( $database_key ) ) && parent:: get_data( esc_attr( $database_key ) ) !== '' ){

                        $media_object   =   wp_get_attachment_image_src(

                                                parent:: get_data( esc_attr( $database_key ) ),

                                                esc_attr( $image_size )
                                            );

                        if( parent:: _is_array( $media_object ) && isset( $media_object[ 0 ] ) ){

                            return  esc_url( $media_object[ 0 ] );

                        }else{

                            return esc_url( $default_img );
                        }

                    }else{

                        return esc_url( $default_img );
                    }

                }else{

                    /**
                     *  If Post id set that mean : one of post id get get data
                     *  ------------------------------------------------------
                     */

                    if( get_post_meta( absint( $post_id ), sanitize_key( $database_key ), true ) ){

                        return  esc_url( wp_get_attachment_image_src(

                                    // 1
                                    get_post_meta( absint( $post_id ), sanitize_key( $database_key ), true ),

                                    // 2
                                    esc_attr( $image_size )

                                )[0] );

                    }else{

                        return esc_url( $default_img );
                    }
                }
            }

            /**
             *  Sec : Condition [ IF YOU WISH  ]
             *  --------------------------------
             *  If Post ID Not Set so current user own post id set by default
             *  -------------------------------------------------------------
             */
            if( empty( $post_id ) ){

                $media_id   =   absint( parent:: get_data( sanitize_key( $database_key ) ) );

            }else{

                $media_id   =   absint( get_post_meta( absint( $post_id ), sanitize_key( $database_key ), true ) );
            }

            /**
             *  1. Couple Dashboard Banner
             *  --------------------------
             */
            parent:: _have_media( $media_id )

            ?   apply_filters( 'weddingdir/media-data', [

                    'media_id'         =>  absint( $media_id ),

                    'image_size'       =>  esc_attr( $image_size ),
                ] )

            :   esc_url( $default_img );
        }

        /**
         *  WeddingDir Gallery
         *  -------------------
         */
        public static function gallery_img_upload( $args = [] ) {

            /**
             *  Default Set Parameter
             *  ---------------------
             */
            $defaults = array(

                'div'           =>  [],

                'row'           =>  [],

                'column'        =>  [],

                'class'         =>  sanitize_html_class( 'btn-primary' ),

                'btn_lable'     =>  esc_attr__('Upload Image', 'weddingdir'),

                'is_ajax'       =>  false,

                'post_id'       =>  '',

                'database_key'  =>  '',

                'image_size'    =>  esc_attr( 'thumbnail' ),

                'img_class'     =>  '',

                'placeholder'   =>  esc_url( parent:: placeholder( 'listing-gallery' ) ),

                'echo'          =>  false,
            );

            $args = wp_parse_args( $args, $defaults );

            extract( $args );

            $data   =   '';

            $data   .=   self:: _div_start_setup( $args );

            $data   .=   

            sprintf('<div class="">

                            <div class="row" 

                                id="image_preview_id_%1$s" 

                                data-ajax-save="%2$s" 

                                data-post-id="%3$s" 

                                data-key="%1$s" 

                                data-value-update-text-id="%1$s_media_ids">%7$s</div>

                            <a href="javascript:" id="button_id_%1$s" class="btn %8$s upload_multi_media"

                            data-ajax-save="%2$s" 

                            data-post-id="%3$s" 

                            data-key="%1$s" 

                            data-media-size="%4$s" 

                            data-preview="image_preview_id_%1$s" 

                            data-value-update-text-id="%1$s_media_ids" 

                            >%5$s</a>

                            <input autocomplete="off" type="hidden" id="%1$s_media_ids" value="%6$s" />

                    </div>',

                /**
                 *  1. Button ID
                 *  ------------
                 */
                esc_attr( $database_key ),

                /**
                 *  2. AJAX to update in database ?
                 *  -------------------------------
                 */
                esc_attr( $is_ajax ),

                /**
                 *  3. Login User Access Post ID to update media
                 *  --------------------------------------------
                 */
                ( isset( $post_id ) && $post_id !== '' )

                ?   absint( $post_id )

                :   absint( parent:: post_id() ),

                /**
                 *  4. Image Size
                 *  -------------
                 */
                esc_attr( $image_size ),

                /**
                 *  5. Button Text Here
                 *  -------------------
                 */
                $btn_lable,

                /**
                 *  6. Image ID
                 *  -----------
                 */
                ( empty( $post_id ) )

                ?   parent:: get_data( sanitize_key( $database_key ) )

                :   get_post_meta( absint( $post_id ), sanitize_key( $database_key ), true ),

                /**
                 *  7. Get Gallery Images
                 *  ----------------------
                 */
                self:: gallery_thumb( 

                    /**
                     *  Have Post ID ?
                     *  --------------
                     */
                    ( empty( $post_id ) )

                    ?   parent:: get_data( sanitize_key( $database_key ) )

                    :   get_post_meta( absint( $post_id ), sanitize_key( $database_key ), true ),

                    /**
                     *  Store IDs
                     *  ---------
                     */
                    sprintf( '%1$s_media_ids', 

                        // 1
                        esc_attr( $database_key )
                    ),

                    /**
                     *  3. Placeholder
                     *  --------------
                     */
                    $placeholder
                ),

                /**
                 *  8. Get Class
                 *  -------------
                 */
                ( isset( $class ) && $class !== '' )

                ?   esc_attr( $class )

                :   ''
            );

            $data   .=   self:: _div_end_setup( $args );

            if( $echo ){

                print   $data;

            }else{

                return  $data;
            }
        }

        /**
         *   Get Field Type to Call Back Function
         *   ------------------------------------
         */
        public static function call_field_type( $args = [] ){

            if( parent:: _is_array( $args ) ){

                extract( $args );

                /**
                 *  Call back function
                 *  ------------------
                 */
                if( $field_type == 'input' ){

                    return  self:: create_input_field( $args );

                }elseif( $field_type == 'input_group' ){

                    return  self:: create_input_group_field( $args );

                }elseif( $field_type == 'select' ){

                    return  self:: create_select_option( $args );

                }elseif( $field_type == 'multiple' ){

                    return  self:: create_multiple_option( $args );

                }elseif( $field_type == 'info' ){

                    return  self:: setup_section_info( $args );

                }elseif( $field_type == 'checkbox' ){

                    return  self:: create_checkbox( $args );

                }elseif( $field_type == 'textarea' ){

                    return  self:: create_textarea( $args );

                }elseif( $field_type == 'textarea-simple' ){

                    return  self:: create_textarea_simple( $args );
                    
                }elseif( $field_type == 'single_img_upload' ){

                    return  self:: single_img_upload( $args );

                }elseif( $field_type == 'profile_img_upload' ){

                    return  self:: profile_img_upload( $args );

                }elseif( $field_type == 'gallery_img_upload' ){

                    return  self:: gallery_img_upload( $args );

                }elseif( $field_type == 'weddingdir_map' ){

                    return  self:: weddingdir_map( $args );

                }elseif( $field_type == 'password' ){

                    return  self:: create_password_field( $args );

                }elseif( $field_type == 'select-location' ){

                    return  self:: create_location_field( $args );
                }
            }
        }

        /**
         *  Create Section
         *  --------------
         */
        public static function create_section( $args = [] ) {

            if( parent:: _is_array( $args ) ){

                /**
                 *  Default Attributes
                 *  ------------------
                 */
                $defaults   = array(

                    'div'       =>  [],

                    'row'       =>  [],

                    'column'    =>  [],

                    'field'     =>  [],
                );

                $args   =   wp_parse_args( $args, $defaults );

                extract( $args );

                $data   =   '';

                $data   .=   self:: _div_start_setup( $args );

                /**
                 *  Setup Select Option
                 *  -------------------
                 */
                if ( parent:: _is_array( $field ) ){

                    $data     .=   self:: call_field_type( $field );
                }

                $data   .=   self:: _div_end_setup( $args );

                /**
                 *  Print Data ?
                 *  ------------
                 */
                print  $data;
            }
        }

        /**
         *  Setup Input Field
         *  -----------------
         */
        public static function create_input_field( $args = [] ) {

            /**
             *  Default Args
             *  ------------
             */
            $defaults       =   array(

                'div'           =>  [],

                'row'           =>  [],

                'column'        =>  [],

                'name'          =>  '',

                'lable'         =>  '',

                'placeholder'   =>  '',

                'require'       =>  false,

                'value'         =>  '',

                'class'         =>  '',

                'type'          =>  esc_attr( 'text' ),

                'disable'       =>  false,

                'formgroup'     =>  true,

                'echo'          =>  false,

                'limit'         =>  '',

                'attr'          =>  ''
            );

            /**
             *  Merge Args
             *  ----------
             */
            $args = wp_parse_args( $args, $defaults);

            extract( $args );

            /**
             *  Create Field
             *  ------------
             */
            $data   =   '';

            $data   .=   self:: _div_start_setup( $args );
            

            $data   .=   

            sprintf('<div class="%11$s">
                            <label class="control-label mb-2" for="%2$s">%14$s</label>
                        %2$s

                        <input autocomplete="off" id="%1$s" name="%3$s" value="%4$s" type="%5$s" placeholder="%6$s" 
                                class="form-control input-md %7$s %10$s" %8$s %9$s %12$s %13$s>

                    </div>',

                /**
                 *  1. Input ID
                 *  -----------
                 */
                ( ! empty( $id ) && isset( $id ) )

                ?   esc_attr( $id )

                :   '',

                /**
                 *  2. Input Label
                 *  --------------
                 */
                ( ! empty( $label ) && isset( $label ) && ! empty( $id ) && isset( $id ) )

                ?   sprintf( '<label class="control-label mb-2" for="%2$s">%1$s</label>',

                        /**
                         *  1. Lable
                         *  --------
                         */
                        esc_attr( $label ),

                        /**
                         *  2. ID
                         *  -----
                         */
                        esc_attr( $id )
                    )

                :   '',

                /**
                 *  3. Input Name
                 *  -------------
                 */
                ( ! empty( $name ) && isset( $name ) )

                ?   esc_attr( $name )

                :   '',

                /**
                 *  4. Input Value
                 *  --------------
                 */
                ( ! empty( $value ) && isset( $value ) )

                ?   esc_attr( $value )

                :   '',

                /**
                 *  5. Input Value
                 *  --------------
                 */
                !   empty( $type )

                ?   esc_attr( $type )

                :   esc_attr( 'text' ),

                /**
                 *  6. Input Placeholder
                 *  --------------------
                 */
                ( ! empty( $placeholder ) && isset( $placeholder ) )

                ?   esc_attr( $placeholder )

                :   '',

                /**
                 *  7. Input Field Class
                 *  --------------------
                 */
                ( ! empty( $class ) && isset( $class ) )

                ?   esc_attr( $class )

                :   '',

                /**
                 *  8. Input Field Requird ?
                 *  ------------------------
                 */
                ( $require == true && isset( $require ) )

                ?   esc_attr( 'required' )

                :   '',

                /**
                 *  9. Is Disable ?
                 *  ------------
                 */
                ( isset( $disable ) && $disable == true )

                ?   esc_attr( 'disabled' )

                :   '',

                /**
                 *  10 If is datepicker update unique class
                 *  ---------------------------------------
                 */
                $type == esc_attr( 'date' )

                ?   sanitize_html_class( 'weddingdir_datepicker' )

                :   '',

                /**
                 *  11. Have From Group Class
                 *  -------------------------
                 */
                ( isset( $formgroup ) && $formgroup == true )

                ?   sanitize_html_class( 'mb-3' )

                :   '',

                /**
                 *  12. Have From Group Class
                 *  -------------------------
                 */
                ( isset( $limit ) && parent:: _have_data( $limit ) )

                ?   sprintf( 'maxlength="%1$s"', absint( $limit ) )

                :   '',

                /**
                 *  13. Have Extra Attr
                 *  -------------------
                 */
                ! empty( $attr )

                ?   $attr

                :   '',
                 /**
                 *  14. Heading Lable
                 *  --------------------
                 */
                ( ! empty( $headingLable ) && isset( $headingLable ) )

                ?   esc_attr( $headingLable )

                :   ''
            );

            $data   .=   self:: _div_end_setup( $args );

            if( $echo ){

                print   $data;

            }else{

                return  $data;
            }
        }

        /**
         *  Setup Input Field
         *  -----------------
         */
        public static function create_input_group_field( $args = [] ) {

            /**
             *  Default Args
             *  ------------
             */
            $defaults       =   array(

                'div'           =>  [],

                'row'           =>  [],

                'column'        =>  [],

                'name'          =>  '',

                'lable'         =>  '',

                'placeholder'   =>  '',

                'require'       =>  false,

                'value'         =>  '',

                'class'         =>  '',

                'type'          =>  esc_attr( 'text' ),

                'disable'       =>  false,

                'formgroup'     =>  true,

                'echo'          =>  false,

                'limit'         =>  '',

                'before_input'  =>  '',

                'after_input'   =>  ''
            );

            /**
             *  Merge Args
             *  ----------
             */
            $args = wp_parse_args( $args, $defaults); 

            extract( $args );

            /**
             *  Create Field
             *  ------------
             */
            $data   =   '';

            $data   .=   self:: _div_start_setup( $args );

            $data   .=   

            sprintf('<div class="%11$s">

                        %2$s

                        <input autocomplete="off" id="%1$s" name="%3$s" value="%4$s" type="%5$s" placeholder="%6$s" 
                                class="form-control input-md %7$s %10$s" %8$s %9$s %12$s>

                        %13$s

                    </div>',

                /**
                 *  1. Input ID
                 *  -----------
                 */
                ( ! empty( $id ) && isset( $id ) )

                ?   esc_attr( $id )

                :   '',

                /**
                 *  2. Input Label
                 *  --------------
                 */
                !   empty( $before_input )

                ?   $before_input

                :   '',

                /**
                 *  3. Input Name
                 *  -------------
                 */
                ( ! empty( $name ) && isset( $name ) )

                ?   esc_attr( $name )

                :   '',

                /**
                 *  4. Input Value
                 *  --------------
                 */
                ( ! empty( $value ) && isset( $value ) )

                ?   esc_attr( $value )

                :   '',

                /**
                 *  5. Input Value
                 *  --------------
                 */
                parent:: _have_data( $type ) && $type !== esc_attr( 'date' )

                ?   esc_attr( $type )

                :   esc_attr( 'text' ),

                /**
                 *  6. Input Placeholder
                 *  --------------------
                 */
                ( ! empty( $placeholder ) && isset( $placeholder ) )

                ?   esc_attr( $placeholder )

                :   '',

                /**
                 *  7. Input Field Class
                 *  --------------------
                 */
                ( ! empty( $class ) && isset( $class ) )

                ?   esc_attr( $class )

                :   '',

                /**
                 *  8. Input Field Requird ?
                 *  ------------------------
                 */
                ( $require == true && isset( $require ) )

                ?   esc_attr( 'required' )

                :   '',

                /**
                 *  9. Is Disable ?
                 *  ------------
                 */
                ( isset( $disable ) && $disable == true )

                ?   esc_attr( 'disabled' )

                :   '',

                /**
                 *  10 If is datepicker update unique class
                 *  ---------------------------------------
                 */
                $type == esc_attr( 'date' )

                ?   sanitize_html_class( 'weddingdir_datepicker' )

                :   '',

                /**
                 *  11. Have From Group Class
                 *  -------------------------
                 */
                apply_filters( 'weddingdir/class', explode( ' ', 'input-group mb-3' ) ),

                /**
                 *  12. Have From Group Class
                 *  -------------------------
                 */
                ( isset( $limit ) && parent:: _have_data( $limit ) )

                ?   sprintf( 'maxlength="%1$s"', absint( $limit ) )

                :   '',

                /**
                 *  13. Input Label
                 *  ---------------
                 */
                !   empty( $after_input )

                ?   $after_input

                :   ''
            );

            $data   .=   self:: _div_end_setup( $args );

            if( $echo ){

                print   $data;

            }else{

                return  $data;
            }
        }

        /**
         *  Simple Textarea
         *  ---------------
         */
        public static function create_textarea_simple( $args = [] ) {

            $defaults = array(

                'div'           =>  [],

                'row'           =>  [],

                'column'        =>  [],

                'name'          =>  '',

                'id'            =>  '',

                'lable'         =>  '',

                'placeholder'   =>  '',

                'require'       =>  false,

                'value'         =>  '',

                'class'         =>  '',

                'description'   =>  '',

                'limit'         =>  '',

                'rows'          =>  absint( '6' ),

                'echo'          =>  false,

                'formgroup'     =>  true
            );

            $args = wp_parse_args( $args, $defaults );

            extract( $args );

            $data   =   '';

            $data   .=   self:: _div_start_setup( $args );

            $data   .=   

            sprintf('<div class="%13$s">

                        %2$s %7$s

                        <textarea class="%5$s form-control %9$s" id="%1$s" %10$s name="%8$s" rows="%12$s" placeholder="%4$s" %6$s>%3$s</textarea>

                        %11$s

                    </div>',

                /**
                 *  1. Have ID ?
                 *  ------------
                 */
                ( isset( $id ) && $id !== '' )

                ?   $id

                :   '',

                /**
                 *  2. Have Label ?
                 *  ---------------
                 */
                ( isset( $label ) && $label !== '' && isset( $id ) && $id !== '' )

                ?   sprintf('<label class="control-label mb-2" for="%2$s">%1$s</label>', esc_attr($label), esc_attr($id) )

                :   '',

                /**
                 *  3. Have Value ?
                 *  ---------------
                 */
                ( isset( $value ) && $value !== '' )

                ?   $value

                :   '',

                /**
                 *  4. Have Placeholder ?
                 *  ---------------------
                 */
                ( isset( $placeholder ) && $placeholder !== '' )

                ?   $placeholder

                :   '',

                /**
                 *  5. Have Class ?
                 *  ---------------
                 */
                ( isset( $class ) && $class !== '' )

                ?   $class

                :   '',

                /**
                 *  6. Is Required Fields
                 *  ------------------
                 */
                ( isset( $require ) && $require == true) 

                ?   esc_attr( 'required' ) 

                :   '',

                /**
                 *  7. Have Description ?
                 *  ---------------------
                 */
                (  isset( $description ) && $description !== '' )

                ?   sprintf( '<small>%1$s</small>', $description )

                :   '',

                /**
                 *  8. Have Name ?
                 *  --------------
                 */
                ( isset( $name ) && $name !== '' )

                ?   $name

                :   '',

                /**
                 *  9. Have Character Limit ?
                 *  -------------------------
                 */
                ( isset( $limit ) && parent:: _have_data( $limit ) )

                ?   sanitize_html_class( 'weddingdir-textarea-limit' )

                :   '',

                /**
                 *  10. Have Character Limit ?
                 *  -------------------------
                 */
                ( isset( $limit ) && parent:: _have_data( $limit ) )

                ?   sprintf( 'maxlength="%1$s" data-limit="%1$s"', absint( $limit ) )

                :   '',

                /**
                 *  11. Have Character Limit ?
                 *  -------------------------
                 */
                ( isset( $limit ) && parent:: _have_data( $limit ) )

                ?   sprintf( '<span class="alert alert-dark textarea count_message">%1$s</span>',

                        /**
                         *  1. Limit
                         *  --------
                         */
                        absint( $limit )
                    )

                :   '',

                /**
                 *  12. Have Rows ?
                 *  ---------------
                 */
                ( isset( $rows ) && $rows !== '' )

                ?   $rows

                :   absint( '6' ),

                /**
                 *  13. Have Form Group ?
                 *  ---------------------
                 */
                $formgroup

                ?   sanitize_html_class( 'mb-3' )

                :   ''
            );

            $data   .=   self:: _div_end_setup( $args );

            if( $echo ){

                print   $data;

            }else{

                return  $data;
            }
        }

        /**
         *  Editor
         *  ------
         */
        public static function create_textarea( $args = [] ) {

            $defaults = array(

                'div'           =>  [],

                'row'           =>  [],

                'column'        =>  [],

                'name'          =>  '',

                'id'            =>  esc_attr( parent:: _rand() ),

                'lable'         =>  '',

                'placeholder'   =>  '',

                'require'       =>  false,

                'value'         =>  '',

                'class'         =>  '',

                'description'   =>  '',

                'formgroup'     =>  true,

                'height'        =>  '',

                'limit'         =>  absint( '400' ),

                'echo'          =>  false,
            );

            $args = wp_parse_args( $args, $defaults );

            extract( $args );

            $data   =   '';

            $data   .=   self:: _div_start_setup( $args );

            /**
             *  Field
             *  -----
             */
            $data     .=

            sprintf('<div class="%9$s">

                        %2$s %7$s

                        <textarea class="summerynotes weddingdir-editor %5$s" id="%1$s" name="%8$s" rows="6" placeholder="%4$s" 

                            data-height="%10$s" data-limit="%11$s" %6$s>%3$s</textarea>

                            <div class="mt-2">

                                <span id="%1$s-limit" class="alert alert-dark weddingdir-editor count_message">%11$s</span>

                            </div>

                    </div>',

                /**
                 *  1. Have ID ?
                 *  ------------
                 */
                esc_attr( $id ),

                /**
                 *  2. Have Label ?
                 *  ---------------
                 */
                ( isset( $label ) && $label !== '' && isset( $id ) && $id !== '' )

                ?   sprintf('<label class="control-label mb-2" for="%2$s">%1$s</label>', esc_attr($label), esc_attr($id) )

                :   '',

                /**
                 *  3. Have Value ?
                 *  ---------------
                 */
                ( isset( $value ) && $value !== '' )

                ?   $value

                :   '',

                /**
                 *  4. Have Placeholder ?
                 *  ---------------------
                 */
                ( isset( $placeholder ) && $placeholder !== '' )

                ?   $placeholder

                :   '',

                /**
                 *  5. Have Class ?
                 *  ---------------
                 */
                ( isset( $class ) && $class !== '' )

                ?   $class

                :   '',

                /**
                 *  6. Is Required Fields
                 *  ------------------
                 */
                ( isset( $require ) && $require == true) 

                ?   esc_attr( 'required' ) 

                :   '',

                /**
                 *  7. Have Description ?
                 *  ---------------------
                 */
                (  isset( $description ) && $description !== '' )

                ?   sprintf( '<small>%1$s</small>', $description )

                :   '',

                /**
                 *  8. Have Name ?
                 *  --------------
                 */
                ( isset( $name ) && $name !== '' )

                ?   $name

                :   '',

                /**
                 *  9. Have From Group Class
                 *  ------------------------
                 */
                ( isset( $formgroup ) && $formgroup == true )

                ?   sanitize_html_class( 'mb-3' )

                :   '',

                /**
                 *  10. Have Height ?
                 *  -----------------
                 */
                ( isset( $height ) && parent:: _have_data( $height ) )

                ?   absint( $height )

                :   '',

                /**
                 *  11. Have Editor Character Limit ?
                 *  --------------------------------
                 */
                ( isset( $limit ) && parent:: _have_data( $limit ) )

                ?   absint( $limit )

                :   '',

                /**
                 *  12. Value in limit
                 *  ------------------
                 */
                ( isset( $value ) && $value !== '' && $value >= $limit )

                ?   sprintf( '<span style="color:green;">%1$s</span>', absint( strlen( trim( $value ) ) ) )

                :   '',

                /**
                 *  13. value out of limit
                 *  ----------------------
                 */
                ( isset( $value ) && $value !== '' && $value <= $limit )

                ?   sprintf( '<span style="color:red;">%1$s</span>', absint( strlen( trim( $value ) ) ) )

                :   ''
            );

            $data   .=   self:: _div_end_setup( $args );

            /**
             *  Is pring ?
             *  ----------
             */
            if( $echo ){

                print   $data;

            }else{

                return  $data;
            }
        }

        /**
         *  Setup Password Field
         *  --------------------
         */
        public static function create_password_field( $args = [] ) {

            /**
             *  Default Args
             *  ------------
             */
            $defaults       =   array(

                'id'            =>  '',

                'div'           =>  [],

                'row'           =>  [],

                'column'        =>  [],

                'name'          =>  '',

                'lable'         =>  '',

                'placeholder'   =>  '',

                'require'       =>  false,

                'value'         =>  '',

                'class'         =>  '',

                'type'          =>  esc_attr( 'password' ),

                'disable'       =>  false,

                'formgroup'     =>  true,

                'echo'          =>  false
            );

            /**
             *  Merge Args
             *  ----------
             */
            $args = wp_parse_args( $args, $defaults); 

            extract( $args );

            $data   =   '';

            $data   .=   self:: _div_start_setup( $args );

            $data   .=

            sprintf('<div class="%10$s">

            <label class="control-label mb-2" for="%2$s">%11$s</label>
                        %2$s

                        <div class="password-eye">
                            
                            <input autocomplete="off" 

                                id="%1$s" name="%3$s" value="%4$s" type="%5$s" 

                                placeholder="%6$s" class="form-control input-md %7$s"

                            %8$s %9$s>

                            <span class="fa fa-fw fa-eye"></span>

                        </div>

                    </div>',

                /**
                 *  1. Input ID
                 *  -----------
                 */
                ( ! empty( $id ) && isset( $id ) )

                ?   esc_attr( $id )

                :   '',

                /**
                 *  2. Input Label
                 *  --------------
                 */
                ( ! empty( $label ) && isset( $label ) && ! empty( $id ) && isset( $id ) )

                ?   sprintf( '<label class="control-label mb-2" for="%2$s">%1$s</label>',

                        /**
                         *  1. Lable
                         *  --------
                         */
                        esc_attr( $label ),

                        /**
                         *  2. ID
                         *  -----
                         */
                        esc_attr( $id )
                    )

                :   '',

                /**
                 *  3. Input Name
                 *  -------------
                 */
                ( ! empty( $name ) && isset( $name ) )

                ?   esc_attr( $name )

                :   '',

                /**
                 *  4. Input Value
                 *  --------------
                 */
                ( ! empty( $value ) && isset( $value ) )

                ?   esc_attr( $value )

                :   '',

                /**
                 *  5. Input Value
                 *  --------------
                 */
                ( ! empty( $type ) && isset( $type ) )

                ?   esc_attr( $type )

                :   esc_attr( 'password' ),

                /**
                 *  6. Input Placeholder
                 *  --------------------
                 */
                ( ! empty( $placeholder ) && isset( $placeholder ) )

                ?   esc_attr( $placeholder )

                :   '',

                /**
                 *  7. Input Field Class
                 *  --------------------
                 */
                ( ! empty( $class ) && isset( $class ) )

                ?   esc_attr( $class )

                :   '',

                /**
                 *  8. Input Field Requird ?
                 *  ------------------------
                 */
                ( $require == true && isset( $require ) )

                ?   esc_attr( 'required' )

                :   '',

                /**
                 *  9. Is Disable ?
                 *  ------------
                 */
                ( isset( $disable ) && $disable == true )

                ?   esc_attr( 'disabled' )

                :   '',

                /**
                 *  10. Have From Group Class
                 *  -------------------------
                 */
                ( isset( $formgroup ) && $formgroup == true )

                ?   sanitize_html_class( 'mb-3' )

                :   '',
                /**
                 *  11. Heading Lable
                 *  --------------------
                 */
                ( ! empty( $headingLable ) && isset( $headingLable ) )

                ?   esc_attr( $headingLable )

                :   ''                
            );

            $data   .=   self:: _div_end_setup( $args );

            if( $echo ){

                print   $data;

            }else{

                return  $data;
            }
        }

        /**
         *  Setup Location Field
         *  --------------------
         */
        public static function create_location_field( $args = [] ) {

            /**
             *  Default Args
             *  ------------
             */
            $defaults       =   array(

                'div'                   =>  [],

                'row'                   =>  [],

                'column'                =>  [],

                'lable'                 =>  '',

                'placeholder'           =>  '',

                'require'               =>  false,

                'class'                 =>  'listing-location',

                'type'                  =>  esc_attr( 'text' ),

                'disable'               =>  false,

                'formgroup'             =>  true,

                'echo'                  =>  false,

                'id'                    =>  esc_attr( 'listing-location' ),

                'name'                  =>  esc_attr( 'listing-location' ),

                'page_template'         =>  absint( '1' ),

                'location_value_id'     =>  '',

                'location_value_name'   =>  '',

                'ajax'                  =>  true,

                'taxonomy'              =>  WeddingDir_Taxonomy:: listing_location_taxonomy(),
            );

            /**
             *  Merge Args
             *  ----------
             */
            $args = wp_parse_args( $args, $defaults); 

            extract( $args );

            $data    =      '';

            $data   .=      self:: _div_start_setup( $args );

            $data   .=      apply_filters( 'weddingdir/input-location', [

                                'target_class'    =>    'weddingdir-listing-page mb-3',

                                'input_style'     =>    sanitize_html_class( 'form-dark' ),

                                'location_id'     =>    $location_value_id,

                                'value'           =>    $location_value_name,

                                'hide_empty'      =>    false,

                                'ajax_load'       =>    false,

                                'taxonomy'        =>    $taxonomy

                            ] );

            $data   .=   self:: _div_end_setup( $args );

            if( $echo ){

                print   $data;

            }else{

                return  $data;
            }
        }

        /**
         *  Load WeddingDir - Map
         *  ---------------------
         */
        public static function weddingdir_map( $args = [] ) {

            if( parent:: _is_array( $args ) ){

                $defaults = array(

                    'div'           =>  [],

                    'row'           =>  [],

                    'column'        =>  [],

                    'id'            =>  '',

                    'class'         =>  '',

                    'echo'          =>  false
                );

                $args = wp_parse_args($args, $defaults);

                extract( $args );

                $data    =   '';

                $data   .=   self:: _div_start_setup( $args );

                $data   .=

                sprintf(' <div id="%1$s" class="map_height %2$s"></div>',

                    /**
                     *  1. Map ID
                     *  ---------
                     */
                    ( isset( $id ) && $id !== '' ) 

                    ?   esc_attr( $id )

                    :   '',

                    /**
                     *  2. Have Extra Class
                     *  -------------------
                     */
                    ( isset( $class ) && $class !== '' )

                    ?   esc_attr( $class )

                    :   ''
                );

                $data   .=   self:: _div_end_setup( $args );

                /**
                 *  Is Print ?
                 *  ----------
                 */
                if( $echo ){

                    print   $data;

                }else{

                    return  $data;
                }
            }
        }

        /**
         *  Default Thumbs
         *  --------------
         */
        public static function gallery_thumb( $vendor_gallery, $_store_ids = '', $placeholder = '' ){

            $string = '';

            if( empty( $placeholder ) ){

                $placeholder    =   esc_url( parent:: placeholder( 'listing-gallery' ) );
            }

            $_have_data         =   parent:: _coma_to_array( $vendor_gallery );

            if ( parent:: _is_array( $_have_data ) ) {

                foreach ( $_have_data as $key ) {

                    /**
                     *  Media Check 
                     *  -----------
                     */
                    if ( parent:: _have_media( $key ) ) {

                        $string .=

                        sprintf('   <div class="col-md-3 weddingdir_gallery_thumb">

                                        <div class="dash-categories">

                                            <div class="edit">

                                                <a href="javascript:" class="weddingdir-remove-media" data-media-id="%2$s">

                                                    <i class="fa fa-trash"></i>

                                                </a>

                                            </div>

                                            <img src="%1$s" data-media-id="%2$s" src="%4$s" />

                                        </div>

                                    </div>',

                            /**
                             *  1. Get Media ID to Media SRC
                             *  ----------------------------
                             */
                            parent:: _have_media( $key )

                            ?   apply_filters( 'weddingdir/media-data', [

                                    'media_id'         =>  absint( $key ),

                                    'image_size'       =>  esc_attr( 'thumbnail' ),

                                ] )

                            :   esc_url( $placeholder ),

                            /**
                             *  2. Media ID
                             *  -----------
                             */
                            absint( $key ),

                            /**
                             *  3. Store ID
                             *  -----------
                             */
                            $_store_ids,

                            /**
                             *  4. Image Alt
                             *  ------------
                             */
                            esc_attr( get_bloginfo( 'name' ) )
                        );
                    }
                }
            }

            else {

                for ( $i = absint( '0' ); $i <= absint( '7' ); $i++ ) {

                    $string .=

                    sprintf('   <div class="col-md-3 weddingdir_gallery_thumb">

                                    <div class="dash-categories">

                                        <div class="edit">

                                            <a href="javascript:" class="weddingdir-remove-media" data-media-id="%2$s">

                                                <i class="fa fa-trash"></i>

                                            </a>

                                        </div>

                                        <img src="%1$s" data-media-id="%2$s" alt="%3$s" />

                                    </div>

                                </div>',

                        /**
                         *  1. Placeholder
                         *  --------------
                         */
                        esc_url( $placeholder ),

                        /**
                         *  2. Random Value
                         *  ---------------
                         */
                        esc_attr( parent:: _rand() ),

                        /**
                         *  3. Brand Name
                         *  -------------
                         */
                        esc_attr( get_bloginfo( 'name' ) )
                    );
                }
            }

            /**
             *  Return Data
             *  -----------
             */
            return      $string;
        }

        /**
         *  Div > Row > Column Setup
         *  ------------------------
         */
        public static function _div_start_setup( $args = [] ){

            /**
             *  Have Args ?
             *  -----------
             */
            if( parent:: _is_array( $args ) ){

                $defaults = array(

                    'div'           =>  [],

                    'row'           =>  [],

                    'column'        =>  [],

                    'echo'          =>  false
                );

                $args = wp_parse_args($args, $defaults);

                extract( $args );

                $data         =   '';

                /**
                 *  Extra Start Div
                 *  ---------------
                 */
                if ( parent:: _is_array( $div ) && $div[ 'start' ] == true ) {

                    $data     .=   self:: div_start( $div );
                }

                /**
                 *  Row Start Setup
                 *  ---------------
                 */
                if ( parent:: _is_array( $row ) && $row[ 'start' ] == true ) {

                    $data     .=   self:: row_start( $row );
                }

                /**
                 *  Column Start Setup
                 *  ------------------
                 */
                if ( parent:: _is_array( $column ) && $column[ 'start' ] == true ) {

                    $data     .=   self:: column_start( $column );
                }

                /**
                 *  Is Print ?
                 *  ----------
                 */
                if( $echo ){

                    print   $data;

                }else{

                    return  $data;
                }
            }
        }

        /**
         *  Div > Row > Column Setup
         *  ------------------------
         */
        public static function _div_end_setup( $args = [] ){

            /**
             *  Have Args ?
             *  -----------
             */
            if( parent:: _is_array( $args ) ){

                $defaults = array(

                    'div'           =>  [],

                    'row'           =>  [],

                    'column'        =>  [],

                    'echo'          =>  false
                );

                $args = wp_parse_args($args, $defaults);

                extract( $args );

                $data         =   '';

                /**
                 *  Column Start Setup
                 *  ------------------
                 */
                if ( parent:: _is_array( $column ) && $column[ 'end' ] == true ) {

                    $data     .=   self:: column_end( $column );
                }

                /**
                 *  Row End Setup
                 *  -------------
                 */
                if ( parent:: _is_array( $row ) && $row[ 'end' ] == true ) {

                    $data     .=   self:: row_end( $row );
                }

                /**
                 *  Extra Div End
                 *  -------------
                 */
                if ( parent:: _is_array( $div ) && $div[ 'end' ] == true ) {

                    $data     .=   self:: div_end( $div );
                }

                /**
                 *  Is Print ?
                 *  ----------
                 */
                if( $echo ){

                    print   $data;

                }else{

                    return  $data;
                }
            }
        }

        /**
         *  [Helper] = Show Data with Accordion
         *  -----------------------------------
         */
        public static function data_show_in_collapse( $title = '', $id = '', $content = '' ){

            return

            sprintf( '<div class="accordion_section">

                        <div  class="card-header"   id="%1$s">

                                <a  href="javascript:" 

                                    class="collapsed" 

                                    data-bs-toggle="collapse"

                                    data-bs-target="#collapse_%1$s" 

                                    aria-expanded="false" 

                                    aria-controls="collapse_%1$s">%2$s<i class="remove_collapse fa fa-close"></i>

                                </a>

                        </div>

                        <div    id="collapse_%1$s" 

                                class="collapse" 

                                aria-labelledby="%1$s" 

                                data-parent="#%3$s">
                            
                                %4$s
                        </div>

                    </div>', 

                /**
                 *  1. Random ID
                 *  ------------
                 */
                esc_attr( parent:: _rand() ),

                /**
                 *  2. Heading
                 *  ----------
                 */
                esc_attr( $title ),

                /**
                 *  3. Section Parent ID
                 *  --------------------
                 */
                esc_attr( $id ),

                /**
                 *  4. Collapse Body Content
                 *  ------------------------
                 */
                $content
            );
        }

        /**
         *  [Helper] = Remove Section Icon
         *  ------------------------------
         */
        public static function removed_section( $_is_active = true ){

            /**
             *  Removed Collapse
             *  ----------------
             */
            if( $_is_active ){

                return  sprintf(   '<a href="javascript:" class="btn btn-primary remove_collapse text-start">

                                        <i class="fa fa-trash"></i>

                                    </a>'
                        );
            }
        }

        /**
         *  [Helper] = Remove Section Icon
         *  ------------------------------
         */
        public static function removed_section_icon( $_is_active = true ){

            /**
             *  Removed Collapse
             *  ----------------
             */
            if( $_is_active ){

                return  sprintf(   '<a href="javascript:" class="remove_collapse card-box-remove-icon">

                                        <i class="fa fa-trash"></i>

                                    </a>'
                        );
            }
        }

        /**
         *  [Helper] = Remove Section Icon
         *  ------------------------------
         */
        public static function removed_core_section_icon( $_is_active = true ){

            /**
             *  Removed Collapse
             *  ----------------
             */
            if( $_is_active ){

                return  sprintf(   '<a href="javascript:" class="remove_core_collapse card-box-remove-icon">

                                        <i class="fa fa-trash"></i>

                                    </a>'
                        );
            }
        }
    }

    /**
     *  WeddingDir Form Fields
     *  ----------------------
     */
    WeddingDir_Form_Fields_Modified::get_instance();
}