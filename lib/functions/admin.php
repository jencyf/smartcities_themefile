<?php
 /**
 * The ADMIN functions for OPTIMIZER
 *
 * Stores all the admin functions of the template.
 *
 * @package LayerFramework
 * 
 * @since  LayerFramework 1.0
 */
 
/**************** LOAD SHORTCODES ****************/
// Hooks your functions into the correct filters

add_filter( 'mce_external_plugins', 'optimizer_add_tinymce_plugin' );
// Declare script for new button
function optimizer_add_tinymce_plugin( $plugin_array ) {
	$plugin_array['optimizer_mce_button'] = get_template_directory_uri() .'/assets/js/shortcodes_js.js';
	$plugin_array['noneditable'] = get_template_directory_uri() .'/assets/js/shortcodes_js.js';
	$plugin_array['save'] = get_template_directory_uri() .'/assets/js/shortcodes_js.js';
	
	$plugin_array['optimedia'] = get_template_directory_uri() .'/assets/js/shortcodes_js.js';
	$plugin_array['canceledit'] = get_template_directory_uri() .'/assets/js/shortcodes_js.js';
	$plugin_array['fullmode'] = get_template_directory_uri() .'/assets/js/shortcodes_js.js';
	$plugin_array['shorty'] = get_template_directory_uri() .'/assets/js/shortcodes_js.js';
	
	return $plugin_array;
}

add_filter( 'mce_buttons', 'optimizer_register_mce_button' );
// Register new button in the editor
function optimizer_register_mce_button( $buttons ) {
	array_push( $buttons, 'optimizer_mce_button' );
	return $buttons;
}

// Enable font size & font family selects in the editor
if ( ! function_exists( 'optimizer_mce_buttons' ) ) {
	function optimizer_mce_buttons( $buttons ) {
		array_unshift( $buttons, 'fontselect' ); // Add Font Select
		array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
		array_splice( $buttons, 5, 0, 'backcolor' ); // Add Text background Button
		return $buttons;
	}
}
add_filter( 'mce_buttons_2', 'optimizer_mce_buttons' );


// Customize mce editor font sizes
if ( ! function_exists( 'optimizer_mce_text_sizes' ) ) {
	function optimizer_mce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 30px 34px 36px 40px 46px 52px 60px 72px 90px 100px 120px 140px 160px 180px 200px 220px 240px 260px 280px 300px";
		return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'optimizer_mce_text_sizes' );


// Add Theme Fonts to POST EDITOR Fonts list
if ( ! function_exists( 'optimizer_fonts_editor' ) ) {
	function optimizer_fonts_editor( $initArray ) {
		$optimizer = optimizer_option_defaults();
		
		if(!empty($optimizer['ptitle_font_id']['font-family'])){ 
			$title_font = $optimizer['ptitle_font_id']['font-family'];
			$title_font = ''.$title_font.'='.$title_font.';';
		}else{ 
			$title_font =''; 
		}
		if(!empty($optimizer['logo_font_id']['font-family'])){ 
			$logo_font = $optimizer['logo_font_id']['font-family'];
			$logo_font = ''.$logo_font.'='.$logo_font.';';
		}else{ 
			$logo_font =''; 
		}
		
		if( !empty($optimizer['custom_font_ttf']) && !empty($optimizer['custom_font_eot']) && !empty($optimizer['custom_font_woff']) ){ 
			$fonturl = $optimizer['custom_font_ttf'];    
			$fontname = substr($fonturl, strrpos($fonturl, "/") + 1);  
			$fontname = str_replace('.ttf','', $fontname);
			$custom_font = $fontname;
			$custom_font = ''.$custom_font.'='.$custom_font.';';
		}else{ 
			$custom_font ='';
		}
		
		
	    $initArray['font_formats'] = ''.$title_font.$logo_font.$custom_font.'Lato=Lato;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats';
            return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'optimizer_fonts_editor' );


// Add Google Scripts for use with the editor
if ( ! function_exists( 'optimizer_editor_fonts_style_fontone' ) ) {
	function optimizer_editor_fonts_style_fonts() {
		$optimizer = optimizer_option_defaults();
		if(!empty($optimizer['ptitle_font_id']['font-family'])){
			if(!$optimizer['ptitle_font_id']['font-family'] == 'Sans Serif' || !$optimizer['ptitle_font_id']['font-family'] == 'Serif' || !$optimizer['ptitle_font_id']['font-family'] == 'Monospaced'){
				$font_url = 'https://fonts.googleapis.com/css?family='.str_replace(' ', '+', ''.$optimizer['ptitle_font_id']['font-family'].'' );
				add_editor_style( str_replace( ',', '%2C', $font_url ) );
			}
			
		}
		if(!empty($optimizer['logo_font_id']['font-family'])){
			if(!$optimizer['ptitle_font_id']['font-family'] == 'Sans Serif' || !$optimizer['ptitle_font_id']['font-family'] == 'Serif' || !$optimizer['ptitle_font_id']['font-family'] == 'Monospaced'){
				$font_url2 = 'https://fonts.googleapis.com/css?family='.str_replace(' ', '+', ''.$optimizer['logo_font_id']['font-family'].'' );
				add_editor_style( str_replace( ',', '%2C', $font_url2 ) );
			}
		}
	}
}
//Load the Fonts only on Editor Pages
add_action( 'init', 'optimizer_editor_fonts_style_fonts' );


//Add Custom Font to TinyMCE Editor Font List
$optimizer = optimizer_option_defaults();
if( !empty($optimizer['custom_font_ttf']) && !empty($optimizer['custom_font_eot']) && !empty($optimizer['custom_font_woff']) ){ 
	function optimizer_customfont_tinymce_css($init) {
	
			$optimizer = optimizer_option_defaults();
			
			
				$fonturl = $optimizer['custom_font_ttf'];    
				$fontname = substr($fonturl, strrpos($fonturl, "/") + 1);  
				$fontname = str_replace('.ttf','', $fontname);
	
				$css = '@font-face {font-family: "'.$fontname.'";src: url("'.$optimizer['custom_font_eot'].'");src: url("'.$optimizer['custom_font_eot'].'?#iefix") format("embedded-opentype"),url("'.$optimizer['custom_font_woff'].'") format("woff"),url("'.$optimizer['custom_font_ttf'].'")  format("truetype");font-style: normal;}'; 
			
			 ?>
				<script type="text/javascript">            
			
					function addTempCSS( ed ) {
						ed.on('init', function() {
							tinyMCE.activeEditor.dom.addStyle(<?php echo json_encode($css) ?>);
						} );
					};
				</script>
			
				<?php
				if (wp_default_editor() == 'tinymce')
					$init['setup'] = 'addTempCSS';
					
				return $init;
	
	}		

	add_filter('tiny_mce_before_init', 'optimizer_customfont_tinymce_css');
}


/**************** Get Category,Tags & Posts list for CUSTOM POST SHORTCODE ****************/
add_action( 'after_wp_tiny_mce', 'optimizer_after_wp_tiny_mce' );
function optimizer_after_wp_tiny_mce() {

	echo '<script type="text/javascript">';
	$post_types = get_post_types( array('public'=> true), 'names' ); 
	echo 'var lts_posts =\'';
	foreach ( $post_types as $post_type ) {
	   echo '<option value="'.$post_type.'">'.$post_type.'</option>';
	}
	echo '\';';
	
	$lts_cats =  get_categories(array('type'=> 'post','child_of'=> 0,'orderby' => 'name','order'=> 'ASC','hide_empty'=> 0,'hierarchical'=> 0,'pad_counts'=> false ));
	echo 'var lts_cats =\'';
	foreach($lts_cats as $cats){
		echo '<option value="'.$cats->slug.'">'.esc_attr($cats->name).'</option>';
		}
	echo '\';';
		
	$lts_tags =  get_tags(array('orderby' => 'name','order'=> 'ASC','hide_empty'=> 0,'hierarchical'=> 0,'pad_counts'=> false ));
	echo 'var lts_tags =\'';
	foreach($lts_tags as $tagss){
		echo '<option value="'.$tagss->slug.'">'.esc_attr($tagss->name).'</option>';
		}
	echo '\';';	
	echo '</script>';
	
}

//LOAD SHORTCODES WINDOW STYLES & JS
function optimizer_tmce_replace() {
	?>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/assets/css/shortcodes.css'; ?>" />
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.5.8/perfect-scrollbar.min.js"></script>
	<?php
}
add_action( 'after_wp_tiny_mce', 'optimizer_tmce_replace' );


//SHOW BLINKING HIGHLIGHT ON OPTIMIZER OPTIONS MENU
function optimizer_options_highlight() {
	echo '<style type="text/css">
	/*THEME ACTIVATION HOOK*/
	body.themes-php #menu-appearance li a[href*="optimizer-license"]{color:white!important;}
	body.themes-php #menu-appearance li a[href*="optimizer-license"]:after{content:"";border: 3px solid #999;border-radius: 30px;height: 18px;width: 18px;position: absolute;left:130px;margin-top:-5px;animation: blinky 1s ease-out;animation-iteration-count: infinite; -moz-animation: blinky 1s ease-out;-moz-animation-iteration-count: infinite; -webkit-animation: blinky 1s ease-out;-webkit-animation-iteration-count: infinite; opacity: 0.0}
	@-webkit-keyframes blinky {
		0% {-webkit-transform: scale(0.1, 0.1); opacity: 0.0;}
		50% {opacity: 1.0;}
		100% {-webkit-transform: scale(1.2, 1.2); opacity: 0.0;}
	</style>';
}

add_action('after_switch_theme', 'optimizer_after_install');
function optimizer_after_install () {
	add_action('admin_head', 'optimizer_options_highlight');
}


function optimizer_post_colorpicker(){
	
	$screen = get_current_screen();
	if ( $screen->base == 'post' ){ 
		echo '<script type="text/javascript">jQuery(document).ready(function() {     jQuery(".optimizer_meta_control .color-picker").wpColorPicker();    });</script>';
	}	
}
add_action('admin_head', 'optimizer_post_colorpicker');



/* Display NOTICE TO CONVERT TO LATEST OPTIONS */

add_action('admin_notices', 'optimizer_admin_notice');

function optimizer_admin_notice() {
	$optimizer = optimizer_option_defaults();
	global $optimizerdb; 
	global $current_user ;
        $user_id = $current_user->ID;
        /* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_user_meta($user_id, 'optimizer_update_ignore') && current_user_can('edit_theme_options') ) {

			//echo '<div class="error"><p>'; 
			//printf(__('Your Theme Optimizer has been updated. An action is required to update the Theme. <a href="https://www.layerthemes.com/improved-optimizer-wordpress-theme/" target="_blank">learn More</a>. | <a href="%1$s">Hide Notice</a>'), '?optimizer_update_ignore=0');
			//echo "</p></div>";

	}
}

add_action('admin_init', 'optimizer_notice_ignore');

function optimizer_notice_ignore() {
	global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['optimizer_update_ignore']) && '0' == $_GET['optimizer_update_ignore'] ) {
             add_user_meta($user_id, 'optimizer_update_ignore', 'true', true);
	}
}