[![Build Status](https://travis-ci.org/Automattic/_s.svg?branch=master)](https://travis-ci.org/Automattic/_s)

_s-plus
=======

¡Hola! soy un tema para Wordpress llamado `_s-plus`. Lo se, soy muy parecido a `_s` o tambien `underscore`. Estoy basado en `_s` pero con muchas funcionalidades avanzadas que una vez me examines podran ahorrarte algo de tiempo valioso.

La idea detras de este tema es ser una base solida para creacion de temas personalizados en conjunto de ACF. No intenta dar un estilo prestablecido, ni ser plantilla para algun tipo especial de proyecto. Cuando lo instales notaras que practicamente esta en blanco, bueno aunque en el aspecto visual.

Estas son las funcionalidades mas destacadas del tema:

* Flujo de trabajo automatizado con `gulp`, listo para usar.
* Estructura de archivos mejorada.
* Compatibilidad de `smooth-scroll` para todos los navegadores(incluyendo Safari).
* Mejoras con el manejo de imagenes.
* Configuraciones generales facilmente cambiables.
* Facil uso de implementacion personalizada del **Customizer**
* Funciones utilitarias para `theLoop`.
* Uso facil con **ACF** (Blocks y Flexible Content).
* Implementacion de grid basica
* Implementacion de Menu responsive
* Mejoras de accesibilidad
* Ayudantes para `sass/css`.
* Todas las demas mejoras de `_s`.

Instalación
------------

### Requerimientos

`_s-plus` requiere de las siguientes dependencias:

- [Node.js](https://nodejs.org/)

### Inicio rapido

Clone or download this repository, change its name to something else (like, say, `megatherium-is-awesome`), and then you'll need to do a six-step find and replace on the name in all the templates.

1. Search for `'_s_plus'` (inside single quotations) to capture the text domain and replace with: `'theme-name'`.
2. Search for `_s_plus_` to capture all the functions names and replace with: `theme-name_`.
3. Search for `Text Domain: _s_plus` in `style.css` and replace with: `Text Domain: theme-name`.
4. Search for <code>&nbsp;_s-plus</code> (with a space before it) to capture DocBlocks and replace with: <code>&nbsp;theme-name</code>
5. Search for `_s_plus-` to capture prefixed handles and replace with: `theme-name-`.
6. Search for `_S_PLUS_` (in uppercase) to capture constants and replace with: `THEME_NAME_`.
7. Opcionalmente, para el prefijo de las utilidades, reemplace `sp_` por `theme-name`.

Then, update the stylesheet header in `style.css`, the links in `footer.php` with your own information and rename `_s.pot` from `languages` folder to use the theme's slug. Next, update or delete this readme.

### Setup

To start using all the tools that come with `_s`  you need to install the necessary Node.js and Composer dependencies :

```sh
$ composer install
$ npm install
```

### Available CLI commands

`_s` comes packed with CLI commands tailored for WordPress theme development :

- `composer lint:wpcs` : checks all PHP files against [PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/).
- `composer lint:php` : checks all PHP files for syntax errors.
- `composer make-pot` : generates a .pot file in the `languages/` directory.
- `npm run compile:css` : compiles SASS files to css.
- `npm run compile:rtl` : generates an RTL stylesheet.
- `npm run watch` : watches all SASS files and recompiles them to css when they change.
- `npm run lint:scss` : checks all SASS files against [CSS Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/css/).
- `npm run lint:js` : checks all JavaScript files against [JavaScript Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/javascript/).
- `npm run bundle` : generates a .zip archive for distribution, excluding development and system files.

Now you're ready to go! The next step is easy to say, but harder to do: make an awesome WordPress theme. :)

Good luck!
