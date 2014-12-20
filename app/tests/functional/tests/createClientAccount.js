exports.run = function() {

    casper.test.begin('Add Client Account',function(test) {

        Util.start();
        Util.loginAs('protocol');

        casper.thenOpen(Util.domain+'/clients');

        casper.then(function() {
            this.click(Util.currentPage().firstClient);
        });

        casper.then(function() {
            this.click(Util.currentPage().accountLink);
        });

        casper.then(function() {
            this.click(Util.currentPage().createAccountButton);
        });

        casper.then(function() {
            this.click(Util.currentPage().saveButton);
        });

        casper.then(function() {
            test.assertTextExists('needs to verify their account.','Account added.');
        });

        casper.run(function() {
            test.done();
        });

    });

};