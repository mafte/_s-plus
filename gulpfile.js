const gulp = require("gulp");
const fs = require("fs"); /* Permite leer y escribir archivos en el SO. Ocupado para generar stylesheets de iconos */

/*
——— CSS
*/
const sass = require('gulp-sass')(require('sass'));
//var CleanCSSNEW = require('clean-css');
const cleanCSS = require('gulp-clean-css'); /* Optimize and clean CSS */
const autoPrefixer = require("gulp-autoprefixer"); /* Añade prefijos a propiedades css */

/*
——— JS
*/
const uglify = require("gulp-uglify"); /* Comprime JavaScript */
// const jshint = require("gulp-jshint"); /* Analiza la calidad de js */
const babel = require("gulp-babel"); /* Genera codigo JS compatible con ES5 */

/*
——— Tools
*/
const browserSync = require("browser-sync"); /* Mantiene actualizado el navegador con los cambios */
const concat = require("gulp-concat"); /* Concatena archivos */
const sourcemaps = require("gulp-sourcemaps"); /* Fuente de mapas para SASS y JS */
const plumber = require("gulp-plumber"); /* Permite el manejo de los errores */
const concatFilenames = require("gulp-concat-filenames"); // import all files from folder
const lineec = require('gulp-line-ending-corrector'); // Consistent Line Endings for non UNIX systems.
const gulp_replace = require('gulp-replace'); //Busca y reemplaza string en los archivos.

/*
——— Images
*/
const svgToMiniDataURI = require("mini-svg-data-uri");
const { series } = require("gulp");


/*————————————————————————————————————————————————————*\
    ●❱ BASIC SETUP
\*————————————————————————————————————————————————————*/

var config = {
    urlBrowserSync: "pruebas.local",
    slug_theme: "slug-theme",
    BrowserList: "last 1 versions",
    pathIconsOrigin: "assets/source/icons/", //Does not work with sub directories
    pathExportIconsSheet: "assets/source/scss/_base/",
    clean_css: true,
    path_source_js: "assets/source/js/",
    path_dist_js: "assets/dist/js/",
};

/*————————————————————————————————————————————————————*\
    ●❱ BROWSER-SYNC
\*————————————————————————————————————————————————————*/

function reload(done) {
    browserSync.reload();
    done();
}

/*————————————————————————————————————————————————————*\
    ●❱ STYLES
\*————————————————————————————————————————————————————*/

function css() {
    const options = {
        compatibility: {
            properties: {
                zeroUnits: false
            }
        },
        level: 2
    };

    return gulp
        .src("assets/source/scss/style.scss")

        .pipe(sourcemaps.init())
        .pipe(plumber())
        .pipe(sass().on("error", sass.logError))
        .pipe(autoPrefixer(config.BrowserList))
        .pipe(cleanCSS(options))
        .pipe(sourcemaps.write("."))
        .pipe(gulp.dest("."))
        .pipe(browserSync.stream())
}

/*  |> SCSS - auto import
——————————————————————————————————————————————————————*/

let concatOptions = {
    root: "./assets/source/scss/",
    prepend: "@import '",
    append: "';",
};

/*
——— For site styles
*/

function scssSite() {
    return gulp
        .src("assets/source/scss/Site/*.*")
        .pipe(concatFilenames("_site.scss", concatOptions))
        .pipe(gulp.dest("./assets/source/scss"));
}

/*
——— For Gutenberg Blocks with ACF
*/

function scssBlocks() {
    return gulp
        .src("assets/source/scss/acf/blocks/*.*")
        .pipe(concatFilenames("_blocks.scss", concatOptions))
        .pipe(gulp.dest("./assets/source/scss"));
}

/*
——— For Flexible content with ACF
*/

function scssComponents() {
    return gulp
        .src("assets/source/scss/acf/components/*.*")
        .pipe(concatFilenames("_components.scss", concatOptions))
        .pipe(gulp.dest("./assets/source/scss"));
}

/*  |> Icons
——————————————————————————————————————————————————————*/

var filesNamesOriginal = [],
    filesNamesFilter = [],
    filesNamesWithoutExtension = [],
    filesContents = [];

function codeSvgs() {
    filesNamesOriginal = fs.readdirSync(config.pathIconsOrigin);

    //Filter only .svg files
    filesNamesFilter = [];
    filesNamesFilter.length = 0;
    for (let index = 0; index < filesNamesOriginal.length; index++) {
        const element = filesNamesOriginal[index];

        if (element.search(".svg") >= 0) {
            filesNamesFilter.push(element);
        }
    }

    for (let index = 0; index < filesNamesFilter.length; index++) {
        const element = filesNamesFilter[index];

        //Remove file extension
        filesNamesWithoutExtension[index] = element.replace(".svg", "");

        //Read file content
        filesContents[index] = fs.readFileSync(
            config.pathIconsOrigin + "/" + element, {
                encoding: "utf-8",
            }
        );

        //Code to use it correctly in css
        /* Automatically changes the icons from white to black. That serves to later use a class with filters, in case it is necessary to change the color */
        filesContents[index] = svgToMiniDataURI(filesContents[index]).replace(
            "fill='white'",
            "fill='black'"
        );
    }
}

function createIconSheet() {
    //Open :root
    let content = `:root {\n`;

    //Generate variables CSS
    for (let index = 0; index < filesNamesWithoutExtension.length; index++) {
        const element = filesNamesWithoutExtension[index];
        const contentSVG = filesContents[index];
        content = content + `\t--${element}: url("${contentSVG}");\n`;
    }

    //Close :root
    content = content + "}";

    //Base style for icon
    content =
        content +
        `
.icon {
    --size: 22px;
    background-repeat: no-repeat;
    background-size: contain;
    background-position: center;
    width: var(--size);
    height: var(--size);
    display: inline-block;
    transition: .3s all;
}\n`;

    //Generate icons class
    for (let index = 0; index < filesNamesWithoutExtension.length; index++) {
        const element = filesNamesWithoutExtension[index];

        content =
            content + `.${element}{ background-image: var(--${element}) };\n`;
    }

    fs.writeFileSync(
        config.pathExportIconsSheet + "_icons-sheet.scss",
        content
    );
    // console.log(content);

    /** Clear all variables */
    filesNamesOriginal = [],
        filesNamesFilter = [],
        filesNamesWithoutExtension = [],
        filesContents = [];
}

async function iconSh() {
    codeSvgs();
    createIconSheet();

    return true;
}

/*————————————————————————————————————————————————————*\
    ●❱ JS TASK
\*————————————————————————————————————————————————————*/

function js_vendors() {

    const vendors = [
        // 'node_modules/jquery/dist/jquery.min.js',
        // 'node_modules/lazyload/lazyload.min.js',
        // config.path_source_js + 'smoothscroll.min.js',
        // config.path_source_js + 'tiny-slider.min.js',
    ]

    const customs = [
        config.path_dist_js + 'production.min.js',
    ]

    let scripts = vendors.concat(customs);

    return gulp.src(scripts)
        // .pipe(sourcemaps.init())
        .pipe(plumber())
        .pipe(concat("production.min.js"))
        .pipe(lineec())
        // .pipe(sourcemaps.write("."))
        .pipe(gulp.dest(config.path_dist_js))
}

function js_custom() {

    const customs = [
        config.path_source_js + 'main.js',
    ]

    return gulp.src(customs)
        // .pipe(sourcemaps.init())
        .pipe(plumber())
        .pipe(babel({
            presets: [
                [
                    '@babel/preset-env', // Preset to compile your modern JS to ES5.
                    {
                        targets: {
                            browsers: config.BrowserList
                        } // Target browser list to support.
                    }
                ]
            ]
        }))
        .pipe(concat("production.js"))
        .pipe(lineec())
        .pipe(gulp.dest(config.path_dist_js))
        .pipe(concat("production.min.js"))
        .pipe(uglify())
        .pipe(lineec())
        .pipe(gulp.dest(config.path_dist_js))
}

/*————————————————————————————————————————————————————*\
    ●❱ MAIN TASK
\*————————————————————————————————————————————————————*/

exports.default = gulp.series(gulp.parallel(scssSite, scssBlocks, scssComponents, iconSh, js_custom), js_vendors, css, initAll);


function initAll() {

    let path_scss = "assets/source/scss/";

    browserSync.init({
        //logLevel: "info",
        //browser: ["Chrome"],
        open: "external",
        host: config.urlBrowserSync,
        proxy: config.urlBrowserSync,
        watchEvents: ["change", "add", "unlink", "addDir", "unlinkDir"],
    });

    gulp.watch(["assets/**/site/*.scss"], {
        events: ['add', 'unlink']
    }, scssSite);
    gulp.watch(["assets/**/acf/blocks/*.scss"], {
        events: ['add', 'unlink']
    }, scssBlocks);
    gulp.watch(["assets/**/acf/components/*.scss"], {
        events: ['add', 'unlink']
    }, scssComponents);

    gulp.watch(["assets/source/icons/*.svg"], iconSh);

    gulp.watch(["assets/source/js/*.js"], series(js_custom, js_vendors));

    gulp.watch(
        [
            path_scss + "**/*.scss",
            "!" + path_scss + "**/_site.scss",
            "!" + path_scss + "**/_components.scss",
            "!" + path_scss + "**/_blocks.scss",
        ],
        css
    );

    gulp.watch(["*.php", "template-parts/**/*.php", "ACF/**/*.php"], reload);

};


/*————————————————————————————————————————————————————*\
    ●❱ REPLACE SLUG THEME
\*————————————————————————————————————————————————————*/

async function replace_slug_theme() {
    if (config.slug_theme != "slug-theme") {
        return gulp.src(['*.*', '*/**/*.*', '!node_modules/**/*.*', '!gulpfile.js'], {
            base: "./"
        })

        .pipe(gulp_replace("'_s_plus'", "'" + config.slug_theme + "'")) //Replace text-domain in all files

        .pipe(gulp_replace('_s_plus_',
            (config.slug_theme.replace(/-/g, '_')).toLowerCase() + '_')) //Replace prefixed name functions

        .pipe(gulp_replace("Text Domain: _s_plus", "Text Domain: " + config.slug_theme)) //Replace Text Domain in style.css

        .pipe(gulp_replace(' _s_plus',
            (" " + config.slug_theme.replace(/-/g, '_')).toLowerCase())) //Replace DocBlocks name

        .pipe(gulp_replace('_s_plus-',
            config.slug_theme.toLowerCase() + '-')) //Replace prefixed handles

        .pipe(gulp_replace('_S_PLUS_',
            (config.slug_theme.replace(/-/g, '_')).toUpperCase() + '_')) //Replace CONSTANS names

        .pipe(gulp.dest('./'));
    } else {
        console.log("*------------------------------------------------- *");
        console.log("* Please add your slug-theme into gulp file first  *");
        console.log("*------------------------------------------------- *");
        return true
    }

};

exports.replace_slug_theme = replace_slug_theme;