<html>
    <head>
        <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,300italic,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='/assets/css/jquery.easy-pie-chart.css' rel='stylesheet' type='text/css'>
        <link href='//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
        <link href="/assets/css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id='content'>
            <div class="page-loading-status">
                <img src="/assets/img/spinner.gif">
            </div>
        </div>
        <footer class="footer"></footer>

        <!-- TEMPLATES -->
        <?php include 'underscore-templates.php'; ?>

        <!-- SCRIPTS -->
        <script type="text/javascript" src="http://d3js.org/d3.v3.min.js"></script>
        <script type="text/javascript" src="/assets/js/vendor/local-storage.js"></script>
        <script type="text/javascript" src="/assets/js/vendor/jquery.min.js"></script>
        <script type="text/javascript" src="/assets/js/vendor/jquery-ui-custom.js"></script>
        <script type="text/javascript" src="/assets/js/vendor/jquery.easy-pie-chart.js"></script>
        <script type="text/javascript" src="/assets/js/vendor/mustache.js"></script>
        <script type="text/javascript" src="/assets/js/vendor/underscore.js"></script>
        <script type="text/javascript" src="/assets/js/vendor/backbone.js"></script>
        <script type="text/javascript" src="/assets/js/vendor/backbone.babysitter.js"></script>
        <script type="text/javascript" src="/assets/js/vendor/backbone.wreqr.js"></script>
        <script type="text/javascript" src="/assets/js/vendor/marionette.js"></script>

        <script type="text/javascript" src="/assets/js/src/app.js"></script>
        <script type="text/javascript" src="/assets/js/src/models/GithubUser.js"></script>
        <script type="text/javascript" src="/assets/js/src/models/PullRequest.js"></script>
        <script type="text/javascript" src="/assets/js/src/models/PullRequests.js"></script>
        <script type="text/javascript" src="/assets/js/src/models/Settings.js"></script>
        <script type="text/javascript" src="/assets/js/src/models/CommitActivity.js"></script>
        <script type="text/javascript" src="/assets/js/src/views/PullRequestItemView.js"></script>
        <script type="text/javascript" src="/assets/js/src/views/HomePullRequestsView.js"></script>
        <script type="text/javascript" src="/assets/js/src/views/HomeHeadsUpView.js"></script>
        <script type="text/javascript" src="/assets/js/src/views/HomeLayout.js"></script>
        <script type="text/javascript" src="/assets/js/src/views/FooterLayout.js"></script>
        <script type="text/javascript" src="/assets/js/src/views/SettingsLayout.js"></script>
        <script type="text/javascript" src="/assets/js/src/views/CommitActivityGraphView.js"></script>
        <script type="text/javascript" src="/assets/js/src/Router.js"></script>

        <script type="text/javascript" src="/assets/js/src/init.js"></script>
    </body>
</html>
