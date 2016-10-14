# Ride: Template Minifier (Smarty)

Smarty plugins for the Ride framework, used to minify and include javascript/css files in templates.

## Code Sample

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
{style src="css/print.css" media="print"} {* Optional media parameter, defaults to 'all' *}

{* minify css files and include them in the template *}
{styles}
```

## Related Modules 

- [ride/app](https://github.com/all-ride/ride-app)
- [ride/app-image](https://github.com/all-ride/ride-app-template)
- [ride/app-template](https://github.com/all-ride/ride-app-template)
- [ride/app-template-smarty](https://github.com/all-ride/ride-app-template-smarty)
- [ride/lib-image](https://github.com/all-ride/ride-lib-i18n)
- [ride/lib-minifier](https://github.com/all-ride/ride-lib-minifier)
- [ride/lib-template](https://github.com/all-ride/ride-lib-template)
- [ride/lib-template-smarty](https://github.com/all-ride/ride-lib-template-smarty)
- [ride/web](https://github.com/all-ride/ride-web)
- [ride/web-minifier](https://github.com/all-ride/ride-web-api)
- [ride/web-template](https://github.com/all-ride/ride-web-template)
- [ride/web-template-smarty](https://github.com/all-ride/ride-web-template-smarty)

## Installation

You can use [Composer](http://getcomposer.org) to install this application.

```
composer require ride/web-template-smarty-minifier
```
