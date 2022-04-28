[](https://travis-ci.org/Automattic/_s)

_s-plus
=======

¡Hola! soy un tema para Wordpress llamado `_s-plus`. Lo se, soy muy parecido a `_s` o tambien `underscore`, y esto es asi porque estoy basado en el, pero con muchas funcionalidades avanzadas que una vez conozcas podran ahorrarte tiempo valioso.

La idea detras de este tema es ser una base solida para creacion de temas personalizados en conjunto con ACF. No intenta dar un estilo prestablecido, ni marcar algun tipo de tendencia grafica. Cuando lo instales notaras que practicamente esta en blanco(bueno, refiriendonos al aspecto visual).

Estas son las funcionalidades mas destacadas:

* Flujo de trabajo automatizado con `gulp`; listo para usar.
* Estructura de archivos mejorada.
* Compatibilidad de `smooth-scroll` para todos los navegadores(incluyendo Safari).
* Mejoras en el manejo de imagenes.
* Configuraciones generales accesibles.
* Una base solida para agregar opciones al `customizer`
* Funciones utilitarias para el `WP Loop`.
* Facil implementacion de **ACF** (Gutenbergs Blocks y Flexible Content).
* Integracion de grid básica
* Construcción funcional de menu responsive.
* Mejoras de accesibilidad
* Ayudantes para SASS/CSS.

Instalación
------------

### Requerimientos

`_s-plus` requiere de las siguientes dependencias:

- [Node.js](https://nodejs.org/)

### Setup

To start using all the tools that come with `_s-plus`  you need to install the necessary Node.js dependencies:

```sh
$ npm install
```

### Inicio rapido

Clone or download this repository, change its name to something else (like, say, `theme-name`), and then you'll need to do a six-step find and replace on the name in all the templates. Para hacer esto hay dos formas, la rapida y la estandar. La rapida consiste en ir al `gulpfile.js` y establecer en el parametro `slug_theme` el **Text Domain** del tema. Ahora en consola(recuerda antes instalar las dependencias), ejecutas:

```sh
$ gulp replace_slug_theme
```

Con eso bastara. El metodo estandar trata de hacerlo manual, ejecutamos los siguientes pasos asegurandote que la sensibilidad de mayusculas/minisculas este activada a la hora de buscar y reemplazar con tu editor de codigo favorito.

1. Search for `'_s_plus'` (inside single quotations) to capture the text domain and replace with:`'theme-name'`.
2. Search for `_s_plus_` to capture all the functions names and replace with:`theme_name_`.
3. Search for `Text Domain: _s_plus` in `style.css` and replace with:`Text Domain: theme-name`.
4. Search for ` _s_plus` (with a space before it) to capture DocBlocks and replace with:` theme_name`.
5. Search for `_s_plus-` to capture prefixed handles and replace with:`theme-name-`.
6. Search for `_S_PLUS_` (in uppercase) to capture constants and replace with:`THEME_NAME_`.

Opcionalmente, para el prefijo de las utilidades, reemplace `sp_` por `theme_name_`.

## Caracteristicas

### Tareas automatizadas con gulp

`_s_plus` viene con un conjunto de tareas listas para que funcionen casi al instante.

Solo edita el archivo `gulpfile.js` busca el apartado **`BASIC SETUP`** y establece en el parametro `urlBrowserSync` la url del servidor local de tu proyecto. Los demas campos son opcionales; sientete libre de editarlos a tus necesidades.

**De manera general estas son las tareas:**

* SASS/CSS: compila, optimiza y minifica.
* JS: Concatena todos los scripts, transforma ES6 a ES5 con Babel 8 y los minifica. Para agregar mas scripts para concatener abre `gulpfile.js` y busca el apartado **`JS TASK`**.
* ICONS: Al agregar iconos `.svg` al directorio `assets/source/icons` se genera automaticamente una hoja de estilo para uso.
* AUTO-RELOAD: Injecta CSS automaticamente, recarga el navegador al guardar los archivos de plantillas `.php`.
* AUTO-IMPORT: No te preocupes de estar pendiente de importar manualmente cada archivo `sass` nuevo. Esta tarea genera de manera automatica los`import` de todos los archivos que estan dentro de determinados directorios. Los directorios son: `/assets/source/scss/acf/blocks`, `/assets/source/scss/acf/components` y `/assets/source/scss/site`.

### Estructura de archivos mejorada

Aunque este punto puede ser subjetivo, menos siempre es mejor. La organizacion de archivos tiene como fin la facil busqueda de las opciones comunes. A veces es abrumador tener lleno el directorio raiz del tema, es por eso que los archivos comunes de Wordpress(single.php, page.php, 404.php, etc) estan dentro de template-parts, y siguen funcionando como se debe porque el index.php raiz hace el trabajo. Si no te gusta esto. Sencillamente regresa los archivos al directorio raiz y listo. El funcionamiento de jerarquia de plantillas de Wordpress se comporta sin diferencias.

### Compatibilidad de `smooth-scroll`

Al momento de escribir esto, la mayoria de los navegadores modernos tiene soporte nativo, pero para los que no, se ha agregado un polyfill para solucionarlo. Si deseas un offset para compensar el menu sticky(si lo usas), ubica main.js y cambia la variable offset para el numero de pixeles de offset.

### Mejoras en el manejo de imagenes.

Entre las mejoras estan:

1. Uso de[vainilla-lazyload library](https://github.com/verlok/vanilla-lazyload) para la carga de imagenes. Actualmente la mayoria de los navegadores soportan lazyload atributo, pero vainilla-lazyload library demuestra un mejor rendimiento, con acceso de otras increibles opciones.
2. Se creo una funcion llamada `sp_img_resp`, la cual permite solicitar una imagen dado ID y tamaño de imagen, con notacion responsive. Si vainilla-lazyload library esta activo en la cola de scripts de WP, entonces se acoplara para que funcione sin problemas. Cabe destacar que dicha funcion puede ser utilizada en el `WP Loop`, por defecto tomara el ID del elemento actual del loop.
3. En caso de errores, producidos por ID inexistentes o tamaños de imagen incorrectos, se tomaran decisiones alternativas automaticamente para evitar errores visuales. Por ejemplo si no existe la imagen solicitada entonces se generara una imagen placeholder en su lugar.
4. Se ha añadido de forma campacta la funcionalidad de[Imsanity plugin](https://es.wordpress.org/plugins/imsanity/). En resumen, reescalara automaticamente imagenes mayores a 2000px de ancho. Si se detecta que Imsanity esta activo, entonces dicha funcionalidad se desactiva para utilices el plugin en su lugar, sin conflictos.
5. Se han deshabilitado el escalado de imagenes predeterminado de Wordpress. Un poco de contexto: Wordpress actualmente reescalara las imagenes mayores que 2000px, y se le asignara el pos-fijo `scaled`. Esta imagen en la BD se utiliza para el tamaño de imagen`full`. Aunque parece buena idea, la funcionalidad por defecto conserva la imagen original, aunque nunca mas sea utilizada. Un gran espacio desperdiciado.
6. Se han desactivado los tamaños de imagen intermedios, los cuales es posible que no los utilices, ni sepas que se generan. Puedes volverlos a activar si deseas.

### Facil configuración

Las configuraciones comunes de Wordpress como widgets, tamaños de imagenes, menus, estilos y scripts han sido ordenados para ser accesibles con facilidad. Ve a `includes/_setup/`; comprueba tu mismo.

### Facil implementacion de customizer

El tema trae una plantilla de configuracion para agregar campos al customizer. Ve a `includes/others/settings_customizer.php`. De forma predeterminada la inclusion de ese archivo esta deshabilitado; habilitalo en functions.php en el apartado *|> Widgets*.

### Funciones utilitarias

En el dia a dia hay tareas repetitivas que se hacen mejor con funciones para mejorar la legibilidad del codigo y el mantenimiento. Son pocas, pero te ayudaran mucho.

* **sp_get_img__url()** Obtiene la url de imagen dado un ID y tamaño de imagen. ID no es obligatorio, se tomara el ID del elemento actual dentro del loop.
* **sp_get_img__alt()** Obtiene el texto alternativo de una imagen dado el ID. ID no es obligatorio, se tomara el ID del elemento actual dentro del loop
* **sp_get_cat__name()** Obtiene el nombre de la primer categoria asignada al post actual dentro del loop.
* **sp_get_cat__url()** Obtiene la url de la primer categoria asignada al post actual dentro del loop.
* **sp_the_excerpt()** Obtiene el extracto de la publicacion actual dado un limite de palabras.
* **sp_img_resp()** Genera un elemento html de imagen completo con notacion responsive, dado el tamaño de imagen e ID. El ID no es obligatorio.
* **sp_get_asset()** Obtiene la ruta del recurso especificado, ubicado en`assets/source/img/`.

### Uso con Advanced Custom Fields(ACF)

El tema esta listo para usar **`flexible content`** y **`acf blocks`**, juntos o separados. Ademas trae ejemplos de componentes y bloques para un rapido comienzo. Recuerda que es necesario tener ACF Pro y sincroniza los archivos JSON para poder ver los grupos de campos personalizados en el panel de ACF.

De forma predeterminado los dos metodos de construccion estan activados. Si solamente deseas utilizar un metodo, por orden y comodida puede eliminar el otro.

* **Dejar solamente ACF Blocks**

Elimina la carpeta `ACF/flexible-content/`, y los siguientes archivos: `ACF/acf-generate-layout.php` y `ACF/acf-generate-page.php`.

* **Dejar solamente flexible content**

Elimina la carpeta `ACF/blocks`. Ahora en el archivo `includes/others/acf.php` busca el apartado ***`|> Register blocks for ACF`*** y eliminalo.

#### Notas sobre flexible content

De forma predeterminada la estructura para **`flexible content`** es anidada; consta primero de columnas y luego componentes (`Add column > Add component`). Dicha estructura es util para composiciones complejas. Si solo deseas utilizar el enfoque clasico donde se añaden componentes (`Add component`)directamente entonces tendras que hacer unos pequeños cambios para adaptarlo.

1. Ir al admin de grupos ACF y borrar o desactivar el grupo `[BUILDER] LAYOUT`.
2. Entrar a `[BUILDER] PAGE`, activarlo y configurarlo para que se muestre en las paginas(o donde desees).
3. En `includes/others/acf.php` establecer la constante **`ACF_NESTED`** en `false`.

### Grid layout

Trae integrada un sistema grid basado en Boostrap pero mucho mas compacto.

### Menu responsive

No necesitas invertir mucho tiempo en hacer el menu responsive. Solo agrega elementos al menu principal y en movil funcionara perfectamente. Viene preparado hasta tres niveles de profundidad. Si necesitas cambiar el breakpoint del menu ve a `assets/source/scss/site/header.scss` y cambia la variable **`$breakpoint_menu`**.

### Mejoras de accesibilidad

* Link Skip to Content
* Sub menus del header accesibles desde el teclado
* En menu responsive se añaden botones para la expansicion de sub-menus
* Correcto etiquetado de elemento H1. En homepage el elemento h1 es el nombre del sitio, en el resto no.

### Ayudantes de SASS

_s_plus incluye una serie de mixins que una vez entiendas como utilizar el proceso sera mas facil. Estos son algunos de los mas relevantes:

* **Propiedades responsives:** Con el mixin `interpolate` puedes utilizar propiedades responsives. Entre sus caracteristicas estan:
  * Uso de diferentes unidades, puede ser rem, em o px.
  * Implementar la propiedad `important` si es necesario
  * Uso de unidades negativas. Util cuando necesitamos por ejemplo un margin de positivo a negativo o vicerversa por necesitades de diseño.
  * Creacion de variables CSS.
  * Se incluye la correccion para el funcionamiento en Safari
  * Implementacion de media query en unidades em por buena practica.[Vea el motivo aqui.](https://zellwk.com/blog/media-query-units/)
  * Incluye una serie de shorthands. Por ejemplo puedes utilizar los mixin font-size, margin(con todas su varientes), padding(con todas sus varientes) y rfs; esta ultima para cualquier otra propiedad.
