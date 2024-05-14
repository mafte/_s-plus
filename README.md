_s-plus
=======
<p>
<img src="screenshot.png" width="1000" />

</p>

Hello! I'm a WordPress theme called `_s-plus`. I know, I'm very similar to `_s` or also `underscore`, and that's because I'm based on it, but with many extra functionalities that once you get to know them, can save you valuable time.

The idea behind this theme is to be a solid base for creating custom themes in conjunction with ACF. It doesn't try to give a predefined style or set any graphical trend. When you install it, you'll notice that visually it's almost blank.

Here are the most outstanding features:

* Automated workflow with `gulp`; ready to use.
* Optimized file structure.
* Improved image handling.
* Accessible general settings.
* Template for adding options to the `customizer`.
* Utility functions for the `WP Loop`.
* Easy implementation of ACF (Gutenberg Blocks and Flexible Content).
* Basic CSS grid integration.
* Fully functional responsive menu.
* Accessibility improvements.
* Utilities for SASS/CSS.

Installation
------------

### Requirements

`_s-plus` requires the following dependencies:

* [Node.js](https://nodejs.org/)

### Setup

To start using all the tools that come with `_s-plus`, you must install the necessary Node.js dependencies:

```sh
$ npm install
```

### Quick Start

Clone or download this repository, rename it (like, let's say, `theme-name`), and then you should search and replace the name in all templates. You can do this in two ways: semi-automatic and manual. The semi-automatic way involves going to the `gulpfile.js` file and setting the **Text Domain** of the theme in the `slug_theme` parameter. Now, in the terminal (with all dependencies installed), run:

```sh
$ gulp replace_slug_theme
```

The manual method involves searching and replacing the name in six steps, ensuring that the case sensitivity is activated.

1.  Search for `'_s_plus'` (inside single quotes) to capture the text domain and replace it with `'theme-name'`.
2.  Search for `_s_plus_` to capture all function names and replace them with: `theme_name_`.
3.  Search for `Text Domain: _s_plus` in `style.css` and replace it with `Text Domain: theme-name`.
4.  Search for `_s_plus` (with a space before) to capture DocBlocks and replace it with `theme_name`.
5.  Search for `_s_plus-` to capture prefixed identifiers and replace them with: `theme-name-`.
6.  Search for `_S_PLUS_` (in uppercase) to capture constants and replace with: `THEME_NAME_`.

Optionally, for utility prefixing, replace `sp_` with `theme_name_`.

Features
--------

### Automated tasks with gulp

`_s_plus` comes with a set of tasks ready to run almost instantly.

Simply edit the `gulpfile.js` file, go to the **BASIC SETUP** section, and set the `urlBrowserSync` parameter to your local project's URL. The other fields are optional; feel free to edit them as per your needs.

**In general, these are the tasks:**

* SASS/CSS: compiles, optimizes, and minifies.
* JS: Concatenates all scripts, transforms ES6 to ES5 with Babel 8, and minifies them. To add more scripts, open `gulpfile.js` and look for the **`JS TASK`** section. There are two arrays `vendors` and `customs`. Scripts in `vendors` will only concatenate, while those in `customs` will be analyzed with Babel.
* ICONS: Adding `.svg` icons to the `assets/icons` directory automatically generates a style sheet for use.
* AUTO-RELOAD: Automatically injects CSS, reloads the browser when saving `.php` template files.
* AUTO-IMPORT: No need to worry about manually importing each new `.scss` file. This task automatically generates `imports` for all files within specific directories. These directories are: `/assets/scss/blocks`, `/assets/scss/components`, and `/assets/scss/site`.

### Enhanced file structure

Although this point may be subjective, _**less is always more**_. Files have been reorganized to make common options easier to find. Sometimes having the theme's root directory crowded can be overwhelming, which is why general template files of WordPress hierarchy (single.php, page.php, 404.php, etc.) are within the `/template-parts` folder; everything still works as it should because the `index.php` file in the theme's root redirects to the appropriate template. If you don't like this, simply move the files back to the root directory, and the WordPress template hierarchy will function without differences.

### Compatibility with `smoothScroll`

At the time of writing this, most modern browsers have native support for smooth-scroll (not to be confused with smoothScrollBar), but for those that don't, a polyfill has been added to resolve it. If you need an offset to compensate for using a sticky menu (if you're using one), in the `/assets/js/main.js` file, find the **`● SMOOTH SCROLL`** section and change the **`offset`** variable to the necessary number of pixels. By default, this is disabled.

### Improved image handling.

Improvements include:

1.  Use of [vanilla-lazyload library](https://github.com/verlok/vanilla-lazyload) for image loading. Currently, most browsers support the lazyload attribute, but `vainilla-lazyload` library shows better performance.
2.  Utilization of responsive images through the `sp_resp_img` function. Here are some notes about this function:
    * It allows generating a [responsive image with markup](https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Responsive_images) given an ID and image size.
    * If `vainilla-lazyload` library is active in WP script queue, it will integrate seamlessly.
    * It can be used in the WP Loop without specifying the image ID; by default, it fetches the featured image of the current post within the WP loop.
    * This function handles common errors. If the image ID doesn't exist, it generates a placeholder image; if the ID is correct but the provided image size isn't, it defaults to a valid size, typically `large`.
3.  Default WordPress image scaling for images larger than `2560px` has been disabled. A bit of context: Since WordPress 5.3, images larger than `2560px` are automatically rescaled and a `scaled` postfix is added. Although it seems like a good idea, the default functionality retains the original image even if it's never used again, which isn't what most cases need.
4.  Compact addition of [Imsanity plugin](https://es.wordpress.org/plugins/imsanity/) functionality. Its basic function is to automatically rescale images wider than `2000px`. If the `Imsanity` plugin is detected as active, it will take priority to avoid conflicts.
5.  Intermediate image sizes ('1536x1536', '2048x2048') have been disabled, which you may not use or even know they are generated. You can re-enable them if needed.

### Easy configuration

Common WordPress settings (widgets, image sizes, menus, styles, and scripts) have been divided into individual files for easier accessibility and code maintenance. Check them out in `/includes/base/`.

### Quick customizer setup

The theme comes with a configuration template to add fields to the customizer. Go to `includes/features/settings_customizer.php`. By default, inclusion of this file is disabled; enable it in `functions.php` under the _●❱ CUSTOMIZER_ section.

### Utility functions

Day-to-day repetitive tasks are better handled with functions to improve code readability and maintenance. There are a few, but very useful ones.

* **sp_img_resp()** Generates a complete HTML image element with responsive notation, given image size and ID. ID is optional; it will take the current element's ID within the WP loop by default.
* **sp_get_img__url()** Gets the image URL given an ID and image size. ID is optional; it will take the current element's ID within the WP loop by default.
* **sp_get_img__alt()** Gets the alternative text of an image given the ID. ID is optional; it will take the current element's ID within the WP loop by default.
* **sp_get_cat__name()** Gets the name of the first category assigned to the current post within the WP loop.
* **sp_get_cat__url()** Gets the URL of the first category assigned to the current post within the WP loop.
* **sp_the_excerpt()** Gets the excerpt of the current post within the WP loop with a word limit.
* **sp_get_asset()** Gets the path of the specified resource located in `/assets/img/`.

### Use with Advanced Custom Fields(ACF)

The theme is ready for use with **`flexible content`** and **`acf blocks`**, together or separately. It also includes examples of components and blocks for a quick start. You need to have the ACF Pro plugin installed and sync the JSON files to see the custom field groups in the ACF admin panel.

By default, both building methods are activated. If you only want to use one method, you can delete the other for simplicity.

* **Keep only ACF Blocks**

Delete the `/ACF/flexible-content/` folder and the following files: `/ACF/acf-generate-layout.php` and `/ACF/acf-generate-page.php`.

* **Keep only flexible content**

Delete the `/ACF/blocks` folder. Now in the `/includes/features/acf.php` file, change the `ACF_ONLY_CP` constant to `true`.

#### Notes on flexible content

By default, the structure for **`flexible content`** is nested; it consists of columns first and then components (`Add column > Add component`). This structure is useful for complex compositions. If you only want to use the classic approach where components are added directly (`Add component`), you need to make some small changes to adapt.

1.  Go to the ACF field groups admin and delete or disable the `[BUILDER] LAYOUT` group.
2.  Go to the `[BUILDER] PAGE` field group, and enable it. By default, it's displayed on pages.
3.  In `/includes/features/acf.php`, set the `ACF_NESTED` constant to `false`.

### Grid layout

It includes a CSS grid system based on Bootstrap but much more compact.

### Responsive menu

You don't need to spend a lot of time making the menu responsive. Simply add items to the main menu, and it will be practically ready. It's prepared for up to three levels deep. If you need to change the menu breakpoint, go to `/assets/scss/site/header.scss` and change the **`$breakpoint_menu`** variable.

### Accessibility improvements

* Includes the **Skip to Content** link.
* Header menu and sub-menus are keyboard accessible.
* Mobile menu adapted for a better experience.
* Proper H1 element tagging. On the homepage, the H1 element is the site name, on other pages it's appropriately tagged.

### SASS helpers

`_s_plus` includes a series of mixins that once you understand how to use them, the process becomes faster. Here are some of the most relevant:

* **interpolate:** Allows using responsive properties. Its features include:
    * Handles different units (`rem, em, or px`).
    * Supports using the `!important` property.
    * Allows negative units.
    * Allows using CSS variables instead of a property.
    * Includes correction for Safari functioning.
    * Automatically converts units in media queries to `em`. [See why here.](https://zellwk.com/blog/media-query-units/)
    * Uses shorthands. For example: font-size, margin (with all variants), padding (with all variants), and rfs; the latter for any other property.
* **m_query:** Allows creating media queries more quickly.
    * By default, media queries are `max-width` type.
    * Accepts `rem, em, or px`.
    * Automatically converts the breakpoint to `em`. [See why here.](https://zellwk.com/blog/media-query-units/)
    * Subtracts .02 pixels from default media query to avoid screen overlaps. [See more details here.](https://getbootstrap.com/docs/5.2/layout/breakpoints/#max-width)