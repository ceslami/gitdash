<?php

    include 'lib.php';

    $auth_url = 'https://github.com/login/oauth/authorize?client_id=d9ff044e5a5eba36673b&redirect_uri=http://localhost:8888/oauth_redirect&scope=user,repo';

    $app->hook('slim.before.router', function () {
        include 'header.php';
    });

    $app->get('/?', function()  {
        echo "<a href='".$auth_url."'>Log in with Github</a>";
    });

    $app->get('/oauth_redirect/?', function() use ($app) {
        $code = $app->request()->params('code');
        $token = isset($_COOKIE['access_token']) ? $_COOKIE['access_token'] : get_access_token($code);

        $app->redirect('/app');
    });

    $app->get('/app/?', function() use ($app, $auth_url) {
        $token = isset($_COOKIE['access_token']) ? $_COOKIE['access_token'] : "";

        $data = curl_download('https://api.github.com/orgs/Betterment/repos?type=private&access_token='.$token);
        $repos = json_decode($data);


        echo "<div style='float:left;width:50%;height:100%;overflow-y:scroll;font-size:14px'>";
            foreach($repos as $repo) {
                $d = curl_download('https://api.github.com/repos/Betterment/'.$repo->name.'/pulls?access_token='.$token);
                $pull_requests = json_decode($d);

                if(count($pull_requests)) {
                    echo "<h3 style='margin-bottom:10px'><a href='".$repo->html_url."/pulls'>".$repo->name."</a> &middot; (".count($pull_requests).")</h3>";

                    echo "<table style='width:100%;font-size:12px'>";
                        foreach($pull_requests as $pr) {
                            $c = curl_download('https://api.github.com/repos/Betterment/'.$repo->name.'/pulls/'.$pr->number.'?access_token='.$token);
                            $comments = json_decode($c);

                            $date_parts = explode('T', $comments->created_at);
                            $days_ago = days_ago($date_parts[0]);
                            $days_ago_str = $days_ago ? $days_ago.' days ago' : '<24 hours ago';

                            echo "<tr>";
                                echo "<td style='width:71%;' valign='top'><a href='".$pr->html_url."'>".$pr->title."</a></td>".
                                     "<td style='width:16%;padding-left:1.5%;' valign='top'>".$days_ago_str."</td>".
                                     "<td style='width:6.5%;padding-left:1.5%;display:inline-block;' valign='top'>".$comments->commits."</td>".
                                     "<td style='width:6.5%;padding-left:1.5%;display:inline-block;' valign='top'>".$comments->comments."</td>";
                            echo "</tr>";
                        }
                    echo "</table>";

                    echo "<hr style='opacity:.3'>";
                }
            }
        echo "</div>";
    });



    $app->hook('slim.after.router', function () {
        include 'footer.php';
    });

    $app->run();
