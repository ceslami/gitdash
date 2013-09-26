var Settings = Backbone.Model.extend({
    initialize: function() {
        this.set({
            approval_words: localStorage.getItem('settings.approval_words') ? localStorage.getItem('settings.approval_words') : 'lgtm',
            freshness_threshold: localStorage.getItem('settings.freshness_threshold') ? localStorage.getItem('settings.freshness_threshold') : 3,
            refresh_interval: localStorage.getItem('settings.refresh_interval') ? localStorage.getItem('settings.refresh_interval') : 10,
            organization: 'Betterment'
        });
    },
    sync: function(method, model, options) {
        for(key in model.attributes) {
            if(model.attributes.hasOwnProperty(key)) {
                localStorage.setItem('settings.'+key, model.attributes[key]);
            }
        }
    }
});

