exports.run = function() {

    return {
        uri:'\\/clients(\\?[^\\?]+)?$',
        selectors:{
            firstClient:'.index-table-cell:first-of-type a',
            addClientButton:'.button[name="add client"]',
            searchForm:'form[name="search form"]'
        }
    }

};