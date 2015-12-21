<?php
/**
 * Premise Tabs
 *
 * Add Tabs
 *
 * @package Premise Tabs
 * @subpackage model
 */

/**
 * Premise Tabs Class
 *
 * @example $tabs = new Premise_Tabs();
 *          ob_start();
 *          $tabs->set_tab( '<div class="premise-row">' . ob_get_clean() . '</div>', __( 'Menus', 'vmenu' ), 'fa-cutlery' );
 *          $tabs->tabs_output();
 */
class Premise_Tabs {

	/**
	 * The defaults
	 *
	 * @see constructor
	 *
	 * @var array
	 */
	var $defaults = array(
		'tabs-label-display' => 'inline'
	);


	/**
	 * The options
	 *
	 * @see constructor
	 *
	 * @var array
	 */
	var $options = array();


	/**
	 * The tabs
	 *
	 * @var array
	 */
	var $tab = array();


	/**
	 * The tab group counter
	 *
	 * @var integer
	 */
	static $tab_group_counter = 1;


	/**
	 * The tab group
	 *
	 * @var integer
	 */
	var $tab_group;


	/**
	 * Constructor
	 *
	 * @param array $options Tabs options.
	 */
	public function __construct( $options = array() ) {

		$this->tab_group = Premise_Tabs::$tab_group_counter++;

		$this->options = array_replace_recursive( $this->defaults, (array) $options );
	}



	/**
	 * Set Tab
	 *
	 * @example $tabs->set_tab( '<div class="premise-row">' . ob_get_clean() . '</div>', __( 'Menus', 'vmenu' ), 'fa-cutlery' );
	 *
	 * @param string $tab_content Tab Content HTML.
	 * @param string $title       Tab Title.
	 * @param string $icon        Tab Icon: Font Awesome (eg. 'fa-twitter'), or image src. Optional.
	 */
	public function set_tab( $tab_content, $title, $icon = '' ) {

		$this->tab[] = array(
			'content' => (string) $tab_content,
			'title' => (string) $title,
			'icon' => (string) $icon,
		);
	}



	/**
	 * Tabs Output
	 *
	 * @uses Premise_Tabs::get_tabs()
	 */
	public function tabs_output() {

		echo $this->get_tabs();
	}


	/**
	 * Get Tabs
	 *
	 * @uses Premise_Tabs::get_tab()
	 *
	 * @return string Tabs HTML or empty string if no tabs
	 */
	public function get_tabs() {

		$number_tabs = count( $this->tab );

		if ( $number_tabs < 1 ) {

			return '';
		}

		ob_start();	?>

		<ul class="premise-tabs premise-tabs-<?php echo esc_attr( $this->tab_group ); ?> premise-clear">

		<?php
		for ( $tab_number = 0; $tab_number < $number_tabs; $tab_number++ ) {

			// Generate each tab.
			echo $this->get_tab( $tab_number );
		} ?>

		</ul><!-- /premise-tabs -->

		<?php return ob_get_clean();
	}



	/**
	 * Tab
	 *
	 * @see  https://css-tricks.com/examples/CSSTabs/radio.php
	 * @see  http://www.onextrapixel.com/2013/07/31/creating-content-tabs-with-pure-css/
	 *
	 * @uses Premise_Tabs::get_tab_header()
	 * @uses Premise_Tabs::get_tab_footer()
	 *
	 * @param  integer $tab_number Tab Number.
	 *
	 * @return string Tab HTML or empty string if tab does not exist
	 */
	public function get_tab( $tab_number ) {

		if ( ! isset( $this->tab[ (int) $tab_number ] ) ) {

			return '';
		}

		$tab = $this->get_tab_header( $tab_number );

		$tab .= $this->tab[ $tab_number ]['content'];

		$tab .= $this->get_tab_footer( $tab_number );

		return $tab;
	}



	/**
	 * Tab Header
	 *
	 * @see  https://css-tricks.com/examples/CSSTabs/radio.php
	 *
	 * @param  integer $tab_number Tab Number.
	 *
	 * @return string Tab Header HTML or empty string if tab does not exist
	 */
	public function get_tab_header( $tab_number ) {

		if ( ! isset( $this->tab[ (int) $tab_number ] ) ) {

			return '';
		}

		$tab = $this->tab[ (int) $tab_number ];

		$checked = '';

		if ( 0 === (int) $tab_number ) {

			$checked = ' checked';
		}

		$number_tabs = count( $this->tab );

		$block = $this->options['tabs-label-display'] === 'block';

		ob_start(); ?>

		<li class="premise-tab"<?php echo $block ? ' style="width: ' . esc_attr( 100 / $number_tabs ) . '%"' : ''; ?>>
			<input type="radio"<?php echo esc_attr( $checked ); ?> name="premise-tab-group-<?php echo sanitize_html_class( $this->tab_group ); ?>" id="premise-tab<?php echo esc_attr( $tab_number ); ?>" class="premise-tab-radio">
			<label for="premise-tab<?php echo esc_attr( $tab_number ); ?>" class="premise-tab-label"<?php echo $block ? ' style="display: block;"' : ''; ?>>
			<?php if ( strpos( $tab['icon'], 'fa-' ) === 0 ) : ?>
				<i class="fa <?php echo esc_attr( $tab['icon'] ); ?>"></i>
			<?php elseif ( $tab['icon'] ) : // Image src. ?>
				<img src="<?php echo esc_attr( $tab['icon'] ); ?>" />
			<?php endif; ?>
				<?php echo esc_html( $tab['title'] ); ?>
			</label>

			<div id="premise-tab-content<?php echo esc_attr( $tab_number ); ?>" class="premise-tab-content">

		<?php return ob_get_clean();
	}



	/**
	 * Tab Footer
	 *
	 * @see  https://css-tricks.com/examples/CSSTabs/radio.php
	 *
	 * @param  integer $tab_number Tab Number.
	 *
	 * @return string Tab Header HTML or empty string if tab does not exist
	 */
	public function get_tab_footer( $tab_number ) {

		if ( ! isset( $this->tab[ (int) $tab_number ] ) ) {

			return '';
		}

		ob_start(); ?>

			</div><!-- /premise-tab-content -->
		</li><!-- /premise-tab -->

		<?php return ob_get_clean();
	}
}
