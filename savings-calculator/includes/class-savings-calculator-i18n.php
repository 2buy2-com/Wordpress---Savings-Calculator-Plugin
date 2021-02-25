<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.0.1
 *
 * @package    Savings_Calculator
 * @subpackage Savings_Calculator/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.0.1
 * @package    Savings_Calculator
 * @subpackage Savings_Calculator/includes
 * @author     2buy2 <david.hendy@2buy2.com>
 */
class Savings_Calculator_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.0.1
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'savings_calculator',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
