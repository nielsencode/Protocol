$(function() {
    $('.supplement').mousedown(function() {
        $('.selected-supplement').removeClass('selected-supplement').addClass('supplement');
        $(this).removeClass('supplement').addClass('selected-supplement');
        $('.disabled-button').removeAttr('disabled').removeClass('disabled-button').addClass('button');
    });

    $('.cancel').click(function() {
        parent.$('.modal-dialog-box-close').click();
    });

    $('.buttons').on('click','.button',function() {
        var supplement = JSON.parse(decodeURIComponent($('.selected-supplement').attr('supplement')));
        parent.addSupplement(supplement);
        parent.$(':input[name="supplement"]').change();
        parent.$('.modal-dialog-box-close').click();
    });
});