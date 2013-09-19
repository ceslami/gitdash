        <div style="clear:both"></div>
        <footer>
            <div class="inner">
                GitDash by Cyrus Eslami &middot; 2013
                <div style="float:right">
                    Have a suggestion? <a href="https://github.com/ceslami/gitdash/issues">Write an issue</a> or <a href="https://github.com/ceslami/gitdash/">open a pull request</a>.
                </div>
            </div>
        </footer>

        <!-- TEMPLATES -->

        <script type="text/template" id="home">
            <div class='experiments'></div>
            <div style='float:right;width:40%;height:100%' class="overview" id="overview"></div>
        </script>

        <script type="text/template" id="pull-request">
            <% if(showRepoName) { %>
                <tr class="header">
                    <td></td>
                    <td style="font-size: 12px;font-weight: 200;color: #666;text-transform: uppercase;letter-spacing: 1px;"><%= head.repo.name %></td>
                </tr>
            <% } %>
            <tr data-href='<%= html_url %>'>
                <td style='width:8%;' valign='top'><div style="width: 27px;height: 27px;margin:2px 0 0;overflow:hidden;border-radius:15px"><img style="width:100%" title="<%= user.login %>" src="<%= user.avatar_url %>"></div></td>
                <td style='width:76%;' valign='top'>
                    <span style="font-weight:400;color: #3847FC;text-decoration: underline;"><%= title %></span>
                    <div style="margin: 2px 0 0;font-size: 11px;">
                        <%= commits %> commits &nbsp;&middot;&nbsp; <%= changed_files %> files &nbsp;&middot;&nbsp; <%= comments %> Comments
                    </div>
                </td>
                <td style='width:16%;font-style: italic;font-weight: 300;' valign='top'><%= days_ago(created_at) %></td>
            </tr>
        </script>
        <script type="text/template" id="home-heads-up">
            <div>
                <div style="width:50%;float:left;text-align:center">
                    <div style="color:#666;cursor:help;font-weight:200" title="Percentage of pull requests that are less than 4 days old">Freshness Score</div>
                    <div class="chart" data-percent="73" style="margin:10px auto 0;font-size: 28px;font-weight: 100;">73%</div>
                </div>
                <div style="width:50%;float:left">

                </div>
                <div style="clear:both"></div>
            </div>
            <div style="width:100%;margin:20px 0 0">
                <div style="color:#666;font-weight:200;text-align:center">Your Pull Requests</div>
                <div id="user-pull-requests">

                </div>
            </div>
        </script>
        <script type="text/template" id="home-pull-requests">
            <table id="experiments"></table>
        </script>

        <script type="text/javascript" src="/js/vendor/jquery.min.js"></script>
        <script type="text/javascript" src="/js/vendor/jquery-ui-custom.js"></script>
        <script type="text/javascript" src="/js/vendor/jquery.easy-pie-chart.js"></script>
        <script type="text/javascript" src="/js/vendor/mustache.js"></script>
        <script type="text/javascript" src="/js/vendor/underscore.js"></script>

        <script type="text/javascript" src="/js/vendor/backbone.js"></script>
        <script type="text/javascript" src="/js/vendor/backbone.babysitter.js"></script>
        <script type="text/javascript" src="/js/vendor/backbone.wreqr.js"></script>
        <script type="text/javascript" src="/js/vendor/marionette.js"></script>

        <script type="text/javascript">

            var Marionette = Backbone.Marionette,
                App = new Marionette.Application();

            App.addRegions({
                'content': '#content'
            });

            App.start();

            var GithubUser = Backbone.Model.extend({
                url: function() {
                  return 'http://localhost:8888/api/user/';
                }
            });

            var PullRequests = Backbone.Collection.extend({
                url: function() {
                  return 'http://localhost:8888/api/pulls/';
                }
            });

            var PullRequestItemView = Marionette.ItemView.extend({
                template: "#pull-request",
                tagName: 'tbody',

                events: {
                    'click tr:not(.header)': 'goToGithub'
                },

                templateHelpers: {
                    days_ago: function(timestamp) {
                        var now = new Date(),
                            date = new Date(timestamp),
                            datediff = now.getTime() - date.getTime(),
                            daysAgo = Math.floor(datediff/(1000*60*60*24));

                        return daysAgo ? daysAgo+' day'+(daysAgo == 1 ? '' : 's')+' ago' : '<24 hours ago';
                    }
                },

                goToGithub: function(event) {
                    var href = $(event.currentTarget).attr('data-href');

                    var win = window.open(href, '_blank');
                    win.focus();
                }
            });

            var HomePullRequestsView = Marionette.CompositeView.extend({
                template: "#home-pull-requests",
                tagName: 'article',
                className: 'song',

                itemView: PullRequestItemView,
                itemViewContainer: '#experiments',

                initialize: function() {
                    var self = this;

                    if(this.collection !== undefined) {
                        _.each(this.collection.models, function(el, i) {
                            var lastIndex = i ? i-1 : 0,
                                isFirstInRepo = self.collection.models[i].get('head').repo.name != self.collection.models[lastIndex].get('head').repo.name;

                            self.collection.models[i].set('showRepoName', isFirstInRepo || !i);
                        })
                    }
                }
            })

            var HomeHeadsUpView = Marionette.ItemView.extend({
                template: "#home-heads-up",
                tagName: 'article',
                className: 'song',

                regions: {
                    'userPullRequests': '#user-pull-requests'
                },

                days_ago: function(timestamp, asInt) {
                    var now = new Date(),
                        date = new Date(timestamp),
                        datediff = now.getTime() - date.getTime(),
                        daysAgo = Math.floor(datediff/(1000*60*60*24));

                    if(asInt) return daysAgo;
                    return daysAgo ? daysAgo+' days ago' : '<24 hours ago';
                },

                countStalePullRequests: function() {
                    var self = this,
                        stale_pull_requests = _.reduce(this.collection.models, function(memo, obj){
                            var num = self.days_ago(obj.get('created_at'), true) > 3 ? 1 : 0;
                            return memo + num;
                        }, 0),
                        count_pull_requests = this.collection.models.length;

                    return (count_pull_requests-stale_pull_requests) / count_pull_requests;
                },

                onShow: function() {
                    var freshness = parseInt(this.countStalePullRequests()*100);
                    $('.chart')
                        .attr('data-percent', freshness)
                        .text(freshness+'%')
                        .easyPieChart({
                            animate: 1000
                        });

                }
            });

            var HomeLayout = Marionette.Layout.extend({
                template: "#home",

                regions: {
                    experiments: '.experiments',
                    overview: '#overview'
                },

                onShow: function() {
                    var experimentView = new HomePullRequestsView({
                            collection: App.collections.pull_requests
                        }),
                        headsUp = new HomeHeadsUpView({
                            collection: App.collections.pull_requests
                        });

                    this.experiments.show(experimentView);
                    this.overview.show(headsUp);
                }
            });

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

        </script>

        <script type="text/javascript" src="/js/src/Router.js"></script>

        <script type="text/javascript">
            // Document Ready
            $(document).ready(function() {
                $('.content').animate({opacity:1}, 300);

                App.collections = {};
                var pull_requests = new PullRequests(),
                    user = new GithubUser();

                $.when(
                    pull_requests.fetch(),
                    user.fetch()
                ).done(function(){
                    _.extend(App.collections, {
                        pull_requests: pull_requests,
                        user: user
                    });

                    App.vent   = _.extend({}, Backbone.Events);
                    App.router = new Router();
                    Backbone.history.start()

                    App.router.navigate('/', {trigger: true});
                });

                $(document).on("click", "a:not([data-bypass])", function(evt) {
                  var href = { prop: $(this).prop("href"), attr: $(this).attr("href") };
                  var root = location.protocol + "//" + location.host;

                  if (href.prop && href.prop.slice(0, root.length) === root) {
                    evt.preventDefault();
                    Backbone.history.navigate(href.attr, true);
                  }
                });
            });

        </script>
    </body>
</html>
