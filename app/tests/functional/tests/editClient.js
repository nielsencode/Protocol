exports.run = function() {

    casper.test.begin('Edit Client',function(test) {

        Util.start();
        Util.loginAs('protocol');

        casper.thenOpen(Util.domain+'/clients');

        casper.then(function() {
            this.click(Util.currentPage().firstClient);
        });

        casper.then(function() {
            this.click(Util.currentPage().editLink);
        });

        var email = Date.now()+'@mailinator.com';

        casper.then(function() {
            this.fill(Util.currentPage().editClientForm,{
                email:email
            },true);
        });

        casper.then(function() {
            test.assertTextExists(email,'Client edited.');
        });

        casper.run(function() {
            test.done();
        });

    });

};