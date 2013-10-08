var GeneralSettingsView = Marionette.ItemView.extend({
    template: '#settings-general',

    events: {
        "keydown .freshness-threshold": "restrictNumeric",
        "click .save": "saveSettings"
    },

    templateHelpers: {
        organization_list: function() {
            var organizations = App.collections.user.get('organizations'),
                current = App.settings.get('organization');

            return _.reduce(organizations, function(memo, el) {
                var isSelected = current == el.login ? 'selected' : '';
                return memo += "<option value='"+el.login+"' "+isSelected+">"+el.login+"</option>";
            }, "");
        }
    },

    restrictNumeric: function(e) {
        a = [48,49,50,51,52,53,54,55,56,57]; // 0-9
        a.concat([8,46]); // backspace and delete

        if (!_.contains(a, e.which)) {
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

        $('.saved-successfully').fadeIn(200).delay(1500).fadeOut(200);
    }
});
