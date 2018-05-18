<?php
/*
 *FRONTPAGE - TEXT SECTION WIDGET
 */
add_action( 'widgets_init', 'optimizer_register_front_text' );

/*
 * Register widget.
 */
function optimizer_register_front_text() {
	register_widget( 'optimizer_front_text' );
}


/*
 * Widget class.
 */
class optimizer_front_Text extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */

	function __construct() {
		if(is_customize_preview()){$widgetname = __( 'Advanced Text', 'optimizer' ); }else{ $widgetname = __( '&diams; Advanced Text Widget', 'optimizer' ); }
		parent::__construct( 'optimizer_front_text', $widgetname, array(
			'classname'   => 'optimizer_front_text textblock',
			'description' => __( 'Optimizer Advanced Text Section widget', 'optimizer' ),
			'customize_selective_refresh' => true,
		) );
		$this->alt_option_name = 'optimizer_front_text';
		add_action('wp_enqueue_scripts', array(&$this, 'front_text_enqueue_css'));
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {

		
		extract( $args );
		/* Our variables from the widget settings. */
		$content = isset( $instance['content'] ) ? apply_filters( 'wp_editor_widget_content', $instance['content'] ) : __('Lorem ipsum dolor sit amet, consectetur dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.', 'optimizer');
		$padtopbottom = isset( $instance['padtopbottom'] ) ? apply_filters('widget_title', $instance['padtopbottom'] ) : '';
		$paddingside = isset( $instance['paddingside'] ) ? apply_filters('widget_title', $instance['paddingside'] ) : '';
		$parallax = isset( $instance['parallax'] ) ? $instance['parallax'] : '';
		$content_color = isset( $instance['content_color'] ) ? $instance['content_color'] : '';
		$content_bg = isset( $instance['content_bg'] ) ? $instance['content_bg'] : '';
		$content_bgimg = isset( $instance['content_bgimg'] ) ? esc_url($instance['content_bgimg']) : '';

		/* Before widget (defined by themes). */
		echo $before_widget;
		
			//Sitegorigin Builder FIX
			echo '<span class="so_widget_id" data-panel-id="'.$this->id.'"></span>';
			if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';

			if ( !empty($parallax) ){$parallax = 'text_parallax';}else{$parallax = '';}
			
		echo '<div class="text_block '.$parallax.'">
				<div class="parallax_img" data-parallax="scroll" data-image-src="'.$content_bgimg.'"></div>
				<div class="text_block_wrap">
				<div class="center">';

			
			if ( $content || is_customize_preview() ){  
					//Make inline editable
					if(is_customize_preview()){ $id= $this->id; $controlid = 'data-optionid="widget-'.$id.'-content"';}else{ $controlid = '';}
					
					echo '<div class="text_block_content tiny_content_editable" '.$controlid .'>'.do_shortcode(wp_make_content_images_responsive($content)).'</div>';  
			}
		
		
		echo '</div></div></div>';


		//Stylesheet-loaded in Customizer Only.
		if(is_customize_preview()){
			$id= $this->id;
			$content_bg =		isset( $instance['content_bg'] ) ? 'background-color:'.$instance['content_bg'].';' : 'background-color:#333333;';
			$content_bgimg =	isset( $instance['content_bgimg'] ) ? 'background-image:url(' . $instance['content_bgimg'] . ');' : '';
			$padtopbottom =		isset( $instance['padtopbottom'] ) ? 'padding-top:'.$instance['padtopbottom'].'%;padding-bottom:'.$instance['padtopbottom'].'%;' : 'padding-top:5%;padding-bottom:5%;';
			$paddingside =		isset( $instance['paddingside'] ) ? 'padding-left:'.$instance['paddingside'].'%;padding-right:'.$instance['paddingside'].'%;' : 'padding-left:5%;padding-right:5%;';
			$content_color =	isset( $instance['content_color'] ) ? 'color:'.$instance['content_color'].';' : 'color:#ffffff;';
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
					$calcWidth ='width: calc('.$thewidth.'% - '.$leftrightmargin.')!important;';
					
			}
			
			//Padding
			if ( ! empty( $instance['padding'] ) ) {
				if(!empty($instance['padding'][0])){ $paddingTop ='padding-top:'.$instance['padding'][0].';';}
				if(!empty($instance['padding'][1])){ $paddingBottom ='padding-bottom:'.$instance['padding'][1].';';}
				if(!empty($instance['padding'][2])){ $paddingLeft ='padding-left:'.$instance['padding'][2].';';}
				if(!empty($instance['padding'][3])){ $paddingRight ='padding-right:'.$instance['padding'][3].';';}
				
				$boxSizing='box-sizing:border-box;';
				
			}
			
			echo '<style>#'.$id.' .text_block{ ' . $content_bg . '' .$padtopbottom. '' .$paddingside. ''.$content_color. '' . $content_bgimg . '}#'.$id.' .text_block a:link, #'.$id.' .text_block a:visited{'.$content_color. '}   @media screen and (min-width: 480px){#'.$id.' .text_block{'.$marginTop.$marginBottom.$marginLeft.$marginRight. $paddingTop.$paddingBottom.$paddingLeft.$paddingRight.'}.frontpage_sidebar #'.$id.' {'.$calcWidth. $boxSizing.'} }</style>';

		}
		$id= $this->id;
		if($parallax){ echo '<script>jQuery(window).ready(function() {jQuery("#'.$id.' .parallax_img").parallax({naturalHeight: jQuery(this).parent().outerHeight(), bleed: 50, iosFix: true, androidFix: true});  });</script>';}
		
		
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
		$instance['padtopbottom'] = strip_tags($new_instance['padtopbottom']);
		$instance['paddingside'] = strip_tags($new_instance['paddingside']);
		$instance['parallax'] = strip_tags($new_instance['parallax']);
		$instance['content_color'] = optimizer_sanitize_hex($new_instance['content_color']);
		$instance['content_bg'] = optimizer_sanitize_hex($new_instance['content_bg']);
		$instance['content_bgimg'] = esc_url_raw($new_instance['content_bgimg']);
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
		'content' => __('Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits. Dramatically visualize customer directed convergence without revolutionary ROI.','optimizer'),
		'padtopbottom' => '2',
		'paddingside' => '2',
		'parallax' => '',
		'content_color' => '#ffffff',
		'content_bg' => '#333333',
		'content_bgimg' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>


        <!-- Text Content Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e('Content:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" value="<?php echo esc_attr($instance['content']); ?>" type="hidden" />
            <a onclick="javascript:WPEditorWidget.showEditor('<?php echo $this->get_field_id( 'content' ); ?>');" class="button edit-content-button"><?php _e( 'Edit content', 'optimizer' ) ?></a>
		</p>
        
		
		<!-- Text Content Padding top/bottom Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'padtopbottom' ); ?>"><?php _e('Top &amp; Bottom Padding', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'padtopbottom' ); ?>" name="<?php echo $this->get_field_name( 'padtopbottom' ); ?>" value="<?php echo $instance['padtopbottom']; ?>"  min="0" max="80" type="range" />
		</p>
        
		<!-- Text Content Padding left/right Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'paddingside' ); ?>"><?php _e('Side Padding', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'paddingside' ); ?>" name="<?php echo $this->get_field_name( 'paddingside' ); ?>" value="<?php echo $instance['paddingside']; ?>"  min="0" max="80" type="range" />
		</p> 

		
		<!-- Text Content Text Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'content_color' ); ?>"><?php _e('Text Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'content_color' ); ?>" name="<?php echo $this->get_field_name( 'content_color' ); ?>" value="<?php echo $instance['content_color']; ?>" type="text" />
		</p>
                
        <!-- Text Content Background Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'content_bg' ); ?>"><?php _e('Background Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'content_bg' ); ?>" name="<?php echo $this->get_field_name( 'content_bg' ); ?>" value="<?php echo $instance['content_bg']; ?>" type="text" />
		</p>
		
		<!-- Text Content Background Image Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'content_bgimg' ); ?>"><?php _e('Background Image', 'optimizer') ?></label>
			<div class="media-picker-wrap">
            <?php if(!empty($instance['content_bgimg'])) { ?>
				<img style="max-width:100%; height:auto;" class="media-picker-preview" src="<?php echo esc_url($instance['content_bgimg']); ?>" />
                <i class="fa fa-times media-picker-remove"></i>
            <?php } ?>
            <input class="widefat media-picker" id="<?php echo $this->get_field_id( 'content_bgimg' ); ?>" name="<?php echo $this->get_field_name( 'content_bgimg' ); ?>" value="<?php echo esc_url($instance['content_bgimg']); ?>" type="hidden" />
            <a class="media-picker-button button" onclick="mediaPicker(this.id)" id="<?php echo $this->get_field_id( 'content_bgimg' ).'mpick'; ?>"><?php _e('Select Image', 'optimizer') ?></a>
            </div>
		</p>
        

        <!-- Text Content Parallax Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'parallax' ); ?>"><?php _e('Parallax Effect', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'parallax' ); ?>" name="<?php echo $this->get_field_name( 'parallax' ); ?>" value="1" type="checkbox" <?php if ( '1' == $instance['parallax'] ) echo 'checked'; ?> />
		</p>
        
        
        
<?php
	}
		//ENQUEUE CSS
        function front_text_enqueue_css() {
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
			

			$content_bgimg =	isset( $instance['content_bgimg'] ) ? 'background-image:url(' . $instance['content_bgimg'] . ');' : '';
			$content_bg =		isset( $instance['content_bg'] ) ? 'background-color:'.$instance['content_bg'].';' : 'background-color:#333333;';
			$padtopbottom =		isset( $instance['padtopbottom'] ) ? 'padding-top:'.$instance['padtopbottom'].'%;padding-bottom:'.$instance['padtopbottom'].'%;' : 'padding-top:5%;padding-bottom:5%;';
			$paddingside =		isset( $instance['paddingside'] ) ? 'padding-left:'.$instance['paddingside'].'%;padding-right:'.$instance['paddingside'].'%;' : 'padding-left:5%;padding-right:5%;';
			$content_color =	isset( $instance['content_color'] ) ? 'color:'.$instance['content_color'].';' : 'color:#ffffff;';
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
					$calcWidth ='width: calc('.$thewidth.'% - '.$leftrightmargin.')!important;';
					
			}
			
			//Padding
			if ( ! empty( $instance['padding'] ) ) {
				if(!empty($instance['padding'][0])){ $paddingTop ='padding-top:'.$instance['padding'][0].';';}
				if(!empty($instance['padding'][1])){ $paddingBottom ='padding-bottom:'.$instance['padding'][1].';';}
				if(!empty($instance['padding'][2])){ $paddingLeft ='padding-left:'.$instance['padding'][2].';';}
				if(!empty($instance['padding'][3])){ $paddingRight ='padding-right:'.$instance['padding'][3].';';}
				
				$boxSizing='box-sizing:border-box;';
				
			}
			
			$widget_style = '#'.$id.' .text_block{ ' . $content_bg . '' .$padtopbottom. '' .$paddingside. ''.$content_color. '' . $content_bgimg . '}#'.$id.' .text_block a:link, #'.$id.' .text_block a:visited{'.$content_color. '}@media screen and (max-width: 480px){#'.$id.' .text_block .parallax_img{'.$content_bgimg.'}}   @media screen and (min-width: 480px){#'.$id.' .text_block{'.$marginTop.$marginBottom.$marginLeft.$marginRight. $paddingTop.$paddingBottom.$paddingLeft.$paddingRight.'}.frontpage_sidebar #'.$id.' {'.$calcWidth. $boxSizing.'} }';
			wp_add_inline_style( 'optimizer-style', $widget_style );
			
        	}
		}
	}
}
?>