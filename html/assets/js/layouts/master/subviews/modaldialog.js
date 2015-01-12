$(function() {
    var dialogBox = $('.modal-dialog-box');

    dialogBox.css({
        marginLeft:-1*dialogBox.outerWidth(true)/2,
        marginTop:-1*dialogBox.outerHeight(true)/2
    });

    $('.modal-dialog-box-close').click(function() {
        $('.modal-dialog').css('left',9999);
        var src = $('.modal-dialog-box-frame').attr('src');
        $('.modal-dialog-box-frame').attr('src',src);
    });
});