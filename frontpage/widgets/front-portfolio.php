<?php
/*
 *FRONTPAGE - POSTS SECTION WIDGET
 */
 
/**
 * Custom walker to print category checkboxes for widget forms
 */

 
add_action( 'widgets_init', 'optimizer_register_front_portfoio' );

/*
 * Register widget.
 */
function optimizer_register_front_portfoio() {
	register_widget( 'optimizer_front_portfolio' );
}


/*
 * Widget class.
 */
class optimizer_front_Portfolio extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */

	function __construct() {
		if(is_customize_preview()){$widgetname = __( 'Portfolio', 'optimizer' ); }else{ $widgetname = __( '&diams; Portfolio Widget', 'optimizer' ); }
		
		parent::__construct( 'optimizer_front_portfoio', $widgetname, array(
			'classname'   => 'optimizer_front_portfoio postsblck',
			'description' => __( 'This Widget lets you display Portfolio items.', 'optimizer' ),
			'customize_selective_refresh' => true,
		) );
		$this->alt_option_name = 'optimizer_front_portfoio';
		add_action('wp_enqueue_scripts', array(&$this, 'front_portfoio_enqueue_css'));
		add_action('wp_footer', array(&$this,  'optimizer_portfoio_masonry_run'));
		
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {

		
		extract( $args );
		/* Our variables from the widget settings. */
		$title = isset( $instance['title'] ) ? $instance['title'] : __('Our Work', 'optimizer');
		$subtitle = isset( $instance['subtitle'] ) ? $instance['subtitle'] : __('Check Out Our Portfolio', 'optimizer');
		$layout = isset( $instance['layout'] ) ? absint($instance['layout']) : '1';
		$hover = isset( $instance['hover'] ) ? $instance['hover'] : '';
		$count = isset( $instance['count'] ) ? absint($instance['count']) : '6';
		$category = isset( $instance['category'] ) ? $instance['category'] : array();
		
		$previewbtn = isset( $instance['previewbtn'] ) ? $instance['previewbtn'] : '1';
		$linkbtn = isset( $instance['linkbtn'] ) ? $instance['linkbtn'] : '1';
		$divider = isset( $instance['divider'] ) ? apply_filters('widget_title', $instance['divider']) : 'fa-stop';
		$fullwidth = isset( $instance['fullwidth'] ) ? $instance['fullwidth'] : '';
		$postbgcolor = isset( $instance['postbgcolor'] ) ? $instance['postbgcolor'] : '';
		$titlecolor = isset( $instance['titlecolor'] ) ? $instance['titlecolor'] : '';
		$secbgcolor = isset( $instance['secbgcolor'] ) ? $instance['secbgcolor'] : '';
		

		/* Before widget (defined by themes). */
		echo $before_widget;
		
			//Sitegorigin Builder FIX
			echo '<span class="so_widget_id" data-panel-id="'.$this->id.'"></span>';
			if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';
			
			//THE QUERY
			if(!empty($category)){	$blogcat = $category;	$blogcats =implode(',', $blogcat);	}else{	$blogcats = '';	}
			if(!empty($fullwidth)){ $fullwidth_class ='portfolio_full';}else{	$fullwidth_class = '';	}
			if(empty($title) && empty($subtitle) && $divider == 'no_divider'){ $hide_margin ='hide_margin';}else{	$hide_margin = '';	}
		
		echo '<div class="postlayout_'.$layout.' '.$fullwidth_class.' '.$hide_margin.'">
		<div class="optimportfolio" data-post-layout="'.$layout.'" data-post-count="'.$count.'" data-post-category="'.$blogcats.'" data-post-previewbtn="'.$previewbtn.'" data-post-linkbtn="'.$linkbtn.'" data-post-hover="'.$hover.'" >
		<div class="center">';
			
            echo '<div class="homeposts_title">';
            	if($title || is_customize_preview()) { echo '<h2 class="home_title"><span>'.do_shortcode($title).'</span></h2>';}
                if($subtitle || is_customize_preview()) { echo '<div class="home_subtitle"><span>'.do_shortcode($subtitle).'</span></div>'; }
				if ( $divider ){
					if( $divider !== 'no_divider'){
						if($divider == 'underline'){ $underline= 'title_underline';}else{$underline='';}
							echo '<div class="optimizer_divider '.$underline.'"><span class="div_left"></span><span class="div_middle"><i class="fa '.$divider.'"></i></span><span class="div_right"></span></div>';
					}
				}
            echo '</div>';
			
			//Call the Posts
			if(function_exists('portfolio_post_type_init') || ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'custom-content-types' ) ) ){
				optimizer_portfolio_layouts($layout, $count, $hover, $category,$previewbtn , $linkbtn);
			}
			
                
		echo '</div></div></div>';
		

		//Stylesheet-loaded in Customizer Only.
		if(is_customize_preview()){
			$id= $this->id;
			$idbase = str_replace('-','_',$this->id);
			
			$postbgcolor =		'';
			$titlecolor =		'#333333;';
			$secbgcolor =		'background-color:#ffffff;';
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
			
			if ( ! empty( $instance['layout'] ) ) {		$layout = $instance['layout'];  }else{$layout = '1';}
			if ( ! empty( $instance['postbgcolor'] ) ){	$postbgcolor = 'background-color: ' . $instance['postbgcolor'] . '; ';}
			if ( ! empty( $instance['titlecolor'] ) ) {	$titlecolor =  $instance['titlecolor'] . '; ';}
			if ( ! empty( $instance['secbgcolor'] ) ) {	$secbgcolor = 'background-color: ' . $instance['secbgcolor'] . '; ';}
			
			echo '<style>#'.$id.' .optimportfolio{ '.$secbgcolor.' }#'.$id.' .optimportfolio .home_title, #'.$id.' .optimportfolio .home_subtitle, #'.$id.' span.div_middle, #'.$id.' .portfolio_wrap .hover_style_5 .post_content .catag_list, #'.$id.' .portfolio_wrap .hover_style_5 .post_content .catag_list a, #'.$id.' .portfolio_wrap .hover_style_5 .post_content h2 a{color:'.$titlecolor.' }#'.$id.' span.div_left, #'.$id.' span.div_right{background-color:' . $titlecolor . '}  @media screen and (min-width: 480px){#'.$id.' .optimportfolio{'.$marginTop.$marginBottom.$marginLeft.$marginRight. $paddingTop.$paddingBottom.$paddingLeft.$paddingRight.'}#'.$id.' {'.$calcWidth. $boxSizing.'} }</style>';
			

		if($layout == 3 || $layout == 4){
			wp_enqueue_script('optimizer_masonry',get_template_directory_uri().'/assets/js/masonry.js', array('jquery'), false);
			echo '<script type="text/javascript">
			jQuery(window).bind("load", function() {
					//Layout3 Masonry
					
					var container'.$idbase.' = jQuery("#'.$this->id.' .lay1_wrap");
					if(container'.$idbase.'){
						container'.$idbase.'.imagesLoaded(function() {
							container'.$idbase.'.masonry({
							  itemSelector: ".hentry"
							});
						});
						container'.$idbase.'.imagesLoaded(function() {
						
							jQuery(".portfolio_nav li").on("click", function () {
								setTimeout(function(){
									container'.$idbase.'.masonry();
								}, 600);	
							});
						
						});
						
					}
					
			});
			</script>';
		}
		
		} // If Customizer END
		
		/* After widget (defined by themes). */
		echo $after_widget;
		
	}


	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		/* No need to strip tags */
		$instance['subtitle'] = strip_tags( $new_instance['subtitle'] );
		$instance['layout'] = strip_tags($new_instance['layout']);
		$instance['hover'] = $new_instance['hover'];
		$instance['count'] = $new_instance['count'];
		$instance['category'] = $new_instance['category'];
		
		$instance['previewbtn'] = strip_tags($new_instance['previewbtn']);
		$instance['linkbtn'] = strip_tags($new_instance['linkbtn']);
		$instance['divider'] = strip_tags($new_instance['divider']);
		$instance['fullwidth'] = strip_tags($new_instance['fullwidth']);
		$instance['postbgcolor'] = strip_tags($new_instance['postbgcolor']);
		$instance['titlecolor'] = $new_instance['titlecolor'];
		$instance['secbgcolor'] = $new_instance['secbgcolor'];

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
		'title' => __('Our Work','optimizer'),
		'subtitle' => __('Check Out Our Portfolio','optimizer'),
		'layout' => '1',
		'hover' => '1',
		'count' => '6',
		'category' => array(),
		'previewbtn' => '1',
		'linkbtn' => '1',
		'divider' => 'fa-stop',
		'fullwidth' => '',
		'postbgcolor' => '',
		'titlecolor' => '#333333',
		'secbgcolor' => '#ffffff',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

        
        
<?php 
//CHECK IF PORTFOLIO PLUGIN EXIST
if(function_exists('portfolio_post_type_init') || ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'custom-content-types' ) ) ){ ?>

		<!-- Posts Title Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo htmlspecialchars($instance['title'], ENT_QUOTES, "UTF-8"); ?>" type="text" />
		</p>
        
        <!-- Posts subtitle Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e('Subtitle:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo htmlspecialchars($instance['subtitle'], ENT_QUOTES, "UTF-8"); ?>" type="text" />
		</p>
        
        <!-- POSTS TITLE DIVIDER Field -->
        <p>
			<label for="<?php echo $this->get_field_id( 'divider' ); ?>"><?php _e('Title Divider:', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'divider' ); ?>" name="<?php echo $this->get_field_name( 'divider' ); ?>" class="widefat">
                <option value="underline" <?php if ( 'underline' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Underline', 'optimizer') ?></option>
                <option value="border-center" <?php if ( 'border-center' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Bordered (Center)', 'optimizer') ?></option>
                <option value="border-left" <?php if ( 'border-left' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Bordered (Left)', 'optimizer') ?></option>
                <option value="border-right" <?php if ( 'border-right' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Bordered (Right)', 'optimizer') ?></option>
                <option value="fa-stop" <?php if ( 'fa-stop' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Rhombus', 'optimizer') ?></option>
				<option value="fa-star" <?php if ( 'fa-star' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Star', 'optimizer') ?></option>
                <option value="fa-times" <?php if ( 'fa-times' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Cross', 'optimizer') ?></option>
				<option value="fa-bolt" <?php if ( 'fa-bolt' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Bolt', 'optimizer') ?></option>
				<option value="fa-asterisk" <?php if ( 'fa-asterisk' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Asterisk', 'optimizer') ?></option>
                <option value="fa-chevron-down" <?php if ( 'fa-chevron-down' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Chevron', 'optimizer') ?></option>
				<option value="fa-heart" <?php if ( 'fa-heart' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Heart', 'optimizer') ?></option>
				<option value="fa-plus" <?php if ( 'fa-plus' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Plus', 'optimizer') ?></option>
                <option value="fa-bookmark" <?php if ( 'fa-bookmark' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Bookmark', 'optimizer') ?></option>
				<option value="fa-circle-o" <?php if ( 'fa-circle-o' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Circle', 'optimizer') ?></option>
                <option value="fa-th-large" <?php if ( 'fa-th-large' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Blocks', 'optimizer') ?></option>
				<option value="fa-minus" <?php if ( 'fa-minus' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Sides', 'optimizer') ?></option>
				<option value="fa-cog" <?php if ( 'fa-cog' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Cog', 'optimizer') ?></option>
                <option value="fa-reorder" <?php if ( 'fa-reorder' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Blinds', 'optimizer') ?></option>
                <option value="fa-diamond" <?php if ( 'fa-diamond' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Diamond', 'optimizer') ?></option>
                <option value="fa-gg" <?php if ( 'fa-gg' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Tetris', 'optimizer') ?></option>
                <option value="fa-houzz" <?php if ( 'fa-houzz' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Digital', 'optimizer') ?></option>
                <option value="fa-rocket" <?php if ( 'fa-rocket' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Rocket', 'optimizer') ?></option>
                <option value="no_divider" <?php if ( 'no_divider' == $instance['divider'] ) echo 'selected="selected"'; ?>><?php _e('Hide Divider', 'optimizer') ?></option>
			</select>
		</p>
        
        <!-- Posts Layout Field -->
        <p>
			<label for="<?php echo $this->get_field_id( 'layout' ); ?>"><?php _e('Portfolio Layout:', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo $this->get_field_name( 'layout' ); ?>" class="widefat">
				<option value="1" <?php if ( '1' == $instance['layout'] ) echo 'selected="selected"'; ?>><?php _e('Square', 'optimizer') ?></option>
				<option value="2" <?php if ( '2' == $instance['layout'] ) echo 'selected="selected"'; ?>><?php _e('Square (Spaced)', 'optimizer') ?></option>
                <option value="3" <?php if ( '3' == $instance['layout'] ) echo 'selected="selected"'; ?>><?php _e('Masonry', 'optimizer') ?></option>
                <option value="4" <?php if ( '4' == $instance['layout'] ) echo 'selected="selected"'; ?>><?php _e('Masonry (Spaced)', 'optimizer') ?></option>
                <!--<option value="5" <?php //if ( '5' == $instance['layout'] ) echo 'selected="selected"'; ?>><?php _e('Slider', 'optimizer') ?></option>-->
			</select>
		</p>
        
        <!-- Posts Hover Field -->
        <p>
			<label for="<?php echo $this->get_field_id( 'hover' ); ?>"><?php _e('Hover Style:', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'hover' ); ?>" name="<?php echo $this->get_field_name( 'hover' ); ?>" class="widefat">
				<option value="1" <?php if ( '1' == $instance['hover'] ) echo 'selected="selected"'; ?>><?php _e('Style 1', 'optimizer') ?></option>
				<option value="2" <?php if ( '2' == $instance['hover'] ) echo 'selected="selected"'; ?>><?php _e('Style 2', 'optimizer') ?></option>
                <option value="3" <?php if ( '3' == $instance['hover'] ) echo 'selected="selected"'; ?>><?php _e('Style 3', 'optimizer') ?></option>
                <option value="4" <?php if ( '4' == $instance['hover'] ) echo 'selected="selected"'; ?>><?php _e('Style 4', 'optimizer') ?></option>
                <option value="5" <?php if ( '5' == $instance['hover'] ) echo 'selected="selected"'; ?>><?php _e('Disable Hover: Always Show Title', 'optimizer') ?></option>
			</select>
		</p>
        
        
        <!-- Posts Category Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e('Categories', 'optimizer') ?></label>
			<span class="widget_multicheck">
			<?php
			  if(function_exists('portfolio_post_type_init')){
				  $taxonomy= 'portfolio_category'; 
			  }elseif( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'custom-content-types' ) && get_option('jetpack_portfolio')=='1' ){
				  $taxonomy= 'jetpack-portfolio-type'; 
			  }else{ $taxonomy ='category';}
			
				$categories = get_terms(array( $taxonomy ), array( 'fields' => 'ids' ));

                foreach($categories as $cat) {
            ?>
            <label><input id="<?php echo $this->get_field_id( 'category' ) . $cat; ?>" name="<?php echo $this->get_field_name('category'); ?>[]" type="checkbox" value="<?php echo $cat; ?>" <?php if(!empty($instance['category']) ) { ?><?php foreach ( $instance['category'] as $checked ) { checked( $checked, $cat, true ); } ?><?php } ?>><?php $term = get_term($cat, $taxonomy); echo $term->name; ?></label>
            <?php
                }
            ?>
        	</span>
		</p>
        
        
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number of Posts:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" type="text" />
		</p>

        
        <!-- POSTS Preview Button Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'previewbtn' ); ?>"><?php _e('Display Preview Button', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'previewbtn' ); ?>" name="<?php echo $this->get_field_name( 'previewbtn' ); ?>" value="1" type="checkbox" <?php if ( '1' == $instance['previewbtn'] ) echo 'checked'; ?> />
		</p>
        
        <!-- POSTS Link Button Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'linkbtn' ); ?>"><?php _e('Display Link Button', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'linkbtn' ); ?>" name="<?php echo $this->get_field_name( 'linkbtn' ); ?>" value="1" type="checkbox" <?php if ( '1' == $instance['linkbtn'] ) echo 'checked'; ?> />
		</p> 
        
        <!-- POSTS Link Button Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'fullwidth' ); ?>"><?php _e('Make the Widget Full Width', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'fullwidth' ); ?>" name="<?php echo $this->get_field_name( 'fullwidth' ); ?>" value="1" type="checkbox" <?php if ( '1' == $instance['fullwidth'] ) echo 'checked'; ?> />
		</p> 
        
         
        <!-- Posts Backgrounnd Color Field -->
<!--		<p>
			<label for="<?php echo $this->get_field_id( 'postbgcolor' ); ?>"><?php _e('Post Background Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'postbgcolor' ); ?>" name="<?php echo $this->get_field_name( 'postbgcolor' ); ?>" value="<?php echo $instance['postbgcolor']; ?>" type="text" />
		</p>-->
        
        
        <!-- Posts Section Title Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'titlecolor' ); ?>"><?php _e('Portfolio Section Title Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'titlecolor' ); ?>" name="<?php echo $this->get_field_name( 'titlecolor' ); ?>" value="<?php echo $instance['titlecolor']; ?>" type="text" />
		</p>
        
        <!-- Posts Section Background Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'secbgcolor' ); ?>"><?php _e('Portfolio Section Background', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'secbgcolor' ); ?>" name="<?php echo $this->get_field_name( 'secbgcolor' ); ?>" value="<?php echo $instance['secbgcolor']; ?>" type="text" />
		</p>
<?php }else{ ?>

	<p><?php _e('Please Install ','optimizer'); ?><a href="https://wordpress.org/plugins/portfolio-post-type/" target="_blank"><?php _e('this portfolio plugin','optimizer'); ?></a> <?php _e('to activate this widget.','optimizer'); ?></p>
    <p><?php _e('OR', 'optimizer'); ?></p>
    <p><?php _e('If you are using Jetpack, You can activate the Jetpack Custom Post Type Module. Then Go to Settings > Writing to enable "Portfolio Projects".','optimizer'); ?></p>
    
    
    
<?php }//PORTFOLIO Plugin CHeck END ?>


<?php
	}
	
	function optimizer_portfoio_masonry_run(){
		$settings = get_option($this->option_name);
		if(!is_customize_preview()){
		if ( empty( $settings ) ) {
			return;
		}
		

		foreach ( $settings as $instance_id => $instance ) {
			$id = $this->id_base . '-' . $instance_id;
			
			if ( ! is_active_widget( false, $id, $this->id_base ) ) {
				continue;
			}
		$idbase = str_replace('-','_',$this->id);
		if ( ! empty( $instance['layout'] ) ) {$layout = $instance['layout'];  }else{$layout = '1';}
		if($layout == 3 || $layout == 4){
			echo '<script type="text/javascript">
			jQuery(window).bind("load", function() {
					//Layout3 Masonry
					
					var container'.$idbase.' = jQuery("#'.$this->id.' .lay1_wrap");
					if(container'.$idbase.'){
						container'.$idbase.'.imagesLoaded(function() {
							container'.$idbase.'.masonry({
							  itemSelector: ".hentry"
							});
						});

						container'.$idbase.'.imagesLoaded(function() {
						
							jQuery(".portfolio_nav li").on("click", function () {
								setTimeout(function(){
									container'.$idbase.'.masonry();
								}, 600);	
							});
						
						});
						
					}
					
			});
			</script>';
		}
	}
}
}

		
		
	//ENQUEUE CSS
    function front_portfoio_enqueue_css() {
		$settings = get_option($this->option_name);
		if(!is_customize_preview()){
		if ( empty( $settings ) ) {
			return;
		}
		

		foreach ( $settings as $instance_id => $instance ) {
			$id = $this->id_base . '-' . $instance_id;

			if ( ! is_active_widget( false, $id, $this->id_base ) ) {
				continue;
			}

			$postbgcolor =		'';
			$titlecolor =		'#333333;';
			$secbgcolor =		'background-color:#ffffff;';
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
			
			if ( ! empty( $instance['layout'] ) ) {$layout = $instance['layout'];  }else{$layout = '1';}
			
			if ( ! empty( $instance['postbgcolor'] ) ) {
				$postbgcolor = 'background-color: ' . $instance['postbgcolor'] . '; ';
			}
			if ( ! empty( $instance['titlecolor'] ) ) {
				$titlecolor =  $instance['titlecolor'] . '; ';
			}
			if ( ! empty( $instance['secbgcolor'] ) ) {
				$secbgcolor = 'background-color: ' . $instance['secbgcolor'] . '; ';
			}

			
			
			$widget_style = '#'.$id.' .optimportfolio{ '.$secbgcolor.' }#'.$id.' .optimportfolio .home_title, #'.$id.' .optimportfolio .home_subtitle, #'.$id.' span.div_middle, #'.$id.' .portfolio_wrap .hover_style_5 .post_content .catag_list, #'.$id.' .portfolio_wrap .hover_style_5 .post_content .catag_list a, #'.$id.' .portfolio_wrap .hover_style_5 .post_content h2 a{color:'.$titlecolor.' }#'.$id.' span.div_left, #'.$id.' span.div_right{background-color:' . $titlecolor . '}  @media screen and (min-width: 480px){#'.$id.' .optimportfolio{'.$marginTop.$marginBottom.$marginLeft.$marginRight. $paddingTop.$paddingBottom.$paddingLeft.$paddingRight.'}#'.$id.' {'.$calcWidth. $boxSizing.'} }';
			wp_add_inline_style( 'optimizer-style', $widget_style );
			
			
		//Load Masonry
		if ( is_active_widget( false, false, $this->id_base, true ) ) {
			if($layout == 3 || $layout == 4){
				wp_enqueue_script('optimizer_masonry',get_template_directory_uri().'/assets/js/masonry.js', array('jquery'), false);
				
			}
		}
		
			}
			
        }
		

		
	}
}
?>