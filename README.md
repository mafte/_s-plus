[![Build Status](https://travis-ci.org/Automattic/_s.svg?branch=master)](https://travis-ci.org/Automattic/_s)

_s-plus
=======

¡Hola! soy un tema para Wordpress llamado `_s-plus`. Lo se, soy muy parecido a `_s` o tambien `underscore`, y esto es asi porque soy basado en `_s` pero con muchas funcionalidades avanzadas que una vez me examines podran ahorrarte algo de tiempo valioso.

La idea detras de este tema es ser una base solida para creacion de temas personalizados en conjunto de ACF. No intenta dar un estilo prestablecido, ni ser unicamente dirigido a un tipo de proyecto. Cuando lo instales notaras que practicamente esta en blanco, bueno aunque sea en el aspecto visual.

Estas son las funcionalidades mas destacadas:

* Flujo de trabajo automatizado con `gulp`, listo para usar.
* Estructura de archivos mejorada.
* Compatibilidad de `smooth-scroll` para todos los navegadores(incluyendo Safari).
* Mejoras en el manejo de imagenes.
* Configuraciones generales facilmente cambiables.
* Facil uso de implementacion personalizada del `customizer`
* Funciones utilitarias para el `loop`.
* Facil implementacion de **ACF** (Blocks y Flexible Content).
* Integracion de grid basica
* Construccion funcional de menu responsive.
* Mejoras de accesibilidad
* Ayudantes para `sass/css`.
* Y casi todas las demas mejoras incluidas en `_s`.

Instalación
------------

### Requerimientos

`_s-plus` requiere de las siguientes dependencias:

- [Node.js](https://nodejs.org/)

### Inicio rapido

Clone or download this repository, change its name to something else (like, say, `theme-name`), and then you'll need to do a six-step find and replace on the name in all the templates.

1. Search for `'_s_plus'` (inside single quotations) to capture the text domain and replace with: `'theme-name'`.
2. Search for `_s_plus_` to capture all the functions names and replace with: `theme_name_`.
3. Search for `Text Domain: _s_plus` in `style.css` and replace with: `Text Domain: theme-name`.
4. Search for <code>&nbsp;_s__plus</code> (with a space before it) to capture DocBlocks and replace with: <code>&nbsp;theme__name</code>
5. Search for `_s_plus-` to capture prefixed handles and replace with: `theme-name-`.
6. Search for `_S_PLUS_` (in uppercase) to capture constants and replace with: `THEME_NAME_`.
7. Opcionalmente, para el prefijo de las utilidades, reemplace `sp_` por `theme-name`.

Then, update the stylesheet header in `style.css`, the links in `footer.php` with your own information and rename `_s.pot` from `languages` folder to use the theme's slug. Next, update or delete this readme.

### Setup

To start using all the tools that come with `_s-plus`  you need to install the necessary Node.js dependencies :

```sh
$ npm install
```

## Caracteristicas

#### Tareas automatizadas con gulp

`_s_plus` viene con un conjunto de tareas listas para que funcionen casi al instante.

Solo edita el archivo `gulpfile.js` busca el apartado **`BASIC SETUP`** y establece en el parametro `urlBrowserSync` la url local de tu proyecto. Los demas campos son opcionales; sientete libre de editarlos a tus necesidades.

**De manera general estas son las tareas:**

* SASS/CSS: compila, optimiza y minifica.
* JS: Concatena todos los scripts, transforma ES6 a ES5 con Babel 8 y los minifica. Para agregar mas scripts para concatener abre `gulpfile.js` y busca el apartado **`JS TASK`**.
* ICONS: Al agregar iconos .svg al directorio `/assets/source/icons` genera automaticamente una hoja de estilo para usarlos rapidamente.
* AUTO-RELOAD: Injecta css automaticamente, recarga el navegador al guardar los archivos de plantillas `.php`.
* AUTO-IMPORT: No te preocupes de estar pendiente de importar cada archivo `sass` agregado. Esta tarea genera de manera automatica los `import` de todos los archivos que estan dentro de determinados directorios. Los directorios son: `/assets/source/scss/acf/blocks`, `/assets/source/scss/acf/components`y`/assets/source/scss/site`.
