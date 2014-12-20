exports.run = function() {

    return {
        uri:'\\/protocols\\/supplements$',
        selectors:{
            firstSupplement:'.supplements li:first-of-type',
            addButton:'.button[name="add button"]'
        }
    };

};