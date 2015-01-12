exports.run = function() {

    casper.test.begin('Edit Supplement',function(test) {

        Util.start();
        Util.loginAs('protocol');

        casper.thenOpen(Util.domain+'/supplements');

        casper.then(function() {
            this.click(Util.currentPage().firstSupplement);
        });

        casper.then(function() {
            this.click(Util.currentPage().editSupplementLink);
        });

        var supplementName = Date.now().toString();

        casper.then(function() {
            this.sendKeys(Util.currentPage().nameField,supplementName);
        });

        casper.then(function() {
            this.click(Util.currentPage().saveButton);
        });

        casper.then(function() {
            test.assertSelectorHasText(
                Util.currentPage().heading,
                supplementName,
                'Supplement edited.'
            );
        });

        casper.run(function() {
            test.done();
        });

    });

};