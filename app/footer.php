        <div style="clear:both"></div>
        <footer class="footer"></footer>

        <!-- TEMPLATES -->



        <script type="text/template" id="footer">
            <div class="inner">
                <ul class="pages">
                    <li class="home active" title="Home"><div class="icon icon-home"></div></li>
                    <li class="settings" title="Settings"><div class="icon icon-cogs"></div></li>
                    <div class="loading-status">
                        <img style="width:100%" src="http://www.chimply.com/coconut/images/516706">
                    </div>
                </ul>
                <div style="float:right">
                    Have a suggestion? <a href="https://github.com/ceslami/gitdash/issues">Write an issue</a> or <a href="https://github.com/ceslami/gitdash/">open a pull request</a>. &nbsp;&middot;&nbsp; GitDash, Cyrus Eslami &nbsp;&middot;&nbsp; 2013
                </div>
            </div>
        </script>

        <script type="text/template" id="home">
            <div class='experiments'></div>
            <div style='float:right;width:40%;height:100%' class="overview" id="overview"></div>
        </script>

        <script type="text/template" id="pull-request">
            <% if(showRepoName) { %>
                <tr class="header">
                    <td></td>
                    <td style="color:#3E5161;font-size: 12px;font-weight: 600;text-transform: uppercase;letter-spacing: 1px;"><%= head.repo.name %></td>
                </tr>
            <% } %>
            <tr data-href='<%= html_url %>'>
                <td style='width:8%;position:relative' valign='top'>
                    <div style="width:30px;height:30px;margin:2px 0 0;position:relative">
                        <div style="width: 30px;height: 30px;overflow:hidden;border-radius:15px">
                            <img style="width:100%" title="<%= user.login %>" src="<%= user.avatar_url %>">
                        </div>
                    </div>
                </td>
                <td style='width:76%;font-size: 12px;' valign='top'>
                    <div>
                        <span style="font-weight:400;color:#769AB8;text-decoration: underline;"><%= title %></span>
                        <%= is_new_badge() %>
                        <%= has_approval_badge() %>
                        <%= is_off_master_badge() %>
                    </span>
                    <div style="margin: 3px 0 0;color:#666">
                        <%= commits %> commits &nbsp;&middot;&nbsp; <%= changed_files %> files &nbsp;&middot;&nbsp; <%= comments %> Comments
                    </div>
                </td>
                <td style='width:16%;color: #666;font-weight: 300;text-align:right;position:relative' valign='top'><%= days_ago() %></td>
            </tr>
        </script>
        <script type="text/template" id="home-heads-up">
            <div>
                <div style="width:50%;float:left;text-align:center">
                    <div style="color:#666;cursor:help;font-weight:200" title="Percentage of pull requests that are less than 4 days old">Freshness Score</div>
                    <div class="chart" style="margin:10px auto 0;font-size: 28px;font-weight: 100;"></div>
                </div>
                <div style="width:50%;float:left;text-align:center">
                    <div style="color:#666;cursor:help;font-weight:200" title="Percentage of pull requests that are less than 4 days old">Your Open Pull Requests</div>
                    <div class="user-pull-requests" style="font-size: 85px;margin: 13px 0 0;font-weight: 100;"></div>
                </div>
                <div style="clear:both"></div>
            </div>
            <div style="margin:40px 0 0">
                <div style="width:50%;float:left;text-align:center">
                    <div style="color:#666;cursor:help;font-weight:200" title="Number of pull requests which contain your 'looks good' comments">Ready To Merge <span style="vertical-align:2px" class="badge blue white-text">SHIP IT</span></div>
                    <div class="ready-to-merge" style="font-size: 85px;margin: 13px 0 0;font-weight: 100;"></div>
                </div>
                <div style="width:50%;float:left;text-align:center">
                    <div style="color:#666;cursor:help;font-weight:200" title="Number of pull requests without any comments">Uncommented Pull Requests <span style="vertical-align:2px" class="badge green white-text">NEW</span></div>
                    <div class="uncommented" style="font-size: 85px;margin: 13px 0 0;font-weight: 100;"></div>
                </div>
                <div style="clear:both"></div>
            </div>
        </script>
        <script type="text/template" id="home-pull-requests">
            <div style="color:#242F38;margin: 0 0 12px;padding: 0 0 12px;border-bottom: 1px solid #e5e5e5;">
                <div style="font-size:16px;font-weight:200;float:left;">Open Pull Requests</div>
                <div style="float:right;display:none;">
                    Opened by:
                    <select class="filter-users">
                        <option value="all">Everyone</option>
                        <option value="user">Me</option>
                    </select>
                </div>
                <div style="clear:both"></div>
            </div>
            <table id="experiments"></table>
        </script>

        <script type="text/template" id="settings">
            <div id="settings">
                <div style="font-size:16px;font-weight:200;margin:0 0 12px;padding:0 0 12px;border-bottom:1px solid #e5e5e5">Settings</div>
                <form class="settings">
                    <fieldset>
                        <label>
                            <div style="margin:5px 0 0;font-size:14px">Approval Words:</div>
                            <div style="font-size:12px;margin:5px 15px 0 0;color:#666">
                                You can specify the words or phrases that your
                                team uses in comments to mark a pull request as
                                ready to merge. This field is case-sensitive, and you
                                can separate terms with a comma.
                            </div>
                        </label>
                        <input type="text" class="approval-words" value="<%= approval_words %>">
                        <div style="clear:both"></div>
                    </fieldset>
                    <fieldset>
                        <label>
                            <div style="margin:5px 0 0;font-size:14px" >Freshness Score Threshold:</div>
                            <div style="font-size:12px;margin:5px 15px 0 0;color:#666">
                                The calculation of the Freshness Score depends on
                                how old pull requests are. By default, we designate
                                a 3 day old pull requests as stale. Depending on your
                                code review process, you may want to adjust this.
                            </div>
                        </label>
                        <input type="number" min="1" max="10" class="freshness-threshold" value="<%= freshness_threshold %>"> <span style="display:inline-block;margin:5px 0 0 10px;font-size:14px">days</span>
                    </fieldset>
                </form>
                <button class="save">Save Settings</button>
            </div>
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

        <script type="text/javascript" src="/js/vendor/local-storage.js"></script>

        <script type="text/javascript" src="/js/src/app.js"></script>
        <script type="text/javascript" src="/js/src/models/GithubUser.js"></script>
        <script type="text/javascript" src="/js/src/models/PullRequest.js"></script>
        <script type="text/javascript" src="/js/src/models/PullRequests.js"></script>

        <script type="text/javascript" src="/js/src/views/PullRequestItemView.js"></script>
        <script type="text/javascript" src="/js/src/views/HomePullRequestsView.js"></script>
        <script type="text/javascript" src="/js/src/views/HomeHeadsUpView.js"></script>
        <script type="text/javascript" src="/js/src/views/HomeLayout.js"></script>
        <script type="text/javascript" src="/js/src/views/FooterLayout.js"></script>
        <script type="text/javascript" src="/js/src/views/SettingsLayout.js"></script>

        <script type="text/javascript" src="/js/src/Router.js"></script>
        <script type="text/javascript" src="/js/src/init.js"></script>
    </body>
</html>
