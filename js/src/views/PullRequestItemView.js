var PullRequestItemView = Marionette.ItemView.extend({
    template: "#pull-request",
    tagName: 'tbody',

    events: {
        'click tr:not(.header)': 'goToGithub'
    },

    templateHelpers: {
        days_ago: function(timestamp) {
            var now = new Date(),
                date = new Date(this.created_at),
                datediff = now.getTime() - date.getTime(),
                daysAgo = Math.floor(datediff/(1000*60*60*24));

            return daysAgo ? daysAgo+' day'+(daysAgo == 1 ? '' : 's')+' ago' : '<24 hours ago';
        },
        has_approval: function(phrase) {
            var approvals = _.filter(this.comments_list, function(el) {
                return el.body.indexOf(phrase) > -1;
            });

            return approvals.length > 0;
        },
        has_approval_badge: function(phrase) {
            if(this.has_approval(phrase)) {
                return this.print_badge();
            }
        },
        is_off_master: function() {
            return this.base.repo.master_branch == 'master';
        },
        is_off_master_badge: function() {
            if(this.is_off_master()) {
                return this.print_badge({
                    style: {
                        background: 'red',
                        text: 'white-text'
                    },
                    title: 'Branched off of master',
                    text: 'Master'
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
                    text: 'LGTM'
                },
                options = _.extend(defaults, options);

            return '<span title="'+options.title+'" class="badge '+options.style.background+' '+options.style.text+'">'+options.text+'</span>';
        }
    },

    goToGithub: function(event) {
        var href = $(event.currentTarget).attr('data-href');

        var win = window.open(href, '_blank');
        win.focus();
    },

    initialize:function(){
        console.log(this.model)
    }
});
