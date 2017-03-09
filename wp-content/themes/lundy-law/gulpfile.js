var gulp = require('gulp');
var sass = require('gulp-sass');
var livereload = require('gulp-livereload');

gulp.task('default', function() {

});

gulp.task('sass', function () {
	return gulp.src('./development/styles/style.scss')
		.pipe(sass().on('error', sass.logError))
		.pipe(gulp.dest('./'))
		.pipe(livereload());
});

//livereload any php edits
gulp.task('php', function() {
	gulp.src('./*.php')
		.pipe(livereload());
});

gulp.task('watch', function () {
	livereload.listen();
	gulp.watch('./development/styles/*.scss', ['sass'] );
	gulp.watch('./*.php', ['php']);
});