exports.run = function() {

    casper.test.begin('Edit Protocol',function(test) {

        Util.start();
        Util.loginAs('protocol');

        casper.thenOpen(Util.domain+'/clients');

        casper.then(function() {
            this.click(Util.currentPage().firstClient);
            this.click(Util.currentPage().firstClient);
        });

        casper.then(function() {
            this.click(Util.currentPage().firstProtocol);
        });

        var prescription = Date.now().toString();

        casper.then(function() {
            this.sendKeys(Util.currentPage().firstPrescription,prescription);
        });

        casper.then(function() {
            this.click(Util.currentPage().saveButton);
        });

        casper.then(function() {
            test.assertMatch(
                this.evaluate(function() {
                    return $('.client-protocols-table-cell').first().text();
                }),
                new RegExp(prescription),
                'Protocol edited.'
            );
        });

        casper.run(function() {
            test.done();
        });

    });

};