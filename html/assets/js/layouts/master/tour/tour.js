var tour = new Tour();

var steps = [];

require([
    'tour/partials/intro',
    'tour/partials/subscriberSettings',
    'tour/partials/addClient',
    //'tour/partials/'
],function() {
    if(!tour._current) {
        tour.init();
    }

    $(function() {
        if($('.master-navbar-dropdown-menu-item:contains("Settings")').length) {
            //tour.end();
            tour.restart();
            //tour.start();
        }
    });

    console.log(tour);
});