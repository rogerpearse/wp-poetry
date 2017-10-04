<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/rogerpearse
 * @since             1.0.0
 * @package           Wp_Poetry
 *
 * @wordpress-plugin
 * Plugin Name:       WP Poetry
 * Plugin URI:        https://github.com/rogerpearse/wp-poetry
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Roger Pearse
 * Author URI:        https://github.com/rogerpearse
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-poetry
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-poetry-activator.php
 */
function activate_wp_poetry() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-poetry-activator.php';
	Wp_Poetry_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-poetry-deactivator.php
 */
function deactivate_wp_poetry() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-poetry-deactivator.php';
	Wp_Poetry_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_poetry' );
register_deactivation_hook( __FILE__, 'deactivate_wp_poetry' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-poetry.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_poetry() {

	$plugin = new Wp_Poetry();
	$plugin->run();

}
run_wp_poetry();

/** =================== The plugin stuff for functions.php ======================= */

/**
	Add a menu with styles in to the second row of the editor (the "kitchen sink")
	This just picks up ordinary styles by default.
	https://torquemag.io/2016/09/add-custom-styles-wordpress-editor-manually-via-plugin/
 */
function add_style_select_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}

// Register our callback to the appropriate filter
add_filter( 'mce_buttons_2', 'add_style_select_buttons' );

/** 
	Add custom styles to the WordPress editor
	This replaces the default styles with these custom styles.
	In the code snippet above, we are creating three different 
	custom styles. In particular, we are adding options to 
	create a red button, a content box, and a highlighter for text passages.
  */
function my_custom_styles( $init_array ) {  
 
    $style_formats = array(  
        // These are the custom styles
        array(  
            'title' => 'Red Button',  
            'block' => 'span',  
            'classes' => 'red-button',
            'wrapper' => true,
        ),  
        array(  
            'title' => 'Content Block',  
            'block' => 'span',  
            'classes' => 'content-block',
            'wrapper' => true,
        ),
        array(  
            'title' => 'Highlighter',  
            'block' => 'span',  
            'classes' => 'highlighter',
            'wrapper' => true,
        ),
    );  
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );  
    
    return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_custom_styles' );

// Enable styles in the editor as well as display.  Path is relative to the active theme root
function custom_editor_styles() {
	add_editor_style( '../../plugins/wp-poetry/wp-poetry-styles.css' );
}
 
add_action( 'init', 'custom_editor_styles' );



