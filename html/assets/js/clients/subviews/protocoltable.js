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

        clone.css('width',$('.protocol-table').width());

        var container = $('<div></div>')
            .addClass('protocol-table-column-fixed')
            .append(clone);

        container.css({
            width:$('.protocol-table-label-cell').first().outerWidth(true)
        });

        $('.protocol-table').after(container);

        // Fixed column - portrait
        var clone = $('.protocol-table-portrait').clone();

        var container = $('<div></div>')
            .addClass('protocol-table-portrait-header-fixed')
            .append(clone);

        container.css({
            height:$('.protocol-table-label-cell-portrait').outerHeight(true),
            width:$('.protocol-table-portrait').outerWidth()
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