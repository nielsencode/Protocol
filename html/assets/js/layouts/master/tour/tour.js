var tour = new Tour();

var steps = [];

require([
    'tour/partials/intro',
    'tour/partials/subscriberSettings',
    'tour/partials/addClient',
    //'tour/partials/'
],function() {
    tour.init();

    $(function() {
       //tour.restart();
    });
});