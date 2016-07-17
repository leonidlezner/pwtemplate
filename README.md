# PWTemplate
Processwire basic template by Leonid Lezner.

**Gulp** is used for stylesheet and JS automation, **Stylus** is used for writing beautiful CSS files. **PostCSS** simply makes you life easier.

## Installation

Clone the repository to the site folder of your ProcessWire installation. Add following lines to the config.php:

```
$config->appendTemplateFile = '_main.inc';
$config->prependTemplateFile = '_init.inc';
```

## Compiling the styles

Go to the **src** folder and install the nodeJS dependencies first:

```
npm install
```

After the installation compile the sources with following command:

```
gulp
```

Watch the folder for changes, recompile css, styles and reload the browser with:

```
gulp watch
```

## More information

* Node.js: https://nodejs.org/en/
* Gulp: http://gulpjs.com/
* PostCSS: https://github.com/postcss/postcss
* Stylus: http://stylus-lang.com/
