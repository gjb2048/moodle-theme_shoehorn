require(['core/first'], function() { // jshint ignore:line
    require(['theme_shoehorn/bootstrap', 'theme_shoehorn/anti_gravity', 'core/log'], function(b, ag, log) { // jshint ignore:line
        log.debug('Shoehorn JavaScript initialised');
    });
});
