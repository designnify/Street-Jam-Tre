<?php
/**
 * This file adds the Home Page to the Street Jam Theme.
 *
 * @author Mauricio Alvarez
 * @package Street Jam
 * @subpackage Customizations
 */
 
add_action( 'wp_enqueue_scripts', 'street_jam_enqueue_scripts' );
/**
 * Enqueue Scripts
 */
function street_jam_enqueue_scripts() {

	if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'sponsors' ) || is_active_sidebar( 'newsletter' ) || is_active_sidebar( 'testimonials' ) || is_active_sidebar( 'three-columns' )  ) {
	
		
	}
}

add_action( 'genesis_meta', 'street_jam_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function street_jam_home_genesis_meta() {

	if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'sponsors' ) || is_active_sidebar( 'newsletter' ) || is_active_sidebar( 'testimonials' ) || is_active_sidebar( 'three-columns' )  ) {

		//* Force content-sidebar layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
		
		//* Add home body class
		add_filter( 'body_class', 'street_jam_body_class' );
		
		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		//* Add homepage widgets
		add_action( 'genesis_loop', 'street_jam_homepage_widgets' );

	}

}

function street_jam_body_class( $classes ) {

	$classes[] = 'street-jam-home';
	return $classes;
	
}

function street_jam_homepage_widgets() {
	
	genesis_widget_area( 'home-top', array(
	'before'	=> '<section id="home-top">',
	'after'		=> '</section>',
	));
	genesis_widget_area( 'sponsors', array(
		'before'	=> '<section id="sponsors"><div class="wrap">',
		'after'		=> '</div></section>',
	));
	genesis_widget_area( 'newsletter', array(
		'before'	=> '<section id="newsletter"><div class="wrap">',
		'after'		=> '</div></section>',
	));
	genesis_widget_area( 'testimonials', array(
		'before'	=> '<section id="testimonials"><div class="wrap">',
		'after'		=> '</div></section>',
	));
	genesis_widget_area( 'three-columns', array(
		'before'	=> '<section id="three-columns"><div class="wrap">',
		'after'		=> '</div></section>',
	));
	
}

genesis();
