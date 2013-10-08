var FilterItemView = Marionette.ItemView.extend({
    template: "#filter",
    tagName: 'tbody',

    initialize: function() {
        this.templateHelpers =  _.extend({
            model: this.model
        }, this.templateHelpers);
    },

    templateHelpers: {
        print_all_conditions: function() {
            var self = this;
            return _.reduce(this.model.get('conditions'), function(memo, el) {
                return memo += self.print_condition(el);
            }, "");
        },
        print_condition: function(el) {
            return el.property + ' ' + el.comparator + ' ' + el.value;
        },
        properties_menu: function() {
            var pr = App.collections.pull_requests.at(0),
                attributes = _.keys(pr.attributes),
                methods = _.keys(_.omit(pr.__proto__, ['constructor', '__proto__'])),
                unique_methods = _.difference(methods, _.keys(Backbone.Model.prototype)),

                methods_list = _.reduce(unique_methods, function(memo, el) {
                    return memo += "<option>"+el+"</option>";
                }, "<optgroup label='Methods'></optgroup>"),
                attributes_list = _.reduce(attributes, function(memo, el) {
                    return memo += "<option>"+el+"</option>";
                }, "<optgroup label='Pull Request Attributes'></optgroup>");

            return methods_list+attributes_list;
        }
    }
});
