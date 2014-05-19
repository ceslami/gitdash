var SettingsLayout = Marionette.Layout.extend({
    template: "#settings",

    regions: {
        generalSettings: '.settings'
    },

    events: {
        "click .save": "saveSettings"
    },

    onShow: function() {
        this.generalSettings.show(new GeneralSettingsView({
            model: App.settings
        }));
    },

    saveSettings: function(e) {
        App.settings.save({
            approval_words: $('input.approval-words').val(),
            freshness_threshold: $('input.freshness-threshold').val(),
            refresh_interval: parseInt($('select.refresh-interval').val()),
            organization: $('select.organization').val()
        });

        $('.saved-successfully').fadeIn(200).delay(1500).fadeOut(200);
    }
});
