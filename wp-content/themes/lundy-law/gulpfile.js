var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('default', function() {
  
});

gulp.task('sass', function () {
	return gulp.src('./development/styles/style.scss')
		.pipe(sass().on('error', sass.logError))
		.pipe(gulp.dest('./'));
});  

gulp.task('watch', function () {
	gulp.watch('./development/styles/*.scss', ['sass'] );
});