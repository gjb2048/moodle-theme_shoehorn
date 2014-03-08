/**
 * Gruntfile for compiling theme_bootstrap .less files.
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
 *               recompile all less files and clear the theme cache.
 *
 *               Options:
 *
 *               --dirroot=<path>  Optional. Explicitly define the
 *                                 path to your Moodle root directory
 *                                 when your theme is not in the
 *                                 standard location.
 *
 * grunt swatch  Task for working with bootswatch files. Expects a
 *               convention to be followed - bootswatch files are
 *               contained within a directory providing the name
 *               by which the swatch is identified. By default the
 *               directory these should be placed in is less/bootswatch
 *               however the user may optionally override this.
 *               e.g. swatch files contained within a directory
 *               located at less/bootswatch/squib will be associated
 *               with the swatch name 'squib'.
 *
 *               Switches the current bootswatch files compiled with
 *               the theme to those of a given bootswatch, recompiles
 *               less and clears the theme cache.
 *
 *               Options:
 *
 *               --name=<swatchname>    Required. Name (as defined by
 *                                      the convention) of the swatch
 *                                      to activate.
 *
 *               --swatches-dir=<path>  Optional. Explicitly define
 *                                      the path to the directory
 *                                      containing your bootswatches
 *                                      (default is less/bootswatch).
 *
 *               --vars-only            Optional. Copy the swatch's
 *                                      variables.less file only
 *                                      and empty custom-bootswatch.less
 *                                      Due to issues with grunt's
 *                                      handling of boolean options
 *                                      if not explicitly set e.g.
 *                                      `--vars-only=true` this option
 *                                      should be passed last.
 *
 *
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
 * grunt bootswatch  Switch the theme less/bootswatch/custom-bootswatch.
 *                   less and less/bootswatch/custom-variables.less
 *                   files for those of a given bootswatch theme using
 *                   convention described in swatch task.
 *
 *                   Options:
 *
 *                   --name=<swatchname>    Required. Name (as defined by
 *                                          the convention) of the swatch
 *                                          to activate.
 *
 *                   --swatches-dir=<path>  Optional. Explicitly define
 *                                          the path to the directory
 *                                          containing your bootswatches
 *                                          (default is less/bootswatch).
 *
 *                   --vars-only            Optional. Copy the swatch's
 *                                          variables.less file only
 *                                          and empty custom-bootswatch.less
 *                                          Due to issues with grunt's
 *                                          handling of boolean options
 *                                          if not explicitly set e.g.
 *                                          `--vars-only=true` this option
 *                                          should be passed last.
 *
 *
 * @package theme
 * @subpackage bootstrap
 * @author Joby Harding www.iamjoby.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

module.exports = function(grunt) {

    // Import modules.
    var path = require('path');

    // Theme Bootstrap constants.
    var LESSDIR         = 'less',
        BOOTSWATCHDIR   = path.join(LESSDIR, 'bootswatch'),
        BOOTSWATCHFILE  = path.join(BOOTSWATCHDIR, 'custom-bootswatch.less'),
        BOOTSWATCHVARS  = path.join(BOOTSWATCHDIR, 'custom-variables.less');

    // PHP strings for exec task.
    var moodleroot = 'dirname(dirname(__DIR__))',
        configfile = '',
        decachephp = '',
        dirrootopt = grunt.option('dirroot') || '';

    // Allow user to explicitly define Moodle root dir.
    if ('' !== dirrootopt) {
        moodleroot = 'realpath("' + dirrootopt + '")';
    }

    configfile = moodleroot + ' . "/config.php"';

    decachephp += "define(\"CLI_SCRIPT\", true);";
    decachephp += "require(" + configfile  + ");";
    decachephp += "theme_reset_all_caches();";

    grunt.initConfig({
        less: {
            // Compile moodle styles.
            moodle: {
                options: {
                    compress: true,
                    paths: "../bootstrap/less",
                    report: 'min',
                    sourceMap: false,
                    outputSourceFiles: true
                },
                files: {
                    "style/moodle.css": "less/moodleallshoehorn.less",
                }
            },
            // Compile editor styles.
            editor: {
                options: {
                    compress: true,
                    paths: "../bootstrap/less",
                    report: 'min',
                    sourceMap: false,
                    outputSourceFiles: true
                },
                files: {
                    "style/editor.css": "less/editorallshoehorn.less"
                }
            }
        },
        exec: {
            decache: {
                cmd: "php -r '" + decachephp + "'",
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
            tasks: ["less:moodle", "less:editor", "exec:decache"],
            options: {
                spawn: false
            }
        }
    });

    // Load contrib tasks.
    grunt.loadNpmTasks("grunt-contrib-less");
    grunt.loadNpmTasks("grunt-contrib-watch");
    grunt.loadNpmTasks("grunt-exec");

    // Register tasks.
    grunt.registerTask("default", ["watch"]);
    grunt.registerTask("decache", ["exec:decache"]);
};