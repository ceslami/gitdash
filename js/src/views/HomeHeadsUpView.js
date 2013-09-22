var HomeHeadsUpView = Marionette.ItemView.extend({
    template: "#home-heads-up",
    tagName: 'article',
    className: 'song',

    regions: {
        'userPullRequests': '#user-pull-requests'
    },

    days_ago: function(timestamp, asInt) {
        var now = new Date(),
            date = new Date(timestamp),
            datediff = now.getTime() - date.getTime(),
            daysAgo = Math.floor(datediff/(1000*60*60*24));

        if(asInt) return daysAgo;
        return daysAgo ? daysAgo+' days ago' : '<24 hours ago';
    },

    onShow: function() {
        var freshness = parseInt(this.collection.stalePullRequests()*100);
        $('.chart')
            .attr('data-percent', freshness)
            .text(freshness+'%')
            .easyPieChart({
                animate: 1000
            });

        $('.user-pull-requests').text(this.collection.getPullRequestsFrom('ceslami').length);
        $('.ready-to-merge').text(this.collection.getReadyToMerge('lgtm').length);
    }
});
