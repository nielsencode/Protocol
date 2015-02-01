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
        $('.protocol-table-label-cell').each(function() {
            var contents = $(this).clone();
            var fixed = $('<div></div>').append(contents);

            fixed.css({
                position:'absolute',
                left:$(this).position().left,
                top:$(this).position().top
            });

            contents.css({
                height:$(this).height()+1,
                width:$(this).width()+2
            });

            $(this).after(fixed);
        });

        // Fixed column - portrait
        var head = $('.protocol-table-head-portrait');

        if(head.length) {

            var clone = head.clone().css({
                position: 'absolute',
                top: head.position().top,
                width: '100%'
            });

            head.find('.protocol-table-label-cell-portrait').each(function (index) {
                var cells = clone.find('.protocol-table-label-cell-portrait');

                $(cells[index]).css({
                    width: $(this).width() + 1,
                    height: $(this).height() + 2
                });
            });

            head.after(clone);

        }

        // Supplement link padding - landscape
        var height = $('.protocol-table-supplement-link').first().outerHeight();

        $('.protocol-table-supplement-link').each(function() {
            var textHeight = $(this).find('.protocol-table-supplement-name').height();

            var padding = (height-textHeight)/2;

            $(this).css({
                paddingTop:padding,
                paddingBottom:padding
            });
        });

        // Supplement link padding - portrait
        $('.protocol-table-supplement-link-portrait').each(function() {
            var textHeight = $(this).find('.protocol-table-supplement-name').height();

            var padding = ($(this).height()-textHeight)/2;

            $(this).css({
                paddingTop:Math.max(padding+8,14),
                paddingBottom:Math.max(padding+8,14)
            });
        });

    }
});