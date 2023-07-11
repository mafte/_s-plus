/*————————————————————————————————————————————————————*\
    ●❱ IMPORT MODULES
\*————————————————————————————————————————————————————*/

const gulp = require("gulp");
const fs = require("fs"); /* Permite leer y escribir archivos en el SO. Ocupado para generar stylesheets de iconos */

/*
——— CSS
*/
const sass = require('gulp-sass')(require('sass'));
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

const config = {
    urlBrowserSync: "pruebas.local",
    slug_theme: "slug-theme",
    BrowserList: "last 1 versions",
    pathIconsOrigin: "assets/icons/", //Does not work with sub directories
    pathExportIconsSheet: "assets/scss/base/",
    clean_css: true,
    path_source_js: "assets/js/",
    path_dist_js: "assets/js/",
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
        .src("assets/scss/style.scss")
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
    root: "./assets/scss/",
    prepend: "@import '",
    append: "';",
};

/*
——— For site styles
*/

function scssSite() {
    return gulp
        .src("assets/scss/site/*.*")
        .pipe(concatFilenames("_site.scss", concatOptions))
        .pipe(gulp.dest("./assets/scss"));
}

/*
——— For Gutenberg Blocks with ACF
*/

function scssBlocks() {
    return gulp
        .src("assets/scss/blocks/*.*")
        .pipe(concatFilenames("_blocks.scss", concatOptions))
        .pipe(gulp.dest("./assets/scss"));
}

/*
——— For Flexible content with ACF
*/

function scssComponents() {
    return gulp
        .src("assets/scss/components/*.*")
        .pipe(concatFilenames("_components.scss", concatOptions))
        .pipe(gulp.dest("./assets/scss"));
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
            content + `.${element}{ background-image: var(--${element}) }\n`;
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
    ]

    return gulp.src(vendors, {allowEmpty: true})
        // .pipe(sourcemaps.init())
        .pipe(plumber())
        .pipe(concat("vendors.min.js"))
        .pipe(uglify())
        .pipe(lineec())
        // .pipe(sourcemaps.write("."))
        .pipe(gulp.dest(config.path_dist_js))
}

function js_custom() {

    const customs = [
        config.path_source_js + 'main.js',
    ]

    return gulp.src(customs)
        .pipe(sourcemaps.init())
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
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(concat("production.min.js"))
        .pipe(uglify())
        .pipe(lineec())
        .pipe(sourcemaps.write("."))
        .pipe(gulp.dest(config.path_dist_js))
}

/*————————————————————————————————————————————————————*\
    ●❱ MAIN TASK
\*————————————————————————————————————————————————————*/

exports.default = gulp.series(gulp.parallel(scssSite, scssBlocks, scssComponents, iconSh, js_custom), css, initAll);

function initAll() {

    let path_scss = "assets/scss/";

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
    gulp.watch(["assets/**/blocks/*.scss"], {
        events: ['add', 'unlink']
    }, scssBlocks);
    gulp.watch(["assets/**/components/*.scss"], {
        events: ['add', 'unlink']
    }, scssComponents);

    gulp.watch(["assets/icons/*.svg"], iconSh);

    gulp.watch(["assets/js/main.js"], series(js_custom));

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