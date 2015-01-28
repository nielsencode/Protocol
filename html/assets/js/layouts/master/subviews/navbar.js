$(function() {

    // Navbar dropdown menus.

    $(document).on('click',function(e) {
        var item = $(e.target).closest('.master-dropdown-navbar-item');

        if(item.length) {
            var link = item.children('.master-small-navbar-link');
            var dropdown = item.children('.master-navbar-dropdown-menu');

            if($(e.target).closest('.master-small-navbar-link').is(link)) {
                link.toggleClass('is-selected');
                dropdown.toggle();
            }

            var items = $('.master-dropdown-navbar-item').not(item);
        }
        else {
            var items = $('.master-dropdown-navbar-item');
        }

        items.children('.master-small-navbar-link').removeClass('is-selected');
        items.children('.master-navbar-dropdown-menu').hide();
    });

});