<?php

    include 'lib.php';

    $app->hook('slim.before.router', function () { });

    $app->get('/?', function()  {
        echo "<a href='https://github.com/login/oauth/authorize?client_id=d9ff044e5a5eba36673b&redirect_uri=http://localhost:8888/oauth_redirect&scope=user,repo'>Log in with Github</a>";
    });

    $app->get('/hi?', function() use ($app)  {
        echo "<a href='https://github.com/login/oauth/authorize?client_id=d9ff044e5a5eba36673b&redirect_uri=http://localhost:8888/oauth_redirect&scope=user,repo'>Log in with Github</a>";
    });

    $app->get('/oauth_redirect?', function() use ($app) {
        $code = $app->request()->params('code');
        $token = isset($_COOKIE['access_token']) ? $_COOKIE['access_token'] : get_access_token($code);

        $data = curl_download('https://api.github.com/orgs/Betterment/repos?type=private&access_token='.$token);
        $repos = json_decode($data);

        foreach($repos as $repo) {
            $d = curl_download('https://api.github.com/repos/Betterment/'.$repo->name.'/pulls?access_token='.$token);
            $pull_requests = json_decode($d);

            if(count($pull_requests)) {
                echo "<h3><a href='".$repo->html_url."/pulls'>".$repo->name."</a> - ".count($pull_requests)."</h3><br>";

                foreach($pull_requests as $pr) {
                    echo "<a href='".$pr->html_url."'>".$pr->title."</a> - ".$pr->created_at."<br>";
                }

                echo "<hr>";
            }
        }

        // var_dump(curl_download('https://api.github.com/orgs/Betterment/events?type=privaaccess_token='.$token));

    });

    $app->hook('slim.after.router', function () {});

    $app->run();
