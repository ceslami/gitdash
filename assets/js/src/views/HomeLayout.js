var HomeLayout = Marionette.Layout.extend({
    template: "#home",

    regions: {
        experiments: '.experiments',
        overview: '#overview'
    },

    onShow: function() {
        var experimentView = new HomePullRequestsView({
                collection: App.collections.pull_requests
            }),
            headsUp = new HomeHeadsUpView({
                collection: App.collections.pull_requests
            });

        this.experiments.show(experimentView);
        this.overview.show(headsUp);
    }
});
