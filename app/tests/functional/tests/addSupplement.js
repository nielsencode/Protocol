exports.run = function() {

    casper.test.begin('Add & Delete A Supplement',function(test) {

        Util.start();
        Util.loginAs('protocol');

        casper.thenOpen(Util.domain+'/supplements');

        casper.then(function() {
            this.click(Util.currentPage().addSupplementButton);
        });

        var supplementName = Date.now().toString();

        casper.then(function() {
            this.fill('form:first-of-type',{
                name:supplementName,
                price:'99.99'
            },true);
        });

        casper.then(function() {
            test.assertSelectorHasText(
                Util.currentPage().heading,
                supplementName,
                'Supplement added.'
            );
        });

        casper.then(function() {
            this.click(Util.currentPage().editSupplementLink);
        });

        casper.then(function() {
            this.setFilter('page.confirm',function(message) {
                return true;
            });
            this.click(Util.currentPage().deleteSupplementLink);
        });

        casper.then(function() {
            test.assertUrlMatch(
                Util.pageUri('/supplements/index'),
                'Supplement deleted.'
            )
        });

        casper.run(function() {
            test.done();
        });

    });

};