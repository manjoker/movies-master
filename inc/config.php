<?php
session_name('movies_session');
session_start();

define('FACEBOOK_SDK_ROOT_PATH', 'facebook');

define('FACEBOOK_SDK_V4_SRC_DIR', 'inc/'.FACEBOOK_SDK_ROOT_PATH.'/src/Facebook/');
require __DIR__ . '/'.FACEBOOK_SDK_ROOT_PATH.'/autoload.php';

define('FB_APP_ID', '502151559942833');
define('FB_APP_SECRET', 'd29895a1c737574e37883e95dca475fd');

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
