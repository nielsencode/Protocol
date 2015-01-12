$(function() {
    $(':input[name="same_as_billing"]').change(function() {
        if(!$(this).is(':checked')) {
            return false;
        }

        var fields = [
            'address',
            'city',
            'state',
            'zip',
            'phone'
        ];

        $.each(fields,function(key,value) {
            var billing = $(':input[name="billing_'+value+'"]');
            var shipping = $(':input[name="shipping_'+value+'"]');
            shipping.val(billing.val());
        });
    });
});