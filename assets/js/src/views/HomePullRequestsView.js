var HomePullRequestsView = Marionette.CompositeView.extend({
    template: "#home-pull-requests",
    tagName: 'article',
    className: 'song',

    itemView: PullRequestItemView,
    itemViewContainer: '#experiments',

    initialize: function() {
        var self = this;

        if(this.collection !== undefined) {
            _.each(this.collection.models, function(el, i) {
                var lastIndex = i ? i-1 : 0,
                    isFirstInRepo = self.collection.models[i].get('head').repo.name != self.collection.models[lastIndex].get('head').repo.name;

                self.collection.models[i].set('showRepoName', isFirstInRepo || !i);
            })
        }
    }
});
