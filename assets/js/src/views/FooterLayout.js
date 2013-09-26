var FooterLayout = Marionette.Layout.extend({
    template: "#footer",

    events: {
        "click ul.pages li": "goToPage"
    },

    goToPage: function(e) {
        var page = $(e.currentTarget).data('page');
        App.router.navigate('/'+page, true)
    }
});
