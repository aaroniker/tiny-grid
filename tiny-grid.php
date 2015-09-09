<?php

/*
Plugin Name: Tiny Grid
Plugin URI: http://aaroniker.me
Description: Adds buttons to the TinyMCE Editor to use the bootstrap grid system
Version: 0.2
Author: Aaron Iker
Author URI: http://www.aaroniker.me
License: GPL2
*/

if (!defined('WPINC'))
	die();

if(!class_exists('Tiny_Grid'))
{
    class Tiny_Grid
    {
		
        public function __construct()
        {
			
        }
		
        public static function activate()
        {
			
        }
    
        public static function deactivate()
        {

        }
		
    }
}

function tiny_grid_scripts()
{
	wp_enqueue_style('feather-css', plugins_url('css/feather.css', __FILE__), false, '');
}

add_action('admin_enqueue_scripts', 'tiny_grid_scripts');

function tiny_grid_mce($mce_css)
{
	if (!empty($mce_css))
		$mce_css .= ',';

	$mce_css .= plugins_url('css/bootstrap-grid.css', __FILE__);

	return $mce_css;
}

add_filter('mce_css', 'tiny_grid_mce');

function tiny_grid_editor()
{
	add_editor_style(plugins_url( 'css/style.css', __FILE__ ));
}

add_action('admin_init', 'tiny_grid_editor');

function tiny_grid_buttons()
{
     if(current_user_can('edit_posts' ) && current_user_can('edit_pages')) {
          add_filter('mce_buttons', 'tiny_grid_buttons_register');
          add_filter('mce_external_plugins', 'tiny_grid_buttons_add');
     }
}

add_action('admin_init', 'tiny_grid_buttons');

function tiny_grid_buttons_register($buttons)
{
     array_push($buttons, "2grid", "3grid", "visualblocks");
     return $buttons;
}

function tiny_grid_buttons_add($plugin_array)
{
    $plugin_array['tiny_grid_button_script'] = plugins_url( 'js/buttons.js', __FILE__ ) ;
	$plugin_array['visualblocks'] = plugins_url('js/visualblocks.js', __FILE__);
    
	return $plugin_array;
}

function tiny_grid_admin_head()
{
    $plugin_url = plugins_url( '/', __FILE__ );
    
	echo '
		<script>
			var tinyGrid = {
				"url": "'.$plugin_url.'",
			};
		</script>
    ';
}

foreach(array('post.php','post-new.php') as $hook)
     add_action("admin_head-$hook", 'tiny_grid_admin_head');

if(class_exists('Tiny_Grid')) {
	register_activation_hook(__FILE__, array('Tiny_Grid', 'activate'));
    register_deactivation_hook(__FILE__, array('Tiny_Grid', 'deactivate'));

    $tiny_grid = new Tiny_Grid();	
}

?>