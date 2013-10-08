var SettingsLayout = Marionette.Layout.extend({
    template: "#settings",

    regions: {
        generalSettings: '.settings',
        filters: '#filters'
    },

    onShow: function() {
        var generalSettingsView = new GeneralSettingsView({
                model: App.settings
            }),
            filtersView = new FiltersView({
                collection: App.settings.get('filters')
            });

        this.generalSettings.show(generalSettingsView);
        this.filters.show(filtersView);
    }
});
