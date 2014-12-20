exports.run = function() {

    return {
        uri:'\\/clients\\/[0-9]+\\/protocols\\/print$',
        selectors:{
            heading:'.heading'
        }
    };

};