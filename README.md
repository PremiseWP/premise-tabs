# Premise Tabs plugin

Build tabs markup quikly and customize it for your own project.  

This plugin builds and outputs the markup for responsive tabs. It is meant to be extremely flexible
yet basic so you can easily override or customize the tabs to your liking without having to hack
a bunch of code. 

### The Basic Syntax

This class accepts 3 arguments:  
`$tabs`    (required) - an array of arrays containing the tabs  
`$options` (optional) - a string or array to define [options](#options)  
`$raw`     (optional) - boolean value, on false does not bind JS or CSS, default is true.

```  
// Default arguments
new Premise_tabs( array(), 'top', false );
```  

To avoid loading unnecessary libraries this plugin uses its own JS code which you can expand on, or 
completely prevent from running by passing `true` as the third argument.  

This plugin is built for developers in the sense that is meant to be used with ease 
in any scenario where tabs could be necessary. By building the minimum amount of markup necessary (or the 
"base Markup" as we call it), we allow you to build on top of our code, rather than try to change it. 

For example, if you want to change the CSS simply pass a class as your second argument and use it in your
own code. [See an example here](#overriding-css). 

If you really want to go "Bare Bones" sort of speak, pass 
a third argument with a boolean value `true` and none of our CSS or JS will even load. You literally get 
just the markup for the tabs. Do with it as you please. [See an example of this](#using-the-raw-feature)!  

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

## Options  

Options can be a string or an array. When used as a string, there are four built in 'options' in Premise Tabs. 
They each represent where to place the tabs (top, left, right, or bottom). 

```php

new Premise_Tabs( $tabs, 'top' );    // display tabs at the top
new Premise_Tabs( $tabs, 'bottom' ); // display tabs at the bottom
new Premise_Tabs( $tabs, 'left' );   // displays tabs stacked on the left
new Premise_Tabs( $tabs, 'right' );  // displays tabs stacked on the right

```  

Basically, when this option is used as a string it adds a class to the main wrapper in addition to its own class.
The class is always prefixed with `ptabs-`, so if you pass a class `my_class` you would reference it like this in 
your CSS `.ptabs-my_class`.

## Overriding CSS

when using a custom class, like `my_class`, simply pass it as your second argument.

```php
new Premise_Tabs( $tabs, 'my_class' );
```

Then in your CSS, reference it this way: 

```CSS
.ptabs-wrapper.ptabs-my_class {
	/* all your CSS here will override the CSS from Premise Tabs */
}
```

**Note:** All tabs by default have the class `.ptabs-wrapper` attached to
their main wraopper `div` and all the CSS is scoped to that class. So it is safe to always prefix your
CSS with that class to ensure that it overrides the CSS from Premise Tabs.

### Using The Raw Feature

The `raw` argument is the third argument this class takes and it is useful when
you dont want any of the JavaScript or the CSS to load, none of it!  

```php
new Premise_Tabs( $tabs, 'my_class', true );
```  

Now you can apply (not override) the css, this way:

```css
.ptabs-my_class {
	/* your code here
	But you will also have to write your own JS */
}
```

Uses [Grunt](http://gruntjs.com/getting-started).

======

# Changelog
* **2.0.0:** Simplified the use of the Premise_Tabs to 3 arguments:
	* Tabs: _Requied_ an array of arrays containing the information for each tab.
		```php
		array(
			'title' => '',
			'icon' => '',
			'content' => '',
		)
		```
	* Options: _Optional_ a string to add as class or array with options.
	* Raw: _Optional_ a boolean value. true removes `ptabs-wrapper` class from main wrapper. Default if false

