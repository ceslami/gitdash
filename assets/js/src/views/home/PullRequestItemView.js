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
        is_off_master_badge: function() {
            if(this.model.isOffMaster()) {
                return this.print_badge({
                    style: {
                        background: 'red',
                        text: 'white-text'
                    },
                    title: 'Branched off of master',
                    text: '<span class="icon icon-code-fork"></span> Master'
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
        }
    },

    goToGithub: function(event) {
        var href = $(event.currentTarget).attr('data-href'),
            win = window.open(href, '_blank');

        win.focus();
    }
});
