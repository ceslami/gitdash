var SettingsLayout = Marionette.Layout.extend({
    template: "#settings",

    regions: {
        generalSettings: '.settings',
        filters: '#filters'
    },

    onShow: function() {
        var self = this;

        App.settings.fetch().done(function() {
            App.settings.attributes = App.settings.get('0');

            var filters = new Filters(App.settings.get('filters')),
                generalSettingsView = new GeneralSettingsView({
                    model: App.settings
                }),
                filtersView = new FiltersView({
                    collection: filters
                });

            self.generalSettings.show(generalSettingsView);
            self.filters.show(filtersView);
        })
    }
});
