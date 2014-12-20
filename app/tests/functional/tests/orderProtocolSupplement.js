exports.run = function() {

    casper.test.begin('Order Protocol Supplement',function(test) {

        Util.start();
        Util.loginAs('client');

        casper.thenOpen(Util.domain+'/profile');

        casper.then(function() {
            this.click(Util.currentPage().firstProtocol);
        });

        casper.then(function() {
            this.click(Util.currentPage().orderButton);
        });

        casper.then(function() {
            this.click(Util.currentPage().recurringOrder);
        });

        casper.then(function() {
            this.fill(Util.currentPage().orderForm,{},true);
        });

        casper.then(function() {
            test.assertTextExists(
                'Your order has been placed.',
                'Order placed.'
            )
        });

        casper.run(function() {
            test.done();
        });

    });

};