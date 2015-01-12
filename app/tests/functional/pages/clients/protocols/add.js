exports.run = function() {

    return {
        uri:'\\/clients\\/[0-9]+\\/protocols\\/add$',
        selectors:{
            chooseSupplementLink:'.choose-supplement',
            firstPrescription:'.long-form-text:first-of-type',
            saveButton:'.button[value="Save"]'
        }
    };

};