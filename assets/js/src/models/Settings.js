var Settings = Backbone.Model.extend({
    initialize: function() {
        this.set({
            approval_words: localStorage.getItem('settings.approval_words') || 'lgtm, LGTM',
            freshness_threshold: localStorage.getItem('settings.freshness_threshold') || 3,
            refresh_interval: localStorage.getItem('settings.refresh_interval') || 10,
            organization: localStorage.getItem('settings.organization') || 'Betterment'
        });

        var isOffMaster = new Filter({
                name: '<span class="icon icon-code-fork"></span> Master',
                description: 'Branched off of master',
                bgColor: 'red',
                conditions: [
                    {
                        property: 'isOffMaster',
                        comparator: '===',
                        value: 'true'
                    }
                ]
            }),
            filters = new Filters([isOffMaster]);

        this.set({
            filters: filters
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

