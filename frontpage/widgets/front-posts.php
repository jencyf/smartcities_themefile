<?php
/*
 *FRONTPAGE - POSTS SECTION WIDGET
 */
 
/**
 * Custom walker to print category checkboxes for widget forms
 */

 
add_action( 'widgets_init', 'optimizer_register_front_posts' );

/*
 * Register widget.
 */
function optimizer_register_front_posts() {
	register_widget( 'optimizer_front_posts' );
}


/*
 * Widget class.
 */
class optimizer_front_Posts extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */

	function __construct() {
		if(is_customize_preview()){$widgetname = __( 'Posts', 'optimizer' ); }else{ $widgetname = __( '&diams; Posts Widget', 'optimizer' ); }
		
		parent::__construct( 'optimizer_front_posts', $widgetname, array(
			'classname'   => 'optimizer_front_posts postsblck',
			'description' => __( 'This Widget lets you display WordPress Posts, Pages and Woocommerce Products.', 'optimizer' ),
			'customize_selective_refresh' => true,
		) );
		$this->alt_option_name = 'optimizer_front_posts';
		add_action('wp_enqueue_scripts', array(&$this, 'front_posts_enqueue_css'));
		add_action('wp_footer', array(&$this,  'optimizer_masonry_run'));
		
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
		$type = isset( $instance['type'] ) ? $instance['type'] : 'post';
		$pages = isset( $instance['pages'] ) ? $instance['pages'] : '';
		$count = isset( $instance['count'] ) ? absint($instance['count']) : '6';
		$category = isset( $instance['category'] ) ? $instance['category'] : array();
		$product_category = isset( $instance['product_category'] ) ? $instance['product_category'] : array();
		$sidebar = isset( $instance['sidebar'] ) ? $instance['sidebar'] : '';
		
		$previewbtn = isset( $instance['previewbtn'] ) ? $instance['previewbtn'] : '1';
		$linkbtn = isset( $instance['linkbtn'] ) ? $instance['linkbtn'] : '1';
		$divider = isset( $instance['divider'] ) ? apply_filters('widget_title', $instance['divider']) : 'fa-stop';
		$navigation = isset( $instance['navigation'] ) ? $instance['navigation'] : 'numbered';
		$postbgcolor = isset( $instance['postbgcolor'] ) ? $instance['postbgcolor'] : '';
		$titlecolor = isset( $instance['titlecolor'] ) ? $instance['titlecolor'] : '';
		$secbgcolor = isset( $instance['secbgcolor'] ) ? $instance['secbgcolor'] : '';
		

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		
			//Sitegorigin Builder FIX
			echo '<span class="so_widget_id" data-panel-id="'.$this->id.'"></span>';
			if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';
			
			//THE QUERY
			if(!empty($category) && $type == 'post'){	$blogcat = $category;	$blogcats =implode(',', $blogcat);	}else{	$blogcats = '';	}
			if(!empty($pages) && $type == 'page'){	$widgetpages =implode(',', $pages);	}else{	$widgetpages = '';	}
			if(!empty($product_category) && $type == 'product'){	$prodcat = $product_category;	$prodcats =implode(',', $prodcat);	}else{	$prodcats = '';	}
		
		$hasidebar ='';
		if($sidebar =='no_sidebar' || empty($sidebar)){ $hasidebar =  'widgt_no_sidebar'; }else{ $hasidebar =  'widgt_has_sidebar'; } 
		
		echo '<div class="postlayout_'.$layout.' '.$hasidebar.'">
		<div class="lay'.$layout.' optimposts" data-post-layout="'.$layout.'" data-post-type="'.$type.'" data-post-count="'.$count.'" data-post-category="'.$blogcats.'" data-product-category="'.$prodcats.'" data-post-pages="'.$widgetpages.'" data-post-previewbtn="'.$previewbtn.'" data-post-linkbtn="'.$linkbtn.'" data-post-navigation="'.$navigation.'" data-post-sidebar="'.$sidebar.'">
		<div class="center">';
			
            echo '<div class="homeposts_title title_'.str_replace('fa-','dvd_',$divider).'">';
            	if($title || is_customize_preview()) { echo '<h2 class="home_title"><span>'.do_shortcode($title).'</span></h2>';}
                if($subtitle || is_customize_preview()) { echo '<div class="home_subtitle"><span>'.do_shortcode($subtitle).'</span></div>'; }
				if ( $divider ){
					if( $divider !== 'no_divider'){
						if($divider == 'underline'){ $underline= 'title_underline';}else{$underline='';}
							echo '<div class="optimizer_divider '.$underline.' divider_style_'.str_replace('fa-','dvd_',$divider).'"><span class="div_left"></span><span class="div_middle"><i class="fa '.$divider.'"></i></span><span class="div_right"></span></div>';
					}
				}
            echo '</div>';
			
			//Call the Posts
			optimizer_posts($layout, $type, $count, $category, $product_category, $pages, $previewbtn , $linkbtn, $navigation, $sidebar);
			
			
                
		echo '</div></div></div>';
		

		//Stylesheet-loaded in Customizer Only.
		if(is_customize_preview()){
			$id= $this->id;
			
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
					
					
					if ( ! empty( $instance['width']) && !empty($instance['margin'][2]  ) ) {	$leftrightmargin = $marginLeft;   }
					
					if ( ! empty( $instance['width']) && !empty($instance['margin'][3]  ) ) {	$leftrightmargin = $marginRight;	}
					
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
			
			echo '<style>#'.$id.' .lay'.$layout.' .hentry, #'.$id.' .lay'.$layout.' .lay2_wrap .type-product{ '.$postbgcolor.' }#'.$id.' .lay'.$layout.'{ '.$secbgcolor.' }#'.$id.' .lay'.$layout.' .home_title, #'.$id.' .lay'.$layout.' .home_subtitle, #'.$id.' span.div_middle{color:'.$titlecolor.' }#'.$id.' span.div_left, #'.$id.' span.div_right{background-color:' . $titlecolor . '}  @media screen and (min-width: 480px){#'.$id.' .optimposts{'.$marginTop.$marginBottom.$marginLeft.$marginRight. $paddingTop.$paddingBottom.$paddingLeft.$paddingRight.'}#'.$id.' {'.$calcWidth. $boxSizing.'} }</style>';
			
			echo '<script type="text/javascript">
			jQuery(window).ready(function() {		
				jQuery(".lay1").each(function(index, element) {
					var divs = jQuery(this).find(".hentry");
					for(var i = 0; i < divs.length; i+=3) {
					  divs.slice(i, i+3).wrapAll("<div class=\'ast_row\'></div>");
					}
					if (jQuery(window).width() < 1200) {
						var flaywidth = jQuery(this).find(".hentry").width();
						jQuery(this).find(".post_image").css({"maxHeight":(flaywidth * 66)/100});
					}
				});
			});
			</script>';
			
		}

		
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
		$instance['subtitle'] = wp_kses_post( $new_instance['subtitle'] );
		$instance['layout'] = strip_tags($new_instance['layout']);
		$instance['type'] = $new_instance['type'];
		$instance['pages'] = $new_instance['pages'];
		$instance['count'] = $new_instance['count'];
		$instance['category'] = $new_instance['category'];
		$instance['product_category'] = $new_instance['product_category'];
		$instance['sidebar'] = $new_instance['sidebar'];
		
		$instance['previewbtn'] = strip_tags($new_instance['previewbtn']);
		$instance['linkbtn'] = strip_tags($new_instance['linkbtn']);
		$instance['divider'] = strip_tags($new_instance['divider']);
		$instance['navigation'] = strip_tags($new_instance['navigation']);
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
		'type' => 'post',
		'pages' => array(),
		'count' => '6',
		'category' => array(),
		'product_category' => array(),
		'sidebar' => '',
		'previewbtn' => '1',
		'linkbtn' => '1',
		'divider' => 'fa-stop',
		'navigation' => 'numbered',
		'postbgcolor' => '',
		'titlecolor' => '#333333',
		'secbgcolor' => '#ffffff',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

        
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
			<label for="<?php echo $this->get_field_id( 'layout' ); ?>"><?php _e('Posts Layout:', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo $this->get_field_name( 'layout' ); ?>" class="widefat">
				<option value="1" <?php if ( '1' == $instance['layout'] ) echo 'selected="selected"'; ?>><?php _e('Layout 1', 'optimizer') ?></option>
				<option value="2" <?php if ( '2' == $instance['layout'] ) echo 'selected="selected"'; ?>><?php _e('Layout 2', 'optimizer') ?></option>
                <option value="3" <?php if ( '3' == $instance['layout'] ) echo 'selected="selected"'; ?>><?php _e('Layout 3', 'optimizer') ?></option>
                <option value="4" <?php if ( '4' == $instance['layout'] ) echo 'selected="selected"'; ?>><?php _e('Layout 4', 'optimizer') ?></option>
                <option value="5" <?php if ( '5' == $instance['layout'] ) echo 'selected="selected"'; ?>><?php _e('Layout 5', 'optimizer') ?></option>
			</select>
		</p>
        
        <!-- Posts Type Field -->
        <p class="widget_post_type_select">
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e('Posts Type:', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat">
				<option value="post" <?php if ( 'post' == $instance['type'] ) echo 'selected="selected"'; ?>><?php _e('Posts', 'optimizer') ?></option>
				<option value="page" <?php if ( 'page' == $instance['type'] ) echo 'selected="selected"'; ?>><?php _e('Pages', 'optimizer') ?></option>
                <option value="product" <?php if ( 'product' == $instance['type'] ) echo 'selected="selected"'; ?>><?php _e('Products (Woocommerce)', 'optimizer') ?></option>
			</select>
		</p>
        
		<!-- Pages Select Field -->
		<p class="post_page_select <?php if ( 'page' == $instance['type'] ) echo 'post_type_selected"'; ?>">
			<label for="<?php echo $this->get_field_id( 'pages' ); ?>"><?php _e('Display These Pages', 'optimizer') ?></label>
            <span class="widget_multicheck">
			<?php
				$pageids = get_all_page_ids();
                foreach($pageids as $page) {
            ?>
				<?php if(get_post_status($page) == 'publish'){ ?>
                	<label><input id="<?php echo $this->get_field_id('pages') . $page; ?>" name="<?php echo $this->get_field_name('pages'); ?>[]" type="checkbox" value="<?php echo $page; ?>"  <?php if(!empty($instance['pages'])) { ?><?php foreach ( $instance['pages'] as $checked ) { checked( $checked, $page, true ); } ?><?php } ?> /><?php echo get_the_title($page); ?></label>
                <?php } ?>
            <?php } ?>
            </span>
		</p>
        
        
        <!-- Posts Category Field -->
		<p class="post_cat_select <?php if ( 'post' == $instance['type'] ) echo 'post_type_selected"'; ?>">
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e('Categories', 'optimizer') ?></label>
			<span class="widget_multicheck">
			<?php
				$categories = get_terms(array( 'category' ), array( 'fields' => 'ids' ));

                foreach($categories as $cat) {
            ?>
            <label><input id="<?php echo $this->get_field_id( 'category' ) . $cat; ?>" name="<?php echo $this->get_field_name('category'); ?>[]" type="checkbox" value="<?php echo $cat; ?>" <?php if(!empty($instance['category'])) { ?><?php foreach ( $instance['category'] as $checked ) { checked( $checked, $cat, true ); } ?><?php } ?>><?php echo get_cat_name($cat); ?></label>
            <?php
                }
            ?>
        	</span>
		</p>
        
        <!-- Product Category Field -->
        <?php if ( class_exists( 'WooCommerce' ) ) { ?>
		<p class="product_cat_select <?php if ( 'product' == $instance['type'] ) echo 'post_type_selected"'; ?>">
			<label for="<?php echo $this->get_field_id( 'product_category' ); ?>"><?php _e('Product Categories', 'optimizer') ?></label>
			<span class="widget_multicheck">
			<?php
				$categories = get_terms(array( 'product_cat' ), array( 'fields' => 'ids' ));

                foreach($categories as $cat) {
            ?>
            <label><input id="<?php echo $this->get_field_id( 'product_category' ) . $cat; ?>" name="<?php echo $this->get_field_name('product_category'); ?>[]" type="checkbox" value="<?php echo $cat; ?>" <?php if(!empty($instance['product_category'])) { ?><?php foreach ( $instance['product_category'] as $checked ) { checked( $checked, $cat, true ); } ?><?php } ?>><?php $productcatid = get_term_by( 'id', absint( $cat ), 'product_cat' );
echo $productcatid->name; ?></label>
            <?php
                }
            ?>
        	</span>
		</p>
        <?php } ?>
        
        
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
        
        
        <!-- Posts Sidebar Field -->
        <p>
			<label for="<?php echo $this->get_field_id( 'sidebar' ); ?>"><?php _e('Sidebar:', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'sidebar' ); ?>" name="<?php echo $this->get_field_name( 'sidebar' ); ?>" class="widefat">
            	<option value="" <?php if ( '' == $instance['sidebar'] ) echo 'selected="selected"'; ?>><?php _e('-----------------------', 'optimizer') ?></option> 
				  <option value="no_sidebar" <?php if ( 'no_sidebar' == $instance['sidebar'] ) echo 'selected="selected"'; ?>><?php _e('Disabled', 'optimizer') ?></option> 
				  <?php 
				  $allsidebars = $GLOBALS['wp_registered_sidebars'];
					unset($allsidebars['foot_sidebar']); 
					unset($allsidebars['front_sidebar']); 
				  foreach($allsidebars as $sidebarr ) { ?>
                        <option value="<?php echo $sidebarr['id']; ?>"<?php if ($instance['sidebar'] == $sidebarr['id']) echo ' selected="selected"'; ?>><?php echo $sidebarr['name']; ?></option>
                    <?php }?>
			</select>
		</p>
        
        
        <!-- Posts Navigation Field -->
        <p>
			<label for="<?php echo $this->get_field_id( 'navigation' ); ?>"><?php _e('Posts Navigation:', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'navigation' ); ?>" name="<?php echo $this->get_field_name( 'navigation' ); ?>" class="widefat">
				<option value="numbered" <?php if ( 'numbered' == $instance['navigation'] ) echo 'selected="selected"'; ?>><?php _e('Numbered', 'optimizer') ?></option>
                <option value="oldnew" <?php if ( 'oldnew' == $instance['navigation'] ) echo 'selected="selected"'; ?>><?php _e('Next/Previous Entries', 'optimizer') ?></option>
                <option value="infscroll" <?php if ( 'infscroll' == $instance['navigation'] ) echo 'selected="selected"'; ?>><?php _e('Infinite Scroll (Manual)', 'optimizer') ?></option>
                <option value="infscroll_auto" <?php if ( 'infscroll_auto' == $instance['navigation'] ) echo 'selected="selected"'; ?>><?php _e('Infinite Scroll (Auto)', 'optimizer') ?></option>
				<option value="no_nav" <?php if ( 'no_nav' == $instance['navigation'] ) echo 'selected="selected"'; ?>><?php _e('Disabled', 'optimizer') ?></option> 
			</select>
		</p>
        
        
               
        <!-- Posts Backgrounnd Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'postbgcolor' ); ?>"><?php _e('Post Background Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'postbgcolor' ); ?>" name="<?php echo $this->get_field_name( 'postbgcolor' ); ?>" value="<?php echo $instance['postbgcolor']; ?>" type="text" />
		</p>
        
        
        <!-- Posts Section Title Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'titlecolor' ); ?>"><?php _e('Posts Section Title Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'titlecolor' ); ?>" name="<?php echo $this->get_field_name( 'titlecolor' ); ?>" value="<?php echo $instance['titlecolor']; ?>" type="text" />
		</p>
        
        <!-- Posts Section Background Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'secbgcolor' ); ?>"><?php _e('Posts Section Background', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'secbgcolor' ); ?>" name="<?php echo $this->get_field_name( 'secbgcolor' ); ?>" value="<?php echo $instance['secbgcolor']; ?>" type="text" />
		</p>

<?php
	}
	
	function optimizer_masonry_run(){
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
		$idbase = str_replace('-','_',$id);
		if ( ! empty( $instance['layout'] ) ) {$layout = $instance['layout'];  }else{$layout = '1';}
		if($layout == 3){
			echo '<script type="text/javascript">
			jQuery(window).bind("load", function(){
				//Layout3 Masonry
				var container'.$idbase.' = document.querySelector("#'.$id.' .lay3_wrap");
				var msnry;
				if(container'.$idbase.'){
					imagesLoaded( container'.$idbase.', function() {
						new Masonry( container'.$idbase.', {
					  // options
					  itemSelector: ".hentry, .type-product"
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
    function front_posts_enqueue_css() {
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
					
					
					if ( ! empty( $instance['width']) && !empty($instance['margin'][2]  ) ) {	$leftrightmargin = $marginLeft;   }
					
					if ( ! empty( $instance['width']) && !empty($instance['margin'][3]  ) ) {	$leftrightmargin = $marginRight;	}
					
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

			
			
			$widget_style = '#'.$id.' .lay'.$layout.' .hentry, #'.$id.' .lay'.$layout.' .lay2_wrap .type-product{ '.$postbgcolor.' }#'.$id.' .lay'.$layout.'{ '.$secbgcolor.' }#'.$id.' .lay'.$layout.' .home_title, #'.$id.' .lay'.$layout.' .home_subtitle, #'.$id.' span.div_middle{color:'.$titlecolor.' }#'.$id.' span.div_left, #'.$id.' span.div_right{background-color:' . $titlecolor . '}  @media screen and (min-width: 480px){#'.$id.' .optimposts{'.$marginTop.$marginBottom.$marginLeft.$marginRight. $paddingTop.$paddingBottom.$paddingLeft.$paddingRight.'}#'.$id.' {'.$calcWidth. $boxSizing.'} }';
			wp_add_inline_style( 'optimizer-style', $widget_style );
			
			
		//Load Masonry
		if ( is_active_widget( false, false, $this->id_base, true ) ) {
			if($layout == 3){
				wp_enqueue_script('optimizer_masonry',get_template_directory_uri().'/assets/js/masonry.js', array('jquery'), false);
				
			}
		}
		
			}
			
        }
		

		
	}
}
?>