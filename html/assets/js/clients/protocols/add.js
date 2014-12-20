function addSupplement(supplement) {
    $('.supplement').html(supplement.name+'&nbsp;&nbsp;&nbsp;');
    $(':input[name="supplement"]').val(supplement.id);
}

$(function() {
    $(':input[name$="prescription"]').focus(function() {
        $(this).closest('.form-row').find(':input[name$="scheduletime_id"]').prop('checked',true);
    });

    $('.choose-supplement').click(function() {
        $('.modal-dialog').css('left',0);
    });

    $(':input[name="supplement"]').change(function() {
        if($(this).val().length) {
            $('.disabled-button').removeAttr('disabled').removeClass('disabled-button').addClass('button');
        }
    });
});