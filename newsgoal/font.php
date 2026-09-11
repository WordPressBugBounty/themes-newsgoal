<?php
/*--------------------------------------------------------------------*/
/*     Register Google Fonts
/*--------------------------------------------------------------------*/
function newsgoal_fonts_url() {
	
    $fonts_url = '';
		
    $font_families = array();
 
	$font_families = array('Exo 2:300,400,500,600,700,800,900|Rubik:300,400,500,600,700&display=swap');
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

    return $fonts_url;
}
function newsgoal_scripts_styles() {
    wp_enqueue_style( 'newsgoal-fonts', newsgoal_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'newsgoal_scripts_styles' );