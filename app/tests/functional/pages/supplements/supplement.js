exports.run = function() {

    return {
        uri:'\\/supplements\\/[0-9]+$',
        selectors:{
            heading:'.heading',
            editSupplementLink:'.info-table-edit-link',
            orderButton:'.button[name="order button"]'
        }
    };

};