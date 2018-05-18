// Widgetize Page with Sidebar Selection
jQuery(document).ready(function($) {
    jQuery("#optimizer_widgetize_form").click(function() {
		jQuery('#choose_custom_sidebar').slideUp(300);
        //console.log('Button clicked.');
		nonce = jQuery("input#optimizer_pagemeta_nonce").val();
		
		var pagesidebar = jQuery('#optimizer_widgetize_sidebar').val();
		var pagesidebarpos = jQuery('.page_sidebar_position input:radio:checked').val();
        jQuery.post(
            params.ajaxURL, {
                'action': 'optimizer_widgetize_page',
                'nonce' : nonce,
				'postid': jQuery('#optimizer_widgetize_pageid').val(),
				'pagesidebar': pagesidebar,
            },
            function(response) {
				console.log('Page Meta Updated!');
				jQuery( "#optimizer_widgetize_redirect" ).trigger( "click" );
            }
        );
    });
});