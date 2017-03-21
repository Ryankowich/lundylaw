var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var livereload = require('gulp-livereload');
var notify = require('gulp-notify');

gulp.task('default', function() {

});

//compile sass to css
gulp.task('sass', function () {
	return gulp.src('./development/styles/style.scss')
		.pipe(sass().on('error', sass.logError))
		.pipe(gulp.dest('./'))
		.pipe(notify("Stylesheet updated."))
		.pipe(livereload());
});

//concat all js 
gulp.task('scripts', function() {
	return gulp.src('./development/scripts/*.js')
		.pipe(concat('all.js'))
		.pipe(gulp.dest('./js/'))
		.pipe(notify("Scripts updated."))
		.pipe(livereload());
});

//livereload any php edits
gulp.task('php', function() {
	gulp.src('./footer.php')
		.pipe(notify("Current PHP file updated."))
		.pipe(livereload());
});

gulp.task('watch', function () {
	livereload.listen();
	gulp.watch('./development/styles/*.scss', ['sass'] );
	gulp.watch('./development/scripts/*.js', ['scripts']);
	gulp.watch('./footer.php', ['php']);
});