<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since      0.0.1
 *
 * @package    Savings_Calculator
 * @subpackage Savings_Calculator/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Savings_Calculator
 * @subpackage Savings_Calculator/public
 * @author     2buy2 <david.hendy@2buy2.com>
 */
class Savings_Calculator_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/savings-calculator-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/savings-calculator-public.js', array( 'jquery' ), $this->version, false );

	}

}

function getCategories(){
	return array(
		'Telecoms',
		'Office Supplies',
		'Water',
		'Catering',
		'Cleaning'
	);
}

function calculatorSteps(){
	$cat_options = '';
	foreach(getCategories() as $cat){
		$cat_options .= '<option value="'.strtolower(str_replace(' ', '_', $cat)).'">'.$cat.'</option>';
	}

	return array(
		0 => (object) array(
			'description' => 'Select one of our spend areas',
			'content' => 
				'<select name="savingscalc[cat]">'
					.'<option value="">Please select</option>'
					.$cat_options
				.'</select>'
			),
		1 => (object) array(
			'description' => 'Tell us your current spending',
			'content' => '<input type="text" name="savingscalc[spend]" />'
		),
		2 => (object) array(
			'description' => 'Press the button and discover your savings',
			'content' => '<button class="button button-primary savingscalc_submit">How much could I save?</button>'
		)
	);
}

function displayCalculator(){
	?>
	<div class="savingscalc">
		<h3>Savings <span>Calculator</span></h3>
		<p>Discover how much you could save</p>
		<div class="savingscalc-container">
			<div class="savingscalc-aside">
				<?php foreach(calculatorSteps() as $key => $step){ ?>
					<div class="savingscalc-aside_item savingscalc-aside_item<?= $key; ?>">
						<p class="savingscalc-aside_item__step">Step <?= $key + 1; ?></p>
						<p class="savingscalc-aside_item__description"><?= $step->description; ?></p>
					</div>
				<?php } ?>
			</div>
			<div class="savingscalc-main">
				<?php foreach(calculatorSteps() as $key => $step){ ?>
					<div class="savingscalc-main_item savingscalc-main_item<?= $key; ?>">
						<?= $step->content; ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * The [savingscalculator] shortcode.
 *
 * Accepts a title and will display a box.
 *
 * @param array  $atts    Shortcode attributes. Default empty.
 * @param string $content Shortcode content. Default null.
 * @param string $tag     Shortcode tag (name). Default empty.
 * @return string Shortcode output.
 */

function savingscalculator_shortcode( $atts = [], $content = null, $tag = '' ) {
    // normalize attribute keys, lowercase
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );
 
    // override default attributes with user attributes
    $savingscalculator_atts = shortcode_atts(
        array(
            'title' => 'WordPress.org',
        ), $atts, $tag
    );
	
	return displayCalculator();
}
 
/**
 * Central location to create all shortcodes.
 */
function savingscalculator_shortcodes_init() {
    add_shortcode( 'savingscalculator', 'savingscalculator_shortcode' );
}
 
add_action( 'init', 'savingscalculator_shortcodes_init' );
