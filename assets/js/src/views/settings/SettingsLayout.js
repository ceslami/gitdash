var SettingsLayout = Marionette.ItemView.extend({
    template: "#settings",

    events: {
        "keydown .freshness-threshold": "restrictNumeric",
        "click .save": "saveSettings"
    },

    templateHelpers: {
        organization_list: function() {
            var options,
                user = App.collections.user;

            _.each(user.get('organizations'), function(el, i) {
                options += "<option value='"+el.login+"' "+(App.settings.get('organization') == el.login ? 'selected' : '')+">"+el.login+"</option>";
            })

            return options;
        }
    },

    restrictNumeric: function(e) {
        var a = [],
            k = e.which;

        for (i = 48; i < 58; i++) {
            a.push(i);
        }
        a.push(8); // backspace
        a.push(46); // delete

        if (!(a.indexOf(k)>=0)) {
            e.preventDefault();
        }
    },

    saveSettings: function(e) {
        App.settings.save({
            approval_words: $('input.approval-words').val(),
            freshness_threshold: $('input.freshness-threshold').val(),
            refresh_interval: parseInt($('select.refresh-interval').val()),
            organization: $('select.organization').val()
        });

        $('.saved-successfully').fadeIn(200).delay(1500).fadeOut(200)
    }
});
