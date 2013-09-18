        <div style="clear:both"></div>
        <footer>
            <div class="inner">
                GitDash by Cyrus Eslami &middot; 2013
                <div style="float:right">
                    Have a suggestion? <a href="https://github.com/ceslami/gitdash/issues">Write an issue</a> or <a href="https://github.com/ceslami/gitdash/">open a pull request</a>.
                </div>
            </div>
        </footer>

        <script type="text/template" id="home">
            <div class='experiments'></div>
            <div style='float:right;width:40%;height:100%' class="overview" id="overview"></div>
        </script>

        <script type="text/template" id="pull-request">
            <% if(showRepoName) { %>
                <tr class="header">
                    <td style="font-size:14px;font-weight:bold"><%= head.repo.name %></td>
                </tr>
            <% } %>
            <tr>
                <td style='width:50%;' valign='top'><a target='_blank' href='<%= html_url %>'><%= title %></a></td>
                <td style='width:16%;' valign='top'><%= user.login %></td>
                <td style='width:16%;' valign='top'><%= days_ago(created_at) %></td>
                <td style='width:6%;' valign='top'><%= commits %></td>
                <td style='width:6%;' valign='top'><%= changed_files %></td>
                <td style='width:6%;' valign='top'><%= comments %></td>
            </tr>
        </script>

        <script type="text/template" id="home-heads-up">
                <div>
                    <div style="width:50%;float:left;text-align:center">
                        <div style="color:#666;cursor:help" title="Percentage of pull requests that are less than 4 days old">Freshness Score</div>
                        <div class="chart" data-percent="73" style="margin:10px auto 0;font-size: 28px;font-weight: 100;">73%</div>
                    </div>
                    <div style="width:50%;float:left">

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

            var PullRequests = Backbone.Collection.extend({
                url: function() {
                  return 'http://localhost:8888/api/pulls/';
                }
            });

            var PullRequestItemView = Marionette.ItemView.extend({
                template: "#pull-request",
                tagName: 'tbody',

                templateHelpers: {
                    days_ago: function(timestamp) {
                        var now = new Date(),
                            date = new Date(timestamp),
                            datediff = now.getTime() - date.getTime(),
                            daysAgo = Math.floor(datediff/(1000*60*60*24));

                        return daysAgo ? daysAgo+' days ago' : '<24 hours ago';
                    }
                },
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
                    $('.chart')
                        .attr('data-percent', this.countStalePullRequests()*100)
                        .text((this.countStalePullRequests()*100)+'%')
                        .easyPieChart()
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
        </script>

        <script type="text/javascript" src="/js/src/Router.js"></script>

        <script type="text/javascript">
            // Document Ready
            $(document).ready(function() {
                $('.content').animate({opacity:1}, 300);

                App.collections = {};
                App.collections.pull_requests = new PullRequests();

                App.collections.pull_requests.fetch({
                    success: function() {
                        App.vent   = _.extend({}, Backbone.Events);
                        App.router = new Router();
                        Backbone.history.start()
                    }
                })

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
<!--

    <div style='float:right;width:40%;height:100%'>
        <div style='margin:20px'>
        <div style='font-size:18px;margin:0 0 5px'><span style='display:inline-block;width:40px'>$repo_count</span> repositories with open requests</div>
        <div style='font-size:18px;margin:0 0 5px'><span style='display:inline-block;width:40px'>$pull_requests_count</span> open pull requests</div>
        <div style='font-size:18px;margin:0 0 5px'><span style='display:inline-block;width:40px'>$unique_users_count</span> devs with open requests</div>
        <div style='font-size:18px;margin:0 0 5px'><span style='display:inline-block;width:40px'>$old_posts</span> pull requests >5 days old</div>
    </div>
</div>
 -->
