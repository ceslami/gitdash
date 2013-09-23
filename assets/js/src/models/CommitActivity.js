var CommitActivity = Backbone.Collection.extend({
    url: function() {
      return 'http://localhost:8888/api/'+App.settings.get('organization')+'/stats/commits';
    }
});
