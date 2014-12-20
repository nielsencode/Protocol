exports.run = function() {

    return {
        uri:'\\/supplements\\/[0-9]+\\/order$',
        selectors:{
            recurringOrder:'input[name="recurring_order"]',
            orderForm:'form:first-of-type'
        }
    };

};