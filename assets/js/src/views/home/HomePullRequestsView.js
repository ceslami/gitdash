var HomePullRequestsView = Marionette.CompositeView.extend({
    template: "#home-pull-requests",
    tagName: 'article',
    className: 'song',

    itemView: PullRequestItemView,
    itemViewContainer: '#experiments',

    onBeforeRender: function() {
        var self = this;

        // When we display the pull requests, we want to show a header at the
        // top of each repo's section. We set a temporary attribute on the
        // PullRequest model, ``showRepoName``, that functions as a flag
        // in the template to render a section header. This method is preferable
        // because of the automagic functionality of collection rendering
        // in CompositeView (Model/ItemTemplate pairs are defined declaratively).
        if(this.collection !== undefined) {
            _.each(this.collection.models, function(el, i) {
                var lastIndex = i ? i-1 : 0,
                    isFirstInRepo = self.collection.models[i].get('head').repo.name != self.collection.models[lastIndex].get('head').repo.name;

                self.collection.models[i].set('showRepoName', isFirstInRepo || !i);
            });
        }
    }
});
