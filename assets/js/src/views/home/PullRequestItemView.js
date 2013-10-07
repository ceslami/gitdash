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
        print_badge: function(options) {
            return '<span title="'+options.title+'" class="badge '+options.style.background+' '+options.style.text+'">'+options.text+'</span>';
        },
        print_badges: function() {
            var self = this,
                filters = App.settings.get('filters').models,
                badges = "";

            _.each(filters, function(filter, i) {
                // ...then print a badge if none did.
                if (filter.test(self.model)) {
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
