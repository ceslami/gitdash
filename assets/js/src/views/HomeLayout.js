var HomeLayout = Marionette.Layout.extend({
    template: "#home",
    timers: [],


    regions: {
        experiments: '.experiments',
        overview: '#overview'
    },

    onShow: function() {
        var self = this;

        this.displayRegions();

        this.timers.refresh = setInterval(function() {
            App.collections.pull_requests.fetch().done(function() {
                self.displayRegions();
            });
        }, App.settings.get('refresh_interval')*60*1000);
    },

    displayRegions: function() {
        var pull_requests = new PullRequests(App.collections.pull_requests.models),
            experimentView = new HomePullRequestsView({
                collection: pull_requests
            }),
            headsUp = new HomeHeadsUpView({
                collection: pull_requests
            });

        this.experiments.show(experimentView);
        this.overview.show(headsUp);

        $('.last-update').text((new Date()).toLocaleTimeString());
    },

    clearTimers: function() {
        _.each(this.timers, function(el, i) {
            clearInterval(el);
        });
    },

    onClose: function() {
        this.clearTimers();
    }
});
