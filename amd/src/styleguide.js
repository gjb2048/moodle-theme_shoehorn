/* jshint ignore:start */
define(['jquery', 'theme_shoehorn/bootstrap', 'theme_shoehorn/holder', 'core/log'], function ($, bootstrap, holder, log) {

    "use strict"; // jshint ;_;

    log.debug('Shoehorn Style Guide AMD');

    return {
        init: function () {
            $(document).ready(function ($) {
                !(function (log) {
                    'use strict';

                    log.debug('Shoehorn Style Guide AMD ie10-viewport-bug-workaround init');
                    // See the Getting Started docs for more information:....
                    // http://getbootstrap.com/getting-started/#support-ie10-width.
                    if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
                        var msViewportStyle = document.createElement('style')
                        msViewportStyle.appendChild(
                                document.createTextNode('@-ms-viewport{width:auto!important}')
                                )
                        document.querySelector('head').appendChild(msViewportStyle)
                        log.debug('Shoehorn Style Guide AMD ie10-viewport-bug-workaround active');
                    }
                })(log);

                $("[data-toggle=tooltip]").tooltip();
                $("[data-toggle=popover]").popover().click(function (e) {
                    e.preventDefault()
                });

                // Navigation fake block.
                $(".bs-docs-sidenav > li").each(function() {
                    var $nav = $(this).children(".nav");
                    $(this).hover(
                        function() {
                            $nav.addClass("hovered");
                        }, function() {
                            $nav.removeClass("hovered");
                        }
                    );
                });
            });
            log.debug('Shoehorn Style Guide AMD init');
        }
    }
});
/* jshint ignore:end */
