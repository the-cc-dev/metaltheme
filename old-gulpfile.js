var autoprefixer = require('gulp-autoprefixer'),
    cache = require('gulp-cache'),
    concat = require('gulp-concat'),
    browserSync = require('browser-sync'),
    gulp = require('gulp'),
    imagemin = require('gulp-imagemin'),
    jshint = require('gulp-jshint'),
    manifest = require('asset-builder')('./assets/manifest.json'),
    merge = require('merge-stream'),
    minifycss = require('gulp-minify-css'),
    plumber = require('gulp-plumber'),
    rename = require('gulp-rename'),
    sass = require('gulp-sass'),
    uglify = require('gulp-uglify'),
    wiredep = require('wiredep'),
    
    app = manifest.getDependencyByName('scripts.js');


gulp.task('browser-sync', function() {
  browserSync.init({
    proxy: manifest.config;
  });
});

gulp.task('bs-reload', function () {
  browserSync.reload();
});

gulp.task('bootstrap', function () {
  var bsjs = gulp.src(bsJsPath + 'bootstrap.min.js')
    .pipe(gulp.dest(scriptsPath));
  var bsfonts = gulp.src(bsFontsPath + '*')
        .pipe(gulp.dest(fontsPath))
});

gulp.task('images', function(){
  gulp.src('assets/imgs/**/*')
    .pipe(plumber({
      errorHandler: function (error) {
        console.log(error.message);
        this.emit('end');
    }}))
    .pipe(cache(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true })))
    .pipe(gulp.dest('dist/images/'))
    .pipe(browserSync.reload({stream:true}));
});

/*

gulp.task('', function(){

});

*/

gulp.task('fonts', function(){
    return gulp.src('assets/fonts/**/*')
        .pipe(plumber({
            errorHandler: function (error) {
                console.log(error.message);
                this.emit('end');
            }}))
        .pipe(gulp.dest('dist/fonts/'))
        .pipe(browserSync.reload({stream:true}));
});

gulp.task('styles', function(){
  return gulp.src('assets/scss/**/*.scss')
    .pipe(plumber({
      errorHandler: function (error) {
        console.log(error.message);
        this.emit('end');
    }}))
    .pipe(sass())
    .pipe(gulp.dest('assets/css/'))
    .pipe(rename({suffix: '.min'}))
    .pipe(minifycss())
    .pipe(gulp.dest('dist/styles/'))
    .pipe(browserSync.reload({stream:true}))
});

gulp.task('scripts', function(){
  return gulp.src('assets/js/**/*.js')
    .pipe(plumber({
      errorHandler: function (error) {
        console.log(error.message);
        this.emit('end');
    }}))
    .pipe(jshint())
    .pipe(jshint.reporter('default'))
    .pipe(concat('scripts.js'))
    .pipe(gulp.dest('assets/js/'))
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify())
    .pipe(gulp.dest('dist/scripts/'))
    .pipe(browserSync.reload({stream:true}))
});

gulp.task('default', ['browser-sync'], function(){
  gulp.watch("assets/scss/**/*.scss", ['styles']);
  gulp.watch("assets/js/**/*.js", ['scripts']);
  gulp.watch("assets/imgs/**/*", ['images']);
  gulp.watch("*.html", ['bs-reload']);
  gulp.watch("*.php", ['bs-reload']);
});