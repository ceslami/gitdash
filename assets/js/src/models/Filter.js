var Filter = Backbone.Model.extend({
    test: function(model) {
        var self = this,
            failed = _.reduce(this.get('conditions'), function(memo, el) {

                // Figure out if the value needs to be wrapped as a string
                var value = (el.value == 'true' || el.value == 'false') ? el.value : '"'+el.value+'"',
                    condition = (typeof model[el.property] === 'function')
                    ? 'model["'+el.property+'"]()'+el.operator+value
                    : 'model.get("'+el.property+'")'+el.operator+value;

                return eval(condition) ? memo : ++memo;
            }, 0);

            console.log()

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

