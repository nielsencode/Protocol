var timezone = jstz.determine();

$.ajax({
    type: "POST",
    url:'/timezone/set',
    data:{name:timezone.name()}
});