var FilterItemView = Marionette.ItemView.extend({
    template: "#filter",
    tagName: 'tbody',

    initialize: function() {
        this.templateHelpers = _.extend({
            model: this.model
        }, this.templateHelpers);
    },

    events: {
        'change select': 'saveFilters',
        'keyup input': 'saveFilters',
        'click input': 'makeEditable',
        'blur input': 'saveFilters'
    },

    onShow: function() {
        var self = this;

        this.$(".color-picker").spectrum({
            color: "#"+this.model.get('bgColor'),
            move: function(color) {
                self.$('.badge').css('background', color.toHexString());
            },
            change: function(color) {
                self.$('.badge').css('background', color.toHexString());
                self.model.set({
                    bgColor: color.toHexString()
                });
            }
        });
    },

    saveFilters: function() {
        console.log({
            name: this.$('.name').val(),
            description: this.$('.description').val(),
            bgColor: this.$('.bgColor').val(),
            conditions: [{
                property: this.$('.property').val(),
                operator: this.$('.operator').val(),
                value: this.$('.value').val()
            }]
        })
        this.model.set({
            name: this.$('.name').val(),
            description: this.$('.description').val(),
            bgColor: this.$('.bgColor').val(),
            conditions: [{
                property: this.$('.property').val(),
                operator: this.$('.operator').val(),
                value: this.$('.value').val()
            }]
        });
    },

    makeEditable: function(e) {
        var input = $(e.currentTarget);

        if(input.is(':disabled') && !input.is(':focus')) {
            input.removeAttr('disabled');
        }
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
                    var isSelected = el == this.model.get('conditions')[0].property ? 'selected' : '';
                    return memo += "<option "+isSelected+">"+el+"</option>";
                }, "<optgroup label='Methods'></optgroup>", this),
                attributes_list = _.reduce(_.pairs(attributes), function(memo, el) {
                    var key = el[0],
                        value = el[1],
                        isSelected = key == this.model.get('conditions')[0].property ? 'selected' : '';
                    return memo += "<option "+isSelected+" value='"+key+"'>"+value+"</option>";
                }, "<optgroup label='Pull Request Attributes'></optgroup>", this);

            return methods_list+attributes_list;
        },
        operator_menu: function() {
            var operators = {
                '===': 'equals',
                '>': 'greater than',
                '<': 'less than',
                'contains': 'contains'
            };

            return _.reduce(_.pairs(operators), function(memo, el) {
                var key = el[0],
                    value = el[1],
                    isSelected = value == this.model.get('conditions')[0].operator ? 'selected' : '';
                return memo += "<option "+isSelected+" value='"+key+"'>"+value+"</option>";
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
