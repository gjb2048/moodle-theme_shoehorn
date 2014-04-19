YUI.add('moodle-theme_shoehorn-test', function (Y, NAME) {

/**
The Shoehorn theme's test JavaScript

@namespace Moodle
@module theme_shoehorn.test
**/

/**
@class Moodle.theme_shoehorn.test
@uses node
@uses selector-css3
@constructor
**/
var NS = Y.namespace('Moodle.theme_shoehorn.test');

/**
 * Initialise the Moodle Bootstrap theme JavaScript
 *
 * @method init
 */
NS.init = function() {
    Y.log('Shoehorn YUI test');
};


}, '@VERSION@', {"requires": ["node", "selector-css3"]});
