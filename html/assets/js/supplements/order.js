$(function() {
    $(':input[name="recurring_order"]').change(function() {
        var checked = $(this).is(':checked') ? 1 : 0;
        $('.frequency-section').toggle(checked);
        $(':input[name="autoshipfrequency_id"]').prop('disabled',1-checked);
        $(':input[name="starting_at"]').prop('disabled',1-checked);
    });

    var minDate = new Date();
    minDate.setDate(minDate.getDate()+1);

    var maxDate = new Date();
    maxDate.setMonth(maxDate.getMonth()+1);

    $(':input[name="starting_at"]').datepicker({
        minDate:minDate,
        maxDate:maxDate
    });

    $(':input[name="starting_at"]').datepicker('setDate',minDate);
});