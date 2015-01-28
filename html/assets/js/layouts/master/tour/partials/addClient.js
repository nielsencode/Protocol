tour.addSteps([
    {
        element: 'body',
        placement: 'top',
        title: "Add A Client",
        content: "Let's look at how to add a client."
    },
    {
        element: '.master-navbar-link:contains("Clients")',
        placement: 'bottom',
        title: "Add A Client",
        content: "Click the clients tab.",
        next: -1,
        onShow: function(tour) {
            $('.master-navbar-link:contains("Clients")').click(function() {
                tour.goTo(tour.getCurrentStep()+1);
            });
        }
    },
    {
        element: 'body',
        placement: 'top',
        title: "Clients Page",
        content: "This is the clients page. Here you can sort and search for clients.",
        prev: -1
    },
    {
        element: '.button:contains("Add Client")',
        placement: 'right',
        title: "Add A Client",
        content: "Click \"Add Client\"",
        next: -1,
        onShow: function(tour) {
            $('.button:contains("Add Client")').click(function() {
                tour.goTo(tour.getCurrentStep()+1);
            });
        }
    },
    {
        element: 'body',
        placement: 'top',
        title: "Add A Client",
        content: "To add a client, just fill out this form, then click \"Save\" at the bottom of the page.",
        prev: -1,
        next: -1,
        onShow: function(tour) {
            $('.button[value="Save"]').click(function() {
                tour.goTo(tour.getCurrentStep()+1);
            });
        }
    },
    {
        element: 'body',
        placement: 'top',
        title: function() {
            return $('.error-message').length
                ? "Add A Client"
                : "Client Saved.";
        },
        content: function() {
            return $('.error-message').length
                ? "Oops! Looks like you have some errors. Try fixing them and clicking \"Save\" again."
                : "Your client has been saved!";
        },
        prev: -1,
        onShown: function() {
            if($('.error-message').length) {
                $('.tour-tour button[data-role="next"]').addClass('disabled');
            }
        }
    }
]);