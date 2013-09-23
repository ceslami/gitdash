<?php
    include 'src/config.php';
    include 'src/init.php';
    include 'src/lib.php';

    $auth_url = 'https://github.com/login/oauth/authorize?client_id='.$config['client_id'].'&redirect_uri='.$config['callback_url'].'scope=user,repo';

    $app->get('/?', function() use ($auth_url, $app)  {
        if(isset($_COOKIE['access_token'])) {
            $app->redirect('/app');
        }
        include 'templates/login.php';
    });

    $app->get('/oauth_redirect/?', function() use ($app) {
        $code = $app->request()->params('code');
        $token = isset($_COOKIE['access_token']) ? $_COOKIE['access_token'] : get_access_token($code);

        $app->redirect('/app');
    });

    $app->get('/api/user/?', function() use ($app) {
        // echo get_json('https://api.github.com/user');

        $user = get_data('https://api.github.com/user');
        $user->organizations = get_data('https://api.github.com/user/orgs');

        echo json_encode($user);
    });

    $app->get('/api/:org/repos/?', function($org) use ($app) {
        echo get_json('https://api.github.com/orgs/'.$org.'/repos?type=private');
    });

    $app->get('/api/:org/pulls/?', function($org) use ($app) {
        $pull_requests = array();
        $repos = get_data('https://api.github.com/orgs/'.$org.'/repos?type=private');

        foreach($repos as $repo) {
            $pulls = get_data('https://api.github.com/repos/'.$org.'/'.$repo->name.'/pulls');
            if(count($pulls)) {
                foreach($pulls as $pr) {
                    $pr_data = get_data('https://api.github.com/repos/'.$org.'/'.$repo->name.'/pulls/'.$pr->number);
                    $pr_data->comments_list = get_data($pr->comments_url);
                    $pull_requests[] = $pr_data;
                }
            }
        }

        echo json_encode($pull_requests);
    });

    $app->get('/api/:org/stats/commits/?', function($org) use ($app) {
        $commits  = array();
        $repos = get_data('https://api.github.com/orgs/'.$org.'/repos?type=private');

        foreach($repos as $repo) {
            $weeks = get_data('https://api.github.com/repos/'.$org.'/'.$repo->name.'/stats/commit_activity');
            if(is_array($weeks)) { // when there is no data, $weeks is an object
                $data = array_slice(array_reverse($weeks), -3, 3);
                $merged = array_merge($data[0]->days, $data[1]->days, $data[2]->days);
                $commits[] = array("commits" => $merged);
            }
        }

        echo json_encode($commits);
    });

    $app->get('/app/?', function() use ($app) {
        include 'templates/index.php';
    });

    $app->run();
