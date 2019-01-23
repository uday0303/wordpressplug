<?php
/**
* Plugin Name: simpleslider
* Plugin URI: https://www.yourwebsiteurl.com/
* Description: This is the very first plugin I ever created.
* Version: 1.0
* Author: uday
* Author URI: http://yourwebsiteurl.com/
**/
if(! defined('ABSPATH')){
  die;
}
/*Some Set-up*/
define('EFS_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('EFS_NAME', "simpleslider");
define ("EFS_VERSION", "0.5");
/*Files to Include*/
require_once('sliderimage.php');


/*Add the Javascript/CSS Files!*/
wp_enqueue_script('main', EFS_PATH.'main.js', array('jquery'));
wp_enqueue_style('style', EFS_PATH.'style.css');


/*Add the Hooks to place the javascript in the header*/

function efs_script(){

print '<script type="text/javascript" charset="utf-8">
  jQuery(window).load(function() {
    jQuery(\'.simpleslider\').simpleslider();
  });
</script>';

}

add_action('wp_head', 'efs_script');

function efs_get_slider(){

	$slider= '<div class="simpleslider">
	  <ul class="slides">';

	$efs_query= "post_type=slider-image";
	query_posts($efs_query);


	if (have_posts()) : while (have_posts()) : the_post();
		$img= get_the_post_thumbnail( $post->ID, 'large' );

		$slider.='<li>'.$img.'</li>';

	endwhile; endif; wp_reset_query();


	$slider.= '</ul>
	</div>';

	return $slider;
}


/**add the shortcode for the slider- for use in editor**/

function efs_insert_slider($atts, $content=null){

$slider= efs_get_slider();

return $slider;

}


add_shortcode('ef_slider', 'efs_insert_slider');



/**add template tag- for use in themes**/

function efs_slider(){

	print efs_get_slider();
}

?>
