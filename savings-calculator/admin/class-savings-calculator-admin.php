<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      0.0.1
 *
 * @package    Savings_Calculator
 * @subpackage Savings_Calculator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Savings_Calculator
 * @subpackage Savings_Calculator/admin
 * @author     2buy2 <david.hendy@2buy2.com>
 */
class Savings_Calculator_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.0.1
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/savings-calculator-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/savings-calculator-admin.js', array( 'jquery' ), $this->version, false );

	}
}

function categoriesArray()
{
	return array(
		'Office',
		'Photocopiers',
		'Water',
		'Telecoms'
	);
}

function savingscalculator_register_settings() {
	add_settings_section( 'savingscalculator_settings', 'Savings Calculator Settings', 'savings_calculator_section_text', 'savings_calculator' );
	foreach(categoriesArray() as $key => $cat) {
		add_settings_field( 'saving_'.strtolower(str_replace(' ', '_', $cat)), $cat, 'get_Cat_'.$key, 'savings_calculator', 'savingscalculator_settings' );
		 register_setting( 'savingscalculator_plugin_options', 'saving_'.$key);
	}
}

function get_Cat_0() {
	$key = 0;
	$catname = strtolower(str_replace(' ', '_', categoriesArray()[$key]));
	$options = get_option( 'saving_'.$key );
	if(isset($options)){
		echo "<input name='saving_".$key."' type='text' value='".$options."' />";	
	} else {
		echo "<input name='saving_".$key."' type='text' />";
	}
}

function get_Cat_1() {
	$key = 1;
	$catname = strtolower(str_replace(' ', '_', categoriesArray()[$key]));
	$options = get_option( 'saving_'.$key );
	if(isset($options)){
		echo "<input name='saving_".$key."' type='text' value='".$options."' />";	
	} else {
		echo "<input name='saving_".$key."' type='text' />";
	}
}

function get_Cat_2() {
	$key = 2;
	$catname = strtolower(str_replace(' ', '_', categoriesArray()[$key]));
	$options = get_option( 'saving_'.$key );
	if(isset($options)){
		echo "<input name='saving_".$key."' type='text' value='".$options."' />";	
	} else {
		echo "<input name='saving_".$key."' type='text' />";
	}
}

function get_Cat_3() {
	$key = 3;
	$catname = strtolower(str_replace(' ', '_', categoriesArray()[$key]));
	$options = get_option( 'saving_'.$key );
	if(isset($options)){
		echo "<input name='saving_".$key."' type='text' value='".$options."' />";	
	} else {
		echo "<input name='saving_".$key."' type='text' />";
	}
}

function savings_calculator_section_text() {
    echo '<p>Here you can set all the options for using the Savings Calculator</p>';
}

function savings_calculator_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form method="post" action="options.php">
			<?php 
				settings_fields( 'savingscalculator_plugin_options' );
				do_settings_sections( 'savings_calculator' );
				submit_button(); 
			?>
		</form>
    </div>
    <?php
}

function savingscalculator_options_page() {
    add_options_page(
		'Procurement Savings Calculator',
		'Procurement Savings Calculator',
		'manage_options',
		'savings_calculator',
		'savings_calculator_options_page_html'
	);
	add_action( 'admin_menu', 'savings_calculator_options_page_html' );
}

add_action( 'admin_menu', 'savingscalculator_options_page' );
add_action( 'admin_init', 'savingscalculator_register_settings' );
