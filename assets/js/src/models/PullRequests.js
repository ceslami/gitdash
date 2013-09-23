var PullRequests = Backbone.Collection.extend({
    model: PullRequest,

    url: function() {
      return 'http://localhost:8888/api/'+App.settings.get('organization')+'/pulls/';
    },

    stalePullRequests: function() {
        var self = this,
            stale_pull_requests = _.reduce(this.models, function(memo, obj){
                var num = obj.days_ago(true) > App.settings.get('freshness_threshold') ? 1 : 0;
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
            return el.hasApproval();
        });
    },

    getUncommented: function() {
        return _.filter(this.models, function(el) {
            return el.isUncommented();
        });
    },

    parse: function(response) {
        if(response !== undefined) {
            _.each(response.models, function(el, i) {
                var lastIndex = i ? i-1 : 0,
                    isFirstInRepo = response.models[i].get('head').repo.name != response.models[lastIndex].get('head').repo.name;

                response.models[i].set('showRepoName', isFirstInRepo || !i);
            })
        }

        return response;
    }
});
