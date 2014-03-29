/**
 * Gruntfile for compiling theme_shoehorn .less files.
 *
 * This file configures tasks to be run by Grunt
 * http://gruntjs.com/ for the current theme.
 *
 *
 * Requirements:
 * -------------
 * nodejs, npm, grunt-cli.
 *
 * Installation:
 * -------------
 * node and npm: instructions at http://nodejs.org/
 *
 * grunt-cli: `[sudo] npm install -g grunt-cli`
 *
 * node dependencies: run `npm install` in the root directory.
 *
 *
 * Usage:
 * ------
 * Call tasks from the theme root directory. Default behaviour
 * (calling only `grunt`) is to run the watch task detailed below.
 *
 *
 * Porcelain tasks:
 * ----------------
 * The nice user interface intended for everyday use. Provide a
 * high level of automation and convenience for specific use-cases.
 *
 * grunt watch   Watch the less directory (and all subdirectories)
 *               for changes to *.less files then on detection
 *               run 'grunt compile'
 *
 *               Options:
 *
 *               --dirroot=<path>  Optional. Explicitly define the
 *                                 path to your Moodle root directory
 *                                 when your theme is not in the
 *                                 standard location.
 * grunt compile Run the .less files through the compiler, create the
 *               RTL version of the output, then run decache so that
 *               the results can be seen on the next page load.
 *
 *               Options:
 *
 *               --dirroot=<path>  Optional. Explicitly define the
 *                                 path to your Moodle root directory
 *                                 when your theme is not in the
 *                                 standard location.
 *
 * Plumbing tasks & targets:
 * -------------------------
 * Lower level tasks encapsulating a specific piece of functionality
 * but usually only useful when called in combination with another.
 *
 * grunt less         Compile all less files.
 *
 * grunt less:moodle  Compile Moodle less files only.
 *
 * grunt less:editor  Compile editor less files only.
 *
 * grunt decache      Clears the Moodle theme cache.
 *
 *                    Options:
 *
 *                    --dirroot=<path>  Optional. Explicitly define
 *                                      the path to your Moodle root
 *                                      directory when your theme is
 *                                      not in the standard location.
 *
 *                    --urlprefix=<path> Optional. Explicitly define
 *                                       the path between the domain
 *                                       and the installation in the
 *                                       URL, i.e. /moodle26 being:
 *                                       --urlprefix=/moodle26
 *
 * grunt replace             Run all text replace tasks.
 *
 * grunt replace:rtl_images  Add _rtl to the filenames of certain images
 *                           that require flipping for use with RTL
 *                           languages.
 *
 * grunt replace:font_fix    Correct the format for the Moodle font
 *                           loader to pick up the Glyphicon font.
 *
 * grunt replace:svg_colors  Change the color of the SVGs in pix_core by
 *                           text replacing #999 with a new hex color.
 *                           Note this requires the SVGs to be #999 to
 *                           start with or the replace will do nothing
 *                           so should usually be preceded by copying
 *                           a fresh set of the original SVGs.
 *
 *                           Options:
 *
 *                           --svgcolor=<hexcolor> Hex color to use for SVGs
 *
 * grunt cssflip    Create moodle-rtl.css by flipping the direction styles
 *                  in moodle.css.
 *
 *
 * @package theme
 * @subpackage shoehorn
 * @author G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author Based on code originally written by Joby Harding, Bas Brands, David Scotson and many other contributors. * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

module.exports = function(grunt) {

    // Import modules.
    var path = require('path');

    // Theme Bootstrap constants.
    var LESSDIR         = 'less',
        MOODLEURLPREFIX = grunt.option('urlprefix') || '',
        THEMEDIR        = path.basename(path.resolve('.'));

    // PHP strings for exec task.
    var moodleroot = path.dirname(path.dirname(__dirname)),
        configfile = '',
        decachephp = '',
        dirrootopt = grunt.option('dirroot') || process.env.MOODLE_DIR || '';

    // Allow user to explicitly define Moodle root dir.
    if ('' !== dirrootopt) {
        moodleroot = path.resolve(dirrootopt);
    }

    configfile = path.join(moodleroot, 'config.php');

    decachephp += 'define(\'CLI_SCRIPT\', true);';
    decachephp += 'require(\'' + configfile  + '\');';
    decachephp += 'theme_reset_all_caches();';

    var svgcolor = grunt.option('svgcolor') || '#1F4D87';

    grunt.initConfig({
        less: {
            // Compile moodle styles.
            moodle: {
                options: {
                    compress: false,
                    paths: "../bootstrap/less",
                    report: 'min',                    report: 'min',
                    sourceMap: true,
                    sourceMapRootpath: MOODLEURLPREFIX + '/theme/' + THEMEDIR,
                    sourceMapFilename: 'sourcemap-moodle.json'
                },
                src: 'less/moodleallshoehorn.less',
                dest: 'style/moodle.css'
            },
            // Compile editor styles.
            editor: {
                options: {
                    compress: false,
                    paths: "../bootstrap/less",
                    report: 'min',
                    sourceMap: true,
                    sourceMapRootpath: MOODLEURLPREFIX + '/theme/' + THEMEDIR,
                    sourceMapFilename: 'sourcemap-editor.json'
                },
                src: 'less/editorallshoehorn.less',
                dest: 'style/editor.css'
            }
        },
        exec: {
            decache: {
                cmd: 'php -r "' + decachephp + '"',
                callback: function(error, stdout, stderror) {
                    // exec will output error messages
                    // just add one to confirm success.
                    if (!error) {
                        grunt.log.writeln("Moodle theme cache reset.");
                    }
                }
            }
        },
        watch: {
            // Watch for any changes to less files and compile.
            files: ["less/**/*.less", "../bootstrap/less/**/*.less"],
            tasks: ["compile"],
            options: {
                spawn: false
            }
        },
        cssflip: {
            rtl: {
                src:  'style/moodle.css',
                dest: 'style/moodle-rtl.css'
            }
        },
        copy: {
            svg: {
                 expand: true,
                 cwd:  'pix_core_originals/',
                 src:  '**',
                 dest: 'pix_core/',
            }
        },
        replace: {
            rtl_images: {
                src: 'style/moodle-rtl.css',
                    overwrite: true,
                    replacements: [{
                        from: '[[pix:theme|fp/path_folder]]',
                        to:   '[[pix:theme|fp/path_folder_rtl]]'
                    }, {
                        from: '[[pix:t/collapsed]]',
                        to:   '[[pix:t/collapsed_rtl]]'
                    }, {
                        from: '[[pix:t/collapsed_empty]]',
                        to:   '[[pix:t/collapsed_empty_rtl]]'
                    }, {
                        from: '[[pix:y/tn]]',
                        to:   '[[pix:y/tn_rtl]]'
                    }, {
                        from: '[[pix:y/tp]]',
                        to:   '[[pix:y/tp_rtl]]'
                    }, {
                        from: '[[pix:y/ln]]',
                        to:   '[[pix:y/ln_rtl]]'
                    }, {
                        from: '[[pix:y/lp]]',
                        to:   '[[pix:y/lp_rtl]]'
                    }]
            },
            svg_colors: {
                src: 'pix_core/**/*.svg',
                    overwrite: true,
                    replacements: [{
                        from: '#1F4D87',
                        to: svgcolor
                    }]
            },
            font_fix: {
                src: 'style/moodle.css',
                    overwrite: true,
                    replacements: [{
                        from: 'glyphicons-halflings-regular.eot',
                        to:   'glyphicons-halflings-regular.eot]]',
                    }, {
                        from: 'glyphicons-halflings-regular.svg',
                        to:   'glyphicons-halflings-regular.svg]]',
                    }, {
                        from: 'glyphicons-halflings-regular.ttf',
                        to:   'glyphicons-halflings-regular.ttf]]',
                    }, {
                        from: 'glyphicons-halflings-regular.woff',
                        to:   'glyphicons-halflings-regular.woff]]',
                    }]
            }
        }
    });

    // Load contrib tasks.
    grunt.loadNpmTasks("grunt-contrib-less");
    grunt.loadNpmTasks("grunt-contrib-watch");
    grunt.loadNpmTasks("grunt-exec");
    grunt.loadNpmTasks("grunt-text-replace");
    grunt.loadNpmTasks("grunt-css-flip");
    grunt.loadNpmTasks('grunt-contrib-copy');

    // Register tasks.
    grunt.registerTask("default", ["watch"]);
    grunt.registerTask("decache", ["exec:decache"]);

    grunt.registerTask("compile", ["less", "replace:font_fix", "cssflip", "replace:rtl_images", "decache"]);
    grunt.registerTask("svg", ["copy:svg", "replace:svg_colors"]);
};
