$(function() {
    $('.import-content').css({
        marginTop:-1*$('.import-content').outerHeight(true)/2-33
    });

    $('.button').click(function() {
        $(':input[type="file"]').click();
    });

    $(':input[type="file"]').change(function() {
        $(this).closest('form').submit();
    });

    $('.ok-button').click(function() {
        parent.$('.modal-dialog').css('left','9999px');
        parent.$('.modal-dialog-box-frame').get(0).contentDocument.location.reload();
        parent.location.reload();
    });
});