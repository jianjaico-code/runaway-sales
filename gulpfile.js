var gulp = require("gulp");
var sass = require("gulp-sass");
var header = require("gulp-header");
var cleanCSS = require("gulp-clean-css");
var rename = require("gulp-rename");
var uglify = require("gulp-uglify");
var autoprefixer = require("gulp-autoprefixer");
//var browserSync = require("browser-sync").create();
var browserSync = require("browser-sync");
var php = require("gulp-connect-php");
var babel = require("gulp-babel")

// Copy third party libraries from /node_modules into /vendor
gulp.task("vendor", function() {
	// Bootstrap
	gulp
		.src([
			"./node_modules/bootstrap/dist/**/*",
			"!./node_modules/bootstrap/dist/css/bootstrap-grid*",
			"!./node_modules/bootstrap/dist/css/bootstrap-reboot*"
		])
		.pipe(gulp.dest("./vendor/bootstrap"));

	// ChartJS
	gulp
		.src(["./node_modules/chart.js/dist/*.js"])
		.pipe(gulp.dest("./vendor/chart.js"));

	// DataTables
	gulp
		.src([
			"./node_modules/datatables.net/js/*.js",
			"./node_modules/datatables.net-bs4/js/*.js",
			"./node_modules/datatables.net-bs4/css/*.css",
			"./node_modules/datatables.net-buttons/js/*.js",
			"./node_modules/datatables.net-select/js/*.js"
		])
		.pipe(gulp.dest("./vendor/datatables/"));
	// Font Awesome
	gulp.src(["./node_modules/@fortawesome/**/*"]).pipe(gulp.dest("./vendor"));

	// jQuery
	gulp
		.src([
			"./node_modules/jquery/dist/*",
			"!./node_modules/jquery/dist/core.js"
		])
		.pipe(gulp.dest("./vendor/jquery"));

	// jQuery Easing
	gulp
		.src(["./node_modules/jquery.easing/*.js"])
		.pipe(gulp.dest("./vendor/jquery-easing"));

	// MomentJS
	gulp.src("./node_modules/moment/min/*.js").pipe(gulp.dest("./vendor/moment"));
});

// Compile SCSS
gulp.task("css:compile", function() {
	return gulp
		.src("./scss/**/*.scss")
		.pipe(
			sass
				.sync({
					outputStyle: "expanded"
				})
				.on("error", sass.logError)
		)
		.pipe(
			autoprefixer({
				browsers: [
					"last 1 major version",
					">= 1%",
					"Chrome >= 45",
					"Firefox >= 38",
					"Edge >= 12",
					"Explorer >= 10",
					"iOS >= 9",
					"Safari >= 9",
					"Android >= 4.4",
					"Opera >= 30"
				],
				cascade: false
			})
		)
		.pipe(gulp.dest("./css"))
		.pipe(browserSync.stream());
});

// Minify CSS
gulp.task("css:minify", ["css:compile"], function() {
	return gulp
		.src(["./css/*.css", "!./css/*.min.css"])
		.pipe(cleanCSS())
		.pipe(
			rename({
				suffix: ".min"
			})
		)
		.pipe(gulp.dest("./css"))
		.pipe(browserSync.stream());
});

// CSS
gulp.task("css", ["css:compile", "css:minify"]);

// Minify JavaScript
gulp.task("js:minify", function() {
	return gulp
		.src([
			"./js/**/*.js",
			"./main.js",
			"!./js/**/*.min.js"
		])
		.pipe(babel())
		.pipe(uglify())
		.pipe(
			rename({
				suffix: ".min"
			})
		)
		.pipe(gulp.dest("./js"))
		.pipe(browserSync.stream());
});

// JS
gulp.task("js", ["js:minify"]);

// Default task
gulp.task("default", ["css", "js", "vendor"]);

// Configure the browserSync task
gulp.task("browserSync", function() {
	browserSync.init({
		proxy: "localhost:5000"
	});
});

// Dev task
gulp.task("dev", ["css", "js"], function() {
	gulp.watch("./scss/**/*.scss", ["css"]);
	gulp.watch("./js/*.js", ["js"]);
	// gulp.watch("./*.html").on("change", browserSync.reload);
	// gulp.watch("./*.php").on("change", browserSync.reload);
});

//gulp php
gulp.task("php", function() {
	php.server({}, function() {
		browserSync.init({
			proxy: "localhost:5000"
		});
	});
});
