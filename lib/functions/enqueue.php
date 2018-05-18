<?php
/****************** LOAD CSS & Javascripts (FRONT-END) ******************/
if(!function_exists( 'optimizer_css_js' ) ){
function optimizer_css_js() {
	if ( !is_admin() ) {
	//LOAD CSS-----------------------------------------------
	$theme_data = wp_get_theme();
	wp_enqueue_style( 'optimizer-style', get_stylesheet_uri());
	wp_enqueue_style( 'optimizer-style-core', get_template_directory_uri().'/style_core.css', 'style_core', $theme_data->get( 'Version' ));
	wp_enqueue_style('icons',get_template_directory_uri().'/assets/fonts/font-awesome.css', 'font_awesome', $theme_data->get( 'Version' ));
	wp_enqueue_style('animated_css',get_template_directory_uri().'/assets/css/animate.min.css', 'optimizer-style', $theme_data->get( 'Version' ));
	if ( is_rtl() ) {
		wp_enqueue_style('rtl_css',get_template_directory_uri().'/assets/css/rtl.css', 'rtl_css' );
	}
	//LOAD JS-----------------------------------------------
	wp_enqueue_script('jquery');
	wp_enqueue_script('optimizer_js',get_template_directory_uri().'/assets/js/optimizer.js', array('jquery'), $theme_data->get( 'Version' ), true);
	wp_enqueue_script('optimizer_otherjs',get_template_directory_uri().'/assets/js/other.js', array('jquery'), $theme_data->get( 'Version' ), true);
		global $optimizer; 
		$optimo = array('smoothscroll' => $optimizer['smoothscroll']);
		wp_localize_script( 'optimizer_otherjs', 'optimo', $optimo );
	
	wp_enqueue_script('optimizer_core',get_template_directory_uri().'/assets/js/core.js', array('jquery'), $theme_data->get( 'Version' ), true);
		$optim = array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'sent' => __('Message Sent Successfully!','optimizer'),
		'day' => __('Days','optimizer'),'hour' => __('Hours','optimizer'),'mins' => __('Min','optimizer'),'sec' => __('Sec','optimizer'),
		'redirect' => $optimizer['contactredirect'],
		);
		wp_localize_script( 'optimizer_core', 'optim', $optim );
		
	global $optimizer; if ( ! empty ( $optimizer['post_lightbox_id'] ) ) {wp_enqueue_script('optimizer_lightbox',get_template_directory_uri().'/assets/js/magnific-popup.js', array('jquery'), $theme_data->get( 'Version' ), true);}
	global $optimizer; if($optimizer['slider_type_id'] == "accordion"){wp_enqueue_script('optimizer_accordion',get_template_directory_uri().'/assets/js/accordion.js', array('jquery'), $theme_data->get( 'Version' ), true);}
	//Load MASONRY
	global $optimizerdb;
	if ($optimizer['cat_layout_id'] == "3" ) {
		if (!is_home() ){
			wp_enqueue_script('optimizer_masonry',get_template_directory_uri().'/assets/js/masonry.js', array('jquery'), $theme_data->get( 'Version' ), true);
		}
	}
	if ( is_page() || is_single() ) {
		//Load Masonry
		global $optimizer; global $post; $content = $post->post_content;
		if(has_shortcode( $content, 'display-posts' ) || ( $optimizer['blog_layout_id'] == '5' && is_page_template('template_parts/page-blog_template.php') )){
			wp_enqueue_script('optimizer_masonry',get_template_directory_uri().'/assets/js/masonry.js', array('jquery'), $theme_data->get( 'Version' ), true);
		}
	}
	//Load Coment Reply Javascript
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	if ( is_page() || is_single() ) {
		//Load Gallery Javascript
		global $optimizer; global $post; $content = $post->post_content;
		if (!empty( $optimizer['post_gallery_id'] ) && optimizer_has_shortcode( $content, 'gallery' ) ) {
			wp_enqueue_script('optimizer_gallery',get_template_directory_uri().'/assets/js/gallery.js', array('jquery'), $theme_data->get( 'Version' ), true);
		}
	}
	if(is_customize_preview()){ wp_enqueue_script('optimizer_map',get_template_directory_uri().'/assets/js/map-styles.js', array('jquery'), $theme_data->get( 'Version' ), true); }
	if( is_page_template('template_parts/page-contact_template.php') || is_customize_preview() ) {
		
		global $optimizer;
		if(!empty($optimizer['map_api'])){ $mapkey = 'https://maps.googleapis.com/maps/api/js?key='.$optimizer['map_api'].''; }else{ $mapkey = 'https://maps.googleapis.com/maps/api/js?sensor=false';}
		wp_enqueue_script('optimizer_googlemaps', $mapkey);
	}
	//Beaver Builder Support
	if(isset($_GET['fl_builder'])) {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false,  1 );
		wp_enqueue_script(  'wp-color-picker', admin_url( 'js/color-picker.min.js' ),  array( 'iris' ), false,  1 );
		$colorpicker_l10n = array( 'clear' => __( 'Clear', 'optimizer' ), 'defaultString' => __( 'Default', 'optimizer'  ),  'pick' => __( 'Select Color', 'optimizer'  ));
		wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n );
		wp_enqueue_script( 'optimizer_widgets', get_template_directory_uri() . '/assets/js/widgets.js' );
		wp_enqueue_style( 'optimizer_backend', get_template_directory_uri() . '/assets/css/backend.css' );
	}

	}//IF_Not_Admin check ENDS
}//optimizer_head_js ENDS
}
add_action('wp_enqueue_scripts', 'optimizer_css_js');

/*ADD Facebook JS code for widget and shortcode*/
function optimizer_facebook_js() {
	if(is_page() || is_single()){  global $post; $content = $post->post_content;  }else{  $content = ''; }
	if(is_page() || optimizer_has_shortcode( $content, 'fblike' )){
		echo '<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=219966444765853";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, "script", "facebook-jssdk"));</script>';
	}
}
//add_action('optimizer_body_top','optimizer_facebook_js');
/****************** DYNAMIC CSS & JS ******************/
//Include Dynamic Stylesheet
if ( !is_admin() ) {
	include(get_template_directory() . '/template_parts/custom-style.php');
}
//Load RAW Java Scripts
add_action('wp_footer', 'optimizer_load_js');
function optimizer_load_js() {
if ( !is_admin() ) {
	include(get_template_directory() . '/template_parts/custom-javascript.php');
}
}
/****************** ADMIN CSS & JS ******************/
//Load ADMIN CSS & JS SCRIPTS
function optimizer_admin_cssjs($hook) {
		wp_enqueue_script( 'optimizer_colpickjs', get_template_directory_uri() . '/assets/js/colpick.js' );
		wp_enqueue_style('adminFontAwesome',get_template_directory_uri().'/assets/fonts/font-awesome.css');
        wp_enqueue_style( 'optimizer_colpick_css', get_template_directory_uri() . '/assets/css/colpick.css' );
		wp_enqueue_style( 'optimizer_backend', get_template_directory_uri() . '/assets/css/backend.css' );
		wp_enqueue_script( 'optimizer_widgets', get_template_directory_uri() . '/assets/js/widgets.js' );
		if ( 'widgets.php' == $hook ) {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
		}
		if ( 'edit-tags.php' == $hook ) {
			wp_enqueue_media();
		}
}
add_action( 'admin_enqueue_scripts', 'optimizer_admin_cssjs' );


function optimizer_google_analytics() { ?>
    
        <?php global $optimizer; if (!empty ($optimizer['google_analytics_id'])) { ?><!--Google Analytics Start--><?php echo html_entity_decode($optimizer['google_analytics_id'], ENT_QUOTES, 'UTF-8'); ?><!--Google Analytics END--><?php } ?>
    
<?php }
add_action( 'wp_head', 'optimizer_google_analytics', 10 );
?>