var HomeHeadsUpView = Marionette.Layout.extend({
    template: "#home-heads-up",
    tagName: 'article',
    className: 'song',

    regions: {
        'commitGraph': '.commit-history'
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
        var self = this,
            freshness = parseInt(this.collection.stalePullRequests()*100),
            color = freshness == 100 ? '#37C737' : '#ef1e25';

        $('.chart')
            .attr('data-percent', freshness)
            .text(freshness+'%')
            .easyPieChart({
                animate: 1000,
                barColor: color
            });
        $('.user-pull-requests').html(this.collection.getPullRequestsFrom('ceslami').length ? this.collection.getPullRequestsFrom('ceslami').length : '<div style="display:block;padding:8px 0 0;color:#47CC67" class="icon-ok"></div>');
        $('.ready-to-merge').html(this.collection.getReadyToMerge().length ? this.collection.getReadyToMerge().length : '<div style="display:block;padding:8px 0 0;color:#47CC67" class="icon-ok"></div>');
        $('.uncommented').html(this.collection.getUncommented().length ? this.collection.getUncommented().length : '<div style="display:block;padding:8px 0 0;color:#47CC67" class="icon-ok"></div>');

        self.commitGraph.show(new CommitActivityGraphView());
    }
});
