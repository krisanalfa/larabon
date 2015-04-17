var elixir = require('laravel-elixir'),
    gulp = require('gulp'),
    bower = require('gulp-bower');

gulp.task('bower', function() {
    return bower().pipe(gulp.dest('resources/vendor'));
});

gulp.task('less', function() {
    return elixir(function(mix) {
        mix.less('app.less');
    });
});

gulp.task('copy', function() {
    return elixir(function(mix) {
        mix.copy('resources/vendor/jquery/dist', 'public/vendor/jquery');

        mix.copy('resources/vendor/bootstrap/dist/js', 'public/vendor/bootstrap/js');
        mix.copy('resources/vendor/bootstrap/dist/fonts', 'public/vendor/bootstrap/fonts');
        mix.copy('resources/vendor/font-awesome/fonts', 'public/vendor/font-awesome/fonts');

        mix.copy('resources/vendor/roboto-fontface/fonts', 'public/vendor/roboto-fontface/fonts');
    });
});

gulp.task('default', ['bower', 'less', 'copy']);

