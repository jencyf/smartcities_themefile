<?php
/*
 *FRONTPAGE - CTA SECTION WIDGET
 */
add_action( 'widgets_init', 'optimizer_register_front_cta' );

/*
 * Register widget.
 */
function optimizer_register_front_cta() {
	register_widget( 'optimizer_front_cta' );
}


/*
 * Widget class.
 */
class optimizer_front_Cta extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	

	function __construct() {
		if(is_customize_preview()){$widgetname = __( 'CTA', 'optimizer' ); }else{ $widgetname = __( '&diams; CTA Widget', 'optimizer' ); }
		
		parent::__construct( 'optimizer_front_cta', $widgetname, array(
			'classname'   => 'optimizer_front_cta actionblck',
			'description' => __( 'Optimizer Frontpage Call to Action Section widget', 'optimizer' ),
			'customize_selective_refresh' => true,
		) );
		$this->alt_option_name = 'optimizer_front_cta';
		add_action('wp_enqueue_scripts', array(&$this, 'front_cta_enqueue_css'));
	}	
	

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {

		
		extract( $args );
		/* Our variables from the widget settings. */
		$content = isset( $instance['content'] ) ? apply_filters( 'wp_editor_widget_content', $instance['content'] ) : __('Collaboratively administrate empowered markets via plug-and-play networks.','optimizer');
		$buttontxt = isset( $instance['buttontxt'] ) ? apply_filters('wp_editor_widget_content',  $instance['buttontxt']) :  __('DOWNLOAD NOW', 'optimizer');
		$buttonlink = isset( $instance['buttonlink'] ) ? esc_url($instance['buttonlink']) : '#';
		$buttonalign = isset( $instance['buttonalign'] ) ? apply_filters('widget_title', $instance['buttonalign']) : 'button_right';
		$buttonstyle = isset( $instance['buttonstyle'] ) ? apply_filters('widget_title', $instance['buttonstyle']) : 'button_flat';
		
		$buttontxtcolor = isset( $instance['buttontxtcolor'] ) ? $instance['buttontxtcolor'] : '';
		$buttonbgcolor = isset( $instance['buttonbgcolor'] ) ? $instance['buttonbgcolor'] : '';
		$ctatxtcolor = isset( $instance['ctatxtcolor'] ) ? $instance['ctatxtcolor'] : '';
		$ctabgcolor = isset( $instance['ctabgcolor'] ) ? $instance['ctabgcolor'] : '';
		$ctabgimg = isset( $instance['ctabgimg'] ) ? esc_url($instance['ctabgimg']) : '';

		/* Before widget (defined by themes). */
		echo $before_widget;
		
			//Sitegorigin Builder FIX
			echo '<span class="so_widget_id" data-panel-id="'.$this->id.'"></span>';
			if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';
		
		echo '<div class="home_action cta_'.$buttonalign.'"><div class="center">';
			//Make inline editable
			if(is_customize_preview()){ $id= $this->id; $controlid = 'data-optionid="widget-'.$id.'-content"';}else{ $controlid = '';}
			
			echo '<div class="home_action_left tiny_content_editable" '.$controlid.'>'.do_shortcode( $content ).'</div>';
			
		if ( $buttontxt ){
			$buttonlink = 'href="'.do_shortcode($buttonlink).'"';
			echo '<div class="home_action_right"><div class="home_action_button_wrap"><div class="home_action_button '.$buttonstyle.'"><a '.$buttonlink.'>'.do_shortcode($buttontxt).'</a></div></div></div>';
		}
		
		echo '</div></div>';


		//Stylesheet-loaded in Customizer Only.
		if(is_customize_preview()){
			$id= $this->id;
			
			$buttontxtcolor =		'color:#ffffff;';
			$buttonbgcolor =		'background-color:#db5a49;';
			$ctatxtcolor =			'color:#444444;';
			$ctabgcolor =			'background-color:#f5f5f5;';
			$ctabgimg =				'';
			$marginTop =''; $marginBottom =''; $marginLeft =''; $marginRight ='';$calcWidth =''; 
			$paddingTop =''; $paddingBottom =''; $paddingLeft =''; $paddingRight =''; $boxSizing='';
			
			//Margin
			if ( ! empty( $instance['margin'] ) ) {
				if(!empty($instance['margin'][0])){ $marginTop ='margin-top:'.$instance['margin'][0].';';}
				if(!empty($instance['margin'][1])){ $marginBottom ='margin-bottom:'.$instance['margin'][1].';';}
				if(!empty($instance['margin'][2])){ $marginLeft ='margin-left:'.$instance['margin'][2].';';}
				if(!empty($instance['margin'][3])){ $marginRight ='margin-right:'.$instance['margin'][3].';';}
				
					//Width
					$thewidth ='100';
					$leftrightmargin ='0px';
					
					if ( ! empty( $instance['width']) ) {
							if($instance['width'] == 2){ $thewidth = '50';} if($instance['width'] == 3){ $thewidth = '33.33';} if($instance['width'] == 4){ $thewidth = '66.67';}  
							if($instance['width'] == 5){ $thewidth = '25';}  if($instance['width'] == 6){ $thewidth = '75';}   
					}
					if ( ! empty( $instance['width']) && !empty($instance['margin'][2]  ) ) {	$leftrightmargin = $instance['margin'][2];   }
					if ( ! empty( $instance['width']) && !empty($instance['margin'][3]  ) ) {	$leftrightmargin = $instance['margin'][3];	}
					
					if ( ! empty( $instance['width']) ) {
						if(!empty($instance['margin'][2]) && !empty($instance['margin'][3]) ){
								$leftrightmargin = '('.$instance['margin'][2].' + '.$instance['margin'][3].')';
						}
					}
					$calcWidth ='width: calc(100% - '.$leftrightmargin.')!important;';
					
			}
			
			//Padding
			if ( ! empty( $instance['padding'] ) ) {
				if(!empty($instance['padding'][0])){ $paddingTop ='padding-top:'.$instance['padding'][0].';';}
				if(!empty($instance['padding'][1])){ $paddingBottom ='padding-bottom:'.$instance['padding'][1].';';}
				if(!empty($instance['padding'][2])){ $paddingLeft ='padding-left:'.$instance['padding'][2].';';}
				if(!empty($instance['padding'][3])){ $paddingRight ='padding-right:'.$instance['padding'][3].';';}
				
				$boxSizing='box-sizing:border-box;';
				
			}
			
			
			if ( ! empty( $instance['buttontxtcolor'] ) ) {	$buttontxtcolor = 'color: ' . $instance['buttontxtcolor'] . '; ';}
			if ( ! empty( $instance['ctatxtcolor'] ) ) {	$ctatxtcolor = 'color: ' . $instance['ctatxtcolor'] . '; ';}
			if ( ! empty( $instance['buttonbgcolor'] ) ) {	$buttonbgcolor = 'background-color: ' . $instance['buttonbgcolor'] . '; ';}
			if ( ! empty( $instance['ctabgcolor'] ) ) {		$ctabgcolor = 'background-color: ' . $instance['ctabgcolor'] . '; ';}
			if ( ! empty( $instance['ctabgimg'] ) ) {		$ctabgimg = 'background-image: url(' . $instance['ctabgimg'] . '); ';}
			if ( ! empty( $instance['buttontxtcolor'] ) ) {	$hollhowborder = 'border-color: ' . $instance['buttontxtcolor'] . '; ';}else{ $hollhowborder = ''; }
			if ( ! empty( $instance['buttonbgcolor'] ) ) {	$roundedborder = 'border-color: ' . $instance['buttonbgcolor'] . '; ';}else{ $roundedborder = ''; }
			
			
			echo '<style>#'.$id.' .home_action{ ' . $ctabgcolor . '' . $ctabgimg . ''.$ctatxtcolor. '}   #'.$id.' .home_action_button a{ ' . $buttontxtcolor . '}#'.$id.' .home_action_button.button_hollow{ ' . $hollhowborder . '}#'.$id.' .button_flat, #'.$id.' .button_rounded{' . $buttontxtcolor . '' . $buttonbgcolor . ' ' . $roundedborder . '}   @media screen and (min-width: 480px){#'.$id.' .home_action{'.$marginTop.$marginBottom.$marginLeft.$marginRight.$calcWidth. $paddingTop.$paddingBottom.$paddingLeft.$paddingRight. $boxSizing.'} }</style>';
			
		}

		/* After widget (defined by themes). */
		echo $after_widget;
		
	}


	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
	
		/* No need to strip tags */
		$instance['content'] = wp_kses_post($new_instance['content']);
		$instance['buttontxt'] = strip_tags($new_instance['buttontxt']);
		$instance['buttonlink'] = esc_url_raw($new_instance['buttonlink']);
		$instance['buttonalign'] = strip_tags($new_instance['buttonalign']);
		$instance['buttonstyle'] = strip_tags($new_instance['buttonstyle']);
		
		$instance['buttontxtcolor'] = optimizer_sanitize_hex($new_instance['buttontxtcolor']);
		$instance['buttonbgcolor'] = optimizer_sanitize_hex($new_instance['buttonbgcolor']);
		$instance['ctatxtcolor'] = optimizer_sanitize_hex($new_instance['ctatxtcolor']);
		$instance['ctabgcolor'] = optimizer_sanitize_hex($new_instance['ctabgcolor']);
		$instance['ctabgimg'] = esc_url_raw($new_instance['ctabgimg']);

		return $instance;
	}
	
	/* ---------------------------- */
	/* ------- Widget Settings ------- */
	/* ---------------------------- */
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
		'content' => __('Collaboratively administrate empowered markets via plug-and-play networks.','optimizer'),
		'buttontxt' => __('DOWNLOAD NOW','optimizer'),
		'buttonlink' => '#',
		'buttonalign' => 'button_right',
		'buttonstyle' => 'button_flat',
		'buttontxtcolor' => '#ffffff',
		'buttonbgcolor' => '#db5a49',
		'ctatxtcolor' => '#444444',
		'ctabgcolor' => '#f5f5f5',
		'ctabgimg' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

        
        <!-- Text Content Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e('CTA Content:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" value="<?php echo esc_attr($instance['content']); ?>" type="hidden" />
            <a href="javascript:WPEditorWidget.showEditor('<?php echo $this->get_field_id( 'content' ); ?>');" class="button edit-content-button"><?php _e( 'Edit content', 'optimizer' ) ?></a>
		</p>
        
		<!-- CTA Button TEXT Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'buttontxt' ); ?>"><?php _e('Button Text:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'buttontxt' ); ?>" name="<?php echo $this->get_field_name( 'buttontxt' ); ?>" value="<?php echo htmlspecialchars($instance['buttontxt'], ENT_QUOTES, "UTF-8"); ?>" type="text" />
		</p>
        

		<!-- CTA Button Link Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'buttonlink' ); ?>"><?php _e('Button Link:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'buttonlink' ); ?>" name="<?php echo $this->get_field_name( 'buttonlink' ); ?>" value="<?php echo esc_url($instance['buttonlink']); ?>" type="text" />
		</p>
        
        <!-- CTA Button Align Field -->
        <p>
			<label for="<?php echo $this->get_field_id( 'buttonalign' ); ?>"><?php _e('Button Alignment:', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'buttonalign' ); ?>" name="<?php echo $this->get_field_name( 'buttonalign' ); ?>" class="widefat">
				<option value="button_left" <?php if ( 'button_left' == $instance['buttonalign'] ) echo 'selected="selected"'; ?>><?php _e('Left', 'optimizer') ?></option>
				<option value="button_right" <?php if ( 'button_right' == $instance['buttonalign'] ) echo 'selected="selected"'; ?>><?php _e('Right', 'optimizer') ?></option>
                <option value="button_center" <?php if ( 'button_center' == $instance['buttonalign'] ) echo 'selected="selected"'; ?>><?php _e('Center', 'optimizer') ?></option>
			</select>
		</p>
        
        <!-- CTA Button Style Field -->
        <p>
			<label for="<?php echo $this->get_field_id( 'buttonstyle' ); ?>"><?php _e('Button Style:', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'buttonstyle' ); ?>" name="<?php echo $this->get_field_name( 'buttonstyle' ); ?>" class="widefat">
				<option value="button_flat" <?php if ( 'button_flat' == $instance['buttonstyle'] ) echo 'selected="selected"'; ?>><?php _e('Flat', 'optimizer') ?></option>
				<option value="button_hollow" <?php if ( 'button_hollow' == $instance['buttonstyle'] ) echo 'selected="selected"'; ?>><?php _e('Hollow', 'optimizer') ?></option>
                <option value="button_rounded" <?php if ( 'button_rounded' == $instance['buttonstyle'] ) echo 'selected="selected"'; ?>><?php _e('Rounded', 'optimizer') ?></option>
			</select>
		</p>
        
        
        <!-- CTA BUTTON Text Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'buttontxtcolor' ); ?>"><?php _e('Button Text Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'buttontxtcolor' ); ?>" name="<?php echo $this->get_field_name( 'buttontxtcolor' ); ?>" value="<?php echo $instance['buttontxtcolor']; ?>" type="text" />
		</p>
        
        <!-- CTA BUTTON Background Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'buttonbgcolor' ); ?>"><?php _e('Button Background Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'buttonbgcolor' ); ?>" name="<?php echo $this->get_field_name( 'buttonbgcolor' ); ?>" value="<?php echo $instance['buttonbgcolor']; ?>" type="text" />
		</p>
        
        
        <!-- CTA Section Text Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ctatxtcolor' ); ?>"><?php _e('CTA Section Text Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'ctatxtcolor' ); ?>" name="<?php echo $this->get_field_name( 'ctatxtcolor' ); ?>" value="<?php echo $instance['ctatxtcolor']; ?>" type="text" />
		</p>  
                
        <!-- CTA Section Background Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ctabgcolor' ); ?>"><?php _e('CTA Section Background Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'ctabgcolor' ); ?>" name="<?php echo $this->get_field_name( 'ctabgcolor' ); ?>" value="<?php echo $instance['ctabgcolor']; ?>" type="text" />
		</p>
		
		<!-- CTA Section Background Image Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ctabgimg' ); ?>"><?php _e('CTA Section Background Image', 'optimizer') ?></label>
			<div class="media-picker-wrap">
            <?php if(!empty($instance['ctabgimg'])) { ?>
				<img style="max-width:100%; height:auto;" class="media-picker-preview" src="<?php echo esc_url($instance['ctabgimg']); ?>" />
                <i class="fa fa-times media-picker-remove"></i>
            <?php } ?>
            <input class="widefat media-picker" id="<?php echo $this->get_field_id( 'ctabgimg' ); ?>" name="<?php echo $this->get_field_name( 'ctabgimg' ); ?>" value="<?php echo esc_url($instance['ctabgimg']); ?>" type="hidden" />
            <a class="media-picker-button button" onclick="mediaPicker(this.id)" id="<?php echo $this->get_field_id( 'ctabgimg' ).'mpick'; ?>"><?php _e('Select Image', 'optimizer') ?></a>
            </div>
		</p>
<?php
	}
		//ENQUEUE CSS
        function front_cta_enqueue_css() {
		$settings = $this->get_settings();
		if(!is_customize_preview()){
		if ( empty( $settings ) ) {
			return;
		}

		foreach ( $settings as $instance_id => $instance ) {
			$id = $this->id_base . '-' . $instance_id;

			if ( ! is_active_widget( false, $id, $this->id_base ) ) {
				continue;
			}

			$buttontxtcolor =		'color:#ffffff;';
			$buttonbgcolor =		'background-color:#db5a49;';
			$ctatxtcolor =			'color:#444444;';
			$ctabgcolor =			'background-color:#f5f5f5;';
			$ctabgimg =				'';
						$marginTop =''; $marginBottom =''; $marginLeft =''; $marginRight ='';$calcWidth =''; 
			$paddingTop =''; $paddingBottom =''; $paddingLeft =''; $paddingRight =''; $boxSizing='';
			
			//Margin
			if ( ! empty( $instance['margin'] ) ) {
				if(!empty($instance['margin'][0])){ $marginTop ='margin-top:'.$instance['margin'][0].';';}
				if(!empty($instance['margin'][1])){ $marginBottom ='margin-bottom:'.$instance['margin'][1].';';}
				if(!empty($instance['margin'][2])){ $marginLeft ='margin-left:'.$instance['margin'][2].';';}
				if(!empty($instance['margin'][3])){ $marginRight ='margin-right:'.$instance['margin'][3].';';}
				
					//Width
					$thewidth ='100';
					$leftrightmargin ='0px';
					
					if ( ! empty( $instance['width']) ) {
							if($instance['width'] == 2){ $thewidth = '50';} if($instance['width'] == 3){ $thewidth = '33.33';} if($instance['width'] == 4){ $thewidth = '66.67';}  
							if($instance['width'] == 5){ $thewidth = '25';}  if($instance['width'] == 6){ $thewidth = '75';}   
					}
					if ( ! empty( $instance['width']) && !empty($instance['margin'][2]  ) ) {	$leftrightmargin = $instance['margin'][2];   }
					if ( ! empty( $instance['width']) && !empty($instance['margin'][3]  ) ) {	$leftrightmargin = $instance['margin'][3];	}
					
					if ( ! empty( $instance['width']) ) {
						if(!empty($instance['margin'][2]) && !empty($instance['margin'][3]) ){
								$leftrightmargin = '('.$instance['margin'][2].' + '.$instance['margin'][3].')';
						}
					}
					$calcWidth ='width: calc(100% - '.$leftrightmargin.')!important;';
					
			}
			
			//Padding
			if ( ! empty( $instance['padding'] ) ) {
				if(!empty($instance['padding'][0])){ $paddingTop ='padding-top:'.$instance['padding'][0].';';}
				if(!empty($instance['padding'][1])){ $paddingBottom ='padding-bottom:'.$instance['padding'][1].';';}
				if(!empty($instance['padding'][2])){ $paddingLeft ='padding-left:'.$instance['padding'][2].';';}
				if(!empty($instance['padding'][3])){ $paddingRight ='padding-right:'.$instance['padding'][3].';';}
				
				$boxSizing='box-sizing:border-box;';
				
			}
			
			if ( ! empty( $instance['buttontxtcolor'] ) ) {
				$buttontxtcolor = 'color: ' . $instance['buttontxtcolor'] . '; ';
			}
			if ( ! empty( $instance['ctatxtcolor'] ) ) {
				$ctatxtcolor = 'color: ' . $instance['ctatxtcolor'] . '; ';
			}
			if ( ! empty( $instance['buttonbgcolor'] ) ) {
				$buttonbgcolor = 'background-color: ' . $instance['buttonbgcolor'] . '; ';
			}
			if ( ! empty( $instance['ctabgcolor'] ) ) {
				$ctabgcolor = 'background-color: ' . $instance['ctabgcolor'] . '; ';
			}
			if ( ! empty( $instance['ctabgimg'] ) ) {
				$ctabgimg = 'background-image: url(' . $instance['ctabgimg'] . '); ';
			}

			if ( ! empty( $instance['buttontxtcolor'] ) ) {
				$hollhowborder = 'border-color: ' . $instance['buttontxtcolor'] . '; ';
			}else{ $hollhowborder = ''; }
			if ( ! empty( $instance['buttonbgcolor'] ) ) {
				$roundedborder = 'border-color: ' . $instance['buttonbgcolor'] . '; ';
			}else{ $roundedborder = ''; }
			
			
			$widget_style = '#'.$id.' .home_action{ ' . $ctabgcolor . '' . $ctabgimg . ''.$ctatxtcolor. '}   #'.$id.' .home_action_button a{ ' . $buttontxtcolor . '}#'.$id.' .home_action_button.button_hollow{ ' . $hollhowborder . '}#'.$id.' .button_flat, #'.$id.' .button_rounded{' . $buttontxtcolor . '' . $buttonbgcolor . ' ' . $roundedborder . '}   @media screen and (min-width: 480px){#'.$id.' .home_action{'.$marginTop.$marginBottom.$marginLeft.$marginRight. $paddingTop.$paddingBottom.$paddingLeft.$paddingRight. $boxSizing.$calcWidth.'} }';
			wp_add_inline_style( 'optimizer-style', $widget_style );
			
			}
        }
	}
}
?>