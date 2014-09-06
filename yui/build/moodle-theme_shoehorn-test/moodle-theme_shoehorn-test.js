YUI.add('moodle-theme_shoehorn-test', function (Y, NAME) {

/**
The Shoehorn theme's test JavaScript

@namespace Moodle
@module theme_shoehorn.test
**/

M.theme_shoehorn = M.theme_shoehorn || {};
M.theme_shoehorn.test = M.theme_shoehorn.test || {};
M.theme_shoehorn.test = {
    init: function() {
        showInheritance(Y);
    }
};

/**
@class Moodle.theme_shoehorn.test
@uses node
@uses selector-css3
@constructor
**/
/* var NS = Y.namespace('M.theme_shoehorn.test'); */

/**
 * Initialise the Moodle Bootstrap theme JavaScript
 *
 * @method init
 */
/*NS.init = function() {
    showInheritance(Y);
};

var MYCLASS = function() {
     MYCLASS.superclass.constructor.apply(this, arguments);
};*/

/* https://yuilibrary.com/yui/docs/yui/yui-extend.html */
function Bird(name) {
    this.name = name;
}

Bird.prototype.flighted   = true;  // Default for all Birds
Bird.prototype.isFlighted = function () { return this.flighted; };
Bird.prototype.getName    = function () { return this.name; };

function Chicken(name) {
    // Chain the constructors
    Chicken.superclass.constructor.call(this, name);
}
// Chickens are birds
Y.extend(Chicken, Bird);

// Define the Chicken prototype methods/members
//Chicken.prototype.flighted = false; // Override default for all Chickens

Chicken.prototype.isFlighted = function () { return false; };

function showInheritance(Y) {
    var chicken = new Chicken('Little');





    // Chicken instances inherit Bird methods and members

}


}, '@VERSION@', {"requires": [""]});
