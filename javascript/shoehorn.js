
require(['core/first'], function() {
    require(['theme_shoehorn/bootstrap', 'theme_shoehorn/anti_gravity', 'core/log'], function(b, ag, log) {
        log.debug('Shoehorn JavaScript initialised');
    });
});
