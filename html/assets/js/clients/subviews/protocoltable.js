$(function() {
    window.onload = function() {
        var widths = [];

        $('.client-protocols-table-label-cell').each(function () {
            var height = ($(this).siblings().first().height() - $(this).height()) / 2;
            var padding = (parseInt($(this).css('padding-top')) + parseInt($(this).css('padding-bottom'))) / 2;

            $(this).css({
                paddingTop: height + padding,
                paddingBottom: height + padding
            });

            widths.push($(this).width());
        });

        $('.client-protocols-table-label-cell').each(function () {
            $(this).css('width', Math.max.apply(Math, widths));
            $(this).siblings().first().css({
                paddingLeft: $(this).outerWidth(true) + parseInt($(this).css('padding-left'))
            });
        });

        $('.client-protocols-table-header-cell-link').each(function () {
            var parent = $(this).closest('.client-protocols-table-header-cell');
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

        $('.client-protocols-table-row').each(function () {
            $(this).children('.client-protocols-table-cell,.client-protocols-table-header-cell').each(function (index) {
                if ($(this).text().replace(/\s+/, '').length) {
                    var className = 'protocol-color' + parseInt((index % 3) + 1);
                    $(this).addClass(className);
                }
            });
        });
    }
});