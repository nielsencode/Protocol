exports.run = function() {

   casper.test.begin('Print Protocols',function(test) {

       Util.start();
       Util.loginAs('protocol');

       casper.thenOpen(Util.domain+'/clients');

       casper.then(function() {
           this.click(Util.currentPage().firstClient);
       });

       casper.then(function() {
            this.click(Util.currentPage().printProtocolsLink);
       });

       var printUri = Util.pageUri('/clients/protocols/print');

       casper.waitForPopup(printUri);

       casper.withPopup(printUri,function() {
           test.assertSelectorHasText(
               Util.currentPage().heading,
               'Supplement Schedule for ',
               'Print protocols.'
           );
       });

       casper.run(function() {
           test.done();
       });

   });

};