'use strict';

import plugins  from 'gulp-load-plugins';
import yargs    from 'yargs';
import gulp     from 'gulp';
import rimraf   from 'rimraf';
import fs       from 'fs';
import sass     from 'gulp-sass';
import cmq      from 'gulp-combine-mq';
import webpack      from 'webpack-stream';

// Load all Gulp plugins into one variable
const $ = plugins();

// Check for --production flag
const PRODUCTION = !!(yargs.argv.production);

// Load settings from settings.yml
const COMPATIBILITY = ['last 2 versions', 'ie >= 9']

// Build the "dist" folder by running all of the below tasks
gulp.task('build',
 gulp.series(gulp.parallel(compile_sass, compile_admin_sass, compile_js)));

// Build the site, watch for file changes
gulp.task('default',
  gulp.series('build', watch));

// Delete the "dist" folder
// This happens every time a build starts
// function clean(done) {
//   rimraf(PATHS.dist, done);
// }

// Copy files out of the assets folder
// This task skips over the "img", "js", and "scss" folders, which are parsed separately
function compile_js() {
    return gulp.src('www/src/index.js')
        .pipe(webpack( require('./webpack.config.js') ))
        .pipe(gulp.dest('www/'));
}

// Compile Sass into CSS
// In production, the CSS is compressed
function compile_sass() {
  return gulp.src('www/scss/style.scss')
    .pipe(
      sass({
      }).on('error', sass.logError)
    )
    .pipe($.sourcemaps.init())
    .pipe($.autoprefixer({
        browsers: COMPATIBILITY
    }))
    .pipe(cmq({
      beautify: true
    }))
    .pipe($.if(!PRODUCTION, $.sourcemaps.write()))
    .pipe($.if(PRODUCTION, $.cssnano()))
    .pipe(gulp.dest('www/css'));
}

function compile_admin_sass() {
  return gulp.src('www/scss/admin.scss')
    .pipe(
      sass({
      }).on('error', sass.logError)
    )
    .pipe($.sourcemaps.init())
    .pipe($.autoprefixer({
        browsers: COMPATIBILITY
    }))
    .pipe(cmq({
      beautify: true
    }))
    .pipe($.if(!PRODUCTION, $.sourcemaps.write()))
    .pipe($.if(PRODUCTION, $.cssnano()))
    .pipe(gulp.dest('www/admin/css'));
}

// Combine JavaScript into one file
// In production, the file is minified
function javascript() {
  return gulp.src(PATHS.javascript)
    .pipe($.sourcemaps.init())
    .pipe($.concat('app.js'))
    .pipe($.if(PRODUCTION, $.uglify()
      .on('error', e => { console.log(e); })
    ))
    .pipe($.if(!PRODUCTION, $.sourcemaps.write()))
    .pipe(gulp.dest(PATHS.dist + '/js'));
}

// Copy images to the "dist" folder
// In production, the images are compressed
function images() {
  return gulp.src('src/img/**/*')
    .pipe($.if(PRODUCTION, $.imagemin({
      progressive: true
    })))
    .pipe(gulp.dest(PATHS.dist + '/img'));
}

// Watch for changes to static assets, pages, Sass, and JavaScript
function watch() {
  gulp.watch('www/scss/**/*.scss').on('change', gulp.series(compile_sass, compile_admin_sass));
  gulp.watch('www/src/**/*.js').on('change', gulp.series(compile_js));
  // gulp.watch('src/img/**/*').on('change', gulp.series(images));
}
