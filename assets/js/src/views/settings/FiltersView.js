var FiltersView = Marionette.CompositeView.extend({
    template: "#settings-filters",

    itemView: FilterItemView,
    itemViewContainer: '.filters',

    events: {
        'click .add-filter': 'addFilter'
    },

    addFilter: function() {
        this.collection.add(new Filter({
            name: 'New badge',
            description: '',
            bgColor: 'rgb(0, 143, 255)',
            conditions: [{
                property: 'hasApproval',
                operator: '===',
                value: 'true'
            }]
        }));
    },

    randomString: function(len, charSet) {
        var randomString = '',
            charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'+
                             'abcdefghijklmnopqrstuvwxyz'+
                             '0123456789';

        for (var i = 0; i < len; i++) {
            var randomPoz = Math.floor(Math.random() * charSet.length);
            randomString += charSet.substring(randomPoz,randomPoz+1);
        }
        return randomString;
    }
});
