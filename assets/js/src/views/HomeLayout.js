var HomeLayout = Marionette.Layout.extend({
    template: "#home",
    timers: [],

    regions: {
        experiments: '.experiments',
        overview: '#overview'
    },

    onShow: function() {
        var self = this;

        this.displayRegions(self);

        this.timers.refresh = setInterval(function() {
            App.collections.pull_requests.fetch().done(function() {
                self.displayRegions(self);
            });
        }, App.settings.get('refresh_interval')*60*1000);
    },

    displayRegions: function(context) {
        var pull_requests = new PullRequests(App.collections.pull_requests.models),
            experimentView = new HomePullRequestsView({
                collection: pull_requests
            }),
            headsUp = new HomeHeadsUpView({
                collection: pull_requests
            });

        context.experiments.show(experimentView);
        context.overview.show(headsUp);

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
