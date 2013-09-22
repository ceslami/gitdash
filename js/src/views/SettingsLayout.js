var SettingsLayout = Marionette.ItemView.extend({
    template: "#settings",

    events: {
        "keydown .freshness-threshold": "restrictNumeric",
        "click .save": "saveSettings"
    },

    restrictNumeric: function(e) {
        var a = [],
            k = e.which;

        for (i = 48; i < 58; i++) {
            a.push(i);
        }

        if (!(a.indexOf(k)>=0)) {
            e.preventDefault();
        }
    },

    saveSettings: function(e) {
        App.settings.set({
            approval_words: $('input.approval-words').val()
        });

        for(key in App.settings.attributes) {
            if(App.settings.attributes.hasOwnProperty(key)) {
                localStorage.setItem('settings.'+key, App.settings.attributes[key]);
            }
        }
    }
});
