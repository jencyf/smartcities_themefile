jQuery.noConflict();
/** Fire up jQuery - let's dance! */
jQuery(document).ready(function($) {
	
	//Get customizer settings:
	//console.log(_wpCustomizeSettings);
	//console.log(_wpCustomizeWidgetsSettings);
		
	$('#footlinks').appendTo('#customize-controls');
	
	/*SETTINGS*/
	$('.optim_settings').on('click',function() {
		$(this).addClass('opactive');
		$('#optimizer_settings').animate({"left":"-280px"});
	 });
	 $('.optim_settings_close').on('click',function() {
		$('.optim_settings').removeClass('opactive');
		$('#optimizer_settings').animate({"left":"-830px"});
    });
	
	$('.optim_presets').on('click',function() {
		$(this).addClass('opactive');
		$('#preset_options').fadeIn();
	 });
	 $('.preset_close').on('click',function() {
		$('.optim_presets').removeClass('opactive');
		$('#preset_options').fadeOut();
    });
	

	 /*SETTINGS Options Toggle*/
	$('.setting_option h4').toggle(function(){ 
		$(this).parent().addClass('setting_toggle');
		$(this).next('.settings_toggle_inner').slideDown(200);
	},function(){
		$(this).parent().removeClass('setting_toggle');
		$(this).next('.settings_toggle_inner').slideUp(200);
	 });
	 
	 /*EXPAND*/
	$('.optim_expand').toggle(function(){ 
		$(this).addClass('opactive');
		$('body').addClass('optimizer_expand');
		$('#customize-controls').animate({"width":"420px"});
		$('#optimizer_settings').animate({"width":"360px"});
	},function(){
		$(this).removeClass('opactive');
		$('body').removeClass('optimizer_expand');
		$('#customize-controls').animate({"width":"330px"});
		$('#optimizer_settings').animate({"width":"270px"});
	 });



jQuery( document ).on('load ready', function() {
	
	/*MOVE Frontpage Widget Section before footer widget are*/
	wp.customize.section( 'sidebar-widgets-front_sidebar' ).panel( 'front_panel' );
	wp.customize.section( 'sidebar-widgets-front_sidebar' ).priority( 11 );
	wp.customize.section( 'sidebar-widgets-sidebar' ).priority( 3 );
	wp.customize.section( 'sidebar-widgets-foot_sidebar' ).panel( 'footer_panel' );
	wp.customize.section( 'sidebar-widgets-foot_sidebar' ).priority( 1 );
	wp.customize.section( 'basic_sidebar_section' ).panel( 'widgets' );
	wp.customize.section( 'basic_sidebar_section' ).priority( 1 );
	if(!jQuery('#customize-theme-controls #accordion-section-nav').length && jQuery('#customize-theme-controls #accordion-panel-nav_menus').length){ 
		wp.customize.panel( 'nav_menus' ).priority( 1 ); 
	}
	if(jQuery('#customize-theme-controls #accordion-section-nav').length){
		wp.customize.section( 'nav' ).priority( 1 ); 
	}
	wp.customize.panel( 'widgets' ).priority( 2 );
	
	/*TOOLTIP*/
	jQuery('.customize-control-description').each(function() {
        jQuery(this).hide();
		var tipcontent = jQuery(this).text();
		jQuery(this).parent().find('.customize-control-title:first').append('<i class="fa fa-question-circle customize-tooltip"><span class="optim_tooltip">'+tipcontent+'<dl class="tipbottom" /></span></i>');
    });
		$('.customize-tooltip').hoverIntent(function(){ 
			var x = jQuery(this).position();  jQuery(this).find('span').css({"left":-x.left - 8}); jQuery(this).find('dl').css({"left": x.left + 8}); 
				jQuery(this).addClass('tipactive');
				jQuery(this).find('span').stop().fadeIn(300);
		},function(){
				jQuery(this).removeClass('tipactive');
			jQuery(this).find('span').fadeOut(300);
		});
		
		$('ul.accordion-section-content').each(function(index, element) {
            	$(this).find('.customize-control:first .optim_tooltip').addClass('first_tooltip').prepend('<dl class="tipbottom" />');
        });

	//Footer Tooltip
	jQuery('#footlinks a').each(function(index, element) {
		var footip = jQuery(this).attr('title');
        jQuery(this).append('<span class="footer_tooltip">'+footip+'<dl class="tipbottom" /></span>');
		 jQuery(this).removeAttr('title');
    });
	jQuery('#customize-footer-actions .devices button').each(function(index, element) {
		var responsivetip = jQuery(this).find('.screen-reader-text').text();
        jQuery(this).append('<span class="footer_tooltip">'+responsivetip+'<dl class="tipbottom" /></span>');
    });

	jQuery('.button.change-theme').append('<span class="footer_tooltip">'+jQuery(this).attr('title')+'<dl class="tipbottom" /></span>');
	


});

	//Section Description Tooltip
	setTimeout(function(){
		jQuery('.customize-section-description-container').each(function(index, element) {
			jQuery(this).find('.customize-section-description').before('<i class="fa fa-question section-desc-toggle"></i>');
	
			$('.section-desc-toggle').toggle(function(){ 
					$(this).removeClass('fa-question').addClass('fa-times');
					$(this).parent().find('.customize-section-description').slideDown(300);
			},function(){
					$(this).addClass('fa-question').removeClass('fa-times');
					$(this).parent().find('.customize-section-description').slideUp(300);
			});
        });

	}, 1000);	
	
	//QUICKIE
	$('.wp-full-overlay-sidebar').prepend('<div class="quickie"><i class="optimizer_logo">O</i></div>');
	
	$('.wp-full-overlay-sidebar .quickie').after('<div class="quickie_text"><span class="logotxt"></span></div>');
	$('.quickie, .quickie_text, .logotxt').hover(function(){ 
			jQuery('.wp-full-overlay').addClass('quickiehover');
	},function(){
			jQuery('.wp-full-overlay').removeClass('quickiehover');
	});


	//Logo 
	$('.optimizer_logo').click(function(){
		$('.quickie i').removeClass('activeq');
		$('.wp-full-overlay').removeClass('quickiehover subsection-open');
		wp.customize.panel.each( function ( panel ) {  panel.collapse();});
		wp.customize.section.each( function ( section ) {  section.collapse();});
	});
	
	
	//Wordpress 4.7 FIXES------------------------
		if(objectL10n.wp4_7 == 'wp4_7'){
			jQuery('body').addClass('wp4_7');
		}
		
		//Wordpress 4.7 Section toggle
		jQuery(".wp4_7 #customize-theme-controls .control-section ").on("click", ".accordion-section-title", function(e) {
			$('.accordion-section').removeClass('sec_open'); 
			
			if( $(this).parent().has('.open')){
				setTimeout(function () { $('.control-section.open').parent().addClass('sec_open');  }, 50);
			}else{
				setTimeout(function () { $('.control-section.open').parent().removeClass('sec_open');   }, 50);
			}
			
		});
		//Wordpress 4.7 Widget Focus 
		wp.customize.previewer.bind( 'focus-widget-control', function(param){
			wp.customize.control.each( function ( control ) {  if(control.expanded) control.collapse();  });
			
			jQuery('.wp4_7 .accordion-section').removeClass('sec_open'); 
			setTimeout(function () { jQuery('.wp4_7 .control-section.open').parent().addClass('sec_open');  }, 100);
			
			var thewidgetid = param.replace( /^\D+/g, ''); 
			var thewidgetname = param.split("-")[0];
			console.log(param);
			wp.customize.control( 'widget_'+thewidgetname+'['+thewidgetid+']' ).focus();
			
		} );
	//Wordpress 4.7 - Group All Controls in sections
	$('.customize-pane-child:not(.control-section-nav_menu )').each(function(index, element) {
		var ariaid = $(this).attr('id');
        $(this).insertAfter('li.control-subsection[aria-owns="'+ariaid+'"] h3');
    });
	/*Custom Sections Added by Plugins*/
	$('.accordion-section-content').not('.control-section-nav_menu, #sub-accordion-section-colors').each(function(index, element) {
		if(! $(this).parent().parent().hasClass("control-panel-content")) {
			if($(this).has('.customize-control')){
				$(this).addClass('custom_section');
			}
		}
    });
	//-------------------------------------------


	
	//REMOVE NOW CUSTOMIZING THEME INFO
	$('#customize-info').remove();
	
	
	//WIDGET PRESETS
	jQuery('#widget_presets i.fa.fa-times').on('click', function(){
		jQuery('#widget_presets, .tour_backdrop').fadeOut();
	});
		
	function optim_preset_widgets(target){
		jQuery('.preset_widgets_button').on('click', function(){
			jQuery('#widget_presets, .tour_backdrop').fadeIn();
			jQuery(".preset_tabs img").unveil();
		});
		if(target == ''){}else{ jQuery('.widget_preset_left li').removeClass('.active_presw'); jQuery('.widget_preset_left li').eq(target).addClass('.active_presw'); }
	}
	
	optim_preset_widgets();

});

/*REFACTOR CONTROLS*/
jQuery(window).bind('load', function(){

	//Move Switch theme button to footer
	jQuery('.change-theme').prependTo('#footlinks');
	jQuery('.change-theme').attr('title',objectL10n.switchtheme).html('<i class="fa fa-random"></i>');
	jQuery('.button.change-theme').append('<span class="footer_tooltip">'+jQuery('.button.change-theme').attr('title')+'<dl class="tipbottom" /></span>');
	
	//===QUCIKIES===
	//ASSIGN QUICKIE ICONS
	jQuery('#accordion-panel-basic_panel').attr('data-qicon', 'fa-sliders');  jQuery('#accordion-panel-header_panel').attr('data-qicon', 'fa-credit-card');
	jQuery('#accordion-panel-front_panel').attr('data-qicon', 'fa-desktop');  jQuery('#accordion-panel-footer_panel').attr('data-qicon', 'fa-copyright');
	jQuery('#accordion-panel-singlepages_panel').attr('data-qicon', 'fa-indent');  jQuery('#accordion-panel-misc_panel').attr('data-qicon', 'fa-cogs');
	jQuery('#accordion-panel-nav_menus').attr('data-qicon', 'fa-bars');  jQuery('#accordion-panel-widgets').attr('data-qicon', 'fa-codepen');
	jQuery('#accordion-panel-help_panel').attr('data-qicon', 'fa-life-saver');
	
	//INITIATE QUCIKIES
	jQuery('li.control-panel').each(function(index, element) {
        var rawtitle = jQuery(this).find('h3.accordion-section-title').contents().get(0).nodeValue;
		var quickieidraw = jQuery(this).attr('id');
		var quickieid = quickieidraw.replace("accordion-panel-", "");
		if(jQuery(this).attr('data-qicon')){   var qicon = jQuery(this).attr('data-qicon');  }else{  var qicon ='fa-cog';  }
		jQuery('.quickie').append('<i class="fa '+qicon+' quickie_'+quickieid+'"><dl>'+rawtitle+ '</dl></i>');
		
		jQuery('.quickie_'+quickieid).click(function(){  
			jQuery('.quickie i, .quickie_text dl').removeClass('activeq'); jQuery(this).addClass('activeq'); wp.customize.panel( quickieid ).focus(); 	
			jQuery('.wp-full-overlay').removeClass('quickiehover subsection-open'); 
		});
		
		jQuery('#'+quickieidraw).find('h3').click(function(){ 
			jQuery('.quickie i, .quickie_text dl').removeClass('activeq'); jQuery('.quickie_'+quickieid).addClass('activeq');
		});
		
    });
	

		jQuery('.quickie i, .quickie_text dl').click(function(){ 
			wp.customize.section.each( function ( section ) {section.collapse();}); 
		});
		
		jQuery('.accordion-section.control-subsection h3').on('click',function() {
			if(jQuery('.wp-full-overlay').find('.accordion-section.control-subsection.open').length != 0){
				jQuery( '.wp-full-overlay').removeClass('subsection-open').addClass('subsection-open');
			}else{
				jQuery( '.wp-full-overlay').removeClass('subsection-open');
			}
		});
		

		//before WORDPRESS 4.3 Menus Section
		if(jQuery('#customize-theme-controls #accordion-section-nav').length){
			jQuery('#accordion-section-nav').attr('data-qicon', 'fa-bars'); 
			jQuery('#accordion-section-nav').each(function(index, element) {
				var rawtitle = jQuery(this).find('h3.accordion-section-title').contents().get(0).nodeValue;
				var quickieidraw = jQuery(this).attr('id');
				var quickieid = quickieidraw.replace("accordion-section-", "");
				var qicon = jQuery(this).attr('data-qicon');
				jQuery('.quickie_misc_panel').after('<i class="fa '+qicon+' quickie_'+quickieid+'"><dl>'+rawtitle+ '</dl></i>');
				
				jQuery('.quickie_'+quickieid).click(function(){  
					jQuery('.quickie i, .quickie_text dl').removeClass('activeq'); jQuery(this).addClass('activeq'); wp.customize.section( quickieid ).focus(); 
					jQuery('.wp-full-overlay').removeClass('quickiehover subsection-open'); 
				});
				
				jQuery('#'+quickieidraw).find('h3').click(function(){ 
					jQuery('.quickie i, .quickie_text dl').removeClass('activeq'); jQuery('.quickie_'+quickieid).addClass('activeq');
				});
				
			});
		}
		//Hide Customizer Navigation control icon if the navigation control itself is not present
		if(!jQuery('#customize-theme-controls #accordion-section-nav').length){
			jQuery('.quickie_nav').hide();
		}
		
		/*MINI Controls*/
		jQuery('.mini_control').each(function(index, element) {
            jQuery(this).closest('li.customize-control').addClass('has_mini_control');
        });
		
		/*FONT CONTROL NAMES*/
		jQuery('#customize-control-logo_font_family').before('<h4 class="font_controlheader">'+objectL10n.sitettfont+'</h4>');
		jQuery('#customize-control-ptitle_font_family').before('<h4 class="font_controlheader no_border">'+objectL10n.menufont+'</h4>');
		jQuery('#customize-control-content_font_family').before('<h4 class="font_controlheader content_border">'+objectL10n.logofont+'</h4>');
		

		/*LOGO CONTROL TAB*/
		jQuery('#customize-control-logo_image_id, #customize-control-home_logo_id').hide('');
		jQuery('#customize-control-blogname, #customize-control-blogdescription, #accordion-section-headlogo_section .font_controlheader, #customize-control-logo_font_family, #customize-control-logo_font_subsets, #customize-control-logo_font_size, #customize-control-logo_color_id, #customize-control-tagline_font_size').addClass('activelogoption');
		
		jQuery('#customize-control-blogname').addClass('activelogoption').before('<ul class="logo_control_tabs"><li class="txtlogo activlogo"><a>Text</a></li><li class="imglogo"><a>'+objectL10n.image+'</a></li></ul>');
		
	jQuery('.logo_control_tabs li.txtlogo a').click(function(){ 
		jQuery('.logo_control_tabs li').removeClass('activlogo');	jQuery(this).parent().addClass('activlogo');
		jQuery('#customize-control-blogname, #customize-control-blogdescription, #accordion-section-headlogo_section .font_controlheader, #customize-control-logo_font_family, #customize-control-logo_font_subsets, #customize-control-logo_font_size, #customize-control-logo_color_id, #customize-control-tagline_font_size').addClass('activelogoption').show();
		jQuery('#customize-control-logo_image_id, #customize-control-home_logo_id').removeClass('activelogoption');
	});
	
	jQuery('.logo_control_tabs li.imglogo a').click(function(){ 
		jQuery('.logo_control_tabs li').removeClass('activlogo');	jQuery(this).parent().addClass('activlogo');
		jQuery('#customize-control-logo_image_id, #customize-control-home_logo_id').addClass('activelogoption');
		jQuery('#customize-control-blogname, #customize-control-blogdescription, #accordion-section-headlogo_section .font_controlheader, #customize-control-logo_font_family, #customize-control-logo_font_subsets, #customize-control-logo_font_size, #customize-control-logo_color_id, #customize-control-tagline_font_size').removeClass('activelogoption').hide();
	});
		

		//CTA Buttons
		jQuery('#customize-control-static_cta1_text').before('<h4 class="control_cta1_title">'+objectL10n.button1+'</h4>');
		jQuery('#customize-control-static_cta2_text').before('<h4 class="control_cta2_title">'+objectL10n.button2+'</h4>');
	
		var cta1controls = jQuery('#customize-control-static_cta1_text, #customize-control-static_cta1_link, #customize-control-static_cta1_txt_style, #customize-control-static_cta1_bg_color, #customize-control-static_cta1_txt_color');
		var cta2controls = jQuery('#customize-control-static_cta2_text, #customize-control-static_cta2_link, #customize-control-static_cta2_txt_style, #customize-control-static_cta2_bg_color, #customize-control-static_cta2_txt_color');
		
		cta1controls.addClass('hidectas');
		jQuery('.control_cta1_title').toggle(function() {    cta1controls.removeClass('hidectas').addClass('showctas');   },function(){    cta1controls.addClass('hidectas').removeClass('showctas');   });
		cta2controls.addClass('hidectas');
		jQuery('.control_cta2_title').toggle(function() {    cta2controls.removeClass('hidectas').addClass('showctas');   },function(){    cta2controls.addClass('hidectas').removeClass('showctas');   });
		
		/*SLIDER CONTROL TAB*/
		jQuery('#customize-control-static_image_id, #customize-control-static_gallery, #customize-control-static_video_id, #customize-control-slide_ytbid, #customize-control-static_vid_loop, #customize-control-static_vid_mute').hide('');
		
		jQuery('#customize-control-static_image_id').addClass('activebgoption').before('<ul class="slider_control_tabs"><li class="imgbg activbg"><a>'+objectL10n.image+'</a></li><li class="slideshowbg"><a>'+objectL10n.slideshow+'</a></li><li class="vdobg"><a>'+objectL10n.video+'</a></li></ul>');
		
	jQuery('.slider_control_tabs li.imgbg a').click(function(){ 
		jQuery('.slider_control_tabs li').removeClass('activbg');	jQuery(this).parent().addClass('activbg');
		jQuery('#customize-control-static_gallery, #customize-control-static_slide_timer, #customize-control-static_video_id, #customize-control-slide_ytbid, #customize-control-static_vid_loop, #customize-control-static_vid_mute').removeClass('activebgoption');
		jQuery('#customize-control-static_image_id').addClass('activebgoption');
	});
	
	jQuery('.slider_control_tabs li.slideshowbg a').click(function(){ 
		jQuery('.slider_control_tabs li').removeClass('activbg');	jQuery(this).parent().addClass('activbg');
		jQuery('#customize-control-static_image_id').attr('style', '').hide();
		jQuery('#customize-control-static_image_id, #customize-control-static_slide_timer, #customize-control-static_video_id, #customize-control-slide_ytbid, #customize-control-static_vid_loop, #customize-control-static_vid_mute').removeClass('activebgoption');
		jQuery('#customize-control-static_gallery, #customize-control-static_slide_timer').addClass('activebgoption');
	});
	
	jQuery('.slider_control_tabs li.vdobg a').click(function(){ 
		jQuery('.slider_control_tabs li').removeClass('activbg');	jQuery(this).parent().addClass('activbg');
		jQuery('#customize-control-static_image_id').attr('style', '').hide();
		jQuery('#customize-control-static_gallery, #customize-control-static_image_id, #customize-control-static_slide_timer').removeClass('activebgoption');
		jQuery('#customize-control-static_video_id, #customize-control-slide_ytbid, #customize-control-static_vid_loop, #customize-control-static_vid_mute').addClass('activebgoption');
	});

	//Slider Dropdown Select
	var staticontrols = jQuery('.slider_control_tabs, #customize-control-static_image_id, #customize-control-static_img_text_id, #customize-control-slider_txt_color, .control_cta1_title, .control_cta2_title, #customize-control-static_textbox_width, #customize-control-static_textbox_bottom');
	
	var staticontrols2 = jQuery('#customize-control-static_gallery, #customize-control-static_slide_timer, #customize-control-static_video_id, #customize-control-slide_ytbid, #customize-control-static_vid_loop, #customize-control-static_vid_mute,li#customize-control-static_cta1_text, li#customize-control-static_cta1_link, li#customize-control-static_cta1_txt_style, li#customize-control-static_cta1_bg_color, li#customize-control-static_cta1_txt_color, li#customize-control-static_cta2_text, li#customize-control-static_cta2_link, li#customize-control-static_cta2_txt_style,li#customize-control-static_cta2_bg_color, li#customize-control-static_cta2_txt_color');
	
	var nivoaccordion = jQuery('#customize-control-nivo_accord_slider, #customize-control-slider_txt_hide, #customize-control-slidefont_size_id, #customize-control-n_slide_time_id, #customize-control-slide_height');
	
	var currentslider = jQuery('#customize-control-slider_type_id select option:selected').val();
	
	if(currentslider == 'accordion' || currentslider == 'nivo' || currentslider == 'noslider'){  
		staticontrols.addClass('hideslider'); staticontrols2.addClass('hideslider'); 
		jQuery('#customize-control-static_image_id').addClass('hidestatimgc'); 
	}
	
	if(currentslider == 'static' || currentslider == 'noslider'){  nivoaccordion.addClass('hideslider');  }
	
	if(currentslider == 'noslider'){  jQuery('#customize-control-slider_content_align').addClass('hideslider');}
	
	
	if(currentslider == 'accordion' || currentslider == 'nivo' || currentslider == 'static'){  	jQuery('#customize-control-slider_content_align').removeClass('hideslider');   }
	if(currentslider == 'accordion' || currentslider == 'noslider'){  	jQuery('#customize-control-n_slide_time_id, #customize-control-slider_height').addClass('hideslider');   }
	if(currentslider == 'nivo' || currentslider == 'static'){ 	 jQuery('#customize-control-slider_height').removeClass('hideslider');    }
	

		
	jQuery('#customize-control-slider_type_id select').on('change', function(){ 
		if(jQuery(this).find('option:selected').val() == 'static'){
			jQuery('#customize-control-static_image_id').removeClass('hideslider hidestatimgc');
			nivoaccordion.addClass('hideslider');
			staticontrols.removeClass('hideslider');
			jQuery('#customize-control-slider_content_align').removeClass('hideslider');
		}
		if(jQuery(this).find('option:selected').val() == 'accordion' || jQuery(this).find('option:selected').val() == 'nivo'){
			jQuery('#customize-control-static_image_id').attr('style', 'display:none!important;');
			staticontrols.addClass('hideslider');
			staticontrols2.addClass('hideslider').removeClass('activebgoption');
			nivoaccordion.removeClass('hideslider');
			jQuery('#customize-control-slider_content_align').removeClass('hideslider');
			jQuery('#customize-control-slider_height').addClass('hideslider');
		}
		
		if(jQuery(this).find('option:selected').val() == 'static' || jQuery(this).find('option:selected').val() == 'nivo'){
			jQuery('#customize-control-slider_height').removeClass('hideslider');
		}
		
		if(jQuery(this).find('option:selected').val() == 'accordion'){
			jQuery('#customize-control-n_slide_time_id').addClass('hideslider');
		}
		
		if(jQuery(this).find('option:selected').val() == 'noslider'){
			jQuery('#customize-control-static_image_id').attr('style', 'display:none!important;')
			nivoaccordion.addClass('hideslider');
			staticontrols.addClass('hideslider');
			staticontrols2.addClass('hideslider');
			jQuery('#customize-control-slider_content_align, #customize-control-slider_height').addClass('hideslider');
		}
	});
	
	jQuery('.slider_control_tabs').prepend('<span class="stattitle">'+objectL10n.statictitle+'</span>');
	jQuery('#customize-control-nivo_accord_slider').prepend('<span class="nivotitle">'+objectL10n.nivotitle+'</span>');
	

	//Menu Background Color
	var logopos = jQuery('#customize-control-logo_position select option:selected').val();
	jQuery('#customize-control-menubar_color_id').addClass('hideslider');
	if(logopos == 'logo_center' || logopos == 'logo_center_left'){  jQuery('#customize-control-menubar_color_id').removeClass('hideslider');  }
	if(logopos == 'logo_left' || logopos == 'logo_right' || logopos == 'logo_middle'){  jQuery('#customize-control-menubar_color_id').addClass('hideslider');  }
	
	jQuery('#customize-control-logo_position select').on('change', function(){ 
		if(jQuery(this).find('option:selected').val() == 'logo_center' || jQuery(this).find('option:selected').val() == 'logo_center_left'){
			jQuery('#customize-control-menubar_color_id').removeClass('hideslider');
		}
		if(jQuery(this).find('option:selected').val() == 'logo_left' || jQuery(this).find('option:selected').val() == 'logo_right' || jQuery(this).find('option:selected').val() == 'logo_middle'){
			jQuery('#customize-control-menubar_color_id').addClass('hideslider');;
		}
	});
	



	//Refresh Icons beside Controls that are not postMessage
	jQuery( "span.customize-control-title:contains('*')" ).addClass('control-refresh');
	jQuery('.control-refresh').each(function(index, element) {
        jQuery(this).html(jQuery(this).html().replace(/\*/g, ''));
    });
	jQuery('.control-refresh').append('<i class="fa fa-refresh" />');


		/*WIDGET LIGHTING SYSTEM*/
/*		!function(t){t.fn.inlineStyle=function(n){var i,r=this.attr("style");return r&&r.split(";").forEach(function(r){var e=r.split(":");t.trim(e[0])===n&&(i=e[1])}),i}}(jQuery);
		//Add the Lights
		jQuery('li.control-section-sidebar').each(function(index, element) {
			jQuery(this).find('.accordion-section-title').append('<span class="widget_light"><i class="fa fa-circle" /></span>');
		});
		//Turn on the Lights based on sidebar availability
		wp.customize.previewer.bind( 'sidebars-loaded', function(){
			jQuery('li.control-section-sidebar').removeClass('lighton');
			jQuery('li.control-section-sidebar').each(function(index, element) {
					if(jQuery(this).inlineStyle("display") ==' block'){
						jQuery(this).addClass('lighton flashlight');
						setTimeout(function () {  jQuery('li.control-section-sidebar').removeClass('flashlight');  }, 400);
					}
			});
		} );*/
		
		//Add Widget Areas Title
		jQuery('#accordion-section-basic_sidebar_section').after('<h4 class="optimizer_available_widgets">'+objectL10n.widgetareas+'</h4>');
		
		//REPLACE DUMMY CONTENT BUTTON FUNCTIONALITY
		wp.customize.previewer.bind( 'focus-frontsidebar', function(){
			jQuery('.wp-full-overlay').addClass('subsection-open');
			wp.customize.section( 'sidebar-widgets-front_sidebar' ).focus();
			jQuery('html, body').animate({scrollTop: jQuery('#customize-control-sidebars_widgets-front_sidebar').offset().top-100}, 150);
			jQuery('#customize-control-sidebars_widgets-front_sidebar .add-new-widget').removeClass('flashaddbutton').addClass('flashaddbutton');
			setTimeout(function () {  jQuery('#customize-control-sidebars_widgets-front_sidebar .add-new-widget').removeClass('flashaddbutton');  }, 500);
		});
		
		//REPLACE DUMMY CONTENT BUTTON FUNCTIONALITY
		wp.customize.previewer.bind( 'focus-slider-control', function(){
			jQuery('.wp-full-overlay').addClass('subsection-open');
			wp.customize.section( 'slider_section' ).focus();
		});
		
		//Custom Sidebar - Update Button
		//jQuery('#customize-control-custom_sidebar input').after('<button type="button" class="button update-custom-sidebar"><i class="fa fa-circle-o-notch fa-spin" /> Update</button>');
		jQuery('.update-custom-sidebar').click(function() {
			jQuery('#save').trigger('click');
			jQuery(this).find('i').fadeIn(200);
            setTimeout(function () {   window.location = objectL10n.widgetfocusurl;  }, 2000)
        });


	//Customizer Loading Spinner
/*	wp.customize.preview.bind( 'unload', function () { 
		

	});	*/
/*	setTimeout(function(){		
		wp.customize.control( 'widget_optimizer_front_about[1]' ).focus(); //WORKS!		
	}, 3000);*/
	

	
	
	
	/*FRONTPAGE EDIT BUTTON*/				
	jQuery('.frontpage_edit_btn').click(function(){ 		
		jQuery('.quickie i, .quickie_text dl').removeClass('activeq'); jQuery('.quickie_widgets').addClass('activeq');		
		wp.customize.section( 'sidebar-widgets-front_sidebar' ).focus();		
	});		
	//Edit Widget Button For Other Pages
	wp.customize.previewer.bind( 'focus-current-sidebar', function(param){
			jQuery('.wp-full-overlay').addClass('subsection-open in-sub-panel section-open');

			//console.log('Add Button Clicked!');
			wp.customize.section( 'sidebar-widgets-'+param ).focus();
			wp.customize.control.each( function ( control ) {  if(control.expanded) control.collapse();  });
			jQuery('html, body').animate({scrollTop: jQuery('#customize-control-sidebars_widgets-front_sidebar').offset().top-100}, 150);
			jQuery('#customize-control-sidebars_widgets-'+param+' .add-new-widget').removeClass('flashaddbutton').addClass('flashaddbutton');
			
			setTimeout(function () {  jQuery('#customize-control-sidebars_widgets-'+param+' .add-new-widget').removeClass('flashaddbutton');  }, 500);
			jQuery('#customize-control-sidebars_widgets-'+param+' .add-new-widget').trigger('click');  
	} );
	
	
	//Widget Advanced Controls Toggle
	jQuery(document).on("click", ".widget_advanced.advanced_widget_toggle_off h4", function(e) {
			jQuery(this).parent().removeClass('advanced_widget_toggle_off').addClass('advanced_widget_toggle_on');
			jQuery(this).next('.widget_advanced_controls').slideDown(200);
	});

	jQuery(document).on("click", ".widget_advanced.advanced_widget_toggle_on h4", function(e) {
			jQuery(this).parent().removeClass('advanced_widget_toggle_on').addClass('advanced_widget_toggle_off');
			jQuery(this).next('.widget_advanced_controls').slideUp(200);
	 });
	 
	 
	//Custom Font Upload
	jQuery('#customize-control-custom_font_ttf input').after('<a class="fontuploadbtn" onclick="customFontUpload(this.id)" id="cfuttf"><i class="fa fa-upload"></i></a>');
	jQuery('#customize-control-custom_font_eot input').after('<a class="fontuploadbtn" onclick="customFontUpload(this.id)" id="cfueot"><i class="fa fa-upload"></i></a>');
	jQuery('#customize-control-custom_font_woff input').after('<a class="fontuploadbtn" onclick="customFontUpload(this.id)" id="cfuwoff"><i class="fa fa-upload"></i></a>');
	
	//fontstep1
	if(objectL10n.fontonmsg ==''){
	  jQuery('#customize-control-custom_font_ttf').before('<p><span class="customize-control-title">'+objectL10n.fontstep3+'</span>'+objectL10n.fontstep1+'</p>');
	  jQuery('#customize-control-custom_font_woff').after('<a class="font_activate"><i class="fa fa-circle-o-notch fa-spin" /> '+objectL10n.fontstep2+'</a>');
	}else{
	jQuery('#customize-control-custom_font_ttf').before('<p><span class="customize-control-title">'+objectL10n.fontstep5+'</span>'+objectL10n.fontonmsg+'</p>');
		jQuery('#customize-control-custom_font_woff').after('<a class="font_activate font_deactivate"><i class="fa fa-circle-o-notch fa-spin" /> '+objectL10n.fontstep4+'</a>');
	}
	
/*	if(jQuery('#customize-control-custom_font_ttf input').val() =='' && jQuery('#customize-control-custom_font_eot input').val() =='' && jQuery('#customize-control-custom_font_eot input').val() ==''){
		jQuery('#customize-control-custom_font_woff').after('<a class="font_activate"><i class="fa fa-circle-o-notch fa-spin" /> '+objectL10n.fontstep2+'</a>');
	}else{
		jQuery('#customize-control-custom_font_woff').after('<a class="font_activate font_deactivate"><i class="fa fa-circle-o-notch fa-spin" /> '+objectL10n.fontstep4+'</a>');
		}*/
	
	jQuery('.font_deactivate').click(function() {
		jQuery('#customize-control-custom_font_ttf input, #customize-control-custom_font_eot input, #customize-control-custom_font_woff input').val('').trigger('change');
	});
	jQuery('.font_activate').click(function() {
			setTimeout(function () {jQuery('#save').trigger('click');  }, 400)
			jQuery(this).find('i').fadeIn(200);
            setTimeout(function () {   window.location = objectL10n.customfontfocus;  }, 2600)
     });

});



/*CONVERSION PROCESS*/
jQuery(window).bind('load', function(){

		var isconverted = wp.customize.instance('optimizer[converted]').get();
		if(isconverted == ''){
			wp.customize.instance('optimizer[converted]').set('1');
			jQuery('.conversion_message').prependTo('body.wp-customizer').fadeIn();
		}
});


jQuery( document ).on('load ready', function() {

    /* === Checkbox Multiple Control === */

    jQuery( '.customize-control-multicheck input[type="checkbox"]' ).on(
        'change',
        function() {

            checkbox_values = jQuery( this ).parents( '.customize-control' ).find( 'input[type="checkbox"]:checked' ).map(
                function() {
                    return this.value;
                }
            ).get().join( ',' );

            jQuery( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
        }
    );
	/* === RADIO Image Control === */
	
    // Use buttonset() for radio images.
    jQuery( '.customize-control-radio-image .buttonset' ).buttonset();

    // Handles setting the new value in the customizer.
    jQuery( '.customize-control-radio-image input:radio' ).change(
        function() {

            // Get the name of the setting.
            var setting = jQuery( this ).attr( 'data-customize-setting-link' );

            // Get the value of the currently-checked radio input.
            var image = jQuery( this ).val();

            // Set the new value.
            wp.customize( setting, function( obj ) {

                obj.set( image );
            } );
        }
    );

} ); // jQuery( document ).on('load ready)


jQuery(document).ready(function($) {
	"use strict";

	$(".customize-control-toggle").on("click", ".Switch.On", function(e) {
		$(this).removeClass('On').addClass('Off');
	});
	$(".customize-control-toggle").on("click", ".Switch.Off", function(e) {
		$(this).removeClass('Off').addClass('On');
	});

});


jQuery(window).bind('load', function(){
	//Widgets List Modification
		jQuery('#available-widgets-list').prepend('<ul class="optimizer_widget_list"><li class="currnt_widgets"><a>'+objectL10n.optimwidgt+'</a></li><li><a>'+objectL10n.othrimwidgt+'</a></li></ul>');
		jQuery('.optimizer_widget_list li:eq(1)').click(function() {
			jQuery( '.optimizer_widget_list li').removeClass('currnt_widgets');
			jQuery( this ).addClass('currnt_widgets');
			jQuery( '#available-widgets').addClass('active-otherwidget');
		});
		
		jQuery('.optimizer_widget_list li:eq(0)').click(function() {
			jQuery( '.optimizer_widget_list li').removeClass('currnt_widgets');
			jQuery( this ).addClass('currnt_widgets');
			jQuery( '#available-widgets').removeClass('active-otherwidget');
		});
		
	//Social Link fields
	jQuery('#customize-control-facebook_field_id').prepend('<div class="social_fields_heading">'+objectL10n.socialinks+'</div>');
	
	//Replace the "Widget"
	jQuery('#available-widgets-list .widget-tpl').each(function() {
		jQuery(this).prepend('<i class="fa fa-info"></i>');
	});
	//Sort Widgets
	jQuery('#available-widgets-list .widget-tpl').attr('data-order','99');
	jQuery('#available-widgets-list [id^="widget-tpl-optimizer_front_about"]').attr('data-order','1').addClass('widget-tpl-odd');
	jQuery('#available-widgets-list [id^="widget-tpl-optimizer_front_text"]').attr('data-order','2').addClass('widget-tpl-even');
	jQuery('#available-widgets-list [id^="widget-tpl-optimizer_front_blocks"]').attr('data-order','3').addClass('widget-tpl-odd');
	jQuery('#available-widgets-list [id^="widget-tpl-optimizer_front_posts"]').attr('data-order','4').addClass('widget-tpl-even');
	jQuery('#available-widgets-list [id^="widget-tpl-optimizer_front_video"]').attr('data-order','5').addClass('widget-tpl-odd');
	jQuery('#available-widgets-list [id^="widget-tpl-optimizer_front_carousel"]').attr('data-order','6').addClass('widget-tpl-even');
	jQuery('#available-widgets-list [id^="widget-tpl-optimizer_front_slider"]').attr('data-order','7').addClass('widget-tpl-odd');
	jQuery('#available-widgets-list [id^="widget-tpl-optimizer_front_portfoio"]').attr('data-order','8').addClass('widget-tpl-even');
	jQuery('#available-widgets-list [id^="widget-tpl-optimizer_front_map"]').attr('data-order','9').addClass('widget-tpl-odd');
	jQuery('#available-widgets-list [id^="widget-tpl-optimizer_front_newsletter"]').attr('data-order','10').addClass('widget-tpl-even');
	jQuery('#available-widgets-list [id^="widget-tpl-optimizer_front_cta"]').attr('data-order','11').addClass('widget-tpl-odd');
	jQuery('#available-widgets-list [id^="widget-tpl-optimizer_front_testimonials"]').attr('data-order','12').addClass('widget-tpl-even');
	jQuery('#available-widgets-list [id^="widget-tpl-optimizer_front_clients"]').attr('data-order','13').addClass('widget-tpl-odd');
	jQuery('#available-widgets-list [id^="widget-tpl-ast_countdown_widget"]').attr('data-order','14').addClass('widget-tpl-even');
	jQuery('#available-widgets-list [id^="widget-tpl-ast_scoial_widget"]').attr('data-order','15').addClass('widget-tpl-odd');

	
	//Sort The widgets to Optimizer Widgets First
	jQuery('#available-widgets-list').find('.widget-tpl').sort(function (a, b) {
	   return jQuery(a).attr('data-order') - jQuery(b).attr('data-order');
	}).appendTo('#available-widgets-list');
	//Wrap All Optimizer Widgets to fix the description popup 
	jQuery('#available-widgets [id*="widget-tpl-optimizer_"], #available-widgets [id*="widget-tpl-ast_"], #available-widgets [id*="widget-tpl-thn_"]').wrapAll('<div class="the_optim_widgets"></div>');
	jQuery('#available-widgets-list > .widget-tpl').wrapAll('<div class="the_other_widgets"></div>');
	
	jQuery('#available-widgets-list .widget-tpl .fa-info').hoverIntent(function(){ 
		jQuery(this).parent().find('.widget-description').fadeIn(200);
	},function(){
		jQuery(this).parent().find('.widget-description').fadeOut(200);
	});
	
	//Widgets Library Close Button
	jQuery('#available-widgets-list').prepend('<a id="close_widget_library">✖</a>');
	//Close Widgets Library
	jQuery('#close_widget_library').on('click', function() {
			jQuery('.adding-widget .add-new-widget').trigger("click");
	});
	
	
	//WIDGET PRESETS-------------------------------------------------
	//Move the Widget Presets in the Widget Library
	jQuery('.widget_preset_right').appendTo('.the_optim_widgets');
	
	//Append The Preset buttons to widgets that have presets
	jQuery('#available-widgets-list [id^="widget-tpl-optimizer_front_text"], #available-widgets-list [id^="widget-tpl-optimizer_front_blocks"], #available-widgets-list [id^="widget-tpl-optimizer_front_posts"], #available-widgets-list [id^="widget-tpl-optimizer_front_video"] , #available-widgets-list [id^="widget-tpl-optimizer_front_map"], #available-widgets-list [id^="widget-tpl-optimizer_front_cta"], #available-widgets-list [id^="widget-tpl-optimizer_front_newsletter"]').each(function() {
		var title = jQuery(this).find('.widget-title h3').text();
		var widgetid = jQuery(this).attr('data-widget-id');
		var widgetid = widgetid.replace(/[0-9]/g, '');
		var widgetid = widgetid.replace("-", "");

		var position = jQuery(this).find('.widget-top').offset();
		
		jQuery(this).after('<div title="'+title+' Widget Presets" class="widget_preset_btn widget_preset_'+widgetid+'" id="trigger-'+widgetid+'" style="top:'+position.top+'px; bottom:'+position.bottom+'px; left:'+position.left+'px; right:'+position.right+'px;"></div>');

		//Display presets on button clicks
		jQuery('#trigger-'+widgetid).click(function() {
			jQuery('#available-widgets-list [id^="widget-tpl-"]').addClass('hide_widgets_fo_presets');
			jQuery('.widget_preset_right').fadeIn(400);
			jQuery('.widget_preset_right .preset_tabs, ul.optimizer_widget_list, .widget_preset_btn').hide();
			jQuery('.widget_preset_right').find('#tab_'+widgetid).fadeIn(400);
			jQuery('.preset_tabs img').trigger("unveil");
		});
		
		jQuery('.widget_preset_right .fa-angle-left').click(function() {
			jQuery('.widget_preset_right, .widget_preset_right .preset_tabs').fadeOut(400);
			jQuery('ul.optimizer_widget_list, .widget_preset_btn').show();
			jQuery('#available-widgets-list [id^="widget-tpl-"]').removeClass('hide_widgets_fo_presets');
		});
	
	});
	
	
});

/*GENERATE EXPORT*/
jQuery(document).ready(function($) {
	jQuery( '#generatexport' ).on( "click", function(e) {
		e.preventDefault();
		var value = jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data:{
				action: 'optimizer_get_options'
				}
			})
			 .fail(function(r,status,jqXHR) {
				 console.log('failed');
			 })
			 .done(function(result,status,jqXHR) {
				//console.log('success');
				//console.log(result);
				jQuery('#opt_current_options').html(result);
				  function SaveAsFile(t,f,m) {
						try {
							var b = new Blob([t],{type:m});
							saveAs(b, f);
						} catch (e) {
							window.open("data:"+m+"," + encodeURIComponent(t), '_blank','');
						}
					}
			
					SaveAsFile(result,"themeoptions.json","text/plain");
			 });
	});
	
	
	jQuery( '#widgetexport' ).on( "click", function(e) {
		e.preventDefault();
		var value = jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data:{
				action: 'optimizer_wie_send_export_file'
				}
			})
			 .fail(function(r,status,jqXHR) {
				 console.log('failed');
			 })
			 .done(function(result,status,jqXHR) {
				console.log('success');
				console.log(result);
				jQuery('#opt_current_widgets').html(result);
				  function SaveAsFile(t,f,m) {
						try {
							var b = new Blob([t],{type:m});
							saveAs(b, f);
						} catch (e) {
							window.open("data:"+m+"," + encodeURIComponent(t), '_blank','');
						}
					}
			
					SaveAsFile(result,"theme-widgets.wie","text/plain");
			 });
	});

//Refresh when Custom preset is imported
wp.customize.previewer.bind( 'refreshafterpreset', function() {
    //wp.customize.previewer.refresh();
	window.location.reload( true );
} );


//---------------------INLINE EDIT-------------------------------------------------
	//Get Updated tinyMce content
	wp.customize.previewer.bind( 'tinycontent', function(content) {
		//console.log('Triggered tinymce content Update...'+ content[0] + content[1] );
		var optionid = content[0];
		
		//Check If the optionid is of Widget's or Slider's and then focus that specific option and save the changes.
		if(optionid.match(/widget-/g) ){
			var widgetid = content[0];
			var widgetid = widgetid.replace("widget-", ""); var widgetid = widgetid.replace("-content", "");
			var widgetid = widgetid.replace("-block1content", ""); var widgetid = widgetid.replace("-block2content", ""); var widgetid = widgetid.replace("-block3content", ""); 
			var widgetid = widgetid.replace("-block4content", ""); var widgetid = widgetid.replace("-block5content", ""); var widgetid = widgetid.replace("-block6content", "");
			var widgetid = widgetid.replace("-", "[");
			//console.log('Expected: widget_optimizer_front_about[102] - '+widgetid );
			wp.customize.control( 'widget_'+widgetid+']' ).focus();
		}else{
			wp.customize.control( 'static_img_text_id' ).focus(); 
		}
		//SAVE THE CHANGES
		//console.log('Input Data: '+ content[0] + content[1] );
		jQuery('#'+optionid).val(content[1]).trigger('change');
		//setTimeout(function () {jQuery('#save').trigger('click');  }, 1200);

	} );
	
	function inline_editsave(customizeid, string){
		//Update the Widget Title 
		wp.customize.previewer.bind( customizeid, function(content) {
			var str = content[0]; var widgetid = str.replace("-", "[");
			wp.customize.control( 'widget_'+widgetid+']' ).focus();  /*FOCUS FIRST*/
			jQuery('#widget-'+str+string).val(content[1]).trigger('change'); /*THEN CHANGE VALUE*/
			setTimeout(function () {jQuery('#save').trigger('click');  }, 1200); /*THEN TRIGGER SAVE*/
			//console.log('id: '+content[0] + ' data: '+content[1]);
		});
	}

	inline_editsave('titledit', '-title');  /*Widget Title Saving*/
	inline_editsave('subtitledit', '-subtitle'); /*Widget Subtitle Saving*/
	
	/*Widget Subtitle Saving*/
	inline_editsave('blckttedit1', '-block1title');  inline_editsave('blckttedit2', '-block2title');  inline_editsave('blckttedit3', '-block3title');
	inline_editsave('blckttedit4', '-block4title');  inline_editsave('blckttedit5', '-block5title');  inline_editsave('blckttedit6', '-block6title'); 

	/*Countdown Content Edit*/
	inline_editsave('countdnedit', '-desc'); 
	/*Biography Content Edit*/
	inline_editsave('bioedit', '-bio'); inline_editsave('bionamedit', '-name'); inline_editsave('bioccuedit', '-occu'); 
	
	
	//Open up the FullScreen Editor
	wp.customize.previewer.bind( 'fulleditor', function(widgetid) {
		var str = widgetid;
		var widgetidm = str.replace("-", "[");
		wp.customize.control( 'widget_'+widgetidm+']' ).focus();
		
		jQuery('#widget-'+widgetid+'-content').next('a').trigger('click');
		jQuery('#widget-'+widgetid+'-content').next('a').trigger('onclick');
	});

	
});


/*OPTIMIZER THEME TOUR*/
jQuery( document ).on('load ready', function() {
	
	//Remove all the "Shift Click to Edit this Widget" message
	setTimeout(function () {  jQuery('.frontpage_sidebar .widget').attr('title','');  }, 3000);

	wp.customize.previewer.bind( 'start-tour', function(){
		if(!jQuery.cookie('optimizertour')){
			jQuery('#optimizerTour, .tour_backdrop').fadeIn();
		}
	});
	
	//Map APi Key Description
	jQuery('#customize-control-map_api input').before(objectL10n.getmapkey);
	
	//Append Previwe window inner shadow
	jQuery('#customize-preview').prepend('<div id="tour_innerglow"><span class="innerglow glow1"></span><span class="innerglow glow2"></span><span class="innerglow glow3"></span><span class="innerglow glow4"></span></div>');
	
	//Tour Function
	jQuery('.tournext').on('click', function() {
		if(jQuery(this).parent().next().is("li")){
			jQuery(this).parent().hide();
			jQuery(this).parent().next().show();
			var elmid = jQuery(this).parent().next().data('id');
			if(jQuery(this).parent().next().data('preview') == 'true'){}
			jQuery('.tourhighlight').removeClass('tourhighlight');
			jQuery("#customize-preview iframe").contents().find('.tourhighlight').removeClass('tourhighlight'); 
			jQuery('#'+elmid).addClass('tourhighlight');
			if(elmid == 'frontsidebar' || elmid == 'customizer_topbar'){ 
				//console.log('Preview True');
				jQuery("#customize-preview iframe").contents().find('#'+elmid).addClass('tourhighlight'); 
			}
		}
	} );
	
	jQuery('.tourprev').on('click', function() {
		if(jQuery(this).parent().prev().is("li")){
			jQuery(this).parent().hide();
			jQuery(this).parent().prev().show();
			var elmid = jQuery(this).parent().prev().data('id');
			jQuery('.tourhighlight').removeClass('tourhighlight');
			jQuery("#customize-preview iframe").contents().find('.tourhighlight').removeClass('tourhighlight'); 
			jQuery('#'+elmid).addClass('tourhighlight');
			if(elmid == 'frontsidebar' || elmid == 'customizer_topbar'){ 
				console.log('Preview True');
				jQuery("#customize-preview iframe").contents().find('#'+elmid).addClass('tourhighlight'); 
			}
		}
	} );

	jQuery('.tourend, .tourclose').on('click', function() {
		jQuery('#optimizerTour, .tour_backdrop').fadeOut();
		jQuery.cookie('optimizertour', 1, { expires: 365, path: '/'});
	} );
	
	jQuery('#tour_btn').on('click', function() {
		jQuery('#optimizerTour, .tour_backdrop').fadeIn();
		jQuery('.tourclose').show();
		jQuery('#optimizerTour>li').hide();
		jQuery('#optimizerTour li:eq(0)').show();
		jQuery('#optimizer_settings').animate({"left":"-831px"});
		jQuery('.opactive').removeClass('opactive');
		wp.customize.panel.each( function ( panel ) {
			panel.collapse();
		});
	} );
	
} );


jQuery(document).ready(function() {
	
	//Tutorial Video
	jQuery('#customize-control-help-tuts .description').click(function() {
		jQuery('.basic_guide, .guide_backdrop').removeClass('vid_maximize vid_minimize vid_minimized').fadeIn();
	});	
	
	//Video Guides
	jQuery('#customize-control-help-createbus .description').click(function() {
		jQuery('.business_guide, .guide_backdrop').removeClass('vid_maximize vid_minimize vid_minimized').fadeIn();
	});	
	
	//Faq Tabs
	jQuery('.faq_tab_controls h3').click(function() {
		jQuery('.faq_tab_controls h3, .faq_tabs').removeClass('faq_active faq_tab_active'); jQuery(this).addClass('faq_active');  jQuery('.'+jQuery(this).attr('data-tab')).addClass('faq_tab_active');
	});
	
	jQuery('#customize-control-help-faq .description a').click(function() {	jQuery('#faq_tab, .guide_backdrop').fadeIn(); });
	jQuery('.faq_title_bar i').click(function() {	jQuery('#faq_tab, .guide_backdrop').fadeOut(); });
	
});


jQuery(window).bind('load', function(){
	/*PRESETS TABS*/
	jQuery('.widget_preset_left ul li a').on('click',function(event) {
		event.preventDefault();
		jQuery(this).parent().siblings().removeClass("active_presw");
		jQuery(this).parent().addClass("active_presw");
		var parenttab = jQuery(this).attr("href");
		jQuery(".preset_tabs").css({"display":"none"});
		jQuery(parenttab).fadeIn();
		jQuery(".preset_tabs img").unveil();
	});
	
		//Display presets on button clicks
		jQuery('.optim_presets').on('click',function() {
			jQuery('.preset_p img').trigger("unveil");
		});
	
	jQuery(".preset_tabs img, .preset_p img").unveil();
});	

//DUPLICATE WIDGETS
	jQuery( document ).on( 'load widget-added', function(event, widget) {
		
		//Append The duplicate button
		jQuery('.widget-control-actions').each(function(index, element) {
				if(jQuery(this).find('.optimizer_duplicate_widget').length == 0){
					jQuery(this).find('.widget-control-close').before('<a class="optimizer_duplicate_widget">Duplicate</a>');
				}
		});
	});	

	
	jQuery( document ).on('load ready', function() {

				//Duplicate Function
				jQuery(document).on('click','.optimizer_duplicate_widget', function(event) {
					rawsidebarid = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().attr('id');
					rawidgetid = jQuery(this).parent().parent().parent().parent().parent().parent().attr('id');
		
					dsidebarid = rawsidebarid.split('accordion-section-sidebar-widgets-')[1];
					dwidgetid = rawidgetid.split('customize-control-widget_')[1];
		
					//console.log(dsidebarid); console.log(dwidgetid);
					srcWidgetId = ''+dwidgetid+'';
					matches = srcWidgetId.match( /(.+)-(\d+)/ );
					sourceWidgetSettingId = 'widget_' + matches[1] + '[' + matches[2] + ']';
					idBase = matches[1];
					sidebarControl = wp.customize.control('sidebars_widgets['+dsidebarid+']');
					destWidgetControl = sidebarControl.addWidget( idBase );
					destWidgetControl.setting.set( wp.customize( sourceWidgetSettingId ).get( sourceWidgetSettingId ) );
					wp.customize.control.each( function ( control ) {  if(control.expanded) control.collapse();  });
					destWidgetControl.focus();
				});
	
	});
	

jQuery(window).bind('load', function(){	
setTimeout(function(){
	/*YOUTUBE VIDEOES*/
	var tag = document.createElement('script');
	tag.src = "https://www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}, 4000);
});
	//Load 
	var player;
	var tutsplayer;
	
	function onYouTubeIframeAPIReady() {
		player = new YT.Player('business_video', {
			width: '',
			height: '',
			videoId: 'oMPwT2vEqx0',
			playerVars :{color: 'white', 'showinfo': 0, 'playlist':'oMPwT2vEqx0'},
			events: {
				onReady: guide_initialize
			}
		});
		
		tutsplayer = new YT.Player('tuts_video', {
			width: '',
			height: '',
			videoId: 'ziuDRK62Hr8',
			playerVars :{color: 'white', 'showinfo': 0, 'playlist':'ziuDRK62Hr8'},
			events: {
				onReady: tuts_initialize
			}
		});
		
	}


	
/**
 * jQuery Unveil
 * A very lightweight jQuery plugin to lazy load images
 * http://luis-almeida.github.com/unveil
 *
 * Licensed under the MIT license.
 * Copyright 2013 Luís Almeida
 * https://github.com/luis-almeida
 */

(function(e){e.fn.unveil=function(t,n){function f(){var t=u.filter(function(){var t=e(this);if(t.is(":hidden"))return;var n=r.scrollTop(),s=n+r.height(),o=t.offset().top,u=o+t.height();return u>=n-i&&o<=s+i});a=t.trigger("unveil");u=u.not(a)}var r=e(window),i=t||0,s=window.devicePixelRatio>1,o=s?"data-src-retina":"data-src",u=this,a;this.one("unveil",function(){var e=this.getAttribute(o);e=e||this.getAttribute("data-src");if(e){this.setAttribute("src",e);if(typeof n==="function")n.call(this)}});r.on("scroll.unveil resize.unveil lookup.unveil",f);f();return this}})(window.jQuery||window.Zepto);

/*! 
 * FileSaver.js
 * https://github.com/eligrey/FileSaver.js/
 * Released under the MIT license
 */
var saveAs=saveAs||function(e){"use strict";if("undefined"==typeof navigator||!/MSIE [1-9]\./.test(navigator.userAgent)){var t=e.document,n=function(){return e.URL||e.webkitURL||e},o=t.createElementNS("http://www.w3.org/1999/xhtml","a"),r="download"in o,i=function(n){var o=t.createEvent("MouseEvents");o.initMouseEvent("click",!0,!1,e,0,0,0,0,0,!1,!1,!1,!1,0,null),n.dispatchEvent(o)},a=e.webkitRequestFileSystem,c=e.requestFileSystem||a||e.mozRequestFileSystem,u=function(t){(e.setImmediate||e.setTimeout)(function(){throw t},0)},f="application/octet-stream",s=0,d=500,l=function(t){var o=function(){"string"==typeof t?n().revokeObjectURL(t):t.remove()};e.chrome?o():setTimeout(o,d)},v=function(e,t,n){t=[].concat(t);for(var o=t.length;o--;){var r=e["on"+t[o]];if("function"==typeof r)try{r.call(e,n||e)}catch(i){u(i)}}},p=function(e){return/^\s*(?:text\/\S*|application\/xml|\S*\/\S*\+xml)\s*;.*charset\s*=\s*utf-8/i.test(e.type)?new Blob(["\ufeff",e],{type:e.type}):e},w=function(t,u){t=p(t);var d,w,y,m=this,S=t.type,h=!1,O=function(){v(m,"writestart progress write writeend".split(" "))},E=function(){if((h||!d)&&(d=n().createObjectURL(t)),w)w.location.href=d;else{var o=e.open(d,"_blank");void 0==o&&"undefined"!=typeof safari&&(e.location.href=d)}m.readyState=m.DONE,O(),l(d)},R=function(e){return function(){return m.readyState!==m.DONE?e.apply(this,arguments):void 0}},b={create:!0,exclusive:!1};return m.readyState=m.INIT,u||(u="download"),r?(d=n().createObjectURL(t),o.href=d,o.download=u,i(o),m.readyState=m.DONE,O(),void l(d)):(e.chrome&&S&&S!==f&&(y=t.slice||t.webkitSlice,t=y.call(t,0,t.size,f),h=!0),a&&"download"!==u&&(u+=".download"),(S===f||a)&&(w=e),c?(s+=t.size,void c(e.TEMPORARY,s,R(function(e){e.root.getDirectory("saved",b,R(function(e){var n=function(){e.getFile(u,b,R(function(e){e.createWriter(R(function(n){n.onwriteend=function(t){w.location.href=e.toURL(),m.readyState=m.DONE,v(m,"writeend",t),l(e)},n.onerror=function(){var e=n.error;e.code!==e.ABORT_ERR&&E()},"writestart progress write abort".split(" ").forEach(function(e){n["on"+e]=m["on"+e]}),n.write(t),m.abort=function(){n.abort(),m.readyState=m.DONE},m.readyState=m.WRITING}),E)}),E)};e.getFile(u,{create:!1},R(function(e){e.remove(),n()}),R(function(e){e.code===e.NOT_FOUND_ERR?n():E()}))}),E)}),E)):void E())},y=w.prototype,m=function(e,t){return new w(e,t)};return"undefined"!=typeof navigator&&navigator.msSaveOrOpenBlob?function(e,t){return navigator.msSaveOrOpenBlob(p(e),t)}:(y.abort=function(){var e=this;e.readyState=e.DONE,v(e,"abort")},y.readyState=y.INIT=0,y.WRITING=1,y.DONE=2,y.error=y.onwritestart=y.onprogress=y.onwrite=y.onabort=y.onerror=y.onwriteend=null,m)}}("undefined"!=typeof self&&self||"undefined"!=typeof window&&window||this.content);"undefined"!=typeof module&&module.exports?module.exports.saveAs=saveAs:"undefined"!=typeof define&&null!==define&&null!=define.amd&&define([],function(){return saveAs});

/*!
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2006, 2014 Klaus Hartl
 * Released under the MIT license
 */
!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?module.exports=e(require("jquery")):e(jQuery)}(function(e){function n(e){return u.raw?e:encodeURIComponent(e)}function o(e){return u.raw?e:decodeURIComponent(e)}function i(e){return n(u.json?JSON.stringify(e):String(e))}function t(e){0===e.indexOf('"')&&(e=e.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\"));try{return e=decodeURIComponent(e.replace(c," ")),u.json?JSON.parse(e):e}catch(n){}}function r(n,o){var i=u.raw?n:t(n);return e.isFunction(o)?o(i):i}var c=/\+/g,u=e.cookie=function(t,c,s){if(arguments.length>1&&!e.isFunction(c)){if(s=e.extend({},u.defaults,s),"number"==typeof s.expires){var a=s.expires,d=s.expires=new Date;d.setMilliseconds(d.getMilliseconds()+864e5*a)}return document.cookie=[n(t),"=",i(c),s.expires?"; expires="+s.expires.toUTCString():"",s.path?"; path="+s.path:"",s.domain?"; domain="+s.domain:"",s.secure?"; secure":""].join("")}for(var f=t?void 0:{},p=document.cookie?document.cookie.split("; "):[],l=0,m=p.length;m>l;l++){var x=p[l].split("="),g=o(x.shift()),j=x.join("=");if(t===g){f=r(j,c);break}t||void 0===(j=r(j))||(f[g]=j)}return f};u.defaults={},e.removeCookie=function(n,o){return e.cookie(n,"",e.extend({},o,{expires:-1})),!e.cookie(n)}});
