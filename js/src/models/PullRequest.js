var PullRequest = Backbone.Model.extend({
    days_ago: function(asInt) {

        var now = new Date(),
            date = new Date(this.get('created_at')),
            datediff = now.getTime() - date.getTime(),
            daysAgo = Math.floor(datediff/(1000*60*60*24));

        if(asInt) return daysAgo;

        return daysAgo ? daysAgo+' days ago' : '<24 hours ago';
    },
    hasApproval: function(phrase) {
        var approvals = _.filter(this.get('comments_list'), function(el) {
            return el.body.indexOf(phrase) > -1;
        })

        return approvals.length > 0;
    }
});
