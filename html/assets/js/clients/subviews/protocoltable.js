$(function() {
    window.onload = function() {
        var widths = [];

        $('.client-protocols-table-label-cell').each(function () {
            widths.push($(this).width());
        });

        $('.client-protocols-table-label-cell').each(function () {
            $(this).css('width', Math.max.apply(Math, widths));
            $(this).siblings().first().css({
                paddingLeft: $(this).outerWidth(true) + parseInt($(this).css('padding-left'))
            });
        });

        $('.client-protocols-table-label-cell').each(function () {
            var height = ($(this).siblings().first().height() - $(this).height()) / 2;
            var padding = (parseInt($(this).css('padding-top')) + parseInt($(this).css('padding-bottom'))) / 2;

            $(this).css({
                paddingTop: height + padding,
                paddingBottom: height + padding
            });
        });

        $('.client-protocols-table-supplement-cell-link').each(function () {
            var parent = $(this).closest('td,th');
            var height = (parent.height() - $(this).outerHeight(true)) / 2;

            var paddingTop = parseInt(parent.css('padding-top'));
            var paddingBottom = parseInt(parent.css('padding-bottom'));
            var paddingLeft = parseInt(parent.css('padding-left'));
            var paddingRight = parseInt(parent.css('padding-right'));

            parent.css('padding', 0);

            $(this).css({
                paddingTop: height + paddingTop,
                paddingBottom: height + paddingBottom,
                paddingLeft: paddingLeft,
                paddingRight: paddingRight
            });
        });

        // Colors - landscape
        $('.client-protocols-table-row').each(function () {
            $(this).children('.client-protocols-table-cell,.client-protocols-table-header-cell').each(function (index) {
                if ($(this).text().replace(/\s+/, '').length) {
                    var className = 'protocol-color' + parseInt((index % 3) + 1);
                    $(this).addClass(className);
                }
            });
        });

        // Colors - portrait
        $('.client-protocols-table-portrait-row').each(function(index) {
            var className = 'protocol-color' + parseInt((index % 3) + 1);

            $(this).children('.client-protocols-table-portrait-cell').each(function() {
                if ($(this).text().replace(/\s+/, '').length) {
                    $(this).addClass(className);
                }
            });
        });
    }
});