/* jshint ignore:start */
define(['jquery', 'theme_shoehorn/chartist', 'core/log'], function($, Chartist, log) {

  "use strict"; // jshint ;_;

  log.debug('Shoehorn Chartist AMD jQuery initialised');

  return {
    init: function() {
      log.debug('Shoehorn Chartist AMD init initialised');

      $(document).ready(function() {
      // Create a simple bar chart
      var data = {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
        series: [
                  [5, 2, 4, 2, 0]
                ]
              };

        new Chartist.Line('.ct-chart', data);
      });
    }
  }
 });
/* jshint ignore:end */
