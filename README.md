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
own code. This is called a "Skin". [See an example on ho to create your own skin here](#creating-your-own-skins). 

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

Options can be a string or an array. When used as a string, they are referred to as "skins",
there are four built in "skins" in Premise Tabs `top`, `left`, `right`, and `bottom`. They each
represent where the tabs are placed.

```php

new Premise_Tabs( $tabs, 'top' );    // display tabs at the top
new Premise_Tabs( $tabs, 'bottom' ); // display tabs at the bottom
new Premise_Tabs( $tabs, 'left' );   // displays tabs stacked on the left
new Premise_Tabs( $tabs, 'right' );  // displays tabs stacked on the right

```  

Basically, when this option is used as a string it adds a class to the main wrapper in addition to its own class.
The class is always prefixed with `ptabs-`, so if you pass a class `my_skin` you would reference it like this in 
your CSS `.ptabs-my_skin`.

## Creating Your Own Skins

Lets say we are creating a skin called `my_skin`, simply pass it as your second argument.

```php
new Premise_Tabs( $tabs, 'my_skin' );
```

Then in your CSS, reference it like this: 

```CSS
.ptabs-wrapper.ptabs-my_skin {
	/* all your CSS here will override the CSS from Premise Tabs */
}
```

**Note:** All tabs by default have the class `.ptabs-wrapper` attached to
their main wrapper `div` and all the CSS is scoped to that class. So it is safe to always prefix your
CSS with `.ptabs-wrapper` to ensure that it overrides the CSS from Premise Tabs.

## Using The Raw Feature

The `raw` argument is the third argument this class takes and it is useful when
you dont want any of the JavaScript or the CSS to load, none of it!  

```php
new Premise_Tabs( $tabs, 'my_skin', true );
```  

Now you can apply (not override) the css, this way:

```css
.ptabs-my_skin {
	/* your code here
	But you will also have to write your own JS */
}
```

## The Markup  

By default, premise tabs outputs the markup for the tabs as follows:

```html
<div class="ptabs-wrapper ptabs-top">
	<div class="ptabs-tabs-container">
		<div class="ptabs-tab ptabs-tab-0 ptabs-active" data-tab-index="0">
			<a href="javascript:;" class="ptabs-tab-a">
				<div class="ptabs-tab-icon">
					<i class="fa fa-plus"></i>
				</div>
				<div class="ptabs-tab-title">
					Tab 1
				</div>
			</a>
		</div>
		<!-- More Tabs load here... -->
	</div>
	<div class="ptabs-content-container">
		<div class="ptabs-content ptabs-content-0 ptabs-active">
			<div class="ptabs-content-inner">
				# Content for Tab 1 Goes here
			</div>
		</div>
		<!-- Content for other tabs loads here... -->
	</div>
</div>
```  

As you can see the markup is created with the tabs and content in separate divs. We think this approach
is easier to work with, especially in responsive. 

To display the content inside the tabs, pass `content_in_tab => true` as part of your arguments array for
the second argument. Here is an example:  

```php
/**
 * insert tabs with the content inside the tabs
 */
new Premise_Tabs( $tabs, array(
	'skin' => 'top',           // Optional, defaults to 'top'
	'content_in_tab' => true  // When true puts content in tab. Defaults to false
) );
```  

The code above will output the content inside the tabs and will output the tabs as `<li>` elements. Here is how that markup looks like:  

```html
<div class="ptabs-wrapper ptabs-top">
	<div class="ptabs-tabs-inner">
		<ul class="ptabs-tabs-ul">
			<li class="ptabs-tab ptabs-tab-0 ptabs-tab-li ptabs-active" data-tab-index="0">
				<a href="javascript:;" class="ptabs-tab-a">
					<div class="ptabs-tab-icon">
						<i class="fa fa-plus"></i>
					</div>
					<div class="ptabs-tab-title">
						Tab 1
					</div>
				</a>
				<div class="ptabs-content ptabs-content-0 ptabs-active">
					<div class="ptabs-content-inner">
						# Content for tab1 goes here
					</div>
				</div>
			</li>
			<!-- More Tabs load here... -->
		</ul>
	</div>
</div>
```

Uses [Grunt](http://gruntjs.com/getting-started).

======

### Changelog
* **2.0.0:** Simplified the use of the Premise_Tabs class to 3 arguments:
	* Tabs: _Requied_ array containing the information for each tab.
	* Options: _Optional_ string to add as skin or array with options.
	* Raw: _Optional_ boolean true returns raw html. Default is false
	* Added basic styles for 4 different "skins" - `top`, `bottom`, `left`, `right`.

