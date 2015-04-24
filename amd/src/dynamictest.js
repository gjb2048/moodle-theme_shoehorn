/* jshint ignore:start */
define(['jquery'], function($) {

  "use strict"; // jshint ;_;

  console.log('Shoehorn dynamic AMD jQuery initialised');

  $('body').addClass('shoehorndynamic');

  return {
    init: function(dtparm) {
      console.log('Shoehorn dynamic AMD jQuery init initialised');
      console.log(dtparm.a);
      console.log(dtparm.b);
    }
  }
 });
/* jshint ignore:end */
