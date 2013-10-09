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
            return '<span title="'+options.title+'" class="badge '+options.style.text+'" style="background:'+options.style.background+'">'+options.text+'</span>';
        },
        print_badges: function() {
            var self = this,
                filters = new Filters(App.settings.get('filters'));

            return _.reduce(filters.models, function(memo, filter) {
                if (filter.test(self.model)) {
                    memo += self.print_badge(filter.getBadgeSettings());
                }
                return memo;
            }, "");
        }
    },

    goToGithub: function(event) {
        var href = $(event.currentTarget).attr('data-href'),
            win = window.open(href, '_blank');

        win.focus();
    }
});
