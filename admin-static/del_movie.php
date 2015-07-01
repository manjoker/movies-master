<?php
include_once 'header.php';
include_once 'navigation.php';

$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

if (empty($id)) {
	exit('Undefined param id');
}

$query = $db->prepare('SELECT title FROM movies WHERE id = :id');
$query->bindValue('id', $id, PDO::PARAM_INT);
$query->execute();
$movie = $query->fetch();

if (empty($movie)) {
	exit('Undefined movie');
}

$confirm = !empty($_GET['confirm']) ? intval($_GET['confirm']) : 0;

if ($confirm === 1) {

	$query = $db->prepare('DELETE FROM movies WHERE id = :id');
	$query->bindValue('id', $id, PDO::PARAM_INT);
	$query->execute();

	$affected_rows = $query->rowCount();
}
?>

	<div class="container-fluid">

		<div class="row">

			<?php include_once 'sidebar.php' ?>

			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

				<?php
				if (!empty($affected_rows)) {
					echo '<div class="alert alert-success" role="alert">'.$affected_rows.' film(s) supprimé(s)</div>';
					echo redirectJs('movies.php', 2);
					exit();
				}
				?>

				<h1 class="page-header">Supprimer un film</h1>

				Etes-vous sûr de vouloir supprimer le film "<?= $movie['title'] ?>" ?

				<br><br>

				<a href="?id=<?= $id ?>&confirm=1"><button class="btn btn-danger">Supprimer</button></a>
				<a href="movies.php"><button class="btn btn-default">Annuler</button></a>

			</div><!--/.main -->
		</div><!--/.row -->
	</div><!--/.container -->

<?php include_once 'footer.php'; ?>