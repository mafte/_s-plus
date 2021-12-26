const gulp = require("gulp");
const sass = require("gulp-sass");
/* Limpia y optimiza CSS */
const clean = require("gulp-clean-css");
/* Comprime JavaScript */
const uglify = require("gulp-uglify");
/* Concatena archivos */
const concat = require("gulp-concat");
/* Fuente de mapas para SASS */
const sourcemaps = require("gulp-sourcemaps");
/* Permite el manejo de los errores */
const plumber = require("gulp-plumber");
/* Añade prefijos en css */
const autoPrefixer = require("gulp-autoprefixer");
/* Analiza la calidad de js */
const jshint = require("gulp-jshint");
/* Mantiene actualizado el navegador con los cambios */
const browserSync = require("browser-sync");
// import all files from folder
const concatFilenames = require("gulp-concat-filenames");
// For generate icons sheets
const fs = require("fs");
const svgToMiniDataURI = require("mini-svg-data-uri");

/*------------------------------------------------------*\
	|| BASIC SETUP
\*------------------------------------------------------*/

var config = {
    urlBrowserSync: "pruebas.local",
    vAutoprofixer: "last 5 versions",
    pathIconsOrigin: "assets/source/icons/", //Does not work with sub directories
    pathExportIconsSheet: "assets/source/scss/",
};

/*------------------------------------------------------*\
	|| BROWSER-SYNC
\*------------------------------------------------------*/

function reload(done) {
    browserSync.reload();
    done();
}

/*------------------------------------------------------*\
	|| STYLES
\*------------------------------------------------------*/

function css() {
    return gulp
        .src("assets/source/scss/style.scss")

        .pipe(sourcemaps.init())

        .pipe(plumber())
        .pipe(sass().on("error", sass.logError))

        .pipe(
            clean({
                level: 2,
            })
        )
        .pipe(autoPrefixer(config.vAutoprofixer))

        .pipe(sourcemaps.write("."))
        .pipe(gulp.dest("."))
        .pipe(browserSync.stream());
}

/*	|> SCSS - auto import 
\*------------------------------------------------------*/

let concatFilenamesOptions = {
    root: "./assets/source/scss/",
    prepend: "@import '",
    append: "';",
};

/** For site styles */

function scssSite() {
    return gulp
        .src("assets/source/scss/Site/*.*")
        .pipe(concatFilenames("_site.scss", concatFilenamesOptions))
        .pipe(gulp.dest("./assets/source/scss"));
}

/** For Gutenberg Blocks with ACF */

function scssBlocks() {
    return gulp
        .src("assets/source/scss/Blocks/*.*")
        .pipe(concatFilenames("_blocks.scss", concatFilenamesOptions))
        .pipe(gulp.dest("./assets/source/scss"));
}

/** For Flexible content with ACF */

function scssComponents() {
    return gulp
        .src("assets/source/scss/Components/*.*")
        .pipe(concatFilenames("_components.scss", concatFilenamesOptions))
        .pipe(gulp.dest("./assets/source/scss"));
}

/*	|> Icons
\*------------------------------------------------------*/

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
    background-repeat: no-repeat;
    background-size: contain;
    background-position: center;
    width: 22px;
    height: 22px;
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

/*------------------------------------------------------*\
	|| MAIN TASK
\*------------------------------------------------------*/

exports.default = gulp.series(gulp.parallel(scssSite, scssBlocks, scssComponents, iconSh), css, initAll);


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

    gulp.watch(["assets/**/Site/*.scss"], scssSite);
    gulp.watch(["assets/**/Blocks/*.scss"], scssBlocks);
    gulp.watch(["assets/**/Components/*.scss"], scssComponents);

    gulp.watch(["assets/source/icons/*.svg"], iconSh);

    gulp.watch(
        [
            path_scss + "**/*.scss",
            "!" + path_scss + "**/_site.scss",
            "!" + path_scss + "**/_components.scss",
            "!" + path_scss + "**/_blocks.scss",
        ],
        css
    );

    gulp.watch("*.php", reload);

    //gulp.watch('assets/js/*.js', js)

};