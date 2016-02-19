# Premise Tabs plugin

Build tabs markup quikly and customize it for your own project.  

This plugin builds and outputs the markup for responsive tabs. It is meant to be extremely flexible
yet basic so you can easily override or customize the tabs to your liking without having to hack
a bunch of code. 

### The Basic Syntax

This class accepts 3 arguments:  

`$tabs` | (required) - an array of arrays containing the tabs  
___     | ___
`$options` | (optional) - a string or array to define [options](#options)  
`$raw` | (optional) - boolean value, on false does not bind JS or CSS, default is true.

``new Premise_tabs( $tabs, 'top', false )``

To avoid loading unnecessary libraries this plugin uses its own JS code which you can expand on, or 
completely prevent from running by passing a third argument with a boolean value of true.  

This plugin is built for developers in the sense that is meant to be used with ease 
in any scenario where tabs could be necessary. Building the minimum amount of markup necessary (or the 
"base Markup" as we call it), we allow you to build on top of our code, rather than try to change it. 

For example, if you want to change the CSS simply pass a class as your second argument and use it in your
own code. [See an example here](#overriding-css). If you really want to go "Bare Bones" sort of speak, pass 
a third argument with a `boolean` value `true` and none of our CSS or JS will even load. You literally get 
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

**Options:** 

```php

new Premise_Tabs( $tabs, 'top' ); // display tabs at the top
new Premise_Tabs( $tabs, 'bottom' ); // display tabs at the bottom
new Premise_Tabs( $tabs, 'left' ); // displays tabs stacked on the left
new Premise_Tabs( $tabs, 'right' ); // displays tabs stacked on the right

```  

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

**The `raw` Feature:** The `raw` argument is the third argument this class takes and it is useful when
you dont want any of the JavaScript or the css to load, none of it!  

All you have to do is pass a boolean value `true` as your third argument. This will avoid the class
`ptabs-wrapper` from being added, which will result in no CSS or JS firing, since all the CSS and JS is
scoped to the `ptabs-wrapper` class.

Uses [Grunt](http://gruntjs.com/getting-started).