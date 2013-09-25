var Marionette = Backbone.Marionette,
    App = new Marionette.Application();

App.addRegions({
    'content': '#content',
    'footer': '.footer'
});

$(document).ajaxStart(function() {
    console.log('start')
    $('.loading-status').show();
})
$(document).ajaxStop(function() {
    console.log('stop')
    $('.loading-status').hide();
});

App.start();

