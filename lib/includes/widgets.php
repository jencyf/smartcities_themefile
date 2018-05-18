<?php

/*
	/* ---------------------------- */
	/* -------- Flickr Photostream Widget -------- */
	/* ---------------------------- */
add_action( 'widgets_init', 'thn_flckr_widgets' );

/*
 * Register widget.
 */
function thn_flckr_widgets() {
	register_widget( 'thn_flckr_widget' );
}

/*
 * Widget class.
 */
class thn_flckr_Widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	
	function __construct() {
		parent::__construct( 'thn_flckr_widget', __( 'Flickr Photo', 'optimizer' ), array(
			'classname'   => 'thn_flckr_widget',
			'description' => __( 'An Optimizer Widget that displays Flickr image stream from your Flickr account', 'optimizer' ),
		) );
		$this->alt_option_name = 'thn_flckr_widget';
	}
	

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings.  */
		$title = isset( $instance['title'] ) ? apply_filters('widget_title', $instance['title'] ) : 'My Photostream';
		$flickrID = isset( $instance['flickrID'] ) ? $instance['flickrID'] : '25182021@N05';
		$postcount = isset( $instance['postcount'] ) ? $instance['postcount'] : '9';
		$type = isset( $instance['type'] ) ? $instance['type'] : 'user';
		$display = isset( $instance['display'] ) ? $instance['display'] : 'random';
		$size = isset( $instance['size'] ) ? $instance['size'] : 'thumb';

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display Flickr Photos */
		 ?>
			
			<div id="flickr_badge_wrapper" class="clearfix widget_flicrk_<?php echo $size; ?>">
				<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $postcount ?>&amp;display=<?php echo $display ?>&amp;size=m&amp;layout=x&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $flickrID ?>"></script>
			</div>
		
		<?php

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
		$instance['flickrID'] = strip_tags( $new_instance['flickrID'] );
		$instance['postcount'] = absint($new_instance['postcount']);
		$instance['type'] = strip_tags($new_instance['type']);
		$instance['display'] = strip_tags($new_instance['display']);
		$instance['size'] = strip_tags($new_instance['size']);
		
		/* No need to strip tags for.. */

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
		'title' => 'My Photostream',
		'flickrID' => '25182021@N05',
		'postcount' => '9',
		'type' => 'user',
		'display' => 'random',
		'size' => 'thumb',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" />
		</p>

		<!-- Flickr ID: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'flickrID' ); ?>"><?php _e('Flickr ID:', 'optimizer') ?> (<a href="http://idgettr.com/">idGettr</a>)</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'flickrID' ); ?>" name="<?php echo $this->get_field_name( 'flickrID' ); ?>" value="<?php echo $instance['flickrID']; ?>" type="text" />
		</p>
		
		<!-- Postcount: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'postcount' ); ?>"><?php _e('Number of Photos:', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>" class="widefat">
				<option <?php if ( '3' == $instance['postcount'] ) echo 'selected="selected"'; ?>>3</option>
                <option <?php if ( '4' == $instance['postcount'] ) echo 'selected="selected"'; ?>>4</option>
                <option <?php if ( '5' == $instance['postcount'] ) echo 'selected="selected"'; ?>>5</option>
                <option <?php if ( '6' == $instance['postcount'] ) echo 'selected="selected"'; ?>>6</option>
                <option <?php if ( '7' == $instance['postcount'] ) echo 'selected="selected"'; ?>>7</option>
				<option <?php if ( '8' == $instance['postcount'] ) echo 'selected="selected"'; ?>>8</option>
				<option <?php if ( '9' == $instance['postcount'] ) echo 'selected="selected"'; ?>>9</option>
                <option <?php if ( '10' == $instance['postcount'] ) echo 'selected="selected"'; ?>>10</option>
			</select>
		</p>
		
		<!-- Type: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e('Type (user or group):', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat">
				<option <?php if ( 'user' == $instance['type'] ) echo 'selected="selected"'; ?>>user</option>
				<option <?php if ( 'group' == $instance['type'] ) echo 'selected="selected"'; ?>>group</option>
			</select>
		</p>
		
        <!-- Image Size: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e('Image Size', 'optimizer') ?></label>
            <select id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>" class="widefat">
                <option value="thumb"  <?php if ( 'thumb' == $instance['size'] ) echo 'selected="selected"'; ?>><?php _e('Thumbnail', 'optimizer') ?></option>
                <option value="medium"  <?php if ( 'medium' == $instance['size'] ) echo 'selected="selected"'; ?>><?php _e('Medium', 'optimizer') ?></option>
            </select>
        </p>
        
		<!-- Display: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e('Display (random or latest):', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" class="widefat">
				<option <?php if ( 'random' == $instance['display'] ) echo 'selected="selected"'; ?>>random</option>
				<option <?php if ( 'latest' == $instance['display'] ) echo 'selected="selected"'; ?>>latest</option>
			</select>
		</p>
        
		
	<?php
	}
}



/* ---------------------------- */
/* -------- Facebook Likebox Widget -------- */
/* ---------------------------- */
add_action( 'widgets_init', 'ast_fb_widgets' );

/*
 * Register widget.
 */
function ast_fb_widgets() {
	register_widget( 'ast_fb_widget' );
}

/*
 * Widget class.
 */
class ast_fb_Widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function __construct() {
		parent::__construct( 'ast_fb_widget', __( 'Facebook Likebox', 'optimizer' ), array(
			'classname'   => 'ast_fb_widget',
			'description' => __( 'An Optimizer Widget that displays Facebook Likebox of your Facebook Page.', 'optimizer' ),
		) );
		$this->alt_option_name = 'ast_fb_widget';
	}
	

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = isset( $instance['title'] ) ? apply_filters('widget_title', $instance['title'] ) : __('Follow Us on Facebook','optimizer');
		$num = isset( $instance['num'] ) ? $instance['num'] : 'https://www.facebook.com/layerthemes';
		$height = isset( $instance['height'] ) ? $instance['height'] : '200px';

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			
		/* Display a containing div */
		echo '<div class="ast_fb">';

		/* Display Facebook Iframe */
	
	echo '<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=219966444765853";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, "script", "facebook-jssdk"));</script>

<div class="fb-page" data-href="'.esc_url($num).'" data-height="'.$height.'" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/facebook"><a href="'.$num.'">Facebook</a></blockquote></div></div>
';

		echo '</div>';

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
		$instance['num'] = esc_url_raw($new_instance['num']);
		$instance['height'] = strip_tags($new_instance['height']);

		return $instance;
	}
	
	/* ---------------------------- */
	/* ------- Widget Settings ------- */
	/* ---------------------------- */
	
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
		'title' => 'Follow Us on Facebook',
		'num' => 'https://www.facebook.com/layerthemes',
		'height' => '200px'
		
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" />
		</p>

		<!-- Number of Posts: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'num' ); ?>"><?php _e('Facebook Page url:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'num' ); ?>" name="<?php echo $this->get_field_name( 'num' ); ?>" value="<?php echo esc_url($instance['num']); ?>" type="text" />
		</p>
        
        <!-- Number of Posts: Text Input -->
        <p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Height of the like Box', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $instance['height']; ?>" type="text" />
		</p>
		
		
	<?php
	}

}


/* ---------------------------- */
/* -------- Google Plus Followers Widget -------- */
/* ---------------------------- */
add_action( 'widgets_init', 'ast_gplus_widgets' );

/*
 * Register widget.
 */
function ast_gplus_widgets() {
	register_widget( 'ast_gplus_widget' );
}

/*
 * Widget class.
 */
class ast_gplus_Widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function __construct() {
		parent::__construct( 'ast_gplus_widget', __( 'Google + Followers', 'optimizer' ), array(
			'classname'   => 'ast_gplus_widget',
			'description' => __( 'An Optimizer widget that displays your Google Plus Followers.', 'optimizer' ),
		) );
		$this->alt_option_name = 'ast_gplus_widget';
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. 290*/
		$title = isset( $instance['title'] ) ? apply_filters('widget_title', $instance['title'] ) : __('Follow on Google Plus','optimizer');
		$num = isset( $instance['num'] ) ? $instance['num'] : 'https://plus.google.com/+JonathanBeri';
		$gplus_width = isset( $instance['gplus_width'] ) ? $instance['gplus_width'] : '290';
		$templatepath = get_template_directory_uri();

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			
		/* Display a containing div */
		echo '<div class="ast_gplus">';


		echo '<script type="text/javascript">
      (function() {
        window.___gcfg = {\'lang\': \'en\'};
        var po = document.createElement(\'script\');
        po.type = \'text/javascript\';
        po.async = true;
        po.src = \'https://apis.google.com/js/plusone.js\';
        var s = document.getElementsByTagName(\'script\')[0];
        s.parentNode.insertBefore(po, s);
      })();
    </script><div class="wc-gplusmod"><div class="g-plus" data-action="followers" data-height="290" data-href="'.esc_url($num).'?prsrc=2" data-source="blogger:blog:followers" data-width="'.$gplus_width.'"></div></div>';

		echo '</div>';

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
		$instance['num'] = esc_url_raw($new_instance['num']);
		$instance['gplus_width'] = $new_instance['gplus_width'];

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
		'title' => __('Follow on Google Plus','optimizer'),
		'num' => 'https://plus.google.com/+JonathanBeri',
		'gplus_width' => '290'
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" />
		</p>

		<!-- Number of Posts: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'num' ); ?>"><?php _e('Google Plus Url:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'num' ); ?>" name="<?php echo $this->get_field_name( 'num' ); ?>" value="<?php echo $instance['num']; ?>" type="text" />
		</p>
        
		<!-- Number of Posts: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'gplus_width' ); ?>"><?php _e('Box Width:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'gplus_width' ); ?>" name="<?php echo $this->get_field_name( 'gplus_width' ); ?>" value="<?php echo $instance['gplus_width']; ?>" type="text" />
		</p>
		
		
	<?php
	}

}


/* ---------------------------- */
/* -------- BIO Widget -------- */
/* ---------------------------- */
add_action( 'widgets_init', 'ast_bio_widgets' );


/*
 * Register widget.
 */
function ast_bio_widgets() {
	register_widget( 'ast_bio_widget' );
}

/*
 * Widget class.
 */
class ast_bio_Widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */

	
	function __construct() {
		parent::__construct( 'ast_bio_widget', __( 'Biography', 'optimizer' ), array(
			'classname'   => 'ast_bio_widget',
			'description' => __( 'An Optimizer Biography widget to display your biography.', 'optimizer' ),
		) );
		$this->alt_option_name = 'ast_bio_widget';
		add_action('wp_enqueue_scripts', array(&$this, 'front_bio_enqueue_css'));
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings.  */
		$title = isset( $instance['title'] ) ? apply_filters('widget_title', $instance['title'] ) : '';
		$image_uri = isset( $instance['image_uri'] ) ? $instance['image_uri'] : '';
		$name = $instance['name'];isset( $instance['name'] ) ? $instance['name'] : 'John Doe';
		$occu = $instance['occu'];	isset( $instance['occu'] ) ? $instance['occu'] : __('Blogger','optimizer');	
		$bio = $instance['bio'];isset( $instance['bio'] ) ? $instance['bio'] : __('Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits. Dramatically visualize customer directed convergence without revolutionary ROI.','optimizer');
		
		$bgcolor = isset( $instance['bgcolor'] ) ? $instance['bgcolor'] : '';
		$txtcolor = isset( $instance['txtcolor'] ) ? $instance['txtcolor'] : '';
		$titlecolor = isset( $instance['titlecolor'] ) ? $instance['titlecolor'] : '';

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			
		/* Display a containing div */
		echo '<div class="ast_bio">';
		echo '<div class="bio_head"><img alt="'.$name.'" class="ast_bioimg" src="'.esc_url($image_uri).'" '.optimizer_image_attr( esc_url($image_uri) ).' '.optimizer_image_alt(esc_url($image_uri) ).' /></div>';
		
		echo '<div class="ast_biotxt"><h3><span>'.$name.'</span></h3><span class="ast_bioccu"><span>'.$occu.'</span></span><p><span>'.do_shortcode($bio).'</span></p></div>';

		echo '</div>';
		
		
		//Stylesheet-loaded in Customizer Only.
		if(is_customize_preview()){
			$id= $this->id;
			
			$postbgcolor =		'';
			$titlecolor =		'';
			$secbgcolor =		'';
			
			if ( ! empty( $instance['bgcolor'] ) ){	$bgcolor = 'background-color: ' . $instance['bgcolor'] . '; ';}
			if ( ! empty( $instance['txtcolor'] ) ){	$txtcolor = 'color: ' . $instance['txtcolor'] . '; ';}
			if ( ! empty( $instance['titlecolor'] ) ) {	$titlecolor = 'color: ' . $instance['titlecolor'] . '; ';}

			
			echo '<style>#'.$id.' .widget_wrap{ '.$bgcolor.' }#'.$id.' .widgettitle, #'.$id.' .ast_biotxt h3{'.$titlecolor.' } #'.$id.' .ast_biotxt{' . $txtcolor. '}</style>';
			
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
		
        $instance['image_uri'] = esc_url_raw( $new_instance['image_uri'] );
        $instance['name'] = strip_tags( $new_instance['name'] );
        $instance['occu'] = strip_tags( $new_instance['occu'] );
		$instance['bio'] = wp_kses_post( $new_instance['bio'] );
		
		$instance['bgcolor'] = optimizer_sanitize_hex( $new_instance['bgcolor'] );
		$instance['txtcolor'] = optimizer_sanitize_hex( $new_instance['txtcolor'] );
		$instance['titlecolor'] = optimizer_sanitize_hex( $new_instance['titlecolor'] );

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
		'title' => '',
		'image_uri' => get_template_directory_uri().'/assets/images/biowidget_pp.jpg',
		'name' => 'Jhon Doe',
		'occu' => __('Blogger','optimizer'),
		'bio' => __('Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits. Dramatically visualize customer directed convergence without revolutionary ROI.','optimizer'),
		'bgcolor' => '',
		'txtcolor' => '',
		'titlecolor' => '',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'optimizer'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
    </p>
    
    
		<!-- BIO Image Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'image_uri' ); ?>"><?php _e('Image', 'optimizer') ?></label>
			<div class="media-picker-wrap">
            <?php if(!empty($instance['image_uri'])) { ?>
				<img style="max-width:100%; height:auto;" class="media-picker-preview" src="<?php echo esc_url($instance['image_uri']); ?>" />
                <i class="fa fa-times media-picker-remove"></i>
            <?php } ?>
            <input class="widefat media-picker" id="<?php echo $this->get_field_id( 'image_uri' ); ?>" name="<?php echo $this->get_field_name( 'image_uri' ); ?>" value="<?php echo esc_url($instance['image_uri']); ?>" type="hidden" />
            <a class="media-picker-button button" onclick="mediaPicker(this.id)" id="<?php echo $this->get_field_id( 'image_uri' ).'mpick'; ?>"><?php _e('Select Image', 'optimizer') ?></a>
            </div>
		</p>
    
    <p>
      <label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('Name', 'optimizer'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('name'); ?>" id="<?php echo $this->get_field_id('name'); ?>" value="<?php echo $instance['name']; ?>" class="widefat" />
    </p>
    
    <p>
      <label for="<?php echo $this->get_field_id('occu'); ?>"><?php _e('Occupation', 'optimizer'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('occu'); ?>" id="<?php echo $this->get_field_id('occu'); ?>" value="<?php echo $instance['occu']; ?>" class="widefat" />
    </p>
        
        <p>
        <label><?php _e('Description', 'optimizer'); ?></label>
        <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('bio'); ?>" name="<?php echo $this->get_field_name('bio'); ?>"><?php echo $instance['bio']; ?></textarea>
        </p>
		
        
        <!-- Widget Backgrounnd Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'bgcolor' ); ?>"><?php _e('Background Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'bgcolor' ); ?>" name="<?php echo $this->get_field_name( 'bgcolor' ); ?>" value="<?php echo $instance['bgcolor']; ?>" type="text" />
		</p>
        
        <!-- Widget Text Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'txtcolor' ); ?>"><?php _e('Text Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'txtcolor' ); ?>" name="<?php echo $this->get_field_name( 'txtcolor' ); ?>" value="<?php echo $instance['txtcolor']; ?>" type="text" />
		</p>
        
        <!-- Widget Title Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'titlecolor' ); ?>"><?php _e('Title Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'titlecolor' ); ?>" name="<?php echo $this->get_field_name( 'titlecolor' ); ?>" value="<?php echo $instance['titlecolor']; ?>" type="text" />
		</p>
        

		
	<?php
	}


		//ENQUEUE CSS
        function front_bio_enqueue_css() {
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
				
			$postbgcolor =		'';
			$titlecolor =		'';
			$secbgcolor =		'';
			
			if ( ! empty( $instance['bgcolor'] ) ){	$bgcolor = 'background-color: ' . $instance['bgcolor'] . '; ';}
			if ( ! empty( $instance['txtcolor'] ) ){	$txtcolor = 'color: ' . $instance['txtcolor'] . '; ';}
			if ( ! empty( $instance['titlecolor'] ) ) {	$titlecolor = 'color: ' . $instance['titlecolor'] . '; ';}
				
				$widget_style = '#'.$id.' .widget_wrap{ '.$bgcolor.' }#'.$id.' .widgettitle, #'.$id.' .ast_biotxt h3{'.$titlecolor.' } #'.$id.' .ast_biotxt{' . $txtcolor. '}';
				wp_add_inline_style( 'optimizer-style', $widget_style );
			}
		}
	} //END FOREACH
}




/* ---------------------------- */
/* -------- Coundown Widget -------- */
/* ---------------------------- */
add_action( 'widgets_init', 'ast_countdown_widgets' );

function optimizer_datepicker(){
  wp_enqueue_script('jquery-ui-datepicker');
}
add_action('admin_enqueue_scripts', 'optimizer_datepicker');

/*
 * Register widget.
 */
function ast_countdown_widgets() {
	register_widget( 'ast_countdown_widget' );
}

/*
 * Widget class.
 */
class ast_countdown_Widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	
	function __construct() {
		parent::__construct( 'ast_countdown_widget', __( 'Countdown', 'optimizer' ), array(
			'classname'   => 'optim_countdown_widget',
			'description' => __( 'An Optimizer widget to display a Countdown.', 'optimizer' ),
		) );
		$this->alt_option_name = 'ast_countdown_widget';
		add_action('wp_enqueue_scripts', array(&$this, 'front_countdown_enqueue_css'));
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = isset( $instance['title'] ) ? apply_filters('widget_title', $instance['title'] ) : __('Minutes to Midnight','optimizer');
		$desc = isset( $instance['desc'] ) ? $instance['desc'] : __('Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits. Dramatically visualize customer directed convergence.','optimizer');
		$day = isset( $instance['day'] ) ? $instance['day'] : '11/27/2016';
		$hour = isset( $instance['hour'] ) ? $instance['hour'] : '00';
		$minute = isset( $instance['minute'] ) ? $instance['minute'] : '00';
		$seconds = isset( $instance['seconds'] ) ? $instance['seconds'] : '00';
		$style = isset( $instance['style'] ) ? $instance['style'] : 'circle_trans';	
		$title_color = isset( $instance['title_color'] ) ? $instance['title_color'] : '#666E73';
		$content_color = isset( $instance['content_color'] ) ? $instance['content_color'] : '#666E73';
		$content_bg = isset( $instance['content_bg'] ) ? $instance['content_bg'] : '#F2F9FD';	
		$content_bgimg = isset( $instance['content_bgimg'] ) ? $instance['content_bgimg'] : '';	

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';

		/* Display a containing div */
 		if(!empty($content_bgimg)){ $hasbgimg = 'hasbgimg';}else{$hasbgimg = '';}
		echo '<div class="ast_countdown '.$hasbgimg.'">';
			if ( $title ){
				echo $before_title . $title . $after_title;
			}
			
			if ( $desc || is_customize_preview() ) {
				echo '<div class="ast_count"><span class="countdown_content">'.$desc.' </span></div>';
			}
			echo '<ul id="countdown" class="countdown_'.$style.'" data-countdown="'.$day.' '.$hour.':'.$minute.':'.$seconds.'"></ul>';

		echo '</div>';


		
		//Stylesheet-loaded in Customizer Only.
		if(is_customize_preview()){
			$id= $this->id;
			
			echo '<script>jQuery(window).bind("load", function(){
					jQuery("#'.$id.'").each(function(index, element) {
						jQuery(this).find(".ast_countdown ul").countdown(jQuery(this).find(".ast_countdown ul").attr("data-countdown")).on("update.countdown", function(event) {
					   jQuery(this).html(event.strftime(""
						+ "<li><span class=\'days\'>%D</span><p class=\'timeRefDays\'>'.__('Days', 'optimizer').'</p></li>"
						+ "<li><span class=\'hours\'>%H</span><p class=\'timeRefHours\'>'.__('Hours', 'optimizer').'</p></li>"
						+ "<li><span class=\'minutes\'>%M</span><p class=\'timeRefMinutes\'>'.__('Min', 'optimizer').'</p></li>"
						+ "<li><span class=\'seconds\'>%S</span><p class=\'timeRefSeconds\'>'.__('Sec', 'optimizer').'</p></li>"));
						});
					});
				});</script>';
			
				$content_bg =		'background-color:#F2F9FD;';
				$title_color =	'color:#666E73;';
				$content_color =	'color:#666E73;';
				$content_bgimg =	'';
				
				if ( ! empty( $instance['content_bg'] ) ) {$content_bg = 'background-color: ' . $instance['content_bg'] . '!important; ';}
				if ( ! empty( $instance['content_color'] ) ) {$content_color = 'color: ' . $instance['content_color'] . '!important; ';}
				if ( ! empty( $instance['title_color'] ) ) {$title_color = 'color: ' . $instance['title_color'] . '!important; ';}
				if ( ! empty( $instance['content_bgimg'] ) ) {$content_bgimg = 'background-image: url(' . $instance['content_bgimg'] . ')!important; ';}
				
				echo '<style>#'.$id.'{ ' . $content_bg . '' . $content_color . ''.$content_bgimg.'}#'.$id.' .widget_wrap{' . $content_color . '}#'.$id.' .widget_wrap .widgettitle{' . $title_color . '}#'.$id.' .widget_wrap .ast_countdown li{color:rgba('.optimizer_hex2rgb($instance['content_color']).', 0.8)!important;}</style>';
			
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
        $instance['desc'] = wp_kses_post($new_instance['desc']) ;		
        $instance['day'] = strip_tags( $new_instance['day'] );
		$instance['hour'] = strip_tags( $new_instance['hour'] );
		$instance['minute'] = strip_tags( $new_instance['minute'] );
		$instance['seconds'] = strip_tags( $new_instance['seconds'] );
		$instance['style'] = strip_tags( $new_instance['style'] );
		$instance['title_color'] = optimizer_sanitize_hex($new_instance['title_color']);
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
		'title' => __('Minutes to Midnight','optimizer'),
		'desc' => __('Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits. Dramatically visualize customer directed convergence.','optimizer'),		
		'day' => '11/27/2016',
		'hour' => '00',
		'minute' => '00',
		'seconds' => '00',
		'style' => 'circle_trans',
		'title_color' => '#666E73',
		'content_color' => '#666E73',
		'content_bg' => '#F2F9FD',
		'content_bgimg' => ''
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'optimizer'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
    </p>
    
        <p>
        <label><?php _e('Description', 'optimizer'); ?></label>
        <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>"><?php echo $instance['desc']; ?></textarea>
        </p>
        
        
    <p>
    <label><?php _e('Set Countdown Date', 'optimizer'); ?></label>
        <input style="display:inline;" type="text" class="widefat ast_date" name="<?php echo $this->get_field_name('day'); ?>" id="<?php echo $this->get_field_id('day'); ?>" value="<?php echo $instance['day']; ?>" placeholder="mm/dd/yyyy"></p>
        

        
        <p>
        <label><?php _e('Set Countdown Time', 'optimizer'); ?></label>
        <input style="display:inline;width:50px;" type="text" size="3" name="<?php echo $this->get_field_name('hour'); ?>" id="<?php echo $this->get_field_id('hour'); ?>" value="<?php echo $instance['hour']; ?>">:
        <input style="display:inline;width:50px;" type="text" size="3" name="<?php echo $this->get_field_name('minute'); ?>" id="<?php echo $this->get_field_id('minute'); ?>" value="<?php echo $instance['minute']; ?>">:
        <input style="display:inline;width:50px;" type="text" size="3" name="<?php echo $this->get_field_name('seconds'); ?>" id="<?php echo $this->get_field_id('seconds'); ?>" value="<?php echo $instance['seconds']; ?>">
        <div>
        <span style="width:50px; text-align:center; display: inline-block;">Hours</span>
        <span style="width:50px; text-align:center; margin-right:5px;display: inline-block;">Minutes</span>
        <span style="width:50px; text-align:center;display: inline-block;">Seconds</span>
        </div>


    </p>
    
		<p>
			<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e('Coundtown Style:', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>" class="widefat">
				<option value="circle_trans" <?php if ( 'circle_trans' == $instance['style'] ) echo 'selected="selected"'; ?>><?php _e('Circle (Transparent)', 'optimizer') ?></option>
				<option value="circle_white" <?php if ( 'circle_white' == $instance['style'] ) echo 'selected="selected"'; ?>><?php _e('Circle (White)', 'optimizer') ?></option>
                <option value="circle_black" <?php if ( 'circle_black' == $instance['style'] ) echo 'selected="selected"'; ?>><?php _e('Circle (Black)', 'optimizer') ?></option>
                <option value="square_trans" <?php if ( 'square_trans' == $instance['style'] ) echo 'selected="selected"'; ?>><?php _e('Square (Transparent)', 'optimizer') ?></option>
				<option value="square_white" <?php if ( 'square_white' == $instance['style'] ) echo 'selected="selected"'; ?>><?php _e('Square (White)', 'optimizer') ?></option>
                <option value="square_black" <?php if ( 'square_black' == $instance['style'] ) echo 'selected="selected"'; ?>><?php _e('Square (Black)', 'optimizer') ?></option>
				<option value="skewed_trans" <?php if ( 'skewed_trans' == $instance['style'] ) echo 'selected="selected"'; ?>><?php _e('Skewed (Transparent)', 'optimizer') ?></option>
				<option value="skewed_white" <?php if ( 'skewed_white' == $instance['style'] ) echo 'selected="selected"'; ?>><?php _e('Skewed (White)', 'optimizer') ?></option>
                <option value="skewed_black" <?php if ( 'skewed_black' == $instance['style'] ) echo 'selected="selected"'; ?>><?php _e('Skewed (Black)', 'optimizer') ?></option>
				<option value="diamond_trans" <?php if ( 'diamond_trans' == $instance['style'] ) echo 'selected="selected"'; ?>><?php _e('Diamond (Transparent)', 'optimizer') ?></option>
				<option value="diamond_white" <?php if ( 'diamond_white' == $instance['style'] ) echo 'selected="selected"'; ?>><?php _e('Diamond (White)', 'optimizer') ?></option>
                <option value="diamond_black" <?php if ( 'diamond_black' == $instance['style'] ) echo 'selected="selected"'; ?>><?php _e('Diamond (Black)', 'optimizer') ?></option>
			</select>
		</p>
        
		<!-- Countdown Content Title Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title_color' ); ?>"><?php _e('Title Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'title_color' ); ?>" name="<?php echo $this->get_field_name( 'title_color' ); ?>" value="<?php echo $instance['title_color']; ?>" type="text" />
		</p>
    
    
		<!-- Countdown Content Text Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'content_color' ); ?>"><?php _e('Text Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'content_color' ); ?>" name="<?php echo $this->get_field_name( 'content_color' ); ?>" value="<?php echo $instance['content_color']; ?>" type="text" />
		</p>
                
        <!-- Countdown Content Background Color Field -->
		<p>
			<label for="<?php echo $this->get_field_id( 'content_bg' ); ?>"><?php _e('Background Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'content_bg' ); ?>" name="<?php echo $this->get_field_name( 'content_bg' ); ?>" value="<?php echo $instance['content_bg']; ?>" type="text" />
		</p>
        
        <!-- Countdown Content Background Image -->
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
		
	<?php
	}

		//ENQUEUE CSS
        function front_countdown_enqueue_css() {
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
				
				$content_bg =		'background-color:#F2F9FD;';
				$content_color =	'color:#666E73;';
				$title_color =	'color:#666E73;';
				$content_bgimg =	'';
				
				if ( ! empty( $instance['content_bg'] ) ) {$content_bg = 'background-color: ' . $instance['content_bg'] . '!important; '; }
				if ( ! empty( $instance['content_color'] ) ) { $content_color = 'color: ' . $instance['content_color'] . '!important; '; }
				if ( ! empty( $instance['title_color'] ) ) { $title_color = 'color: ' . $instance['title_color'] . '!important; '; }
				if ( ! empty( $instance['content_bgimg'] ) ) { $content_bgimg = 'background-image: url(' . $instance['content_bgimg'] . ')!important; '; }
				if ( ! empty( $instance['content_color'] ) ) {$content_rgba =	$instance['content_color'];}
				
				$widget_style = '#'.$id.'{ ' . $content_bg . '' . $content_color . '' . $content_bgimg . '}#'.$id.' .widget_wrap{' . $content_color . '}#'.$id.' .widget_wrap .widgettitle{' . $title_color . '}#'.$id.' .widget_wrap .ast_countdown li{color:rgba('.optimizer_hex2rgb($content_rgba).', 0.8)!important;}';
				wp_add_inline_style( 'optimizer-style', $widget_style );
			}
		}
	} //END FOREACH
}


/* ---------------------------- */
/* -------- Social Widget -------- */
/* ---------------------------- */
add_action( 'widgets_init', 'ast_scoial_widgets' );


/*
 * Register widget.
 */
function ast_scoial_widgets() {
	register_widget( 'ast_scoial_widget' );
}

/*
 * Widget class.
 */
class ast_scoial_Widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */

	
	function __construct() {
		parent::__construct( 'ast_scoial_widget', __( 'Social Bookmark', 'optimizer' ), array(
			'classname'   => 'ast_scoial_widget',
			'description' => __( 'An Optimizer Social widget to display your Social Follow Buttons.', 'optimizer' ),
		) );
		$this->alt_option_name = 'ast_scoial_widget';
		add_action('wp_enqueue_scripts', array(&$this, 'front_social_enqueue_css'));
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings.*/
		$title = isset( $instance['title'] ) ? apply_filters('widget_title', $instance['title'] ) : '';
		$verb = isset( $instance['verb'] ) ? $instance['verb'] : __('Follow Us On','optimizer');
		$style = isset( $instance['style'] ) ? $instance['style'] : 'square_text';
		$icon_color = isset( $instance['icon_color'] ) ? $instance['icon_color'] : '#ffffff';
		
		$facebook_uri = isset( $instance['fb_uri'] ) ? esc_url($instance['fb_uri']) : 'https://www.facebook.com/optimizerwp';
		$twitter_uri = isset( $instance['twt_uri'] ) ? esc_url($instance['twt_uri']) : 'https://twitter.com/optimizerwp';
		$google_uri = isset( $instance['gplus_uri'] ) ? esc_url($instance['gplus_uri']) :'https://plus.google.com/u/0/b/103483167150562533630/+Layerthemes/posts';
		$youtube_uri = isset( $instance['ytb_uri'] ) ? esc_url($instance['ytb_uri']) : '';
		$flickr_uri = isset( $instance['flckr_uri'] ) ? esc_url($instance['flckr_uri']) : '';
		$linkedin_uri = isset( $instance['lnkdn_uri'] ) ? esc_url($instance['lnkdn_uri']) : '';
		$pinterest_uri = isset( $instance['pntrst_uri'] ) ? esc_url($instance['pntrst_uri']) : '';
		$tumblr_uri = isset( $instance['tumblr_uri'] ) ? esc_url($instance['tumblr_uri']) : '';
		$instagram_uri = isset( $instance['insta_uri'] ) ? esc_url($instance['insta_uri']) : '';

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			
		
		if($style == 'square_text' || $style == 'round_text' || $style == 'full_text' ){ $has_text = 'soc_has_text'; }else{ $has_text = ''; }
		/* Display a containing div */
		echo '<div class="ast_scoial social_style_'. $style .' '.$has_text.'">';
		
		if($icon_color == '#FFFFFF' || $icon_color == '#ffffff'){ $icon_color = ''; }else{ $icon_color = 'style="background-color:'.$instance['icon_color'].'!important;"'; }	 


		if($facebook_uri){ echo '<a target="_blank" class="ast_wdgt_fb" href="'.$facebook_uri.'" '.$icon_color.'><i class="fa-facebook"></i> <span>'.do_shortcode($verb).' </span></a>'; }
		
		if($twitter_uri){echo '<a target="_blank" class="ast_wdgt_twt" href="'.$twitter_uri.'" '.$icon_color.'><i class="fa-twitter"></i> <span>'.do_shortcode($verb).' </span></a>';}
		
		if($google_uri){echo '<a target="_blank" class="ast_wdgt_gplus" href="'.$google_uri.'" '.$icon_color.'><i class="fa-google-plus"></i> <span>'.do_shortcode($verb).' </span></a>';}		
		
		if($youtube_uri){echo '<a target="_blank" class="ast_wdgt_ytb" href="'.$youtube_uri.'" '.$icon_color.'><i class="fa-youtube-play"></i> <span>'.do_shortcode($verb).' </span></a>';}		
		
		if($flickr_uri){echo '<a target="_blank" class="ast_wdgt_flickr" href="'.$flickr_uri.'" '.$icon_color.'><i class="fa-flickr"></i> <span>'.do_shortcode($verb).' </span></a>';}
		
		if($linkedin_uri){echo '<a target="_blank" class="ast_wdgt_lnkdn" href="'.$linkedin_uri.'" '.$icon_color.'><i class="fa-linkedin"></i> <span>'.do_shortcode($verb).' </span></a>';}		
		
		if($pinterest_uri){echo '<a target="_blank" class="ast_wdgt_pntrst" href="'.$pinterest_uri.'" '.$icon_color.'><i class="fa-pinterest"></i> <span>'.do_shortcode($verb).' </span></a>';	}	
		
		if($tumblr_uri){echo '<a target="_blank" class="ast_wdgt_tmblr" href="'.$tumblr_uri.'" '.$icon_color.'><i class="fa-tumblr"></i> <span>'.do_shortcode($verb).' </span></a>';}	
			
		if($instagram_uri){echo '<a target="_blank" class="ast_wdgt_insta" href="'.$instagram_uri.'" '.$icon_color.'><i class="fa-instagram"></i> <span>'.do_shortcode($verb).' </span></a>';	}	
				

		echo '</div>';
		
		//Stylesheet-loaded in Customizer Only.
		if(is_customize_preview()){
			$id= $this->id;
				if ( ! empty( $instance['icon_color'] ) && !$instance['icon_color'] =='#FFFFFF' ) {	 
					echo '<style>#'.$id.' .ast_scoial a, #'.$id.' .ast_scoial.social_style_round_text a i{background-color:' . $instance['icon_color']. ';} #'.$id.' .ast_scoial.social_style_round_text a span{color:' . $instance['icon_color']. '!important;} #'.$id.'.ast_scoial_widget .ast_scoial a{background-color:' . $instance['icon_color']. '!important;}</style>';
				}
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
		$instance['verb'] = strip_tags( $new_instance['verb']);
		$instance['style'] = strip_tags( $new_instance['style']);
		$instance['icon_color'] = optimizer_sanitize_hex( $new_instance['icon_color']);
		$instance['fb_uri'] = esc_url_raw( $new_instance['fb_uri']);
		$instance['twt_uri'] = esc_url_raw( $new_instance['twt_uri']);
		$instance['gplus_uri'] = esc_url_raw( $new_instance['gplus_uri']);	
		$instance['ytb_uri'] = esc_url_raw( $new_instance['ytb_uri']);
		$instance['flckr_uri'] = esc_url_raw( $new_instance['flckr_uri']);
		$instance['lnkdn_uri'] = esc_url_raw( $new_instance['lnkdn_uri']);
		$instance['pntrst_uri'] = esc_url_raw( $new_instance['pntrst_uri']);
		$instance['tumblr_uri'] = esc_url_raw( $new_instance['tumblr_uri']);
		$instance['insta_uri'] = esc_url_raw( $new_instance['insta_uri']);
		

		return $instance;
	}
	
	/* ---------------------------- */
	/* ------- Widget Settings ------- */
	/* ---------------------------- */
	
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
		'title' => '',
		'verb' => 'Follow me on',
		'style' => 'square_text',
		'icon_color' => '#ffffff',
		'fb_uri' => 'https://www.facebook.com/optimizerwp',
		'twt_uri' => 'https://twitter.com/optimizerwp',
		'gplus_uri' => 'https://plus.google.com/u/0/b/103483167150562533630/+Layerthemes/posts',
		'ytb_uri' => '',
		'flckr_uri' => '',
		'lnkdn_uri' => '',
		'pntrst_uri' => '',
		'tumblr_uri' => '',
		'insta_uri' => '',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'optimizer') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo htmlentities($instance['title']); ?>" type="text" />
		</p>
    
        <p>
          <label for="<?php echo $this->get_field_id('verb'); ?>"><?php _e('Follow Text', 'optimizer'); ?></label>
          <input type="text" name="<?php echo $this->get_field_name('verb'); ?>" id="<?php echo $this->get_field_id('verb'); ?>" value="<?php echo $instance['verb']; ?>" class="widefat" />
        </p>
    
		<p>
			<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e('Icon Style:', 'optimizer') ?></label>
			<select id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>" class="widefat">
				<option value="round" <?php if ( 'round' == $instance['style'] ) echo 'selected="selected"'; ?>><?php _e('Round', 'optimizer') ?></option>
                <option value="square" <?php if ( 'square' == $instance['style'] ) echo 'selected="selected"'; ?>><?php _e('Square', 'optimizer') ?></option>
				<option value="round_text" <?php if ( 'round_text' == $instance['style']) echo 'selected="selected"'; ?>><?php _e('Round (With Text)', 'optimizer') ?></option>
				<option value="square_text" <?php if ( 'square_text' == $instance['style'] ) echo 'selected="selected"'; ?>><?php _e('Square (With Text)', 'optimizer') ?>
                <option value="full" <?php if ( 'full' == $instance['style'] ) echo 'selected="selected"'; ?>><?php _e('Full', 'optimizer') ?>
                <option value="full_text" <?php if ( 'full_text' == $instance['style'] ) echo 'selected="selected"'; ?>><?php _e('Full (With Text)', 'optimizer') ?>
			</select>
		</p>
        
		<p>
			<label for="<?php echo $this->get_field_id( 'icon_color' ); ?>"><?php _e('Override Default Icons Color', 'optimizer') ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'icon_color' ); ?>" name="<?php echo $this->get_field_name( 'icon_color' ); ?>" value="<?php echo $instance['icon_color']; ?>" type="text" />
		</p>

	<p style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px;"><strong><?php _e('Pleace Your Social Links in the fields below and they will be auto detected:','optimizer'); ?></strong></p>

    <p>
      <label for="<?php echo $this->get_field_id('fb_uri'); ?>"><?php _e('Link 1 ', 'optimizer'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('fb_uri'); ?>" id="<?php echo $this->get_field_id('fb_uri'); ?>" value="<?php echo esc_url($instance['fb_uri']); ?>" class="widefat" />
    </p>
    
    <p>
      <label for="<?php echo $this->get_field_id('twt_uri'); ?>"><?php _e('Link 2 ', 'optimizer'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('twt_uri'); ?>" id="<?php echo $this->get_field_id('twt_uri'); ?>" value="<?php echo esc_url($instance['twt_uri']); ?>" class="widefat" />
    </p>
    
	<p>
      <label for="<?php echo $this->get_field_id('gplus_uri'); ?>"><?php _e('Link 3 ', 'optimizer'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('gplus_uri'); ?>" id="<?php echo $this->get_field_id('gplus_uri'); ?>" value="<?php echo esc_url($instance['gplus_uri']); ?>" class="widefat" />
    </p>
    
	<p>
      <label for="<?php echo $this->get_field_id('ytb_uri'); ?>"><?php _e('Link 4 ', 'optimizer'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('ytb_uri'); ?>" id="<?php echo $this->get_field_id('ytb_uri'); ?>" value="<?php echo esc_url($instance['ytb_uri']); ?>" class="widefat" />
    </p>   
    
	<p>
      <label for="<?php echo $this->get_field_id('flckr_uri'); ?>"><?php _e('Link 5 ', 'optimizer'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('flckr_uri'); ?>" id="<?php echo $this->get_field_id('flckr_uri'); ?>" value="<?php echo esc_url($instance['flckr_uri']); ?>" class="widefat" />
    </p>
    
	<p>
      <label for="<?php echo $this->get_field_id('lnkdn_uri'); ?>"><?php _e('Link 6 ', 'optimizer'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('lnkdn_uri'); ?>" id="<?php echo $this->get_field_id('lnkdn_uri'); ?>" value="<?php echo esc_url($instance['lnkdn_uri']); ?>" class="widefat" />
    </p>
    
    
	<p>
      <label for="<?php echo $this->get_field_id('pntrst_uri'); ?>"><?php _e('Link 7 ', 'optimizer'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('pntrst_uri'); ?>" id="<?php echo $this->get_field_id('pntrst_uri'); ?>" value="<?php echo esc_url($instance['pntrst_uri']); ?>" class="widefat" />
    </p>    
    
	<p>
      <label for="<?php echo $this->get_field_id('tumblr_uri'); ?>"><?php _e('Link 8 ', 'optimizer'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('tumblr_uri'); ?>" id="<?php echo $this->get_field_id('tumblr_uri'); ?>" value="<?php echo esc_url($instance['tumblr_uri']); ?>" class="widefat" />
    </p>   
    
    <p>
      <label for="<?php echo $this->get_field_id('insta_uri'); ?>"><?php _e('Link 9 ', 'optimizer'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('insta_uri'); ?>" id="<?php echo $this->get_field_id('insta_uri'); ?>" value="<?php echo esc_url($instance['insta_uri']); ?>" class="widefat" />
    </p>

	<?php
	}
	
		//ENQUEUE CSS
        function front_social_enqueue_css() {
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
				
				$icon_color = '';
				if ( ! empty( $instance['icon_color'] ) ) {
					$icon_color = $instance['icon_color'];
				}
				
				if ( ! empty( $instance['icon_color'] ) && !$instance['icon_color'] =='#FFFFFF' ) {	 
				$widget_style = '#'.$id.'.ast_scoial_widget .ast_scoial a{background-color:' . $icon_color. '!important;}';
				}{ $widget_style = '';}
				
				wp_add_inline_style( 'optimizer-style', $widget_style );
				
				}
			} //END FOREACH
		}
	//front_social_enqueue_css

}



/* ---------------------------- */
/* -------- Instagram Widget -------- */
/* ---------------------------- */
add_action( 'widgets_init', 'ast_instagram_widgets' );


/*
 * Register widget.
 */
function ast_instagram_widgets() {
	register_widget( 'ast_instagram_widget' );
}

/*
 * Widget class.
 */
class ast_instagram_Widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */

	function __construct() {
		parent::__construct( 'ast_instagram_widget', __( 'Instagram', 'optimizer' ), array(
			'classname'   => 'ast_instagram_widget',
			'description' => __( 'An Instagram widget that let\'s you display your Instagram photos.', 'optimizer' ),
		) );
		$this->alt_option_name = 'ast_instagram_widget';
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$client_id = $instance['client_id'];
		$access_token = $instance['access_token'];
		$num = $instance['num'];
		$size = isset( $instance['size'] ) ? $instance['size'] : 'thumb';

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			
		/* Display a containing div */
		echo '<ul id="ast_instagram" class="widget_insta_'.$size.'">';
		
		echo '</ul>';
		
		echo '<script type="text/javascript">';
			echo 'jQuery(window).bind("load", function(){';
			echo 'jQuery("#ast_instagram").jqinstapics({"user_id": "'.$client_id.'","access_token": "'.$access_token.'","count": '.$num.'});';
			echo '});';
		echo '</script>';

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
		
		$instance['client_id'] = strip_tags( $new_instance['client_id']);
		$instance['access_token'] = strip_tags( $new_instance['access_token']);
		$instance['num'] = absint( $new_instance['num']);	
		$instance['size'] = strip_tags( $new_instance['size']);	
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
		'title' => '',
		'client_id' => '',
		'access_token' => '',
		'num' => '9',
		'size' => 'thumb',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'optimizer'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
    </p>
    
    <p>
      <label for="<?php echo $this->get_field_id('client_id'); ?>"><?php _e('Instagram user id number', 'optimizer'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('client_id'); ?>" id="<?php echo $this->get_field_id('client_id'); ?>" value="<?php echo $instance['client_id']; ?>" class="widefat" />
    </p>    <p>
      <label for="<?php echo $this->get_field_id('access_token'); ?>"><?php _e('Instagram Access Token', 'optimizer'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('access_token'); ?>" id="<?php echo $this->get_field_id('access_token'); ?>" value="<?php echo $instance['access_token']; ?>" class="widefat" />
    </p>
    
    <p>
      <label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('Number of Photos', 'optimizer'); ?></label>
      <input type="text" name="<?php echo $this->get_field_name('num'); ?>" id="<?php echo $this->get_field_id('num'); ?>" value="<?php echo $instance['num']; ?>" class="widefat" />
    </p>
    
    <!-- Image Size: Text Input -->
    <p>
        <label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e('Image Size', 'optimizer') ?></label>
        <select id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>" class="widefat">
            <option value="thumb"  <?php if ( 'thumb' == $instance['size'] ) echo 'selected="selected"'; ?>><?php _e('Thumbnail', 'optimizer') ?></option>
            <option value="medium"  <?php if ( 'medium' == $instance['size'] ) echo 'selected="selected"'; ?>><?php _e('Medium', 'optimizer') ?></option>
            <option value="large"  <?php if ( 'large' == $instance['size'] ) echo 'selected="selected"'; ?>><?php _e('Large', 'optimizer') ?></option>
        </select>
    </p>

   
    <p>
		<!--WIDGET TIPS-->
         <ul class="widget_tips">
             <li><i class="fa fa-info-circle"></i> <?php _e('To Retrive your user id number and Access token, Please follow ','optimizer'); ?> <a target="_blank" href="https://optimizerwp.com/documentation/activating-instagram-widget/"><?php _e('This Instruction','optimizer'); ?> </a>
             </li>
         </ul>
	</p>
	<?php
	}

}





/* ---------------------------- */
/* -------- Pinterest Widget -------- */
/* ---------------------------- */
include_once(ABSPATH . WPINC . '/feed.php');

// Register the widget.
add_action( 'widgets_init', 'optimizer_register_pinterest_widget' );

function optimizer_register_pinterest_widget() {
	register_widget( 'optimizer_pinterest_widget' );
}


class optimizer_pinterest_Widget extends WP_Widget {



	function __construct() {
		parent::__construct( 'optimizer_pinterest_widget', __( 'Pinterest', 'optimizer' ), array(
			'classname'   => 'optimizer_pinterest_widget',
			'description' => __( 'This Widget lets you add Pinterest Pinboards', 'optimizer' ),
		) );
		$this->alt_option_name = 'optimizer_pinterest_widget';
	}
	
	
    /**
     * Widget settings.
     */
    protected $widget = array(
            // Default title for the widget in the sidebar.
            'title' => 'Recent pins',
            // Default widget settings.
            'username' => 'layerthemes',
            'num' => 12,
            'new_window' => 0,
            // RSS cache lifetime in seconds.
            'cache_lifetime' => 900,
            // Pinterest url
            'pinterest_feed_url' => 'https://pinterest.com/%s/feed.rss',
			'size' => 'thumb'
    );
    
    var $start_time;
    var $protocol;

    
    function widget($args, $instance) {
        extract($args);
        echo($before_widget);
		if(is_customize_preview()) echo '<span class="widgetname">'.$this->name.'</span>';
        $title = apply_filters('widget_title', $instance['title']);
        echo($before_title . $title . $after_title);
		$size = isset( $instance['size'] ) ? $instance['size'] : 'thumb';
        ?>
        <div id="pinterest-pinboard-widget-container" class="widget_pinterest_<?php echo $size; ?>">
            <div class="pinboard">
            <?php

            // Get the RSS.
            $username = $instance['username'];
            $num = $instance['num'];
            $new_window = $instance['new_window'];
            $pins = $this->get_pins($username, $num);
			$size = isset( $instance['size'] ) ? $instance['size'] : 'thumb';
			
            if (is_null($pins)) {
                echo("Unable to load Pinterest pins for '$username'\n");
            } else {
                // Render the pinboard.
                $count = 0;
                foreach ($pins as $pin) {

                    $title = $pin['title'];
                    $url = $pin['url'];
                    $image = $pin['image'];
                    echo("<a href=\"$url\"");
                    if ($new_window) {
                        echo(" target=\"_blank\"");
                    }
                    echo("><img src=\"$image\" alt=\"$title\" title=\"$title\" /></a>");
                    $count++;

                }
            }
            ?>
            </div>
            <div class="pin_link">
                <a class="pin_logo" href="https://pinterest.com/<?php echo($username) ?>/">
                    <img src="https://passets-cdn.pinterest.com/images/small-p-button.png" width="16" height="16" alt="<?php _e('Follow Me on Pinterest' ,'optimizer') ?>" />
                </a>
                <span class="pin_text"><a target="_blank" href="http://pinterest.com/<?php echo($username) ?>/" <?php if ($new_window) { ?>target="_blank"<?php } ?>><?php _e('More Pins' ,'optimizer') ?></a></span>
            </div>
        </div>
        <?php
        echo($after_widget);
    }
	


    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['username'] = strip_tags($new_instance['username']);
        $instance['num'] = strip_tags($new_instance['num']);
        $instance['new_window'] = isset($new_instance['new_window']) ? 1 : 0;
		$instance['size'] = strip_tags($new_instance['size']);

        return $instance;
    }
    
    function form($instance) {
        // load current values or set to default.
        $title = array_key_exists('title', $instance) ? esc_attr($instance['title']) : $this->widget['title'];
        $username = array_key_exists('username', $instance) ? esc_attr($instance['username']) : $this->widget['username'];
        $num = array_key_exists('num', $instance) ? esc_attr($instance['num']) : $this->widget['num'];
        $new_window = array_key_exists('new_window', $instance) ? esc_attr($instance['new_window']) : $this->widget['new_window'];
		$size = array_key_exists('size', $instance) ? esc_attr($instance['size']) : $this->widget['size'];
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'optimizer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title', 'optimizer'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username:', 'optimizer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username', 'optimizer'); ?>" type="text" value="<?php echo $username; ?>" />
        </p>
        
        <!-- Image Size: Text Input -->
        <p>
            <label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e('Image Size', 'optimizer') ?></label>
            <select id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>" class="widefat">
                <option value="thumb"  <?php if ( 'thumb' == $size ) echo 'selected="selected"'; ?>><?php _e('Thumbnail', 'optimizer') ?></option>
                <option value="medium"  <?php if ( 'medium' == $size ) echo 'selected="selected"'; ?>><?php _e('Medium', 'optimizer') ?></option>
                <option value="large"  <?php if ( 'large' == $size ) echo 'selected="selected"'; ?>><?php _e('Large', 'optimizer') ?></option>
            </select>
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('Number of Pins', 'optimizer'); ?></label>
            <input id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="text" value="<?php echo $num; ?>" size="3" />
            <span><small><?php _e(' (Max 25)', 'optimizer'); ?></small></span>
        </p>
        
        <p>
            <input id="<?php echo $this->get_field_id('new_window'); ?>" name="<?php echo $this->get_field_name('new_window', 'optimizer'); ?>" type="checkbox" <?php if ($new_window) { ?>checked="checked" <?php } ?> />
            <label for="<?php echo $this->get_field_id('new_window'); ?>"><?php _e('Open links in a new window?', 'optimizer'); ?></label>
        </p>        
        <?php
    }


    
    /**
     * Retrieve RSS feed for username, and parse the data needed from it.
     * Returns null on error, otherwise a hash of pins.
     */
    function get_pins($username, $num) {

        // Set caching.
        add_filter('wp_feed_cache_transient_lifetime', create_function('$a', 'return '. $this->widget['cache_lifetime'] .';'));

        // Get the RSS feed.
        $url = sprintf($this->widget['pinterest_feed_url'], $username);
        $rss = fetch_feed($url);
        if (is_wp_error($rss)) {
            return null;
        }
		$size = $this->widget['size'];
        
        $maxitems = $rss->get_item_quantity($num);
        $rss_items = $rss->get_items(0, $maxitems);
        
        $pins;
        if (is_null($rss_items)) {
            $pins = null;
        } else {
            // Pattern to replace for the images.
            $search = array('236x');
			if($size == 'large'){$replace = array('736x');}else{$replace = array('236x');}
            
            // Add http replace is running secure.
            if ($this->is_secure()) {
                array_push($search, 'http://');
                array_push($replace, $this->protocol);
            }
            $pins = array();
            foreach ($rss_items as $item) {
                $title = $item->get_title();
                $description = $item->get_description();
                $url = $item->get_permalink();
                if (preg_match_all('/<img src="([^"]*)".*>/i', $description, $matches)) {
                    $image = str_replace($search, $replace, $matches[1][0]);
                }
                array_push($pins, array(
                    'title' => $title,
                    'image' => $image,
                    'url' => $url
                ));
            }
        }
        return $pins;
    }
    
    
    /**
     * Check if the server is running SSL.
     */
    function is_secure() {
        return !empty($_SERVER['HTTPS'])
            && $_SERVER['HTTPS'] !== 'off'
            || $_SERVER['SERVER_PORT'] == 443;
    } 

}