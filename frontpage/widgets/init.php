<?php

//Load the frontpage widgets
require(get_template_directory() . '/frontpage/widgets/front-about.php');
require(get_template_directory() . '/frontpage/widgets/front-blocks.php');
require(get_template_directory() . '/frontpage/widgets/front-text.php');
require(get_template_directory() . '/frontpage/widgets/front-posts.php');
require(get_template_directory() . '/frontpage/widgets/front-dynamic.php');
require(get_template_directory() . '/frontpage/widgets/front-cta.php');
require(get_template_directory() . '/frontpage/widgets/front-map.php');
require(get_template_directory() . '/frontpage/widgets/front-clients.php');
require(get_template_directory() . '/frontpage/widgets/front-testimonials.php');
require(get_template_directory() . '/frontpage/widgets/front-slider.php');
require(get_template_directory() . '/frontpage/widgets/front-video.php');
require(get_template_directory() . '/frontpage/widgets/front-portfolio.php');
require(get_template_directory() . '/frontpage/widgets/front-newsletter.php');


//Add input fields(priority 5, 3 parameters)
add_action('in_widget_form', 'optimizer_in_widget_form',5,3);
//Callback function for options update (priorität 5, 3 parameters)
add_filter('widget_update_callback', 'optimizer_in_widget_form_update',5,3);
//add class names (default priority, one parameter)
add_filter('dynamic_sidebar_params', 'optimizer_dynamic_sidebar_params');


function optimizer_in_widget_form($t,$return,$instance){
    $instance = wp_parse_args( (array) $instance, array( 'width' => 'none', 'visibility' => 'none', 'margin' => array('','','',''), 'padding'=> array('','','','')) );
    if ( !isset($instance['width']) )
        $instance['width'] = null;
    if ( !isset($instance['visibility']) )
        $instance['visibility'] = null;
    
	if ( !isset($instance['margin']) ){
        $instance['margin'] = array();
	}
		
    if ( !isset($instance['padding']) )
        $instance['padding'] = array();	
    ?>
	<?php if(is_customize_preview()) {?>
        <div class="widget_advanced advanced_widget_toggle_off">
        	<h4><i>+</i> <?php _e('Advanced','optimizer'); ?></h4>
            <div class="widget_advanced_controls">
                <label for="<?php echo $t->get_field_id('width'); ?>"><span><?php _e('Width:','optimizer'); ?></span>
                <select id="<?php echo $t->get_field_id('width'); ?>" name="<?php echo $t->get_field_name('width'); ?>">
                    <option <?php selected($instance['width'], '1');?> value="1"><?php _e('Full (1/1)','optimizer'); ?></option>
                    <option <?php selected($instance['width'], '2');?>value="2"><?php _e('Half (1/2)','optimizer'); ?></option>
                    <option <?php selected($instance['width'], '3');?> value="3"><?php _e('One Third (1/3)','optimizer'); ?></option>
                    <option <?php selected($instance['width'], '4');?> value="4"><?php _e('Two Quarter (2/3)','optimizer'); ?></option>
                    <option <?php selected($instance['width'], '5');?> value="5"><?php _e('Quarter (1/4)','optimizer'); ?></option>
                    <option <?php selected($instance['width'], '6');?> value="6"><?php _e('Three Quarter (3/4)','optimizer'); ?></option>
                </select>
                </label>
                
                <label for="<?php echo $t->get_field_id('visibility'); ?>"><span><?php _e('Display On:','optimizer'); ?></span>
                <select id="<?php echo $t->get_field_id('visibility'); ?>" name="<?php echo $t->get_field_name('visibility'); ?>">
                    <option <?php selected($instance['visibility'], '1');?> value="1"><?php _e('All Devices','optimizer'); ?></option>
                    <option <?php selected($instance['visibility'], '2');?>value="2"><?php _e('Desktop Only','optimizer'); ?></option>
                    <option <?php selected($instance['visibility'], '3');?> value="3"><?php _e('Mobile Only','optimizer'); ?></option>
 
                </select>
                </label>
                
                <label for="<?php echo $t->get_field_id('margin'); ?>"><span><?php _e('Margin (in px or %):','optimizer'); ?></span><br>
                <input class="widgt_spacing" id="<?php echo $t->get_field_id('margin'); ?>" name="<?php echo $t->get_field_name('margin'); ?>[]" value="<?php echo $instance['margin'][0]; ?>" placeholder="Top" />
                <input class="widgt_spacing" id="<?php echo $t->get_field_id('margin'); ?>" name="<?php echo $t->get_field_name('margin'); ?>[]" value="<?php echo $instance['margin'][1]; ?>" placeholder="Bottom" />
                <input class="widgt_spacing" id="<?php echo $t->get_field_id('margin'); ?>" name="<?php echo $t->get_field_name('margin'); ?>[]" value="<?php echo $instance['margin'][2]; ?>" placeholder="Left" />
                <input class="widgt_spacing" id="<?php echo $t->get_field_id('margin'); ?>" name="<?php echo $t->get_field_name('margin'); ?>[]" value="<?php echo $instance['margin'][3]; ?>" placeholder="Right" />
                </label>
                
                <label for="<?php echo $t->get_field_id('padding'); ?>"><span><?php _e('Padding (in px or %):','optimizer'); ?></span><br>
                <input class="widgt_spacing" id="<?php echo $t->get_field_id('padding'); ?>" name="<?php echo $t->get_field_name('padding'); ?>[]" value="<?php echo $instance['padding'][0]; ?>" placeholder="Top" />
                <input class="widgt_spacing" id="<?php echo $t->get_field_id('padding'); ?>" name="<?php echo $t->get_field_name('padding'); ?>[]" value="<?php echo $instance['padding'][1]; ?>" placeholder="Bottom" />
                <input class="widgt_spacing" id="<?php echo $t->get_field_id('padding'); ?>" name="<?php echo $t->get_field_name('padding'); ?>[]" value="<?php echo $instance['padding'][2]; ?>" placeholder="Left" />
                <input class="widgt_spacing" id="<?php echo $t->get_field_id('padding'); ?>" name="<?php echo $t->get_field_name('padding'); ?>[]" value="<?php echo $instance['padding'][3]; ?>" placeholder="Right" />
                </label>
                
            </div>
        </div>
    <?php } ?>
    <?php
    $retrun = null;
    return array($t,$return,$instance);
}



function optimizer_in_widget_form_update($instance, $new_instance, $old_instance){
    $instance['width'] = $new_instance['width'];
	$instance['visibility'] = $new_instance['visibility'];
	$instance['margin'] = $new_instance['margin'];
	$instance['padding'] = $new_instance['padding'];

        if ( isset( $new_instance['margin'] ) )
        {
            foreach ( $new_instance['margin'] as $themargin )
            {
                if ( '' !== trim( $themargin['margin'] ) )
                    $instance['margin'][] = $themargin;
            }
        }
		
        if ( isset( $new_instance['padding'] ) )
        {
            foreach ( $new_instance['padding'] as $thepadding )
            {
                if ( '' !== trim( $thepadding['padding'] ) )
                    $instance['padding'][] = $thepadding;
            }
        }
	
    return $instance;
}

function optimizer_dynamic_sidebar_params($params){
    global $wp_registered_widgets;
    $widget_id = $params[0]['widget_id'];
    $widget_obj = $wp_registered_widgets[$widget_id];
    $widget_opt = get_option($widget_obj['callback'][0]->option_name);
    $widget_num = $widget_obj['params'][0]['number'];

            if(isset($widget_opt[$widget_num]['width']))
                    $width = $widget_opt[$widget_num]['width'];
            else
                	$width = '';
					
            if(isset($widget_opt[$widget_num]['visibility']))
                    $visibility = $widget_opt[$widget_num]['visibility'];
            else
                	$visibility = '';	

					
            $params[0]['before_widget'] = preg_replace('/class="/', ' class="widget_col_'.$width.' widget_visbility_'.$visibility.' ',  $params[0]['before_widget'], 1);

    return $params;
}



//CUSTOMIZE THIS PAGE PANEL
function below_the_editor() {
	$screen = get_current_screen();
	if( current_user_can('manage_options') && $screen->id == 'page' ){ 
	
		$widgetized = get_post_meta(get_the_ID(), "widgetized", true);
		$sidebarid = get_post_meta(get_the_ID(), "page_sidebar");
		if($widgetized == '1' && $sidebarid !=='null' ){
			$cpanel = '<div id="customize_page_panel" class="page_widgetized"><div class="custimize_pp_inner">';
			$cpanel .= '<a href="'.admin_url('/customize.php?autofocus[panel]=widgets&url='.get_the_permalink(get_the_ID()).'').'" class="goto_customizer button button-primary button-large">'. __('Add/Edit Widgets','optimizer').'</a>';
			$cpanel .= '<form id="optimizer_unwidgetizer_form" method="post" action=""><input type="hidden" name="widgetize_pid" value="'.get_the_ID().'" />'.wp_nonce_field( 'optimizer_unwidgetized', 'optimizer_unwidgetized' ).'<input class="button button-large" type="submit" name="unwidgetizer" value="'. __('Remove Widgets & Switch Back to Editor','optimizer').'" /></form>';
			$cpanel .= '</div></div>';
			
		}else{

			$cpanel = '<div id="customize_page_panel"><div class="custimize_pp_inner"><p>'. __('Customize This Page with Widgets like Optimizer Frontpage.','optimizer').'</p>';
			$cpanel .= '<form id="optimizer_widgetizer_form" method="post" action=""><input type="hidden" name="widgetize_pid" value="'.get_the_ID().'" />'.wp_nonce_field( 'optimizer_widgetized', 'optimizer_widgetized' ).'<input class="button button-primary button-large" type="submit" name="widgetizer" value="'. __('Activate','optimizer').'" /></form>';
			$cpanel .= '</div></div>';
			
			}
		
		echo $cpanel;
	}
}
add_action( 'edit_form_after_editor', 'below_the_editor' );


//Widgetize The Page
add_action( 'shutdown', 'optimizer_widgetizer' );
function optimizer_widgetizer() {

    if(isset($_POST['widgetizer']) && isset($_POST['widgetize_pid']) && check_admin_referer( 'optimizer_widgetized', 'optimizer_widgetized' ) ) {
		global $optimizer;

		$post_id = absint($_POST['widgetize_pid']);
		$post_tt = get_the_title($post_id);
		$post_tt = str_replace(',','',$post_tt);
		if(strpos($post_tt, " ") !== false){
			$pieces = explode(" ", $post_tt);
			$sidebarname = implode(" ", array_splice($pieces, 0, 5));
		}else{
			$sidebarname = get_the_title($post_id);
			$sidebarname = str_replace(',','',$sidebarname);
		}
		$sidebarid = 'optimizer_'.str_replace('%','',sanitize_title($sidebarname));
		$currentsidebars = explode(',',$optimizer['custom_sidebar']);
		
		
		$active_widgets = get_option( 'sidebars_widgets' );
		$active_widgets[ $sidebarid ][] = 'calendar-'.$post_id.'';
		// Assing a default widget
		$activ_about = get_option( 'widget_calendar' );
		$activ_about[ $post_id ] = array ();
		update_option( 'widget_calendar', $activ_about);
		update_option( 'sidebars_widgets', $active_widgets );
		
		//First Add a New Sidebar
		if(!empty($optimizer['custom_sidebar']) && !in_array($sidebarname, $currentsidebars)){  
				$optimizer['custom_sidebar'] = $optimizer['custom_sidebar'].','.$sidebarname;   
				update_option( 'optimizer', $optimizer ); 
		}
		if(empty($optimizer['custom_sidebar'])){   
				$optimizer['custom_sidebar'] = $sidebarname;   
				update_option( 'optimizer', $optimizer ); 
		}
		//Change the page template & Then Assign the newly created sidebar to this page & Then add "widetize" post_meta for identification
		update_post_meta($post_id, "_wp_page_template", "template_parts/page-nocontent_template.php");
		update_post_meta($post_id, "page_sidebar", $sidebarid);
		update_post_meta($post_id, "widgetized", "1");

		//$redirect = admin_url('/customize.php?autofocus[panel]=widgets&url='.get_the_permalink($post_id).''); 
		//wp_redirect( $redirect);
    }
}	

//Un-Widgetize The Page
add_action( 'shutdown', 'optimizer_unwidgetizer' );
function optimizer_unwidgetizer() {
	
	if(isset($_POST['unwidgetizer']) && isset($_POST['widgetize_pid']) && check_admin_referer( 'optimizer_unwidgetized', 'optimizer_unwidgetized' ) ) {	
		global $optimizer;

		$post_id = absint($_POST['widgetize_pid']);
		$post_tt = get_the_title($post_id);
		if(strpos($post_tt, " ") !== false){
			$pieces = explode(" ", $post_tt);
			$sidebarname = implode(" ", array_splice($pieces, 0, 5));
		}else{
			$sidebarname = get_the_title($post_id);
		}
		$sidebarid = 'optimizer_'.str_replace('%','',sanitize_title($sidebarname));
		$currentsidebars = explode(',',$optimizer['custom_sidebar']);
		

		//Then Remove the Custom Sidebar
		if(!empty($optimizer['custom_sidebar']) && in_array($sidebarname, $currentsidebars)){  
					//REMOVE The sidebar from the Optimizer Option
					$key = array_search ($sidebarname, $currentsidebars);
					unset( $currentsidebars[$key] );
					$currentsidebars = rtrim(implode(',',$currentsidebars));
					$optimizer['custom_sidebar'] = $currentsidebars ;    
					update_option( 'optimizer', $optimizer ); 
		}
		
		//Remove the Widgets First
		$active_widgets = get_option( 'sidebars_widgets' );
		unset($active_widgets[$sidebarid]);
		//$active_widgets[ $sidebarid ] = null;
		update_option( 'sidebars_widgets', $active_widgets );
		
		
		error_log($post_id);
		//THEN Change the page template & Then Assign the newly created sidebar to this page & Then add "widetize" post_meta for identification
		update_post_meta($post_id, "_wp_page_template", "default");
		update_post_meta($post_id, "page_sidebar", "null");
		update_post_meta($post_id, "widgetized", "");
	}

}

/* Add custom column to post list */
add_filter( 'manage_pages_columns' , 'optimizer_customize_column' );
function optimizer_customize_column( $columns ) {
    return array_merge( $columns, 
        array( 'customizer' => __( 'Customize', 'optimizer' ) ) );
}


add_action( 'manage_pages_custom_column', 'optimizer_page_column_content', 10, 2 );
function optimizer_page_column_content( $column_name, $post_id ) {
	if ( $column_name == 'customizer' ) {
		
		$widgetized = get_post_meta(get_the_ID(), "widgetized", true);
		$sidebarid = get_post_meta(get_the_ID(), "page_sidebar");
		
		if($widgetized == '1' && $sidebarid !=='null' ){
			echo '<a href="'.admin_url('/customize.php?autofocus[panel]=widgets&url='.get_the_permalink(get_the_ID()).'').'" class="goto_customizer button button-primary button-large">Customize</a>';
		}
	}
}

