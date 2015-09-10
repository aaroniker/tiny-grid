<?php

/*
Plugin Name: Tiny Grid
Plugin URI: http://aaroniker.me
Description: Adds buttons to the TinyMCE Editor to use the bootstrap grid system
Version: 0.4
Author: Aaron Iker
Author URI: http://www.aaroniker.me
License: GPL2
*/

if (!defined('WPINC'))
	die();

function tiny_grid_scripts()
{
	wp_enqueue_style('feather', plugins_url('css/feather.css', __FILE__), false, '');
}

add_action('admin_enqueue_scripts', 'tiny_grid_scripts');

function tiny_grid_theme_scripts()
{
	if(get_option('load_front'))
		wp_enqueue_style('bootstrap-grid', plugins_url('css/bootstrap3.css', __FILE__), false, '');
}

add_action('wp_enqueue_scripts', 'tiny_grid_theme_scripts');

function tiny_grid_mce($mce_css)
{
	if (!empty($mce_css))
		$mce_css .= ',';

	$mce_css .= plugins_url('css/bootstrap3.css', __FILE__);

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
          add_filter('mce_external_plugins', 'tiny_grid_add');
     }
}

add_action('admin_init', 'tiny_grid_buttons');

function tiny_grid_buttons_register($buttons)
{
     array_push($buttons, "grid", "visualblocks");
     return $buttons;
}

function tiny_grid_add($plugin_array)
{
    $plugin_array['tiny_grid_scripts'] = plugins_url( 'js/scripts.js', __FILE__ ) ;
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
	 
/* Options */

add_action('admin_menu', 'tiny_grid_menu');

function tiny_grid_menu()
{
	add_options_page('Tiny Grid', 'Tiny Grid', 'manage_options', 'tiny-grid', 'tiny_grid_options');
}

add_action('admin_init', 'register_tiny_grid_settings');

function register_tiny_grid_settings()
{
	register_setting('tiny-grid-settings-group', 'version');
	register_setting('tiny-grid-settings-group', 'load_front');
}

function tiny_grid_options()
{
	if (!current_user_can('manage_options'))
		wp_die(__('You do not have sufficient permissions to access this page.'));

?>
<div class="wrap">
    <h2>Tiny Grid</h2>
    <form method="post" action="options.php"> 
    
    <?php settings_fields('tiny-grid-settings-group'); ?>
    <?php do_settings_sections('tiny-grid-settings-group'); ?>
    
    <table class="form-table">
    	<tr valign="top">
    		<th scope="row">Version</th>
            <td>
                <fieldset>
                    <label><input name="version" value="3" <?=(esc_attr(get_option('version')) == '3' || !esc_attr(get_option('version'))) ? 'checked="checked"' : ''; ?> type="radio">3.3.5</label><br>
                    <label><input name="version" value="4" <?=(esc_attr(get_option('version')) == '4') ? 'checked="checked"' : ''; ?> type="radio" disabled="disabled">4</label>
                </fieldset>
            </td>
    	</tr>
        <tr valign="top">
        	<th scope="row">Load bootstrap grid system at frontend?</th>
            <td>
                <fieldset>
                	<label for="load_front">
                    	<input name="load_front" id="load_front" value="1" <?=((get_option('load_front'))) ? 'checked="checked"' : ''; ?> type="checkbox">
                        Yes
                    </label>
                	<p class="description">Only if Bootstrap is not included yet.</p>
                </fieldset>
            </td>
        </tr>
    </table>
    
    <?php submit_button(); ?>
    
    </form>
</div>
<?php

}

?>