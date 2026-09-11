<?php
/**
 * Theme functions and definitions
 *
 * @package NewsGoal
 */
if ( ! function_exists( 'newsgoal_enqueue_styles' ) ) :
	/**
	 * @since 0.1
	 */
	function newsgoal_enqueue_styles() {
		wp_enqueue_style( 'newsup-style-parent', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style( 'newsgoal-style', get_stylesheet_directory_uri() . '/style.css', array( 'newsup-style-parent' ), '1.0' );
		wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
		wp_enqueue_style( 'newsup-default',get_template_directory_uri() .'/css/colors/default.css');
		wp_enqueue_style( 'newsgoal-default-css', get_stylesheet_directory_uri()."/css/colors/default.css" );
		if(is_rtl()){
		wp_enqueue_style( 'newsup_style_rtl', trailingslashit( get_template_directory_uri() ) . 'style-rtl.css' );
	    }
		
	}

endif;
add_action( 'wp_enqueue_scripts', 'newsgoal_enqueue_styles', 9999 );

function newsgoal_theme_setup() {

	//Load text domain for translation-ready
	load_theme_textdomain('newsgoal', get_stylesheet_directory() . '/languages');

	require( get_stylesheet_directory() . '/hooks/hooks.php' );
	require( get_stylesheet_directory() . '/hooks/hook-header-section.php' );
	require( get_stylesheet_directory() . '/customizer-default.php' );
	require( get_stylesheet_directory() . '/frontpage-options.php' );
	require( get_stylesheet_directory() . '/font.php' );


	// custom header Support
		$args = array(
		'default-image'		=>  get_stylesheet_directory_uri() .'/images/head-back.jpg',
		'width'			=> '1600',
		'height'		=> '600',
		'flex-height'		=> false,
		'flex-width'		=> false,
		'header-text'		=> true,
		'default-text-color'	=> '#143745'
	);
	add_theme_support( 'custom-header', $args );

 	add_theme_support( "title-tag");

	add_theme_support( 'automatic-feed-links');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
	'top_right' => __( 'Top Header menu', 'newsgoal' ),
	) );

	$args = array(
		'default-color' => '#f9fafb',
		'default-image' => '',
	);
	add_theme_support( 'custom-background', $args );
	
} 
add_action( 'after_setup_theme', 'newsgoal_theme_setup' );


add_action( 'customize_register', 'newsgoal_customizer_rid_values', 1000 );
function newsgoal_customizer_rid_values($wp_customize) {

	$wp_customize->remove_control('tabbed_section_title');

	$wp_customize->remove_control('latest_tab_title');

	$wp_customize->remove_control('popular_tab_title');

	$wp_customize->remove_control('trending_tab_title');

	$wp_customize->remove_control('select_trending_tab_news_category');
	
	$wp_customize->get_setting('background_color')->transport = 'refresh';

	$wp_customize->remove_section('newsup_popular_tags_section_settings');
	
	$wp_customize->get_setting('header_textcolor')->default = 'fff';

}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function newsgoal_widgets_init() {
	

	register_sidebar( array(
		'name'          => esc_html__( 'Front-Page Left Sidebar Section', 'newsgoal'),
		'id'            => 'front-left-page-sidebar',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="mg-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="mg-wid-title"><h6>',
		'after_title'   => '</h6></div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Front-Page Right Sidebar Section', 'newsgoal'),
		'id'            => 'front-right-page-sidebar',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="mg-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="mg-wid-title"><h6>',
		'after_title'   => '</h6></div>',
	) );

	

}
add_action( 'widgets_init', 'newsgoal_widgets_init' );


function newsgoal_remove_some_widgets(){
// Unregister Frontpage sidebar
unregister_sidebar( 'front-page-sidebar' );
}
add_action( 'widgets_init', 'newsgoal_remove_some_widgets', 11 );

if (!function_exists('newsup_main_list_content')) :
    function newsup_main_list_content() {
        global $post;
        while(have_posts()){ the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('d-md-flex mg-posts-sec-post align-items-center'); ?>>
                <?php newsup_post_image_display_type($post); ?>
                <div class="mg-sec-top-post py-3 col">
                    <?php newsup_post_categories(); ?> 
                    <h4 class="entry-title title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                    <?php newsup_post_meta(); ?>
                    <div class="mg-content">
                        <?php $newsup_excerpt = newsup_the_excerpt( absint( 18 ) );
                        if ( !empty( $newsup_excerpt ) ) {  echo wp_kses_post( wpautop( $newsup_excerpt ) ); } ?>
                    </div>
                </div>
            </article>
        <?php } newsup_page_pagination();
    }
endif;
add_action('newsup_action_main_list_content', 'newsup_main_list_content', 40);