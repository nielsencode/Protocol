exports.run = function() {

    return {
        uri:'\\/clients\\/[0-9]+\\/account\\/add$',
        selectors:{
            saveButton:'.button[value="Save"]'
        }
    };

};