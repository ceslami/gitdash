var GithubUser = Backbone.Model.extend({
    url: function() {
      return APP_URL+'/api/user/';
    }
});
