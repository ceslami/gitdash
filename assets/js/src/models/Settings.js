var Settings = Backbone.Model.extend({
    initialize: function() {
        this.set({
            approval_words: localStorage.getItem('settings.approval_words') ? localStorage.getItem('settings.approval_words') : null,
            freshness_threshold: localStorage.getItem('settings.freshness_threshold') ? localStorage.getItem('settings.freshness_threshold') : null,
            refresh_interval: localStorage.getItem('settings.refresh_interval') ? localStorage.getItem('settings.refresh_interval') : null,
            organization: 'Betterment'
        });
    }
});

