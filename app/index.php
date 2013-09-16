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
        $users = array();
        $pull_requests_count = 0;
        $repo_count = 0;
        $unique_users_count = 0;
        $old_posts = 0;

        $repos = get_data('https://api.github.com/orgs/Betterment/repos?type=private');

        echo "<div class='experiments'>";
            foreach($repos as $repo) {
                $pull_requests = get_data('https://api.github.com/repos/Betterment/'.$repo->name.'/pulls');

                if(count($pull_requests)) {
                    echo "<h3>".
                            "<a target='_blank' style='float:left' href='".$repo->html_url."/pulls'>".$repo->name."</a>".
                            // "<span style='float:right'>".count($pull_requests)." open requests</span>".
                            // "<div style='clear:both'></div>".
                         "</h3>";
                    echo "<table>";
                        foreach($pull_requests as $pr) {
                            $pull_request = get_data('https://api.github.com/repos/Betterment/'.$repo->name.'/pulls/'.$pr->number);

                            $date_parts = explode('T', $pull_request->created_at);
                            $days_ago = days_ago($date_parts[0]);
                            $days_ago_str = $days_ago ? $days_ago.' days ago' : '<24 hours ago';

                            if($days_ago >= 5) {
                                $old_posts++;
                            }

                            $users[] = $pull_request->user->login;
                            $pull_requests_count++;
                            $repo_count++;

                            echo "<tr>";
                                echo "<td style='width:50%;' valign='top'><a target='_blank' href='".$pull_request->html_url."'>".$pull_request->title."</a></td>".
                                     "<td style='width:16%;' valign='top'>".$pull_request->user->login."</td>".
                                     "<td style='width:16%;' valign='top'>".$days_ago_str."</td>".
                                     "<td style='width:6%;' valign='top'>".$pull_request->commits."</td>".
                                     "<td style='width:6%;' valign='top'>".$pull_request->changed_files."</td>".
                                     "<td style='width:6%;' valign='top'>".$pull_request->comments."</td>";
                            echo "</tr>";
                        }
                    echo "</table>";
                    echo "<hr style='opacity:.3'>";
                }
            }
        echo "</div>";

        $unique_users_count = count(array_unique($users));
        echo "<div style='float:right;width:40%;'>";
            echo "<div style='margin:20px'>";
                echo "<div style='font-size:18px;margin:0 0 5px'><span style='display:inline-block;width:40px'>".$repo_count."</span> repositories with open requests</div>";
                echo "<div style='font-size:18px;margin:0 0 5px'><span style='display:inline-block;width:40px'>".$pull_requests_count."</span> open pull requests</div>";
                echo "<div style='font-size:18px;margin:0 0 5px'><span style='display:inline-block;width:40px'>".$unique_users_count."</span> devs with open requests</div>";
                echo "<div style='font-size:18px;margin:0 0 5px'><span style='display:inline-block;width:40px'>".$old_posts."</span> pull requests >5 days old</div>";
            echo "</div>";
        echo "</div>";
    });

    $app->hook('slim.after.router', function () {
        include 'footer.php';
    });

    $app->run();
