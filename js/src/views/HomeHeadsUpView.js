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

        $('.user-pull-requests').html(this.collection.getPullRequestsFrom('ceslami').length ? this.collection.getPullRequestsFrom('ceslami').length : '<div style="display:block;padding:8px 0 0;color:#47CC67" class="icon-ok"></div>');
        $('.ready-to-merge').text(this.collection.getReadyToMerge().length);
        $('.uncommented').text(this.collection.getUncommented().length);
    }
});
