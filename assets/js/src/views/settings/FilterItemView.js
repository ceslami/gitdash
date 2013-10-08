var FilterItemView = Marionette.ItemView.extend({
    template: "#filter",
    tagName: 'tbody',

    initialize: function() {
        this.templateHelpers = _.extend({
            model: this.model
        }, this.templateHelpers);
    },

    templateHelpers: {
        print_all_conditions: function() {
            return _.reduce(this.model.get('conditions'), function(memo, el) {
                return memo += this.print_condition(el);
            }, "", this);
        },
        print_condition: function(el) {
            return el.property + ' ' + el.operator + ' ' + el.value;
        },
        properties_menu: function() {
            var pr = App.collections.pull_requests.at(0),
                // attributes = _.keys(pr.attributes),
                attributes = {
                    'created_at': 'Created Date',
                    'updated_at': 'Last Updated',
                    'title': 'Title',
                    'body': 'Description',
                    'user.login': 'Submitter',
                    'state': 'State',
                    'repo.name': 'Repository Name',
                    'base.ref': 'Branched Off',
                    'mergeable': 'Auto-mergable',
                    'comments': 'Comments',
                    'additions': 'Additions',
                    'deletions': 'Deletions',
                    'changed_files': 'Changed Files'
                },
                methods = _.keys(_.omit(pr.__proto__, ['constructor', '__proto__'])),
                unique_methods = _.difference(methods, _.keys(Backbone.Model.prototype)),

                methods_list = _.reduce(unique_methods, function(memo, el) {
                    console.log(this.model.get('conditions').property);
                    console.log(el)
                    var isSelected = el == this.model.get('conditions')[0].property ? 'selected' : '';
                    return memo += "<option "+isSelected+">"+el+"</option>";
                }, "<optgroup label='Methods'></optgroup>", this),
                attributes_list = _.reduce(attributes, function(memo, el) {
                    var isSelected = el == this.model.get('conditions')[0].property ? 'selected' : '';
                    return memo += "<option "+isSelected+">"+el+"</option>";
                }, "<optgroup label='Pull Request Attributes'></optgroup>", this);

            return methods_list+attributes_list;
        },
        operator_menu: function() {
            var operators = {
                'equals': '===',
                'greater than': '>',
                'less than': '<',
                'contains': 'contains'
            };

            return _.reduce(operators, function(memo, el) {
                var isSelected = el == this.model.get('conditions')[0].operator ? 'selected' : '';
                return memo += "<option "+isSelected+">"+el+"</option>";
            }, "<optgroup label='Pull Request Attributes'></optgroup>", this);
        },
        value_menu: function(property) {
            var type = 'boolean';
                // property.type;

            if(type === 'boolean') {
                return _.reduce({
                    'true': 'true',
                    'false': 'false'
                }, function(memo, el) {
                    var isSelected = el == this.model.get('conditions')[0].value ? 'selected' : '';
                    return memo += "<option "+isSelected+">"+el+"</option>";
                }, "<optgroup label='Pull Request Attributes'></optgroup>", this);
            }
        }
    }
});
