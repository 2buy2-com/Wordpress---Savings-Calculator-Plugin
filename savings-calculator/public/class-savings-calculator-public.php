<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @since      0.0.1
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
	 * @access	 public
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/savings-calculator-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    0.0.1
	 * @access	 public
	 */
	public function enqueue_scripts() {
		wp_register_script( "savingscalculator_script", plugin_dir_url( __FILE__ ) . 'js/savings-calculator-public.js', array('jquery') );
		wp_localize_script('savingscalculator_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
		
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script('savingscalculator_script');
	}

	/**
	 * Retrieving categories from a pre-defined array
	 *
	 * @since    0.0.1
	 * @access	 public
	 */
	public function savingscalculator_categoriesArray_public() {
		require_once(dirname(plugin_dir_path(__FILE__)) . '/includes/class-savings-calculator-customsettings.php');
		$class = new Savings_Calculator_Custom_Settings();
		return $class->categories;
	}

	/**
	 * Define the steps for the calculator
	 *
	 * @since    0.0.1
	 * @access	 private
	 */
	private function calculatorSteps() {
		$cat_options = '';
		foreach(Savings_Calculator_Public::savingscalculator_categoriesArray_public() as $cat){
			$cat_options .= '<option value="'.$cat.'">'.$cat.'</option>';
		}
		return array(
			0 => (object) array(
				'description' => 'Select one of our spend areas',
				'content' => 
					'<select id="savingscalculator_select_cat" name="savingscalc[cat]">'
						.'<option value="">Please select</option>'
						.$cat_options
					.'</select>'
				),
			1 => (object) array(
				'description' => 'Tell us your current spending',
				'content' => '<input type="text" id="savingscalculator_input_spend" name="savingscalc[spend]" />'
			),
			2 => (object) array(
				'description' => 'Press the button and discover your savings',
				'content' => '<button id="savingscalculator_button_submit" class="button button-primary savingscalc_submit">How much could I save?</button>'
			)
		);
	}

	/**
	 * HTML output of the savings calculator
	 *
	 * @since    0.0.1
	 * @access	 public
	 */
	public function displayCalculator() {
		?>
		<div class="savingscalc">
			<h3>Savings <span>Calculator</span></h3>
			<p>Discover how much you could save</p>
			<div class="savingscalc-container">
				<div id="savingscalc-aside" class="savingscalc-aside">
					<?php foreach(Savings_Calculator_Public::calculatorSteps() as $key => $step){ ?>
						<div data-step="<?= $key; ?>" id="savingscalc-aside_item<?= $key; ?>" class="savingscalc-aside_item savingscalc-aside_item<?= $key; ?>">
							<p class="savingscalc-aside_item__step">Step <?= $key + 1; ?></p>
							<p class="savingscalc-aside_item__description"><?= $step->description; ?></p>
						</div>
					<?php } ?>
				</div>
				<div id="savingscalc-main" class="savingscalc-main">
					<?php foreach(Savings_Calculator_Public::calculatorSteps() as $key => $step){ ?>
						<div data-step="<?= $key; ?>" id="savingscalc-main_item<?= $key; ?>" class="savingscalc-main_item savingscalc-main_item<?= $key; ?>">
							<?= $step->content; ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php echo Savings_Calculator_Public::addJS(); ?>
		<?php
	}

	private function addJS() {
		?>
		<script type="text/javascript">
			jQuery(document).on('click', '.savingscalc_submit', function(e){
				e.preventDefault();
				SavingsCalculator.calculateSaving(
					jQuery('#savingscalculator_select_cat').val(), 
					jQuery('#savingscalculator_input_spend').val()
				);
			});

			var SavingsCalculator = {
			init: function() {
				var self = this,
	     		find = function(name) { return document.getElementById(name); };
				this.category = find('savingscalculator_select_cat');
				this.spend = find('savingscalculator_input_spend');
				this.submit = find('savingscalculator_button_submit');	
				this.main = find('savingscalc-main');
				this.aside = find('savingscalc-aside');
				self.stabiliseLayout();
				if(this.category.value && this.spend.value){
					self.submit.addEventListener("click", self.calculateSaving(this.category.value, this.spend.value));
				}
			},
			calculateSaving: function(cat, spend) {
				var data = {
					action: "savingscalculator_AJAX",
					cat: cat,
					spend: spend
				};
				if(this.category && this.spend){
					jQuery.post(myAjax.ajaxurl, data, function (response) {
						console.log(response);
					});
				}
			},
			stabiliseLayout: function() {
				var length = this.aside.children.length;
				for(var x = 0; x < length; x++){
					var key = this.aside.children[x].dataset.step,
					height = this.aside.children[x].offsetHeight;
					document.getElementById('savingscalc-main_item'+key).style.minHeight = height+'px';
				}
			}
		}
		SavingsCalculator.init();
		</script>
		<?php
	}
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
	$atts = array_change_key_case( (array) $atts, CASE_LOWER );
	$savingscalculator_atts = shortcode_atts(
		array(
			'title' => 'WordPress.org',
		), $atts, $tag
	);
	return Savings_Calculator_Public::displayCalculator();
}

/**
 * Creating the shortcode
 * @since 0.0.1
 */
function savingscalculator_shortcodes_init() {
	add_shortcode( 'savingscalculator', 'savingscalculator_shortcode' );
}



/**
 * AJAX query from front-end calculator
 *
 * @since    0.0.1
 */
function savingscalculator_AJAX(){
	$response = array();
	if(empty($_POST['cat']) || empty($_POST['spend'])){
		$response['type'] = 'error';
	} else {
		$response['type'] = 'success';
		$key = array_search($_POST['cat'], Savings_Calculator_Public::savingscalculator_categoriesArray_public());
		$response['category'] = $_POST['cat'];
		$response['key'] = $key;
		$response['spend'] = $_POST['spend'];
		$response['percentage_saved'] = get_option('saving_'.$key);
		$response['new_value'] = ((float) $_POST['spend'] / 100) * (float) $response['percentage_saved']; 
	}
	print_r((object) $response);
}
 
add_action( 'init', 'savingscalculator_shortcodes_init' );
add_action( 'wp_ajax_savingscalculator_AJAX', 'savingscalculator_AJAX' );
add_action( 'wp_ajax_nopriv_savingscalculator_AJAX', 'savingscalculator_AJAX' );
