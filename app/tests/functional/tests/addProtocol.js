exports.run = function() {

    casper.test.begin('Add Protocol',function(test) {

        Util.start();
        Util.loginAs('protocol');

        casper.thenOpen(Util.domain+'/clients');

        casper.then(function() {
            this.click(Util.page('/clients/index').firstClient);
        });

        casper.then(function() {
            this.click(Util.page('/clients/index').addProtocolButton);
        });

        casper.then(function() {
            this.click(Util.page('/clients/protocols/add').chooseSupplementLink);
        });

        casper.withFrame(0,function() {
            this.click(Util.page('/protocols/subviews/supplements').firstSupplement);
        });

        casper.withFrame(0,function() {
            this.waitForSelector(Util.page('/protocols/subviews/supplements').addButton);
        });

        casper.withFrame(0,function() {
            this.click(Util.page('/protocols/subviews/supplements').addButton);
        });

        /*casper.then(function() {
            this.fill('form:first-of-type',{
                'schedules=>0=>prescription':'take 1'
            });
        });*/

        casper.then(function() {
            this.capture('capture.png');
        });

        casper.run(function() {
            test.done();
        });

    });

};