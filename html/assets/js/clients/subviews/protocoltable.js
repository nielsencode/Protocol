$(function() {
    window.onload = function() {

        // Colors - landscape
        $('.protocol-table-row').each(function() {
            $(this).children('.protocol-table-cell,.protocol-table-supplement-cell').each(function(index) {
                if ($(this).text().replace(/\s+/, '').length) {
                    var color = 'protocol-color'+(index%3+1);
                    $(this).addClass(color);
                }
            });
        });

        // Colors - portrait
        $('.protocol-table-supplement-cell-portrait').each(function(index) {
            var color = 'protocol-color'+(index%3+1);
            $(this).addClass(color);

            $(this).siblings('.protocol-table-cell-portrait').each(function() {
                if ($(this).text().replace(/\s+/, '').length) {
                    $(this).addClass(color);
                }
            });
        });

        // Fixed column - landscape
        var clone = $('.protocol-table').clone();

        var container = $('<div></div>').append(clone);

        container.css({
            width:$('.protocol-table-label-cell').first().outerWidth(true),
            overflowX:'hidden',
            position:'absolute',
            top:0
        });

        $('.protocol-table').after(container);

        // Fixed column - portrait
        var clone = $('.protocol-table-portrait').clone();

        var container = $('<div></div>').append(clone);

        container.css({
            position:'absolute',
            top:'-1px',
            height:$('.protocol-table-label-cell-portrait').outerHeight(true),
            overflowY:'hidden',
            width:$('.protocol-table-portrait').outerWidth(),
            overflowX:'hidden'
        });

        $('.protocol-table-portrait').after(container);

        // Supplement link padding - landscape
        var height = $('.protocol-table-supplement-cell').height();

        $('.protocol-table-supplement-link').each(function() {
            var textHeight = $(this).height();

            var padding = (height-textHeight)/2;

            $(this).css({
                paddingTop:padding,
                paddingBottom:padding
            });
        });

        // Supplement link padding - portrait
        $('.protocol-table-supplement-link-portrait').each(function() {
            var height = $(this).closest('.protocol-table-supplement-cell-portrait').outerHeight();
            var textHeight = $(this).height();

            var padding = (height-textHeight)/2;

            $(this).css({
                paddingTop:padding,
                paddingBottom:padding
            });
        });

    }
});