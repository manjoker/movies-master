<?php
session_name('movies_session');
session_start();

define('FACEBOOK_SDK_ROOT_PATH', 'inc/facebook');

define('FACEBOOK_SDK_V4_SRC_DIR', FACEBOOK_SDK_ROOT_PATH.'/src/Facebook/');
require __DIR__ . '/'.FACEBOOK_SDK_ROOT_PATH.'/autoload.php';

define('FB_APP_ID', '911544085571972');
define('FB_APP_SECRET', '7783da3269c3fd0925e796904703d867');

$root_path = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);

$current_year = date('Y');

$current_page = basename($_SERVER['PHP_SELF']);

$pages = array(
	'index.php' => 'Accueil',
	'random.php' => 'Film au hasard',
	'news.php' => 'Actualités',
	'search.php' => 'Recherche',
	'contact.php' => 'Contact'
);