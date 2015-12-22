# Premise Tabs plugin

Easily add CSS tabs to your themes or plugins options page.
Wordpress plugin for [PremiseWP](https://github.com/PremiseWP/Premise-WP) framework.

Example:

```php

$tabs = new Premise_Tabs();

ob_start();

premise_field_section( $my_theme_options_fields );

$tabs->set_tab(
	'<div class="premise-row">' . ob_get_clean() . '</div>',
	__( 'Tab title', 'my_theme_domain' ),
	'fa-cutlery' // Font Awesome icon (or image src).
);

$tabs->tabs_output();

```

Options:

```php

// Defaults.
array(
	'tabs-label-display' => 'inline', // Options: 'inline'|'block'.
	'transition' => '', // Options: 'opacity'|'translateX'.
	'selected-tab-arrow' => false, // Options: true|false.
)

```

Uses [Grunt](http://gruntjs.com/getting-started).

Inspired by https://css-tricks.com/examples/CSSTabs/radio.php and http://www.onextrapixel.com/2013/07/31/creating-content-tabs-with-pure-css/