<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since      0.0.1
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
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/savings-calculator-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/savings-calculator-admin.js', array( 'jquery' ), $this->version, false );
	}
}

function savingscalculator_categoriesArray_admin() {
	require_once(dirname(plugin_dir_path(__FILE__)) . '/includes/class-savings-calculator-customsettings.php');
	$class = new Savings_Calculator_Custom_Settings();
	return $class->categories;
}

function savingscalculator_register_settings() {
	add_settings_section( 'savingscalculator_settings', 'Savings Calculator Settings', 'savings_calculator_section_text', 'savings_calculator' );
	foreach(savingscalculator_categoriesArray_admin() as $key => $cat) {
		add_settings_field( 'saving_'.strtolower(str_replace(' ', '_', $cat)), $cat, 'get_Cat', 'savings_calculator', 'savingscalculator_settings', ['key' => $key] );
		 register_setting( 'savingscalculator_plugin_options', 'saving_'.$key);
	}
}

function get_Cat($args) {
	$options = get_option( 'saving_'.$args['key'] ); 
	if(isset($options)){
		echo "<input name='saving_".$args['key']."' type='number' min='0' max='100' step='1' value='".$options."' />";	
	} else {
		echo "<input name='saving_".$args['key']."' type='number' min='0' max='100' step='1' />";
	}
}

function savings_calculator_section_text() {
    echo '<p>Please enter the savings percentages for each category</p>';
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
