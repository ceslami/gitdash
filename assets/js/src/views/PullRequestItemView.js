var PullRequestItemView = Marionette.ItemView.extend({
    template: "#pull-request",
    tagName: 'tbody',

    events: {
        'click tr:not(.header)': 'goToGithub'
    },

    templateHelpers: {
        days_ago: function(asInt) {
            var now = new Date(),
                date = new Date(this.created_at),
                datediff = now.getTime() - date.getTime(),
                daysAgo = Math.floor(datediff/(1000*60*60*24));

            if(asInt) return daysAgo;
            return daysAgo ? daysAgo+' day'+(daysAgo == 1 ? '' : 's')+' ago' : '<24 hours ago';
        },
        has_approval: function() {
            var approvals = _.filter(this.comments_list, function(el) {
                var words = App.settings.get('approval_words').split(','),
                    contains = 0;

                _.each(words, function(word, i) {
                    contains += el.body.indexOf(word.trim()) > -1 ? 1 : 0
                })
                return contains;
            });

            return approvals.length > 0;
        },
        has_approval_badge: function() {
            if(this.has_approval()) {
                return this.print_badge();
            }
        },
        is_off_master: function() {
            return this.base.ref == 'master';
        },
        is_off_master_badge: function() {
            if(this.is_off_master()) {
                return this.print_badge({
                    style: {
                        background: 'red',
                        text: 'white-text'
                    },
                    title: 'Branched off of master',
                    text: '<span class="icon-code-fork" style="font-weight: 900;"></span> Master'
                });
            }
        },
        is_new: function() {
            return this.comments < 1;
        },
        is_new_badge: function() {
            if(this.is_new()) {
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
            var defaults = {
                    style: {
                        background: 'blue',
                        text: 'white-text'
                    },
                    title: 'Ready to merge',
                    text: 'SHIP IT'
                },
                options = _.extend(defaults, options);

            return '<span title="'+options.title+'" class="badge '+options.style.background+' '+options.style.text+'">'+options.text+'</span>';
        }
    },

    goToGithub: function(event) {
        var href = $(event.currentTarget).attr('data-href'),
            win = window.open(href, '_blank');

        win.focus();
    }
});
