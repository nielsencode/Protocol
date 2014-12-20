var Util = require('util.js').run();

casper.options.clientScripts.push(
    Util.basePath+'/html/assets/js/jquery.min.js'
);

Util.run([
    'addClient',
    'editClient',
    'createClientAccount',
    'editProtocol',
    'printProtocols',
    'addSupplement',
    'editSupplement',
    //'addProtocol',
    'loginAsClient',
    'orderProtocolSupplement'
]);