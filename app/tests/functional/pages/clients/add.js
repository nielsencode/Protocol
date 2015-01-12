exports.run = function() {

    return {
        uri:'\\/clients\\/add$',
        selectors:{
            addClientForm:'form:first-of-type',
            sameAsBillingCheckbox:'#same_as_billing',
            saveButton:'.button[value="Save"]'
        }
    };

};