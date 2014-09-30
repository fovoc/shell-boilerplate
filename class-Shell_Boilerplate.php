<?php

if ( ! class_exists( 'Shell_Boilerplate' ) ) {

	/**
	* The Bootstrap Shell module
	*/
	class Shell_Boilerplate {

		private static $instance;


		/**
		 * Class constructor
		 */
		public function __construct() {

			if ( ! defined( 'MAERA_SHELL_PATH' ) ) {
				define( 'MAERA_SHELL_PATH', dirname( __FILE__ ) );
			}

			// Enqueue the scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 110 );

			// Add stylesheets caching if dev_mode is set to off.
			$theme_options = get_option( 'maera_admin_options', array() );
			if ( 0 == @$theme_options['dev_mode'] ) {

				add_filter( 'maera/styles/caching', '__return_true' );
				// Turn on Timber caching.
				// See https://github.com/jarednova/timber/wiki/Performance#cache-the-twig-file-but-not-the-data
				Timber::$cache = true;
				add_filter( 'maera/timber/cache', array( $this, 'timber_caching' ) );

			} else {

				add_filter( 'maera/styles/caching', '__return_false' );
				TimberLoader::CACHE_NONE;

			}

		}


		/**
		 * Singleton
		 */
		public static function get_instance() {

			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}


		/**
		 * Register all scripts and additional stylesheets (if necessary)
		 */
		function scripts() {

			wp_register_script( 'boilerplatejs', MAERA_BOILERPLATE_SHELL_URL . '/assets/js/boilerplate.min.js', false, null, true  );
			wp_enqueue_script( 'boilerplatejs' );

			wp_register_style( 'boilerplatecss', MAERA_BOILERPLATE_SHELL_URL . '/assets/css/style.css', false, null, true );
			wp_enqueue_style( 'boilerplatecss' );

		}


		/**
		 * Timber caching
		 */
		function timber_caching() {

			$theme_options = get_option( 'maera_admin_options', array() );

			$cache_int = isset( $theme_options['cache'] ) ? intval( $theme_options['cache'] ) : 0;

			if ( 0 == $cache_int ) {

				// No need to proceed if cache=0
				return false;

			}

			// Convert minutes to seconds
			return ( $cache_int * 60 );

		}

	}

}
