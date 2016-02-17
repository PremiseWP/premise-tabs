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
	var $defaults = array(
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
	var $options = 'top';


	/**
	 * The tabs
	 *
	 * @var array
	 */
	var $tabs = array();


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
	public function __construct( $tabs = array(), $params = '' ) {

		if ( is_array( $tabs ) && ! empty( $tabs ) ) {
			// save tabs into our object's tabs property
			foreach ( $tabs as $k => $tab ) {
				if ( is_array( $tab ) ) $this->tabs[] = wp_parse_args( $tab, $this->defaults );
			}

			if ( is_string( $params ) && ! empty( $params ) ) {
				$this->options = $params;
			}
			elseif ( is_array( $params ) ) {
				# parse params
				echo '$params - is an array. Not supported yet.';
			}
			
			$this->load_tabs();
		}
	}


	public function load_tabs() {

		$_html = $this->tabs_independent();

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
				
				// Build the tabs 
				$_tabs .= '<div class="ptabs-tab ptabs-tab-' . $k . '" data-tab-index="' . $k . '">
					<a href="javascript:;" class="ptabs-tab-a">';
						$_tabs .= ( isset( $tab['icon'] ) && ! empty( $tab['icon'] ) ) ? $this->get_icon( $tab['icon'] ) : ''; // get icon whether is image or FA
						$_tabs .= '<div class="ptabs-tab-title">' . $this->stripped_title( $tab['title'] ) . '</div>';
					$_tabs .= '</a>
				</div>';

				// Build the content 
				$_cont .= '<div class="ptabs-content ptabs-content-' . $k . '">';
					$_cont .= $tab['content'];
				$_cont .= '</div>';
			}
		}

		$_tabs .= '</div>';
		$_cont .= '</div>';

		return $_html = '<div class="ptabs-wrapper">' . $_tabs . $_cont . '</div>';
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



	
}
