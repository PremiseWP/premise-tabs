# Premise Tabs plugin

Easily add Responsive CSS tabs to your theme or plugin options page.
Wordpress plugin for [PremiseWP](https://github.com/PremiseWP/Premise-WP) framework.

Example:

```php

$tabs = array(
	array(
		'title' => 'Tab Number One', 
		'icon' => 'fa-plus', // use a Font Awesome icon class
		'content' => 'Lorem..', // enter your content here
	),
	array(
		'title' => 'Tab Number Two', 
		'icon' => '/wp-content/uploads/2016/02/my_icon.png', // You can also pass an img url
		'content' => 'Write some html..',
	),
	array(
		'title' => 'Tab Number Three', 
		'tab_class' => 'red-tab', // enter classes per tab
		'content_class' => 'blue-content', // enter classes per content section
		'content' => 'You know what todo here...',
	),
);

new Premise_Tabs( $tabs );

```

Options:

```php

new Premise_Tabs( $tabs, 'top' ); // display tabs at the top
new Premise_Tabs( $tabs, 'bottom' ); // display tabs at the bottom
new Premise_Tabs( $tabs, 'left' ); // displays tabs stacked on the left
new Premise_Tabs( $tabs, 'right' ); // displays tabs stacked on the right

```  

**The `raw` Feature:** The `raw` argument is the third argument this class takes and it is useful when
you dont want any of the JavaScript or the css to load, none of it!  

All you have to do is pass a boolean value `true` as your third parameter. This will avoid the class
`ptabs-wrapper` from being added, which will result in no CSS or JS firing, since all the CSS and JS is
scoped to the `ptabs-wrapper` class.

Uses [Grunt](http://gruntjs.com/getting-started).