exports.run = function(Util) {

    var page = require(Util.testPath+'/pages/clients/client.js').run();

    page.uri = '\\/profile#?$';

    return page;

};