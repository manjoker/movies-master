<?php
require_once '../inc/config.php';
require_once '../inc/db.php';
require_once '../inc/func.php';

// Si on est pas sur la page login (qui inclue aussi header)
// Et que le user id n'est pas en session (c'est la page login qui définit user_id en session)
if ($current_page != 'login.php' && empty($_SESSION['user_id'])) {
	// Alors on redirige vers la page login
	header('Location: login.php');
	exit();
}

if ($current_page != 'login.php' && isAllowedAccess($current_page, $_SESSION['status']) === false) {
	exit('Not allowed access');
}

$query = $db->prepare('SELECT COUNT(*) as count_movies FROM movies');
$query->execute();
$result = $query->fetch();
$count_movies = $result['count_movies'];

$query = $db->prepare('SELECT COUNT(*) as count_users FROM users');
$query->execute();
$result = $query->fetch();
$count_users = $result['count_users'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../../favicon.ico">

	<title>Espace d'administration</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<script src="js/holder.js"></script>
	<!--
	<script src="js/jquery.hotkeys.js"></script>
	<script src="js/bootstrap-wysiwyg.js"></script>
	-->

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link href="css/styles.css" rel="stylesheet">
</head>

<body>

	<?php
	if ($current_page != 'login.php') {
		include_once 'navigation.php';
	}
	?>

	<div class="container-fluid">

		<div class="row">

			<?php
			if ($current_page != 'login.php') {
				include_once 'sidebar.php';
			}
			?>