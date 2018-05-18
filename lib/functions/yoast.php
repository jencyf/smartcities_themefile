<?php

/**
 * YOAST SEO PLUGIN SUPPORT
 *
 * Count the words in pages that are made with Optimizer Widgets 
 *
 * @package LayerFramework
 * 
 * @since  Optimizer 0.4.1
 */
if (!defined('WPSEO_VERSION') ) {
	return;
}
 
function optimizer_get_widget_data($sidebar_id) {
	global $wp_registered_sidebars, $wp_registered_widgets;
	
	// Holds the final data to return
	$output = array();
	
	if( !$sidebar_id ) {
		// There is no sidebar registered with the name provided.
		return $output;
	} 
	
	// A nested array in the format $sidebar_id => array( 'widget_id-1', 'widget_id-2' ... );
	$sidebars_widgets = wp_get_sidebars_widgets();
	$widget_ids = $sidebars_widgets[$sidebar_id];
	
	if( !$widget_ids ) {
		// Without proper widget_ids we can't continue. 
		return array();
	}
	
	// Loop over each widget_id so we can fetch the data out of the wp_options table.
	foreach( $widget_ids as $id ) {
		// The name of the option in the database is the name of the widget class.  
		$option_name = $wp_registered_widgets[$id]['callback'][0]->option_name;
		
		// Widget data is stored as an associative array. To get the right data we need to get the right key which is stored in $wp_registered_widgets
		$key = $wp_registered_widgets[$id]['params'][0]['number'];
		
		$widget_data = get_option($option_name);
		
		// Add the widget data on to the end of the output array.
		$output[] = $widget_data[$key];
	}
	
	function optimizer_check_widget_content($ar) {  if(isset($ar['content'])) return $ar['content'];  }
	function optimizer_check_widget_desc($ar) {  if(isset($ar['desc'])) return $ar['desc'];  }
	function optimizer_check_widget_title($ar) {  if(isset($ar['title'])) return $ar['title'];  }
	function optimizer_check_widget_subtitle($ar) {  if(isset($ar['subtitle'])) return $ar['subtitle'];  }
	function optimizer_check_widget_block1title($ar) {  if(isset($ar['block1title'])) return $ar['block1title'];  }
	function optimizer_check_widget_block2title($ar) {  if(isset($ar['block2title'])) return $ar['block2title'];  }
	function optimizer_check_widget_block3title($ar) {  if(isset($ar['block3title'])) return $ar['block3title'];  }
	function optimizer_check_widget_block4title($ar) {  if(isset($ar['block4title'])) return $ar['block4title'];  }
	function optimizer_check_widget_block5title($ar) {  if(isset($ar['block5title'])) return $ar['block5title'];  }
	function optimizer_check_widget_block6title($ar) {  if(isset($ar['block6title'])) return $ar['block6title'];  }
	function optimizer_check_widget_block1content($ar) {  if(isset($ar['block1content'])) return $ar['block1content'];  }
	function optimizer_check_widget_block2content($ar) {  if(isset($ar['block2content'])) return $ar['block2content'];  }
	function optimizer_check_widget_block3content($ar) {  if(isset($ar['block3content'])) return $ar['block3content'];  }
	function optimizer_check_widget_block4content($ar) {  if(isset($ar['block4content'])) return $ar['block4content'];  }
	function optimizer_check_widget_block5content($ar) {  if(isset($ar['block5content'])) return $ar['block5content'];  }
	function optimizer_check_widget_block6content($ar) {  if(isset($ar['block6content'])) return $ar['block6content'];  }


	$content = array_map('optimizer_check_widget_content', $output);
	$desc = array_map('optimizer_check_widget_desc', $output);
	$title = array_map('optimizer_check_widget_title', $output);
	$subtitle = array_map('optimizer_check_widget_subtitle', $output);
	$block1title = array_map('optimizer_check_widget_block1title', $output);
	$block2title = array_map('optimizer_check_widget_block2title', $output);
	$block3title = array_map('optimizer_check_widget_block3title', $output);
	$block4title = array_map('optimizer_check_widget_block4title', $output);
	$block5title = array_map('optimizer_check_widget_block5title', $output);
	$block6title = array_map('optimizer_check_widget_block6title', $output);
	$block1content = array_map('optimizer_check_widget_block1content', $output);
	$block2content = array_map('optimizer_check_widget_block2content', $output);
	$block3content = array_map('optimizer_check_widget_block3content', $output);
	$block4content = array_map('optimizer_check_widget_block4content', $output);
	$block5content = array_map('optimizer_check_widget_block5content', $output);
	$block6content = array_map('optimizer_check_widget_block6content', $output);

	
	$widgetcontent = array_merge($content, $desc, $title, $subtitle, $block1title, $block1content, $block2title, $block2content, $block3title, $block3content, $block4title, $block4content, $block5title, $block5content, $block6title, $block6content);

	function widget_content_output($item, $key) {
		 echo $item;
	}
	$widgetcontent = array_walk($widgetcontent, 'widget_content_output');

	
	return $widgetcontent;
}


/*Widget Content in CUSTOMIZER*/
function optimizer_yoast_widget_content() {
	if ( defined('WPSEO_VERSION') ) {
		?>
				<?php 
					$screen = get_current_screen();
					if ( $screen->parent_base == 'edit' && $screen->id == 'page' ){ 
						global $post;
						$widgetized = get_post_meta( $post->ID, 'widgetized', true );
						$sidebarid = get_post_meta( $post->ID, 'page_sidebar', true );
		
							if($widgetized == '1' && $sidebarid !=='null' ){
								echo '<div id="yoast_widget_content" contenteditable="true" style="display:none;">';
								echo optimizer_get_widget_data($sidebarid);
								echo '</div>';
							}
                } ?>
            
            
		<?php
		
	} // END output_wp_editor_widget_html*/
	
}
	
add_action( 'edit_form_after_editor', 'optimizer_yoast_widget_content', 100 );


function optimizer_yoast_widget_analysis() {
	if ( class_exists( 'WPSEO_Recalculate' )){
			$screen = get_current_screen();
		 ?>
		<?php if ( $screen->parent_base == 'edit' && $screen->id == 'page' ){ 
		
			 global $post;
			 $widgetized = get_post_meta( $post->ID, 'widgetized', true );
			 $sidebarid = get_post_meta( $post->ID, 'page_sidebar', true );

					if($widgetized == '1' && $sidebarid !=='null' ){
						echo '<script>
							(function($) {
								$(window).bind("load", function(){
									/**
									 * Set up the Yoast Optimizer WIDGET Analysis 
									 */
									YoastWidgetFAnalysis = function() {
										// Register with YoastSEO
										YoastSEO.app.registerPlugin("yoastWidgetAnalysis", {status: "ready"});
										YoastSEO.app.registerModification("content", this.addAcfFieldsToContent, "yoastWidgetAnalysis", 5);
									}
							
									YoastWidgetFAnalysis.prototype.addAcfFieldsToContent = function(data) {
										var optim_widget_content = "";
										
											optim_widget_content += " "+ $("#yoast_widget_content").html();
							
										return data + optim_widget_content;
									};
							
									new YoastWidgetFAnalysis();
								});
							}(jQuery));
							</script>';
						}
				} ?>
		
	<?php } 
}
add_action('in_admin_footer', 'optimizer_yoast_widget_analysis');