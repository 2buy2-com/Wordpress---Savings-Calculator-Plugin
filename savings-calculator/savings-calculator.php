<?php
/**
 * The plugin Savings Calculator
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             0.0.1
 * @package           Savings Calculator
 *
 * @wordpress-plugin
 * Plugin Name:       Procurement Savings Calculator
 * Description:       A calculator to show how much can be saved based on certain categories of spend.
 * Version:           0.0.1
 * Author:            2buy2
 * Author URI:        https://www.2buy2.com
 * Text Domain:       savings-calculator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 0.0.1 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SAVINGS_CALCULATOR_VERSION', '0.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-savings-calculator-activator.php
 */
function activate_savings_calculator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-savings-calculator-activator.php';
	Savings_Calculator_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-savings-calculator-deactivator.php
 */
function deactivate_savings_calculator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-savings-calculator-deactivator.php';
	Savings_Calculator_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_savings_calculator' );
register_deactivation_hook( __FILE__, 'deactivate_savings_calculator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-savings-calculator.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.1
 */
function run_savings_calculator() {

	$plugin = new Savings_Calculator();
	$plugin->run();

}
run_savings_calculator();
