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

var MYCLASS = function() {
     MYCLASS.superclass.constructor.apply(this, arguments);
};

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

    Y.log('Running: ' + (new Date()));

    Y.log(((chicken instanceof Object) ?
        "chicken IS an instance of Object." :
        "chicken IS NOT an instance of Object."));

    Y.log(((chicken instanceof Bird) ?
        "chicken IS an instance of Bird." :
        "chicken IS NOT an instance of Bird."));

    Y.log(((chicken instanceof Chicken) ?
        "chicken IS an instance of Chicken." :
        "chicken IS NOT an instance of Chicken."));

    // Chicken instances inherit Bird methods and members
    Y.log(((chicken.isFlighted()) ?
        "chicken CAN fly." :
        "chicken CAN NOT fly."));

    Y.log("chicken's name is " + chicken.getName() + ".");
}

showInheritance(Y);


}, '@VERSION@', {"requires": ["node", "selector-css3"]});
