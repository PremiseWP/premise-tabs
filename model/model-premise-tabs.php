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
 * This class is supposed to do one thing well - output markup for tabs.
 * That means that this class is meant to provide developers with the markup
 * necessary for creating tabs, but should let the developer control functionality and
 * styles. Of course, by default this class outputs working tabs with basic styles and
 * fucntionality, but the idea is that they can be easily overridden or customized.
 *
 * @example $tabs = array(
 *          	array(
 *          		'title'   => 'Tab 1',
 *          		'content' => 'HTML for content here..',
 *          	),
 *          	array(..
 *          );
 *          new Premise_Tabs( $tabs, 'top' );
 */
class Premise_Tabs {

	/**
	 * The defaults for each tab
	 *
	 * @see constructor
	 *
	 * @var array
	 */
	protected $defaults = array(
		'title' => '', 
		'icon' => '', 
		'content' => '', 
	);


	/**
	 * The options.
	 *
	 * For ease of use, the options argument can be a string
	 * simply containing the location of where to place the tabs.
	 * This argument defaults to 'top'. An array can also be passed
	 * as the second argument to give you more control - further documentation
	 * in the constructor function.
	 *
	 * @see constructor
	 *
	 * @var array
	 */
	protected $options = array('wall' => 'top');



	protected $options_defaults = array(
		'wall' => 'top',
		'content_in_tab' => false,
	);


	/**
	 * The tabs
	 *
	 * @var array
	 */
	protected $tabs = array();



	public $raw = false;


	/**
	 * html tags allowed in the tabs title
	 * 
	 * @var string
	 */
	protected $allowed_title_tags = '<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<p>,<span>,<br>';


	/**
	 * Constructor
	 *
	 * @param array $options Tabs options.
	 */
	public function __construct( $tabs = array(), $params = '', $raw = false ) {

		if ( is_array( $tabs ) && ! empty( $tabs ) ) {
			// check raw feature
			$this->raw = is_bool( $raw ) ? $raw : $this->raw;
			
			$this->set_options( $params );

			// save tabs into our object's tabs property
			foreach ( $tabs as $k => $tab ) {
				if ( is_array( $tab ) ) $this->tabs[] = wp_parse_args( $tab, $this->defaults );
			}

			
			$this->load_tabs();
		}
	}


	/**
	 * loads the tabs
	 * 
	 * @return string outputs the html for the tabs
	 */
	public function load_tabs() {

		$_html = ( ! $this->options['content_in_tab'] ) ? $this->tabs_independent() : $this->tabs_together();

		echo $_html;
	}



	/**
	 * Prints out tabs separate from the content.
	 *
	 * Both tabs and contents are output in separate containers within
	 * one wrapper container.
	 * 
	 * @return string html for tabs
	 */
	public function tabs_independent() {
		$_tabs = '<div class="ptabs-tabs-container">'; // begin with an clean tabs container
		$_cont = '<div class="ptabs-content-container">'; // begin with an clean contents container

		foreach ( $this->tabs as $k => $tab ) {
			
			if ( ( isset( $tab['title'] ) && ! empty( $tab['title'] ) ) 
				&& ( isset( $tab['content'] ) && ! empty( $tab['content'] ) ) ) {
				
				$tab_class = ( isset( $tab['tab_class'] ) && ! empty( $tab['tab_class'] ) ) ? 
					' ' . esc_attr( $tab['tab_class'] ) : '';
				
				// Build the tabs 
				$_tabs .= '<div class="ptabs-tab ptabs-tab-' . $k . $tab_class . '" data-tab-index="' . $k . '">
					<a href="javascript:;" class="ptabs-tab-a">';
						// get icon whether is image or FA
						$_tabs .= ( isset( $tab['icon'] ) && ! empty( $tab['icon'] ) ) ? $this->get_icon( $tab['icon'] ) : '';
						$_tabs .= '<div class="ptabs-tab-title">' . $this->stripped_title( $tab['title'] ) . '</div>';
					$_tabs .= '</a>
				</div>';

				$cont_class = ( isset( $tab['content_class'] ) && ! empty( $tab['content_class'] ) ) ? 
					' ' . esc_attr( $tab['content_class'] ) : '';

				// Build the content 
				$_cont .= '<div class="ptabs-content ptabs-content-' . $k . $cont_class . '">';
					$_cont .= wpautop( wptexturize( $tab['content'] ) );
				$_cont .= '</div>';
			}
		}

		$_tabs .= '</div>';
		$_cont .= '</div>';

		$_html = '<div class="' . $this->wrapper_class() . '">';
			$_html .= ( 'top' == $this->options['wall'] ) ? $_tabs . $_cont : $_cont . $_tabs;
		$_html .= '</div>';

		return $_html;
	}



	public function tabs_together() {
		# not ready yet
	}


	/**
	 * returns all the wrapper classes
	 * 
	 * @return string wrapper applicable classes
	 */
	public function wrapper_class() {
		// begin with the main class if not raw
		$class = $this->raw ? '' : 'ptabs-wrapper';

		$class .= isset( $this->options['wall'] ) && ! empty( $this->options['wall'] ) ? ' ' . 'ptabs-' . esc_attr( $this->options['wall'] ) : '';

		return $class;
	}



	/**
	 * returns the icon as image or FontAwesome icon
	 *
	 * Uses regexp ti identify it the icon is an image or an fa icon then pricess it 
	 * accordingly.
	 * 
	 * @param  string $icon FontAwesome icon class i.e. fa-plus. or image url to use as icon
	 * @return string       html for tab icon if it is img url or FontAwesome icon. empty string otherwise
	 */
	public function get_icon( $icon = '' ) {
		$_html = '';
		if ( ! empty( $icon ) ) {
			$_html = '<div class="ptabs-tab-icon">';
				
				if ( preg_match('/.*\.png|jpg|jpeg|gif/i', $icon, $match ) ) {
					$_html .= '<img src="' . esc_url( $icon ) . '" class="premise-responsive">';
				}
				elseif ( preg_match('/^fa-/i', $icon, $match ) ) {
					$_html .= '<i class="fa ' . esc_attr( strtolower( $icon ) ) . '"></i>';
				}
				else {
					$_html .= '';
				}

			$_html .= '</div>';
		}
		return $_html;
	}



	/**
	 * returns the title tab stripped
	 *
	 * @see Premise_Tabs::allowed_title_tags for a list allowed tags
	 * 
	 * @param  string $title title to strip tags from
	 * @return string        title stripped.
	 */
	public function stripped_title( $title = '' ) {
		if ( ! empty( $title ) )
			return strip_tags( (string) $title, $this->allowed_title_tags );
		return '';
	}




	public function set_options( $params = '' ) {
		if ( is_string( $params ) && ! empty( $params ) ) {
			$this->options['wall'] = $params;
		}
		elseif ( is_array( $params ) ) {
			$this->options = wp_parse_args( $params, $this->options_defaults );
		}
	}



	
}
