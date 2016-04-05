# ride-web-template-smarty-minifier

Smarty plugins for the Ride framework, used to minify and include javascript/css files in templates.

## Usage

### Javascript
```smarty
{script src="js/jquery.js"}
{script src="js/main.js"}

{* minify javascript files and include them in the template *}
{scripts}
```

### CSS
```smarty
{style src="carbon/css/main.css"}
{style src="css/print.css" media="print"} {* Optional media parameter, defaults to 'screen' *}

{* minify css files and include them in the template *}
{styles}
```