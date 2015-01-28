tour.addSteps([
    {
        element: '.master-navbar-account-dropdown',
        placement: 'left',
        title: "Subscriber Settings",
        content: "Click the account dropdown.",
        next: -1,
        onShow: function(tour) {
            $('.master-navbar-account-dropdown').click(function() {
                setTimeout(function() {
                    tour.goTo(tour.getCurrentStep()+1);
                });
            });
        }
    },
    {
        element: '.master-navbar-dropdown-menu-item:contains("Settings")',
        placement: 'left',
        title: "Subscriber Settings",
        content: "Click the settings link.",
        next: -1,
        prev: -1,
        onShow: function(tour) {
            $('.master-navbar-dropdown-menu-item:contains("Settings")').click(function() {
                tour.goTo(tour.getCurrentStep()+1);
            });
        }
    },
    {
        element: 'body',
        placement: 'top',
        title: "Subscriber Settings",
        content: "This is the settings page. Here you can customize your site.",
        prev: -1
    },
    {
        element: '.colorpicker',
        placement: 'right',
        title: "Theme Color",
        content: "Click a color to change your theme color, then click \"Next.\""
    },
    {
        element: ':input[name="logo"]',
        placement: 'bottom',
        title: "Logo",
        content: "Here you can upload your logo. It will be automatically placed in the header."
    },
    {
        element: '.button:contains("Save")',
        placement: 'top',
        title: "Save Settings",
        content: "Click \"Save\" to save your settings.",
        next: -1,
        onShow: function(tour) {
            $('.button:contains("Save")').click(function() {
                tour.goTo(tour.getCurrentStep()+1);
            });
        }
    },
    {
        element: 'body',
        placement: 'top',
        title: "Subscriber Settings",
        content: "Your settings have been saved!",
        prev: -1
    }
]);