<?php
//session_set_cookie_params(0, '/', '.pistonkafalar.com');
session_start();

if (strpos($_SERVER['SERVER_NAME'], "www.") === 0) {
    $domain = substr($_SERVER['SERVER_NAME'], 4, strlen($_SERVER['SERVER_NAME']));
    //header("Location: http://$domain");
} else {
    $domain = $_SERVER['SERVER_NAME'];
}

define('APP_VER', 'w3421d1313');

if (strpos($domain, '.local') !== FALSE) {
    define('ENVIRONMENT', 'testing');
} else {
    define('ENVIRONMENT', 'production');
}

$ayar['db']['host'] = 'localhost';

switch (ENVIRONMENT) {
    case 'testing':
        $ayar['db']['name'] = 'pistonkafalarc_d';
        $ayar['db']['user'] = 'root';
        $ayar['db']['pass'] = '';
        ini_set('display_errors', 1);

        if ($domain == 'piston.local') {
            define('THEME', 'v1');
        } else if ($domain == 'pistonv2.local') {
            define('THEME', 'v2');
        }
        break;
    default:
        $ayar['db']['name'] = 'pistonkafalarc_d';
        $ayar['db']['user'] = 'piston_user';
        $ayar['db']['pass'] = 'HqdB84qZ88uQWsXv';

        define('THEME', 'v2');

        ini_set('display_errors', 0);
}

error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('Europe/Istanbul');

define('DR', $_SERVER['DOCUMENT_ROOT']);

require_once 'class.isingleton.php';
require_once 'class.factory.php';
require_once 'class.datalayer.php';
require_once 'class.html.php';
require_once 'class.js.php';
require_once 'function.php';
require_once 'class.site.php';
require_once 'class.filtre.php';
require_once 'class.pager.php';
require_once 'class.mektup.php';
require_once 'class.usermanager.php';
require_once 'class.controller.php';
require_once 'class.lifos.php';
require_once 'class.du.php';

$db = factory::get('datalayer');