var gulp = require('gulp');
var sass = require('gulp-sass');
var rename = require("gulp-rename");

sass.compiler = require('node-sass');

gulp.task('default', function () {
    return gulp.src('./src/**/*.scss')
        .pipe(sass({
            outputStyle : 'expanded'
        }).on('error', sass.logError))
        .pipe(gulp.dest('./dist'))

        .pipe(rename({extname : '.min.css'}))

        .pipe(sass({
            outputStyle : 'compressed'
        }).on('error', sass.logError))
        .pipe(gulp.dest('./dist'));
});