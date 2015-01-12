exports.run = function(Util) {

    var page = require(Util.testPath+'/pages/clients/protocols/add.js').run();

    page.uri = '\\/protocols\\/[0-9]+\\/edit$';

    return page;

};