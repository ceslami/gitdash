var CommitActivity = Backbone.Collection.extend({
    url: function() {
      return APP_URL+'/api/'+App.settings.get('organization')+'/stats/commits';
    }
});
