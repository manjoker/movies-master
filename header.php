<?php
<<<<<<< HEAD
require_once 'inc/config.php';
require_once 'inc/func.php';
require_once 'inc/db.php';
=======
session_name('movies_session');
session_start();

require_once 'inc/func.php';
require_once 'inc/db.php';

/*
echo '<pre>';
print_r($_SERVER);
echo '</pre>';
exit();
*/

$current_year = date('Y');

$current_page = basename($_SERVER['PHP_SELF']);

$pages = array(
	'index.php' => 'Accueil',
	'random.php' => 'Film au hasard',
	'news.php' => 'Actualités',
	'search.php' => 'Recherche',
	'contact.php' => 'Contact'
);

>>>>>>> fc9f3abd01b51e27b1883d9a7a7765410a3174c3
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Movies</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/styles.css">
</head>
<body>

	<?php include_once 'navbar.php' ?>

	<div class="container">

		<!-- END HEADER -->