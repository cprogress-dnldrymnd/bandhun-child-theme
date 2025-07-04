<?php
/**
 *  WeddingDir - Theme Header Template
 *  ----------------------------------
 *  @link - https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *  ---------------------------------------------------------------------------------------
 */
?>
<!DOCTYPE html>

<?php do_action( 'weddingdir_html_before' ); ?>

<html <?php language_attributes(); ?>>

  <head><?php do_action( 'weddingdir_head' ); wp_head(); ?>
  <style>
        @font-face {
            font-family: 'DS-Digital';
            /* Specify the font-family name */
            src: url('<?php echo get_stylesheet_directory_uri()."/assets/fonts/DS-DIGIT.TTF";?>') format('truetype');
            src: url('<?php echo get_stylesheet_directory_uri()."/assets/fonts/DS-DIGIB.TTF";?>') format('truetype');
           
        }
    </style>
  </head>

  <body <?php do_action( 'weddingdir_body' ); ?>>

  <?php wp_body_open(); ?>

  <div id="page" class="site">

      <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'weddingdir' ); ?></a>
      
      <?php

      if( ! is_singular( 'website' ) ){

          /**
           *  WeddingDir - Header Actions
           *  ---------------------------
           */
          do_action( 'weddingdir_header' );

          /**
           *  WeddingDir - Before Content Load Actions
           *  ----------------------------------------
           */
          do_action( 'weddingdir_content_before' );
      }

      ?>
      <main id="content" class="site-content">