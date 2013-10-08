var Filter = Backbone.Model.extend({
    test: function(model) {
        var self = this,
            failed = _.reduce(this.get('conditions'), function(memo, el) {
                var condition = (typeof model[el.property] === 'function')
                    ? eval('model["'+el.property+'"]()'+el.operator+el.value)
                    : eval('model.get("'+el.property+'")'+el.operator+el.value);

                return condition ? memo : ++memo;
            }, 0);

        return !failed;
    },
    getBadgeSettings: function() {
        return {
            style: {
                background: this.get('bgColor'),
                text: 'white-text'
            },
            title: this.get('description'),
            text: this.get('name')
        };
    }
});

