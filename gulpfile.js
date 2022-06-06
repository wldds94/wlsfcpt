// // Load Gulp...of course
const { src, dest, task, series, watch, parallel } = require('gulp');

// // CSS related plugins
var sass         = require( 'gulp-sass' );
var autoprefixer = require( 'gulp-autoprefixer' );

// // JS related plugins
var uglify       = require( 'gulp-uglify' );
var babelify     = require( 'babelify' );
var browserify   = require( 'browserify' );
var source       = require( 'vinyl-source-stream' );
var buffer       = require( 'vinyl-buffer' );
var stripDebug   = require( 'gulp-strip-debug' );

// // Utility plugins
var rename       = require( 'gulp-rename' );
var sourcemaps   = require( 'gulp-sourcemaps' );
var notify       = require( 'gulp-notify' );
var options      = require( 'gulp-options' );
var gulpif       = require( 'gulp-if' );

// // Browers related plugins
var browserSync  = require( 'browser-sync' ).create();

var styleSRC     = './src/sass/style.scss';
// var stylePublic   = './src/sass/public.scss';
var styleURL     = './dist/css/';
var mapURL       = './';

var jsSRC        = 'src/js/';
var jsAdmin      = 'admin.js';
// var jsApp        = 'app.js';
// Public
var jsPublic      = 'public.js';
var jsFiles      = [jsPublic];
var jsURL        = './dist/js/';

var styleWatch   = 'src/sass/**/*.scss';
var jsWatch      = 'src/js/**/*.js';
var phpWatch     = './**/*.php';

function css(done) {
	src([styleSRC], {"allowEmpty": true})
		.pipe( sourcemaps.init() )
		.pipe( sass({
			errLogToConsole: true,
			outputStyle: 'compressed'
		}) )
		.on( 'error', console.error.bind( console ) )
		.pipe( autoprefixer({ 
			overrideBrowserslist: [ 'last 2 versions', '> 5%', 'Firefox ESR' ],
			cascade: false
		}) )
		.pipe( sourcemaps.write( mapURL ) )
		.pipe( dest( styleURL ) )
		.pipe( browserSync.stream() );
	done();
}

function js(done) {
	jsFiles.map(function (entry) {
		return browserify({
			entries: [jsSRC + entry]
		})
		.transform( babelify, { presets: [ '@babel/preset-env' ] } )
		.bundle()
		.pipe( source( entry ) )
		.pipe( buffer() )
		.pipe( gulpif( options.has( 'production' ), stripDebug() ) )
		.pipe( sourcemaps.init({ loadMaps: true }) )
		.pipe( uglify() )
		.pipe( sourcemaps.write( '.' ) )
		.pipe( dest( jsURL ) )
		.pipe( browserSync.stream() );
	});
	done();
}

function watch_files() {
	watch( styleWatch, css );
	watch( jsWatch, js );
	src( jsURL + 'public.js' )
		.pipe( notify({ message: 'Gulp is Watching, Happy Coding!' }) );
};

task("css", css);
task("js", js);
task("default", series(css, js));
task("watch", watch_files);