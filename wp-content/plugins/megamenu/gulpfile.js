var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('styles', function() {
    gulp.src('css/admin/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./css/admin/'));
});

gulp.task('default',function() {
    gulp.watch('css/admin/*.scss',['styles']);
});