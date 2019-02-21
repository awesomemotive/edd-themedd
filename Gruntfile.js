module.exports = function(grunt) {

	grunt.registerTask('watch', [ 'watch' ]);

	grunt.initConfig({

		pkg: grunt.file.readJSON('package.json'),

		// concat
		concat: {
			main: {
				options: {
					separator: ';'
				},
				src: ['assets/js/src/**/*.js'],
				dest: 'assets/js/<%= pkg.name %>.js'
			},
			bootstrap: {
				options: {
					separator: ';'
				},
				src: [
					'node_modules/popper.js/dist/umd/popper.js',
					'node_modules/bootstrap/js/dist/util.js',
					'node_modules/bootstrap/js/dist/dropdown.js',
					'node_modules/bootstrap/js/dist/collapse.js',
				],
				dest: 'assets/js/vendors/bootstrap/bootstrap.js'
			},
		},

		// uglify
		uglify: {
			options: {
				mangle: false
			},
			js: {
				files: {
					'assets/js/<%= pkg.name %>.min.js': ['assets/js/<%= pkg.name %>.js'],
					'assets/js/vendors/bootstrap/bootstrap.min.js': ['assets/js/vendors/bootstrap/bootstrap.js']
				}
			}
		},

		sass: {
			default: {
				files: {
					'style.css' : 'assets/scss/style.scss',
					'assets/css/affiliatewp.css': 'assets/scss/compatibility/affiliatewp.scss',
					'assets/css/edd-reviews.css': 'assets/scss/compatibility/edd-reviews.scss',
					'assets/css/edd-fes.css': 'assets/scss/compatibility/edd-fes.scss',
				}
			},
			minify: {
				options: {
					style: 'compressed'
				},
				files: {
					'style.min.css' : 'assets/scss/style.scss',
					'assets/css/affiliatewp.min.css': 'assets/scss/compatibility/affiliatewp.scss',
					'assets/css/edd-reviews.min.css': 'assets/scss/compatibility/edd-reviews.scss',
					'assets/css/edd-fes.min.css': 'assets/scss/compatibility/edd-fes.scss',
				}
			},
		},

		postcss: {
			options: {
				map: true, // inline sourcemaps

				processors: [
					require('autoprefixer')({browsers: 'last 1 versions'}), // add vendor prefixes
				]
			},
			dist: {
				src: [
					'style.css',
					'style.min.css',
					'assets/css/affiliatewp.css',
					'assets/css/affiliatewp.min.css',
					'assets/css/edd-fes.css',
					'assets/css/edd-fes.min.css',
					'assets/css/edd-reviews.css',
					'assets/css/edd-reviews.min.css'

				]
			}
		},

		// watch our project for changes
		watch: {
			// JS
			js: {
				files: ['assets/js/src/**/*.js'],
				tasks: ['concat:main', 'uglify:js']
			},

			css: {
				files: 'assets/scss/**/*.scss',
				tasks: ['sass', 'postcss']
			},
		}
	});

	// Saves having to declare each dependency
	require( "matchdep" ).filterDev( "grunt-*" ).forEach( grunt.loadNpmTasks );

	grunt.registerTask('default', ['concat', 'uglify', 'sass', 'postcss' ]);

};