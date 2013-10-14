var FilterItemView = Marionette.ItemView.extend({
    template: "#filter",
    tagName: 'tbody',

    initialize: function() {
        this.templateHelpers = _.extend(this, this.templateHelpers);
    },

    events: {
        'change select': 'saveFilters',
        'keyup input': 'saveFilters',
        'click input': 'makeEditable',
        'blur input': 'saveFilters',
        'click .delete': 'destroy'
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
                console.log(self.model)
            },
            hide: function(color) {
                self.$('.badge').css('background', color.toHexString());
            }
        });
    },

    saveFilters: function() {
        this.$('.badge').text(this.$('.name').val())
        this.model.set({
            name: this.$('.name').val(),
            description: this.$('.description').val(),
            bgColor: this.$('.color-picker').spectrum("get").toHexString(),
            conditions: [{
                property: this.$('.property').val(),
                operator: this.$('.operator').val(),
                value: this.$('.value').val()
            }]
        });
        console.log({
            name: this.$('.name').val(),
            description: this.$('.description').val(),
            bgColor: this.$('.color-picker').spectrum("get").toHexString(),
            conditions: [{
                property: this.$('.property').val(),
                operator: this.$('.operator').val(),
                value: this.$('.value').val()
            }]
        })
    },

    makeEditable: function(e) {
        var input = $(e.currentTarget);

        if(input.is(':disabled') && !input.is(':focus')) {
            input.removeAttr('disabled');
        }
    },

    destroy: function() {
        var self = this;

        this.$el.fadeOut(300, function() {
            self.model.destroy();
        });
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
                attributes = this.filter_attributes,
                methods = _.keys(_.omit(pr.__proto__, ['constructor', '__proto__'])),
                unique_methods = _.difference(methods, _.keys(Backbone.Model.prototype)),

                methods_list = _.reduce(unique_methods, function(memo, el) {
                    var isSelected = el == this.model.get('conditions')[0].property ? 'selected' : '';
                    return memo += "<option "+isSelected+">"+el+"</option>";
                }, "<optgroup label='Methods'></optgroup>", this),
                attributes_list = _.reduce(attributes, function(memo, el) {
                    var isSelected = el.name == this.model.get('conditions')[0].property ? 'selected' : '';
                    return memo += "<option "+isSelected+" value='"+el.name+"'>"+el.description+"</option>";
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
                console.log(el)
                var key = el[0],
                    value = el[1],
                    isSelected = key == this.model.get('conditions')[0].operator ? 'selected' : '';
                return memo += "<option "+isSelected+" value='"+key+"'>"+value+"</option>";
            }, "<optgroup label='Operators'></optgroup>", this);
        },
        value_menu: function(property) {
            var property = this.model.get('conditions')[0].property,
                attribute = _.first(_.where(this.filter_attributes, {
                    name: property
                }));

            if(!_.isUndefined(attribute) && attribute.input === 'text') {
                return "<input class='value' style='font-size:12px;float:none' type='text' value='"+this.model.get('conditions')[0].value+"' />";
            } else if(!_.isUndefined(attribute) && attribute.input === 'range') {
                return '<input type="number" style="font-size:12px;float:none" class="value" name="points" min="1" max="1000000" value="'+this.model.get('conditions')[0].value+'">';
            } else if(!_.isUndefined(attribute) && attribute.input === 'date') {
                return '<input type="date" style="font-size:12px;float:none" class="value" name="bday" value="'+this.model.get('conditions')[0].value+'">';
            } else {
                return _.reduce({
                    'true': 'true',
                    'false': 'false'
                }, function(memo, el) {
                    var isSelected = el == this.model.get('conditions')[0].value ? 'selected' : '';
                    return memo += "<option "+isSelected+">"+el+"</option>";
                }, "<select class='value'>", this)+'</select>';
            }
        }
    },
    filter_attributes: [
        {
            name: 'created_at',
            description: 'Created Date',
            input: 'date'
        },
        {
            name: 'updated_at',
            description: 'Last Updated',
            input: 'date'
        },
        {
            name: 'title',
            description: 'Title',
            input: 'text'
        },
        {
            name: 'body',
            description: 'Description',
            input: 'text'
        },
        {
            name: 'user.login',
            description: 'Submitter',
            input: 'text'
        },
        {
            name: 'state',
            description: 'State',
            input: 'text'
        },
        {
           name: 'repo.name',
           description: 'Repository Name',
           input: 'text'
        },
        {
            name: 'base.ref',
            description: 'Branched Off',
            input: 'text'
        },
        {
            name: 'mergeable',
            description: 'Auto-mergable',
            input: 'boolean'
        },
        {
            name: 'comments',
            description: 'Comments',
            input: 'text'
        },
        {
            name: 'additions',
            description: 'Additions',
            input: 'range'
        },
        {
            name: 'deletions',
            description: 'Deletions',
            input: 'range'
        },
        {
            name: 'changed_files',
            description: 'Changed Files',
            input: 'range'
        }
    ]
});
