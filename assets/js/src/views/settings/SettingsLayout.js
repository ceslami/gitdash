var SettingsLayout = Marionette.Layout.extend({
    template: "#settings",

    regions: {
        generalSettings: '.settings',
        filters: '#filters'
    },

    events: {
        "click .save": "saveSettings"
    },

    onShow: function() {
        this.generalSettings.show(new GeneralSettingsView({
            model: App.settings
        }));
        this.filters.show(new FiltersView({
            collection: new Filters(App.settings.get('filters'))
        }));
    },

    saveSettings: function(e) {
        App.settings.save({
            approval_words: $('input.approval-words').val(),
            freshness_threshold: $('input.freshness-threshold').val(),
            refresh_interval: parseInt($('select.refresh-interval').val()),
            organization: $('select.organization').val(),
            filters: this.filters.currentView.collection.models
        });

        $('.saved-successfully').fadeIn(200).delay(1500).fadeOut(200);
    }
});
