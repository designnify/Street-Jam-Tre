<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Add Settings to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Street-Jam' );
define( 'CHILD_THEME_URL', 'http://designnify.com/' );
define( 'CHILD_THEME_VERSION', '1.0' );

//* Enqueue Styles and Scripts
add_action( 'wp_enqueue_scripts', 'genesis_sample_scripts' );
function genesis_sample_scripts() {

	//* Add Google Fonts
	wp_register_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700|Oswald:400,300,700|Raleway+Dots', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'google-fonts' );
	
	//* Add Adobe Edge Web Fonts
	wp_register_script( 'my_adobe_edge_fonts', '//use.edgefonts.net/league-gothic.js' );
    wp_enqueue_script( 'my_adobe_edge_fonts' );
    
    //* Add compiled JS
	wp_enqueue_script( 'genesis-sample-scripts', get_stylesheet_directory_uri() . '/js/project-min' . $minnified . '.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	
	//* Add Dashicons
	wp_enqueue_style( 'dashicons' );
	
	//* Add Backstretch Script
	if ( is_singular( array( 'post', 'page' ) ) && has_post_thumbnail() ) {

		wp_enqueue_script( 'street-jam-backstretch', get_bloginfo( 'stylesheet_directory' ) . '/js/min/backstretch-min.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'street-jam-backstretch-set', get_bloginfo( 'stylesheet_directory' ) . '/js/min/backstretch-init.js' , array( 'jquery', 'dbdc-backstretch' ), '1.0.0', true );
	}

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for 2-column footer widgets
add_theme_support( 'genesis-footer-widgets', 2 );

/** Remove secondary sidebar */
unregister_sidebar( 'sidebar-alt' );

//* Remove the header right widget area
unregister_sidebar( 'header-right' );

//* Removing emoji code form head
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

//* Rename menus
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Left Navigation Menu', 'Street-Jam' ), 'secondary' => __( 'Right Navigation Menu', 'Street-Jam' ) ) );

//* Hook menus
add_action( 'genesis_after_header', 'ms_menus_container' );
function ms_menus_container() {

	echo '<div class="navigation-container">';
	do_action( 'ms_menus' );
	echo '</div>';
	
}

//* Relocate Primary (Left) Navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'ms_menus', 'genesis_do_nav' );

//* Relocate Secondary (Right) Navigation
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'ms_menus', 'genesis_do_subnav' );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Add smooth scroll animation
add_action( 'wp_enqueue_scripts', 'sk_smooth_scroll' );
function sk_smooth_scroll() {

	wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/js/jquery.scrollTo.min.js', array( 'jquery' ), '1.4.5-beta', true );
	wp_enqueue_script( 'localScroll', get_stylesheet_directory_uri() . '/js/jquery.localScroll.min.js', array( 'scrollTo' ), '1.2.8b', true );
	wp_enqueue_script( 'scrollto-init', get_stylesheet_directory_uri() . '/js/scrollto-init.js', array( 'localScroll' ), '', true );

}

//* Enable shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

//* Remove the entry meta in the entry header
/*
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
*/

//* Customize the entry meta in the entry header
add_filter( 'genesis_post_info', 'bg_entry_meta_header' );
function bg_entry_meta_header($post_info) {
	$post_info = '[post_date]';
	return $post_info;
}

//* Display Featured Image on top of the post
add_action( 'genesis_before_entry', 'featured_post_image', 8 );
function featured_post_image() {
  if ( ! is_singular( 'post' ) )  return;
	the_post_thumbnail('post-image');
}

//* Remove the entry meta in the entry footer
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

//* Modify the length of post excerpts
add_filter( 'excerpt_length', 'sp_excerpt_length' );
function sp_excerpt_length( $length ) {
	return 20; // pull first 50 words
}

//* Edit the read more link text
add_filter( 'excerpt_more', 'custom_read_more_link');
add_filter('get_the_content_more_link', 'custom_read_more_link');
add_filter('the_content_more_link', 'custom_read_more_link');
function custom_read_more_link() {
return '&nbsp;<a class="more-link" href="' . get_permalink() . '" rel="nofollow">Lue lisää &hellip;</a>';
}

//* Modify the WordPress read more link
add_filter( 'the_content_more_link', 'sp_read_more_link' );
function sp_read_more_link() {
	return '<a class="more-link" href="' . get_permalink() . '">[Continue Reading]</a>';
}

//* Customize the credits
add_filter( 'genesis_footer_creds_text', 'sp_footer_creds_text' );
function sp_footer_creds_text() {
	echo '<div id="credits"><p>';
	echo 'Copyright &copy; ';
	echo date('Y');
	echo ' &middot; Street-Jam &middot; All rights reserved &middot; Built by <a href="http://designnify.com/" target="blank">Designnify - Mauricio Alvarez</a>';
	echo '</p></div>';
}

//* Register widget areas 
genesis_register_sidebar( array(
	'id'				=> 'home-top',
	'name'			=> __( 'Home Top', 'Street-Jam' ),
	'description'	=> __( 'This is home page top widget for video', 'Street-Jam' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'sponsors',
	'name'			=> __( 'Sponsors', 'Street-Jam' ),
	'description'	=> __( 'This is home page sponsors widget', 'Street-Jam' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'newsletter',
	'name'			=> __( 'Newsletter Subscription Form', 'Street-Jam' ),
	'description'	=> __( 'This is home page newsletter subscription widget', 'Street-Jam' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'testimonials',
	'name'			=> __( 'Testimonials', 'Street-Jam' ),
	'description'	=> __( 'This is testimonials widget in the home page', 'Street-Jam' ),
) );
genesis_register_sidebar( array(
	'id'				=> 'three-columns',
	'name'			=> __( 'Three Columns', 'Street-Jam' ),
	'description'	=> __( 'This is 3 columns widget in the home page', 'Street-Jam' ),
) );