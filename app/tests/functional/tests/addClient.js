exports.run = function() {

    casper.test.begin('Add & Delete A Client',function(test) {

        Util.start();
        Util.loginAs('protocol');

        casper.thenOpen(Util.domain+'/clients');

        casper.then(function() {
            this.click(Util.currentPage().addClientButton);
        });

        casper.then(function() {
            var page = Util.currentPage();

            this.fill(page.addClientForm,{
                first_name:'Unit',
                last_name:'Test',
                email:'unit.test@mailinator.com',
                billing_address:'123 test street',
                billing_city:'billing town',
                billing_state:'AK',
                billing_zip:'12345',
                billing_phone:'1234567890'
            });
        });

        casper.then(function() {
            this.click(Util.currentPage().sameAsBillingCheckbox);
        });

        casper.then(function() {
            this.click(Util.currentPage().saveButton);
        });

        casper.then(function() {
            test.assertSelectorHasText(
                Util.currentPage().heading,
                'Unit Test',
                'Client added.'
            );
        });

        casper.then(function() {
            this.click(Util.currentPage().editLink);
        });

        casper.then(function() {
            this.setFilter('page.confirm',function(message) {
                return true;
            });
            this.click(Util.currentPage().deleteLink);
        });

        casper.waitForUrl('/clients',function() {
            test.assert(true,'Client deleted.');
        });

        casper.run(function() {
            test.done();
        });

    });

};