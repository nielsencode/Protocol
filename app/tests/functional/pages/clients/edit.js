exports.run = function() {

    return {
        uri:'\\/clients\\/[0-9]+\\/edit$',
        selectors:{
            deleteLink:'.addedit-delete-link',
            editClientForm:'form[name="edit client"]'
        }
    };

};