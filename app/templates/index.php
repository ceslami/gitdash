<html>
    <head>
        <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,300italic,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='/css/jquery.easy-pie-chart.css' rel='stylesheet' type='text/css'>
        <link href='//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
        <style>
            * {
                font-family:Lato;
            }

            ::-webkit-scrollbar {
                width: 4px;
            }

            ::-webkit-scrollbar-track {
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb {
                border-radius: 10px;
                -webkit-box-shadow: inset 0 0 15px rgba(0,0,0,0.3);
            }

            a {

            }

            header {
                display:none;
                height:40px;
                position:absolute;
                top:0;
                left:0;
                right:0;
                border-bottom:1px solid #e5e5e5;
            }
            header .inner {
                margin:10px;
            }
            header .inner .logo {
                font-weight: 300;
                text-transform: uppercase;
                letter-spacing: 4px;
                float:left;
            }
            .loading-status {
                width:30px;
                height:15px;
                margin:13px 0 0 10px;
                display:inline-block;
            }

            .sidebar {
                display:none;
                position:absolute;
                top:0;
                left:0;
                bottom:40px;
                width:50px;
                border-right:1px solid #e5e5e5;
            }
            .sidebar ul {
                list-style:none;
                margin: 10px 0 0;
                padding: 0;
                text-align: center;
            }
            .sidebar ul li {
                margin: 0 0 10px;
                display:block;
            }

            #content {
                position:absolute;bottom: 50px;top: 10px;left: 10px;right: 10px;
            }

            .experiments {
                float:left;width:60%;overflow-y:scroll;font-size:14px;
                height:100%;
            }
            .experiments h3 {
                margin-bottom:10px;
                color:#888;
                font-size:16px;
                margin-top:5px;
            }
            .experiments h3 a {
                color:#333;text-decoration:none;
            }
            .experiments table {
                border-spacing:0;width:100%;font-size:12px;
                border-collapse: collapse;
            }
            .experiments table tr {}
            .experiments table tr:hover {
                background:#fafafa;
                cursor:pointer;
            }
            .experiments table tbody tr.header:hover {
                background:none;
                cursor:default;
            }
            .experiments table tr td {
                padding:3px 0;
                padding:3px 0 5px 1.5%;
            }
            .experiments table tr td:nth-of-type(2) {
                padding-left:0;
            }
            .experiments table tr td:last-child {
                 padding:3px 3px 0 0;
            }
            .experiments table tr:hover td {
                border-color:#eee;
            }

            .experiments table tbody tr.header td {
                padding:20px 0 3px;
            }

            .experiments table tbody:first-child tr.header td {
                padding:0px 0 3px 0
            }

            .experiments table.header {
                text-transform:uppercase;font-weight:300;
            }

            .experiments hr {
                margin-top:15px;
            }
            #settings {
                margin:20px;
            }
            #settings form.settings {

            }
            #settings form.settings fieldset {
                display:block;
                margin:0 0 20px;
                padding:0;
                border:none;
            }
            #settings form.settings fieldset label {
                float:left;
                width:20%;
                min-width:200px;
            }
            #settings form.settings fieldset input {
                float:left;
                width:200px;
                padding:5px 8px;
                border:1px solid #c5c5c5;
                border-radius:2px;
            }
            #settings form.settings fieldset input[type=number] {
                width:60px;
            }
            #settings button.save,
            #settings button.save:focus {
                background: #4bf;
                padding: 10px 15px;
                border: none;
                border-radius: 4px;
                color: #fff;
                font-size: 16px;
                font-weight: 500;
                letter-spacing: 0px;
                margin:10px 0 0;
                cursor:pointer;
                outline:none;
                 -webkit-transition: background 0.3s ease, color 0.3s ease;
                -moz-transition: background 0.3s ease, color 0.3s ease;
                -o-transition: background 0.3s ease, color 0.3s ease;
                transition: background 0.3s ease, color 0.3s ease;
            }
            #settings button.save:not([disabled]):hover {
                background:#5EC0F8;
            }
            #settings button.save:not([disabled]):active {
                box-shadow: inset 0 2px 0 #2A79A7;
                background: #349CD8;

            }
            #settings button.save[disabled] {
                cursor:default;
                opacity:.5;
            }
            footer {
                position:absolute;height:40px;
                bottom:0;left:0;right:0;
                border-top:1px solid #e5e5e5;
            }
            footer .inner {
                margin:12px;
                color:#aaa;
                font-size:12px;
            }
            footer .inner a {
                color:#888;
                text-decoration:underline;
            }
            footer .inner .pages {
                float:left;
                list-style:none;
                margin: -13px 0 0;
                padding:0;
            }
            footer .inner .pages li {
                display:inline-block;
                margin: 0;
                width: 40px;
                text-align: center;
                height:41px;
                -webkit-transition: background 0.3s ease, color 0.3s ease;
                -moz-transition: background 0.3s ease, color 0.3s ease;
                -o-transition: background 0.3s ease, color 0.3s ease;
                transition: background 0.3s ease, color 0.3s ease;
            }
            footer .inner .pages li:hover,
            footer .inner .pages li.active {
                background:#5EC0F8;
                color:#fff;
                cursor:pointer;
            }
            footer .inner .pages li:active {
                box-shadow: inset 0 2px 0 #2A79A7;
                background: #349CD8;
            }
            footer .inner .pages li .icon {
                vertical-align: 19px;
                margin: 13px 0 0;
                display: block;
                font-size: 16px;

            }

            .badge {
                display:inline-block;
                padding:2px 4px;
                font-weight:400;
                border-radius:3px;
                font-size:8px;
                margin:0 0 0 5px;
                text-transform:uppercase;
            }
            .badge.blue {
                background:#4bf;
            }
            .badge.red {
                background:#f00;
            }
            .badge.green {
                background:#37C737
            }
            .badge.white-text {
                color:#fff;
            }

        </style>
    </head>
    <body>
        <header>
            <div class="inner">
                <div class="logo">GitDash</div>
                <div class="loading-status">
                    <img style="width:100%" src="http://www.chimply.com/coconut/images/516706">
                </div>
            </div>
        </header>
        <div class="sidebar">
            <ul class="pages">
                <li><span class="icon-home"></span></li>
                <li><span class="icon-cogs"></span></li>
            </ul>
        </div>
        <div id='content'>
            <div style="width:128px;height:64px;margin:-32px 0 0 -64px;position:absolute;top:50%;left:50%;">
                <img src="http://www.chimply.com/coconut/images/516706">
            </div>
        </div>
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
                    Have a suggestion? <a target="_blank" href="https://github.com/ceslami/gitdash/issues/new?labels=enhancement">Make a feature request</a> or <a href="https://github.com/ceslami/gitdash/">open a pull request</a>. &nbsp;&middot;&nbsp; GitDash, Cyrus Eslami &nbsp;&middot;&nbsp; 2013
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
                    <div style="color:#666;cursor:help;font-weight:200" title="Percentage of pull requests that are less than 4 days old">Your Open PR&#39;s</div>
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
                    <div style="color:#666;cursor:help;font-weight:200" title="Number of pull requests without any comments">Uncommented PR&#39;s <span style="vertical-align:2px" class="badge green white-text">NEW</span></div>
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
                        <label style="margin:0 20px 0 0">
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
                        <label style="margin:0 20px 0 0">
                            <div style="margin:5px 0 0;font-size:14px" >Freshness Score Threshold:</div>
                            <div style="font-size:12px;margin:5px 15px 0 0;color:#666">
                                The calculation of the Freshness Score depends on
                                how old pull requests are. By default, we designate
                                3 day old pull requests as stale. Depending on your
                                code review process, you may want to adjust this.
                            </div>
                        </label>
                        <input type="number" min="1" max="10" class="freshness-threshold" value="<%= freshness_threshold %>"> <span style="display:inline-block;margin:5px 0 0 10px;font-size:14px">days</span>
                    </fieldset>
                </form>
                <button class="save" disabled>Save Settings</button>
                <div class="saved-successfully" style="display:none;margin:5px;font-size:12px;">
                    <span class="icon-ok" style="color:#37C737"></span> Saved successfully.
                </div>
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
        <script type="text/javascript" src="/js/src/models/Settings.js"></script>

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
