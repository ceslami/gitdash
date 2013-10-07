var PullRequestItemView = Marionette.ItemView.extend({
    template: "#pull-request",
    tagName: 'tbody',

    events: {
        'click tr:not(.header)': 'goToGithub'
    },

    initialize: function() {
        this.templateHelpers =  _.extend({
            model: this.model
        }, this.templateHelpers);
    },

    templateHelpers: {
        has_approval_badge: function() {
            if(this.model.hasApproval()) {
                return this.print_badge({
                    style: {
                        background: 'blue',
                        text: 'white-text'
                    },
                    title: 'Ready to merge',
                    text: 'SHIP IT'
                });
            }
        },
        is_new_badge: function() {
            if(this.model.isUncommented()) {
                return this.print_badge({
                    style: {
                        background: 'green',
                        text: 'white-text'
                    },
                    title: 'Has not been commented on yet',
                    text: 'NEW'
                });
            }
        },
        print_badge: function(options) {
            return '<span title="'+options.title+'" class="badge '+options.style.background+' '+options.style.text+'">'+options.text+'</span>';
        },
        print_badges: function() {
            var self = this,
                filters = App.settings.get('filters').models,
                badges = "";

            _.each(filters, function(filter, i) {

                // Find out if any of the conditions have failed...
                var failed = _.reduce(filter.get('conditions'), function(memo, el) {
                    var condition = (typeof self.model[el.property] === 'function')
                        ? eval('self.model["'+el.property+'"]()'+el.comparator+el.value)
                        : eval('self.model.get("'+el.property+'")'+el.comparator+el.value);

                    return condition ? memo : ++memo;
                }, 0);

                // ...then print a badge if none did.
                if (!failed) {
                    badges += self.print_badge({
                        style: {
                            background: filter.get('bgColor'),
                            text: 'white-text'
                        },
                        title: filter.get('description'),
                        text: filter.get('name')
                    });
                }
            });

            return badges;
        }
    },

    goToGithub: function(event) {
        var href = $(event.currentTarget).attr('data-href'),
            win = window.open(href, '_blank');

        win.focus();
    }
});
