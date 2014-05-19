var FiltersLayout = Marionette.Layout.extend({
    template: "#filters",

    regions: {
        filters: '#filters'
    },

    events: {
        "click .save": "saveSettings"
    },

    onShow: function() {
        this.filters.show(new FiltersView({
            collection: new Filters(App.settings.get('filters'))
        }));
    },

    saveSettings: function(e) {
        App.settings.save({
            filters: this.filters.currentView.collection.models
        });

        $('.saved-successfully').fadeIn(200).delay(1500).fadeOut(200);
    }
});
