var gulp = require('gulp');
var postcss = require('gulp-postcss');
var stylus = require('gulp-stylus');
var plumber = require('gulp-plumber');
var minifyCss = require('gulp-clean-css');
var concat = require('gulp-concat');
var typographic = require('typographic');
var poststylus = require('poststylus');
var browserSync = require('browser-sync').create();
var del = require('del');
var debug = require('gulp-debug');
var ignore = require('gulp-ignore');
var vendor = require('gulp-concat-vendor');
var ftp = require('vinyl-ftp');
var runSequence = require('run-sequence');
var imagemin = require('gulp-imagemin');
var changed = require('gulp-changed');
var favicons = require('gulp-favicons');
var fs = require('fs');
var rimraf = require('rimraf');
var include = require("gulp-include");

var app_information = {
  appName: "snapspace.org",
  appDescription: "snapspace.org",
  developerName: "snapspace.org"
}

var language_files = {
  'default': './js/language/de/*.js',
  'english': './js/language/en/*.js'
};

var source_files = {
  styles: './css/*.styl',
  scripts: './js/*.js',
  vendor_scripts: './js/vendor/*',
  images: './img/**',
};

var dist_folders = {
  root: './../dist/',
  styles: './../dist/css/',
  scripts: './../dist/js/',
  images: './../dist/img/',
};

var ftp_conn = ftp.create({
  host:     '',
  user:     '',
  password: '',
  parallel: 10,
  log:      ftp.log
});

gulp.task('favicons', function() {
  var dir = "./../dist/favicons/";
  var htmlfile = dir + "favicons.html";
  if(!fs.existsSync(dir)) {
    fs.mkdirSync(dir);
  }
  // Create an empty file
  fs.writeFileSync(htmlfile, '');
  return gulp.src("./img/favicon.png")
      .pipe(debug({title: "favicons"}))
      .pipe(favicons({
        appName: app_information.appName,
        appDescription: app_information.appDescription,
        developerName: app_information.developerName,
        developerURL: "/",
        background: "#FFFFFF",
        path: "/site/templates/dist/favicons/",
        version: 1.0,
        logging: false,
        online: false,
        replace: true,
        display: "standalone",
        html: htmlfile,
        icons: {
            android: true,              // Create Android homescreen icon. `boolean`
            appleIcon: true,            // Create Apple touch icons. `boolean`
            appleStartup: false,         // Create Apple startup images. `boolean`
            coast: false,                // Create Opera Coast icon. `boolean`
            favicons: true,             // Create regular favicons. `boolean`
            firefox: true,              // Create Firefox OS icons. `boolean`
            opengraph: false,            // Create Facebook OpenGraph image. `boolean`
            twitter: false,              // Create Twitter Summary Card image. `boolean`
            windows: true,              // Create Windows 8 tile icons. `boolean`
            yandex: false                // Create Yandex browser icon. `boolean`
        }
    })).pipe(gulp.dest("./../dist/favicons/"));
});

gulp.task('styles', function() {
  return gulp.src(source_files.styles)
      .pipe(ignore('_*.styl'))
      .pipe(debug({title: "styles"}))
      .pipe(plumber())
      .pipe(stylus({
          use: [
            typographic(),
            poststylus(['lost', 'autoprefixer'])
          ]
      }))
      //.pipe(minifyCss({compatibility: 'ie8'}))
      .pipe(gulp.dest(dist_folders.styles));
});

gulp.task('languages', function() {
  for(var lang in language_files) {
    gulp.src(language_files[lang])
        .pipe(vendor('lang_' + lang + '.js'))
        .pipe(gulp.dest(dist_folders.scripts));
  }
});

gulp.task('scripts', function() {
  gulp.src(source_files.vendor_scripts)
      .pipe(debug({title: "vendor-scripts"}))
      .pipe(vendor('vendor.js'))
      .pipe(gulp.dest(dist_folders.scripts));

  return gulp.src(source_files.scripts)
      .pipe(debug({title: "scripts"}))
      .pipe(ignore('_*.js'))
      .pipe(include())
      .pipe(plumber())
      .pipe(gulp.dest(dist_folders.scripts));
});

gulp.task('images', function() {
  return gulp.src(source_files.images)
      .pipe(debug({title: "images"}))
      .pipe(changed(source_files.images))
      .pipe(imagemin())
      .pipe(gulp.dest(dist_folders.images));
});

gulp.task('ws', function() {
  gulp.watch(source_files.styles, function() {
    runSequence('styles', browserSync.reload);
  });

  gulp.watch(source_files.scripts, function() {
    runSequence('scripts', 'languages', browserSync.reload);
  });
});

gulp.task('watch', ['browser-sync'], function() {
  gulp.watch(source_files.styles, function() {
    runSequence('styles', browserSync.reload);
  });

  gulp.watch(source_files.scripts, function() {
    runSequence('scripts', 'languages', browserSync.reload);
  });

  gulp.watch(source_files.images, function() {
    runSequence('images', browserSync.reload);
  });
});

gulp.task('ftp_css', function() {
  return gulp.src('../dist/css/*.css', { base: '.', buffer: false } )
    .pipe(debug({title: "upload styles"}))
    .pipe(ftp_conn.dest('/templates/dist'));
});

gulp.task('ftp_js', function() {
  return gulp.src('../dist/js/*.js', { base: '.', buffer: false } )
    .pipe(debug({title: "upload scripts"}))
    .pipe(ftp_conn.dest('/templates/dist/'));
});

gulp.task('watchftp', ['browser-sync-ftp'], function() {
  gulp.watch(source_files.styles, function() {
    runSequence('styles', 'ftp_css', browserSync.reload);
  });

  gulp.watch(source_files.scripts, function() {
    runSequence('scripts', 'ftp_js', browserSync.reload);
  });
});

gulp.task('browser-sync', function() {
  browserSync.init({
    proxy: "http://localhost:8888/"
    /*
    server: {
      baseDir: "./../"
    }*/
  });
});

gulp.task('browser-sync-ftp', function() {
  browserSync.init({
    proxy: "http://preview.snapspace.org"
  });
});

gulp.task('clean', function (cb) {
  rimraf(dist_folders.root, cb);
});

gulp.task('default', function() {
  runSequence('clean', 'styles', 'scripts', 'images', 'languages', 'favicons');
});
