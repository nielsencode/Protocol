exports.run = function() {

    return {
        uri:'\\/supplements\\/[0-9]+\\/edit$',
        selectors:{
            deleteSupplementLink:'.addedit-delete-link',
            nameField:'#name',
            saveButton:'.button[value="Save"]'
        }
    };

};