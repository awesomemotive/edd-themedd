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
           dest: 'assets/js/<%= pkg.name %>.min.js'
         }
    },

    // uglify
    uglify: {
        options: {
          mangle: false
        },
        js: {
            files: {
                'assets/js/<%= pkg.name %>.min.js': ['assets/js/<%= pkg.name %>.min.js']
    		}
        }
    },

    // Add banner to style.css
    usebanner: {
       addbanner: {
          options: {
            position: 'top',
            banner: '/*\nTheme Name: Themedd\n' +
                    'Theme URI: <%= pkg.theme_uri %>\n' +
                    'Author: Easy Digital Downloads\n' +
                    'Author URI: https://easydigitaldownloads.com\n' +
                    'Description: WordPress theme for Easy Digital Downloads\n' +
                    'License: GNU General Public License\n' +
                    'License URI: license.txt\n' +
                    '*/',
            linebreak: true
          },
          files: {
            src: [ 'style.css' ]
          }
        }
    },
    // LESS CSS
	less: {
		style: {
			files: {
				"assets/css/affiliatewp.css": "assets/less/compatibility/affiliatewp.less",
				"assets/css/edd-fes.css": "assets/less/compatibility/edd-fes.less",
				"assets/css/edd-points-and-rewards.css": "assets/less/compatibility/edd-points-and-rewards.less",
			}
		},
		minify: {
			options: {
				compress: true
			},
			files: {
				"style.css": "assets/less/style.less",
				"assets/css/affiliatewp.min.css": "assets/less/compatibility/affiliatewp.less",
				"assets/css/edd-fes.min.css": "assets/less/compatibility/edd-fes.less",
				"assets/css/edd-points-and-rewards.min.css": "assets/less/compatibility/edd-points-and-rewards.less"
			}
		}
	},

    svgstore: {
      options: {
        prefix : 'icon-', // This will prefix each <g> ID
         svg : {
            'xmlns:sketch' : 'http://www.bohemiancoding.com/sketch/ns',
            'xmlns:dc': "http://purl.org/dc/elements/1.1/",
            'xmlns:cc': "http://creativecommons.org/ns#",
            'xmlns:rdf': "http://www.w3.org/1999/02/22-rdf-syntax-ns#",
            'xmlns:svg': "http://www.w3.org/2000/svg",
            'xmlns': "http://www.w3.org/2000/svg",
            'xmlns:sodipodi': "http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd",
            'xmlns:inkscape': "http://www.inkscape.org/namespaces/inkscape"
        }
      },
      default : {
        files: {
            // svgs in the combined folder will be combined into the svg-defs.svg file
            // usage: <svg><use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svg-defs.svg#icon-name-of-svg'; ?>"></use></svg>
            'assets/images/svg-defs.svg': ['assets/images/svgs/combined/*.svg'],
        }
      }
    },

    svgmin: { //minimize SVG files
        options: {
            plugins: [
                { removeViewBox: false },
                { removeUselessStrokeAndFill: false }
            ]
        },
        dist: {
            expand: true,
            cwd: 'assets/images/svgs/original',
            src: ['*.svg'],
            dest: 'assets/images/svgs'
        }
    },

    // watch our project for changes
    watch: {

      // JS
      js: {
        files: ['assets/js/src/**/*.js'],
        tasks: ['concat:main', 'uglify:js'],
      },

      // svgstore
       svgstore: {
         files: ['assets/images/svgs/combined/*.svg'],
         tasks: ['svgstore:default']
      },

      // svgmin
      svgmin: {
          files: ['assets/images/svgs/original/*.svg'],
          tasks: ['svgmin:dist']
      },

      // CSS
      css: {
        files: ['assets/less/**/*.less'],
        tasks: ['less:style', 'less:minify'],
      },

      // Add banner
      addbanner: {
        files: 'style.css',
         tasks: ['usebanner:addbanner'],
         options: {
          spawn: false
        }
      },
    }
  });

  // Saves having to declare each dependency
  require( "matchdep" ).filterDev( "grunt-*" ).forEach( grunt.loadNpmTasks );

  grunt.registerTask('default', ['concat', 'uglify', 'less', 'usebanner', 'svgstore', 'svgmin' ]);

};
