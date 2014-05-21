var Router = Backbone.Router.extend({
  routes: {
    "(/)": "home",
    "settings(/)": "settings",
    "filters(/)": "filters"
  },

  initialize: function() {
    this.bind("route", this.change);
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
    App.content.show(new HomeLayout());
  },

  settings: function() {
    App.content.show(new SettingsLayout({
      model: App.settings
    }));
  },

  filters: function() {
    App.content.show(new FiltersLayout({
      model: App.settings
    }));
  }
});
