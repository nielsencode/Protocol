exports.run = function() {

    casper.test.begin('Login As Client',function(test) {

        Util.start();

        Util.loginAs('protocol');

        casper.thenOpen(Util.domain+'/clients');

        casper.then(function() {
            this.fill(Util.currentPage().searchForm,{
                q:'test client'
            },true);
        });

        casper.then(function() {
            this.click(Util.currentPage().firstClient);
        });

        casper.then(function() {
            this.click(Util.currentPage().accountLink);
        });

        casper.then(function() {
            this.click(Util.currentPage().loginAsLink);
        });

        casper.waitForUrl(Util.pageUri('/profile'));

        casper.then(function() {
            test.assertDoesntExist(
                Util.currentPage().addProtocolButton,
                'Logged in as client.'
            );
        });

        casper.then(function() {
            this.capture('capture.png');
        });

        casper.run(function() {
            test.done();
        });

    });

};