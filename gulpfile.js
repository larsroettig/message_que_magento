/**
 * gulpfile for magento2
 *
 * @author    Johann Zelger <j.zelger@techdivision.com>
 * @copyright 2016 TechDivision GmbH <core@techdivision.com>
 */

// define dependencies
var gulp = require('gulp'),
    fs = require('fs-extra'),
    git = require('gulp-git'),
    gutil = require('gulp-util'),
    watch = require('gulp-watch'),
    rename = require('gulp-rename'),
    rimraf = require('rimraf'),
    exec = require('child_process').exec;

// check envs
if (!process.env.DOCKER_CONTAINER_NAME) {
    throw new gutil.PluginError({
        plugin: 'docker',
        message: 'Please define environment variable for docker container: DOCKER_CONTAINER_NAME="foobar"'
    });
}

// define options for task usage
var options = {
    target: {
        src: [
            '**/*',
            '!.git{,/**}',
            '!.idea{,/**}',
            '!.gitignore',
            '!node_modules{,/**}',
            '!vendor{,/**}',
            '!dist{,/**}',
            '!doc{,/**}',
            '!**/.DS_Store'
        ],
        src_env: [],
        dir: 'dist/'
    },
    deploy: {
        src: [
            'dist/**/*',
            '!dist/.git{,/**}'
        ],
        dir: '/var/www/dist/'
    },
    docker: {
        container: process.env.DOCKER_CONTAINER_NAME,
        basepath: '/var/www/'
    }
};

// define env related files
var envSrcFiles = [
    // 'src/envRelatedFile1.xml',
    // 'src/envRelatedFile2.conf'
];

// enhance env related files by DEPLOY_ENVIRONMENT var
envSrcFiles.forEach(function (file) {
    options.target.src_env.push(file + '.' + process.env.DEPLOY_ENVIRONMENT);
});

/**
 * Cleans target directory
 */
gulp.task('clean', function (cb) {
    rimraf(options.target.dir, cb);
});

/**
 * Copies all env replated src files to given target directory in options
 */
gulp.task('copy-env', function () {
    return gulp.src(options.target.src_env)
        .pipe(rename(function (path) {
            path.extname = "";
        }))
        .pipe(gulp.dest(options.target.dir));
});

/**
 * Copy applications source directory to target dir
 */
gulp.task('copy', function (cb) {
    return gulp.src(options.target.src, {dot: true, followSymlinks: false})
        .pipe(gulp.dest(options.target.dir));
});

/**
 * Copy applications source directory to target dir
 */
gulp.task('deploy:docker', ['copy'], function (cb) {
    exec('docker cp ' + options.target.dir + ' ' + options.docker.container + ':' + options.docker.basepath, function () {
        gutil.log('Deployed', options.target.dir, 'on', gutil.colors.blue(options.docker.container + ':' + options.docker.basepath));
    });
});

/**
 * Deploy prebuilt application to docker container
 */
gulp.task('deploy-clean:docker', ['copy'], function () {
    return exec('docker exec ' + options.docker.container + ' rm -rf ' + options.deploy.dir, function () {
        exec('docker cp ' + options.target.dir + ' ' + options.docker.container + ':' + options.docker.basepath, function () {
            gutil.log('Deployed', options.target.dir, 'on', gutil.colors.blue(options.docker.container + ':' + options.docker.basepath));
        });
    });
});

/**
 * Watcher for src file to be copied to dist folder
 */
gulp.task('watch:src', function (cb) {
    watch(options.target.src, {dot: true, followSymlinks: false}, function (file) {
        gutil.log('Copied', gutil.colors.magenta(file.relative), 'to', gutil.colors.blue(options.target.dir + file.relative));
    }).pipe(gulp.dest(options.target.dir));
    cb();
});

/**
 * Development task which watches all deploy src files for instant deployment
 */
gulp.task('dev:docker', ['watch:src'], function (cb) {
    watch(options.deploy.src, {events: ['add', 'unlink', 'change', 'unlinkDir']}, function (file) {
        // check if directory unlink is going on
        if (file.event === 'unlinkDir') {
            exec('docker exec -t ' + options.docker.container + ' rm -rf ' + options.deploy.dir + file.relative, function () {
                gutil.log('Deleted', gutil.colors.magenta(file.relative), 'on', gutil.colors.blue(options.docker.container + ':' + options.deploy.dir + file.relative));
            });
            return;
        }
        // check if file unlink is going on
        if (file.event === 'unlink') {
            exec('docker exec -t ' + options.docker.container + ' unlink ' + options.deploy.dir + file.relative, function () {
                gutil.log('Deleted', gutil.colors.magenta(file.relative), 'on', gutil.colors.blue(options.docker.container + ':' + options.deploy.dir + file.relative));
            });
            return;
        }
        // create directory first due to problems with addDir event
        exec('docker exec -t ' + options.docker.container + ' mkdir -p ' + options.deploy.dir + file.relative.replace(file.basename, ""), function () {
            // copy file
            exec('docker cp ' + file.path + ' ' + options.docker.container + ':' + options.deploy.dir + file.relative, function () {
                gutil.log('Copied', gutil.colors.magenta(file.relative), 'to', gutil.colors.blue(options.docker.container + ':' + options.deploy.dir + file.relative));
            });
        })
    });
    cb();
});

