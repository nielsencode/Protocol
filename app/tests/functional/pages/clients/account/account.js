exports.run = function() {

    return {
        uri:'\\/clients\\/[0-9]+\\/account$',
        selectors:{
            createAccountButton:'.button[name="create account button"]',
            loginAsLink:'a[name="login as client"]'
        }
    };

};