/* jshint ignore:start */
define(['jquery', 'theme_shoehorn/chartist', 'core/log'], function($, Chartist, log) {

  "use strict"; // jshint ;_;

  log.debug('Shoehorn Chartist AMD jQuery initialised');

  return {
    init: function(data) {
      log.debug('Shoehorn Chartist AMD init initialised');
      log.debug(data);

      $(document).ready(function() {
      // Create a simple bar chart
      /*var data = {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
        series: [
                  [5, 2, 4, 2, 0]
                ]
              }; */

        var options = {
          axisX: {
            showLabel: true
          },
          axisY: {
            onlyInteger: true
          },
          chartPadding: {
            top: 15,
            right: 5,
            bottom: 5,
            left: 5
          },
          showPoint: true
        };
        new Chartist.Line('.ct-chart', data, options);
      });
    }
  }
 });
/* jshint ignore:end */
