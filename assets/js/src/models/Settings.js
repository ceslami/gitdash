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
            hasApproval = new Filter({
                name: 'Ship It',
                description: 'Ready to merge',
                bgColor: 'blue',
                conditions: [
                    {
                        property: 'hasApproval',
                        comparator: '===',
                        value: 'true'
                    }
                ]
            }),
            isUncommented = new Filter({
                name: 'New',
                description: 'Has not been commented on yet',
                bgColor: 'green',
                conditions: [
                    {
                        property: 'isUncommented',
                        comparator: '===',
                        value: 'true'
                    }
                ]
            }),
            filters = new Filters([isOffMaster, hasApproval, isUncommented]);

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

