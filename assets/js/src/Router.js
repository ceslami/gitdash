var Router = Backbone.Router.extend({
  routes: {
    "(/)": "home",
    "settings(/)": "settings",
    "filters(/)": "filters"
  },

  initialize: function() {
    this.bind( "route", this.change);
    App.footer.show(new FooterLayout());
  },

  change: function(page) {
    this.setNavClasses(page);
    ga('send', 'pageview', page);
  },

  setNavClasses: function(page) {
    $('.pages li').removeClass('active')
    $('.pages li.'+page).addClass('active');
  },

  home: function(){
    var view = new HomeLayout();
    App.content.show(view);
  },

  settings: function() {
    var view = new SettingsLayout({
      model: App.settings
    });
    App.content.show(view);
  },

  filters: function() {
    var view = new FiltersLayout({
      model: App.settings
    });
    App.content.show(view);
  }
});
