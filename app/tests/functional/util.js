exports.run = function() {

    var Util = function() {

        var me = this;

        this.basePath = '/var/www';
        this.testPath = this.basePath+'/app/tests/functional';
        this.domain = 'http://192.168.33.10';
        this.pages = {};

        this.modules = {
            pages:[
                '/clients/add',
                '/clients/client',
                '/clients/edit',
                '/clients/index',
                '/clients/account/add',
                '/clients/account/account',
                '/clients/protocols/add',
                '/clients/protocols/print',
                '/profile',
                '/protocols/edit',
                '/protocols/subviews/supplements',
                '/supplements/edit',
                '/supplements/index',
                '/supplements/order',
                '/supplements/supplement'
            ]
        };

        this.credentials = {
            protocol:{
                email:'nick@nicknielsencode.com',
                pass:'Portent1',
                home:'\\/clients$'
            },
            client:{
                email:'test.client@mailinator.com',
                pass:'testpass',
                home:'\\/profile$'
            }
        };

        this.loginAs = function(rolename) {
            var credentials = this.credentials[rolename];

            casper.thenOpen(this.domain+'/logout');
            casper.thenOpen(this.domain+'/login');

            casper.then(function() {
                this.fill('form[name="login"]',{
                    email:credentials.email,
                    password:credentials.pass
                },true);
            });

            casper.waitForUrl(new RegExp(credentials.home));
        };

        this.currentPage = function() {
            var url = casper.getCurrentUrl();

            for(var i in this.pages) {
                var page = this.pages[i];
                if(url.match(new RegExp(page.uri))) {
                    return page.selectors;
                }
            }

            return false;
        };

        this.pageUri = function(path) {
            return new RegExp(this.pages[path].uri);
        }

        this.loadPages = function() {
            for(var i in this.modules.pages) {
                var path = this.modules.pages[i];
                var page = require(this.testPath+'/pages'+path).run(this);
                this.pages[path] = page;
            }
        };

        this.run = function(tests) {
            for(var i in tests) {
                require(this.testPath+'/tests/'+tests[i]+'.js').run();
            }
        };

        this.start = function() {
            casper.start(this.domain);
        };

        (function() {
            me.loadPages();
        })();

    };

    return new Util;

};