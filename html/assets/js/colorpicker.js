$(function() {

    /*
     |--------------------------------------------------------------------------
     | Styles
     |--------------------------------------------------------------------------
     |
     */

    var colorpickerCss = $('\
        <style type="text/css">\
            .colorpicker {\
                background-color:#fff;\
                display:inline-block;\
            }\
            \
            .colorpicker:after {\
                content:"";\
                display:block;\
                clear:both;\
            }\
            \
            .colorpicker-tile {\
                float:left;\
                cursor:pointer;\
                border-bottom:2px solid rgba(0,0,0,.2);\
                margin:1px;\
                width:15px;\
                height:13px;\
            }\
            \
            .colorpicker-tile-selected {\
                border:2px solid #000;\
                width:11px;\
                height:11px;\
            }\
            \
            .colorpicker-empty-tile {\
                border:1px dotted #000;\
                text-align:center;\
                width:13px;\
                height:13px;\
                background:none;\
            }\
        </style>\
    ');

    $('head').prepend(colorpickerCss);

    /*
     |--------------------------------------------------------------------------
     | Plugin
     |--------------------------------------------------------------------------
     |
     */

    $.fn.colorpicker = function (options) {

        var Colorpicker = function (options) {

            var colorpicker = $('<div class="colorpicker"></div>');

            /*
             |--------------------------------------------------------------------------
             | Options
             |--------------------------------------------------------------------------
             |
             */

            colorpicker.settings = $.extend({
                rowsize: 7,
                value: '',
                colors: [
                    '#1BBC9B',
                    '#2ECD71',
                    '#3598DB',
                    '#9B58B5',
                    '#34495E',
                    '#16A086',
                    '#27AE61',
                    '#5299C7',
                    '#8F44AD',
                    '#2D3E50',
                    '#F1C40F',
                    '#E77E23',
                    '#E84C3D',
                    '#EFF3F4',
                    '#ABB7B7',
                    '#F39C11',
                    '#D55401',
                    '#C1392B',
                    '#BEC3C7',
                    '#7E8C8D'
                ]
            }, options);

            /*
             |--------------------------------------------------------------------------
             | Objects
             |--------------------------------------------------------------------------
             |
             */

            var Tile = function (color) {
                var tile = $('<div class="colorpicker-tile"></div>');

                if (color.length) {
                    tile.attr('value', color);
                    tile.css({
                        backgroundColor: color
                    });
                }
                else {
                    tile.attr('value', '');
                    tile.addClass('colorpicker-empty-tile');
                }

                return tile;
            };

            var Input = function () {
                var input = $('<input type="hidden" class="colorpicker-input"/>');
                return input;
            };

            /*
             |--------------------------------------------------------------------------
             | Methods
             |--------------------------------------------------------------------------
             |
             */

            colorpicker.clear = function () {
                colorpicker.find('.colorpicker-tile').removeClass('colorpicker-tile-selected');
            };

            colorpicker.setValue = function (value) {
                colorpicker.find('.colorpicker-input').val(value);
            };

            colorpicker.getValue = function () {
                return colorpicker.find('.colorpicker-input').val();
            };

            /*
             |--------------------------------------------------------------------------
             | Event Handlers
             |--------------------------------------------------------------------------
             |
             */

            colorpicker.mousedown(function (event) {
                var target = $(event.target);
                var tile = target.closest('.colorpicker-tile');

                if (tile.length) {
                    colorpicker.clear();
                    tile.addClass('colorpicker-tile-selected');
                }

                colorpicker.change();
            });

            colorpicker.change(function () {
                var value = colorpicker.find('.colorpicker-tile-selected').attr('value');
                colorpicker.setValue(value);
            });

            /*
             |--------------------------------------------------------------------------
             | Construction
             |--------------------------------------------------------------------------
             |
             */

            colorpicker.append(new Input());

            $.each(colorpicker.settings.colors, function (index, color) {
                var tile = new Tile(color);
                colorpicker.append(tile);

                if ((index + 1) % colorpicker.settings.rowsize == 0) {
                    colorpicker.append('<br>');
                }
            });

            colorpicker.find('.colorpicker-tile').each(function () {
                if ($(this).attr('value') == colorpicker.settings.value) {
                    $(this).click();
                }
            });

            return colorpicker;
        };

        /*
         |--------------------------------------------------------------------------
         | Construction
         |--------------------------------------------------------------------------
         |
         */

        options = $.extend({},options);

        var colors = [];
        this.find('option').each(function() {
            colors.push($(this).attr('value'));
        });
        options.colors = colors;

        var picker = new Colorpicker(options);

        picker.find('.colorpicker-input').attr('name',this.attr('name'));

        var value = this.find('option[selected]').attr('value');
        picker.find('.colorpicker-tile[value="'+value+'"]').mousedown();

        this.after(picker);
        this.remove();

        return picker;

    }
}(jQuery));