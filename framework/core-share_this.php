<?php 
/**
 * The SHARE THIS Function for LayerFramework
 *
 * Displays The social share icons on single posts page.
 *
 * @package LayerFramework
 * 
 * @since  LayerFramework 1.0
 */
global $optimizer;?>

<div class="share_this social_<?php echo $optimizer['share_button_style']; ?>"> 
   <div class="social_buttons">
            
    <span class="share_label"><?php echo $optimizer['share_label']; ?></span>

                <div class="lgn_fb">
                        <a target="_blank" href="https://facebook.com/share.php?u=<?php the_permalink() ?>&amp;amp;t=<?php echo urlencode(the_title('','', false)); ?>" title="<?php _e('Share this on Facebook', 'optimizer');?>"><i class="fa-facebook"></i></a>
                </div>

                <div class="lgn_twt">
                    <a target="_blank" href="https://twitter.com/home?status=Reading:%20<?php $escapett = get_the_title(); $twtt = rawurlencode($escapett); echo $twtt;?>%20<?php the_permalink();?>" title="<?php _e('Tweet This', 'optimizer'); ?>"><i class="fa-twitter"></i></a>
                </div>

				<div class="lgn_gplus">
                    <a target="_blank" title="<?php _e('Plus One This', 'optimizer'); ?>" href="https://plusone.google.com/_/+1/confirm?hl=en&amp;url=<?php echo the_permalink(); ?>"><i class="fa-google-plus"></i></a>
                </div>

                <div class="lgn_pin">
                    <a target="_blank" title="<?php _e('Pin This', 'optimizer'); ?>" href='javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;https://assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());'><i class="fa-pinterest"></i></a>
                </div>

                <div class="lgn_linkedin">
                    <a target="_blank" title="<?php _e('Share this on Linkedin', 'optimizer');?>" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>&title=<?php echo urlencode(the_title('','', false)) ?>"><i class="fa-linkedin"></i></a>
                </div>

                <div class="lgn_stmbl">
                     <a target="_blank" title="<?php _e('Stumble This', 'optimizer'); ?>" href="https://www.stumbleupon.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php echo urlencode(the_title('','', false)) ?>"><i class="fa fa-stumbleupon"></i></a>
                </div>

                <div class="lgn_digg">
                    <a target="_blank" href="https://digg.com/submit?phase=2&amp;amp;url=<?php the_permalink() ?>&amp;amp;title=<?php echo urlencode(the_title('','', false)) ?>" title="<?php _e('Digg This', 'optimizer'); ?>"><i class="fa fa-digg"></i></a>
                </div>

                <div class="lgn_email">
                    <a target="_blank" onclick="window.location.href='mailto:?subject='+document.title+'&body='+escape(window.location.href);" title="<?php _e('Email This', 'optimizer'); ?>"><i class="fa fa-envelope-o"></i></a>
                </div> 

                <div class="lgn_print">
                    <a target="_blank" onclick="window.print();" title="<?php _e('Print This Page', 'optimizer'); ?>"><i class="fa fa-print"></i></a>
                </div>    
                
                <?php do_action('optimizer_after_share_buttons'); ?>

  </div>           
</div>