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
			}
	    },

		// uglify
	    uglify: {
	        options: {
				mangle: false
	        },
	        js: {
	            files: {
	                'assets/js/<%= pkg.name %>.min.js': ['assets/js/<%= pkg.name %>.js']
	    		}
	        }
	    },

		sass: {
			default: {
				files: {
					'style.css' : 'assets/scss/style.scss',
					'assets/css/affiliatewp.css': 'assets/scss/compatibility/affiliatewp.scss',
					'assets/css/edd-points-and-rewards.css': 'assets/scss/compatibility/edd-points-and-rewards.scss',
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
					'assets/css/edd-points-and-rewards.min.css': 'assets/scss/compatibility/edd-points-and-rewards.scss',
					'assets/css/edd-reviews.min.css': 'assets/scss/compatibility/edd-reviews.scss',
					'assets/css/edd-fes.min.css': 'assets/scss/compatibility/edd-fes.scss',
				}
			},
		},

		// Autoprefixer
		autoprefixer: {
			main: {
				files:{
					'style.css': 'style.css',
					'style.min.css': 'style.min.css',
					'assets/css/affiliatewp.css': 'assets/css/affiliatewp.css',
					'assets/css/affiliatewp.min.css': 'assets/css/affiliatewp.min.css',
					'assets/css/edd-fes.css': 'assets/css/edd-fes.css',
					'assets/css/edd-fes.min.css': 'assets/css/edd-fes.min.css',
					"assets/css/edd-reviews.css": 'assets/css/edd-reviews.css',
					"assets/css/edd-reviews.min.css": 'assets/css/edd-reviews.min.css',
					'assets/css/edd-points-and-rewards.css': 'assets/css/edd-points-and-rewards.css',
					'assets/css/edd-points-and-rewards.min.css': 'assets/css/edd-points-and-rewards.min.css'
				},
			},
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
                tasks: ['sass', 'autoprefixer:main']
			},

		}
	});

	// Saves having to declare each dependency
	require( "matchdep" ).filterDev( "grunt-*" ).forEach( grunt.loadNpmTasks );

	grunt.registerTask('default', ['concat', 'uglify', 'sass', 'autoprefixer' ]);

};
