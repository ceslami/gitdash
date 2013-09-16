<?php

    require 'vendor/Slim/Slim.php';

    session_set_cookie_params('3600'); // 1 hour
    session_start();

    // Prepare slim to run and create app object
    \Slim\Slim::registerAutoloader();
    $app = new \Slim\Slim(
        array(
            'templates.path' => './views/',
            'cookies.secret_key'  => 'KEEP_IT_REAL',
            'cookies.lifetime' => time() + (60 * 24 * 60 * 60), // = 60 days
            'cookies.cipher' => MCRYPT_RIJNDAEL_256,
            'cookies.cipher_mode' => MCRYPT_MODE_CBC
        )
    );

    $app->config();

    function curl_download($url){
        if (!function_exists('curl_init')){
            die('Sorry cURL is not installed!');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, "http:/findnewjams.com/feedParser");
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.108 Safari/535.19");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);

        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    function curl_post($url, $fields) {

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }

    // Github API stuff
    // src: https://gist.github.com/technoweenie/419219

    function get_access_token($code) {
        $response = array();
        $fields = array(
            'client_id' => 'd9ff044e5a5eba36673b',
            'redirect_uri' => 'http://localhost:8888/oauth_redirect',
            'client_secret' => '24689980b1a9841b406daba3f7084e40094fdec1',
            'code' => $code
        );

        // Parse returned string as an array and store it in $response
        parse_str(curl_post('https://github.com/login/oauth/access_token/', $fields), $response);

        if(isset($response['access_token'])) {
            setcookie('access_token', $response['access_token'], time()+60*60*24*30, "/");
            return $response['access_token'];
        } else {
            return $response['error'];
        }
    }
