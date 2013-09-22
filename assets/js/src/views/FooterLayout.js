var FooterLayout = Marionette.Layout.extend({
    template: "#footer",

    events: {
        "click .home": "home",
        "click .settings": "settings"
    },

    home: function() {
        App.router.navigate('/', true);
    },

    settings: function() {
        App.router.navigate('/settings', true)
    }
});
