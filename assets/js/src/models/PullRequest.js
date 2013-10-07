var PullRequest = Backbone.Model.extend({
    days_ago: function(asInt) {
        var now = new Date(),
            date = new Date(this.get('created_at')),
            datediff = now.getTime() - date.getTime(),
            daysAgo = Math.floor(datediff/(1000*60*60*24)),
            unit = daysAgo === 1 ? 'day' : 'days';

        if(asInt) return daysAgo;

        return daysAgo
                ? daysAgo+' '+unit+' ago'
                : '<24 hours ago';
    },
    hasApproval: function() {
        var approvals = _.filter(this.allComments(), function(el) {
            var words = App.settings.get('approval_words').split(','),
                contains = 0;

            _.each(words, function(word, i) {
                contains += el.body.indexOf(word.trim()) > -1 ? 1 : 0
            })
            return contains;
        });

        return approvals.length > 0;
    },
    isUncommented: function() {
        return this.allComments() < 1;
    },
    isOffMaster: function() {
        return this.get('base').ref == 'master';
    },
    allComments: function() {
        return this.get('comments_list').concat(this.get('review_comments_list'));
    }
});
