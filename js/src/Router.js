var Router = Backbone.Router.extend({
  routes: {
    "(/)": "home"
  },

  initialize: function() {
    this.bind( "route", this.change)
  },

  change: function() {},

  home: function(){
    var view = new HomeLayout();
    App.content.show(view);
  }
});
