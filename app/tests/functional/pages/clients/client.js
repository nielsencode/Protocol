exports.run = function() {

    return {
        uri:'\\/clients\\/[0-9]+$',
        selectors:{
            accountLink:'.client-menu-item:nth-of-type(2)',
            addProtocolButton:'.button[value="Add"]',
            heading:'.heading',
            editLink:'.info-table-edit-link',
            firstProtocol:'.client-protocols-table-header-cell-link:first-of-type',
            printProtocolsLink:'.client-print-protocols-link'
        }
    };

};