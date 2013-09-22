var GithubUser = Backbone.Model.extend({
    url: function() {
      return 'http://localhost:8888/api/user/';
    }
});
