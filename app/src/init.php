<?php

    require_once(dirname(dirname(__FILE__)).'/vendor/Slim/Slim.php');

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
