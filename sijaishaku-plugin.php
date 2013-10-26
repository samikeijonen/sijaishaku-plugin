<?php
/**
 * Plugin Name: Sijaishaku Plugin
 * Plugin URI: http://foxnet-themes.fi
 * Description: Add stuff what we need in sijaishaku.fi site.
 * Version: 0.1.0
 * Text Domain: sijaishaku-plugin
 * Author: Sami Keijonen
 * Author URI: http://foxnet.fi
 * Contributors: samikeijonen
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume 
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package SijaishakuPlugin
 * @version 0.1
 * @author Sami Keijonen <sami.keijonen@foxnet.fi>
 * @copyright Copyright (c) 2012, Sami Keijonen
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) exit;
 
final class Sijaishaku_Plugin {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  0.1.0
	 * @access private
	 * @var    object
	 */
	private static $instance;

	/**
	 * PHP5 constructor method.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {

		/* Set the constants needed by the plugin. */
		add_action( 'plugins_loaded', array( $this, 'constants' ), 1 );

		/* Internationalize the text strings used. */
		add_action( 'plugins_loaded', array( $this, 'i18n' ), 2 );

		/* Load the functions files. */
		add_action( 'plugins_loaded', array( $this, 'includes' ), 3 );
		
	}

	/**
	 * Defines constants used by the plugin.
	 *
	 * @since 0.1.0
	 */
	public function constants() {

		/* Set constant path to the plugin directory. */
		if ( ! defined( 'SIJAISHAKU_PLUGIN_DIR' ) )	
			define( 'SIJAISHAKU_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		/* Set the constant path to the includes directory. */
		if ( ! defined( 'SIJAISHAKU_PLUGIN_INCLUDES' ) )	
			define( 'SIJAISHAKU_PLUGIN_INCLUDES', SIJAISHAKU_PLUGIN_DIR . trailingslashit( 'includes' ) );
		
		/* Set plugin folder URL. */
		if ( ! defined( 'SIJAISHAKU_PLUGIN_URL' ) )
			define( 'SIJAISHAKU_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

	}
	
	/**
	 * Load the translation of the plugin.
	 *
	 * @since 0.1.0
	 */
	public function i18n() {

		/* Load the translation of the plugin. */
		load_plugin_textdomain( 'sijaishaku-plugin', false, 'sijaishaku-plugin/languages' );
		
	}
	
	/**
	 * Loads the initial files needed by the plugin.
	 *
	 * @since 0.1.0
	 */
	public function includes() {

		require_once( SIJAISHAKU_PLUGIN_INCLUDES . 'functions.php' );
		require_once( SIJAISHAKU_PLUGIN_INCLUDES . 'taxonomy.php' );
		require_once( SIJAISHAKU_PLUGIN_INCLUDES . 'shortcodes.php' );
		require_once( SIJAISHAKU_PLUGIN_INCLUDES . 'gravity-forms.php' );
		
		if ( is_admin() )
			require_once( SIJAISHAKU_PLUGIN_INCLUDES . 'admin.php' );
		
	}
	
    /**
     * Returns the instance.
     *
     * @since  0.2.0
     * @access public
     * @return object
     */
    public static function get_instance() {

		if ( !self::$instance )
			self::$instance = new self;

			return self::$instance;
		}

}

Sijaishaku_Plugin::get_instance();

?>