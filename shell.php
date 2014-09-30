<?php
/*
Plugin Name:         Boilerplate Shell
Plugin URI:
Description:         A boilerplate plugin for creating shells for the Maera theme
Version:             1.0
Author:              Aristeides Stathopoulos, Dimitris Kalliris
Author URI:          http://wpmu.io
*/

define( 'MAERA_BOILERPLATE_SHELL_URL', plugins_url( '', __FILE__ ) );
define( 'MAERA_BOILERPLATE_SHELL_PATH', dirname( __FILE__ ) );

// Include the compiler class
require_once MAERA_BOILERPLATE_SHELL_PATH . '/class-Shell_Boilerplate.php';

/**
 * Include the shell
 */
function maera_shell_boilerplate_include( $shells ) {

	// Add our shell to the array of available shells
	$shells[] = array(
		'value' => 'boilerplate',
		'label' => 'Boilerplate',
		'class' => 'Shell_Boilerplate',
	);

	return $shells;

}
add_filter( 'maera/shells/available', 'maera_shell_boilerplate_include' );

/**
 * Plugin textdomains
 */
function maera_boilerplate_texdomain() {
	$lang_dir    = plugin_dir_path( __FILE__ ) . '/languages';
	$custom_path = WP_LANG_DIR . '/shellboiler-' . get_locale() . '.mo';

	if ( file_exists( $custom_path ) ) {
		load_textdomain( 'shellboiler', $custom_path );
	} else {
		load_plugin_textdomain( 'shellboiler', false, $lang_dir );
	}
}
add_action( 'plugins_loaded', 'maera_boilerplate_texdomain' );
