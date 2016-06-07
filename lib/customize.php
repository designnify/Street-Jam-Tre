<?php

/**
 * Customizer additions.
 *
 * @package Street Jam
 * @author  Mauricio Alvarez
 * @link    http://designnify.com
 * @license GPL2-0+
 */

add_action( 'customize_register', 'street_jam_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 3.0.2
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function street_jam_customizer_register() {

	global $wp_customize;

	$wp_customize->add_section( 'street-jam-image', array(
		'title'    => __( 'Backstretch Image', 'street-jam' ),
		'description' => __( '<p>Use the included default image or personalize your site by uploading your own image for the background.</p><p>The default image is <strong>1600 x 1000 pixels</strong>.</p>', 'dbdc' ),
		'priority' => 75,
	) );

	$wp_customize->add_setting( 'street-jam-backstretch-image', array(
		'default'  => sprintf( '%s/images/default-bg.jpg', get_stylesheet_directory_uri() ),
		'sanitize_callback' => 'esc_url_raw',
		'type'     => 'option',
	) );

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'backstretch-image',
			array(
				'label'       => __( 'Backstretch Image Upload', 'dbdc' ),
				'section'     => 'street-jam-image',
				'settings'    => 'street-jam-backstretch-image'
			)
		)
	);

}
