var FiltersView = Marionette.CompositeView.extend({
    template: "#settings-filters",

    itemView: FilterItemView,
    itemViewContainer: '.filters',

    events: {
        'click .add-filter': 'addFilter'
    },

    addFilter: function() {
        this.collection.add(new Filter({
            name: this.randomString(4, 'YSMD')+' '+this.randomString(2, 'AP'),
            description: 'Ready to merge',
            bgColor: '#00ff00',
            conditions: [
                {
                    property: 'hasApproval',
                    operator: '===',
                    value: 'true'
                }
            ]
        }));
        console.log(this.collection)
    },

    randomString: function(len, charSet) {
        charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var randomString = '';
        for (var i = 0; i < len; i++) {
            var randomPoz = Math.floor(Math.random() * charSet.length);
            randomString += charSet.substring(randomPoz,randomPoz+1);
        }
        return randomString;
    }
});
