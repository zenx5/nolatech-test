<?php
/**
 * Spacing Extension
 *
 * @package Astra Addon
 */

define( 'ASTRA_ADDON_EXT_SPACING_DIR', ASTRA_EXT_DIR . 'addons/spacing/' );
define( 'ASTRA_ADDON_EXT_SPACING_URL', ASTRA_EXT_URI . 'addons/spacing/' );

if ( ! class_exists( 'Astra_Ext_Spacing' ) ) {

	/**
	 * Spacing Initial Setup
	 *
	 * @since 1.2.0
	 */
	// @codingStandardsIgnoreStart
	class Astra_Ext_Spacing {
 // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound
		// @codingStandardsIgnoreEnd

		/**
		 * Member Variable
		 *
		 * @var object instance
		 */
		private static $instance;

		/**
		 *  Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor function that initializes required actions and hooks
		 */
		public function __construct() {
			require_once ASTRA_ADDON_EXT_SPACING_DIR . 'classes/class-astra-ext-spacing-loader.php';

			// Include front end files.
			if ( ! is_admin() ) {
				if ( astra_addon_4_6_0_compatibility() ) {
					require_once ASTRA_ADDON_EXT_SPACING_DIR . 'classes/blog-dynamic.css.php';
				} else {
					require_once ASTRA_ADDON_EXT_SPACING_DIR . 'classes/dynamic.css.php';
				}
			}
		}
	}
}

/**
 *  Kicking this off by calling 'get_instance()' method
 */
Astra_Ext_Spacing::get_instance();
