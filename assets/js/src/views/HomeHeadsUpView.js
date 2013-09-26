var HomeHeadsUpView = Marionette.Layout.extend({
    template: "#home-heads-up",

    regions: {
        'commitGraph': '.commit-history'
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
