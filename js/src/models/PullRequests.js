var PullRequests = Backbone.Collection.extend({
    model: PullRequest,

    url: function() {
      return 'http://localhost:8888/api/pulls/';
    },

    stalePullRequests: function() {
        var self = this,
            stale_pull_requests = _.reduce(this.models, function(memo, obj){
                var num = obj.days_ago(true) > 3 ? 1 : 0;
                return memo + num;
            }, 0),
            total_pull_requests = this.models.length;

        return (total_pull_requests-stale_pull_requests) / total_pull_requests;
    },

    getPullRequestsFrom: function(username) {
        return _.filter(this.models, function(el) {
            return el.get('user').login == username;
        });
    },

    getReadyToMerge: function(phrase) {
        return _.filter(this.models, function(el) {
            console.log(el.hasApproval('lgtm'))
            return el.hasApproval('lgtm');
        });
    }
});
