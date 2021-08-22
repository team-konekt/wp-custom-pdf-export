<?php
/*
Plugin Name: Custom Loops: get_posts()
Description: Demonstrates how to customize the WordPress Loop using get_posts().
Plugin URI:  https://plugin-planet.com/
Author:      Jeff Starr
Version:     1.0
*/



// custom loop shortcode: [get_posts_example]
function pdf_export_shortcode_show_link( $atts ) {
	
	// get global post variable
	global $post;
	
	// define shortcode variables
	extract( shortcode_atts( array( 
		
		'posts_per_page' => 5,
		'orderby' => 'date',
		
	), $atts ) );
	
	// define get_post parameters
	$args = array( 'posts_per_page' => $posts_per_page, 'orderby' => $orderby );

	$exportUrl = $_SERVER['REQUEST_URI'] . "&custom_pdf_export=true";
	
	// begin output variable
	$output  = "<a href='${exportUrl}' target='_blank'>PDF Export Button</a>";
	
	// return output
	return $output;
	
}
// register shortcode function
add_shortcode( 'pdf_export_link', 'pdf_export_shortcode_show_link' );


