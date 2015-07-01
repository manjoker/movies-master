<?php
include_once 'header.php';

$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

if (empty($id)) {
	exit('Undefined movie id');
}

$query = $db->prepare('SELECT * FROM movies WHERE id = :id');
$query->bindValue('id', $id, PDO::PARAM_INT);
$query->execute();
$movie = $query->fetch();

if (empty($movie)) {
	exit('Undefined movie');
}

$title = isset($_POST['title']) ? $_POST['title'] : $movie['title'];
$year = isset($_POST['year']) ? intval($_POST['year']) : $movie['year'];
$genres = isset($_POST['genres']) ? $_POST['genres'] : $movie['genres'];
$synopsis = isset($_POST['synopsis']) ? $_POST['synopsis'] : $movie['synopsis'];
$directors = isset($_POST['directors']) ? $_POST['directors'] : $movie['directors'];
$writers = isset($_POST['writers']) ? $_POST['writers'] : $movie['writers'];
$actors = isset($_POST['actors']) ? $_POST['actors'] : $movie['actors'];
$runtime = isset($_POST['runtime']) ? intval($_POST['runtime']) : $movie['runtime'];
$rating = $movie['rating'];
$slug = $movie['slug'];

$errors = array();

if (!empty($_POST)) {

	if (empty($title)) {
		$errors[] = 'Le titre est obligatoire';
	}
	if (empty($year)) {
		$errors[] = "L'année est obligatoire";
	}

	if (empty($errors)) {

		$query = $db->prepare('UPDATE movies SET title = :title, year = :year, genres = :genres, synopsis = :synopsis, directors = :directors, writers = :writers, actors = :actors, rating = :rating, runtime = :runtime, slug = :slug WHERE id = :id');
		$query->bindValue('title', $title, PDO::PARAM_STR);
		$query->bindValue('year', $year, PDO::PARAM_INT);
		$query->bindValue('genres', $genres, PDO::PARAM_STR);
		$query->bindValue('synopsis', $synopsis, PDO::PARAM_STR);
		$query->bindValue('directors', $directors, PDO::PARAM_STR);
		$query->bindValue('writers', $writers, PDO::PARAM_STR);
		$query->bindValue('actors', $actors, PDO::PARAM_STR);
		$query->bindValue('rating', $rating, PDO::PARAM_INT);
		$query->bindValue('runtime', $runtime, PDO::PARAM_INT);
		$query->bindValue('slug', $slug, PDO::PARAM_STR);
		$query->bindValue('id', $id, PDO::PARAM_INT);
		$query->execute();

		$affected_rows = $query->rowCount();

		if (!empty($affected_rows)) {

			if (!empty($_FILES) && $_FILES['cover']['error'] == UPLOAD_ERR_OK && $_FILES['cover']['size'] < $max_size) {

				move_uploaded_file($_FILES['cover']['tmp_name'], '../covers/'.$id.'.png');
			}

			$confirm = '<div class="alert alert-success" role="success">Le film a bien été modifié</div>';
			$confirm .= redirectJS('movies.php');
		}
	}
}
?>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<?php
				if (!empty($confirm)) {
					echo $confirm;
					exit();
				}

				if (!empty($errors)) {
				?>
				<div class="alert alert-danger" role="alert">
				<?php
				foreach($errors as $error) {
					echo $error.'<br>';
				}
				?>
				</div>
				<?php } ?>

				<h1 class="page-header">Modifier un film</h1>

				<form action="mod_movie.php?id=<?= $id ?>" enctype="multipart/form-data" class="form-horizontal"  method="POST" novalidate>

					<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />

					<div class="form-group">
						<label for="cover" class="col-sm-2 control-label">Cover</label>
						<div class="col-sm-10">
							<input type="file" name="cover" id="cover" placeholder="Cover">
						</div>
					</div>
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">Title</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?= $title ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="synopsis" class="col-sm-2 control-label">Synopsis</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="synopsis" id="synopsis" placeholder="Synopsis"><?= $synopsis ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="runtime" class="col-sm-2 control-label">Duration</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="runtime" id="runtime" placeholder="Duration" value="<?= $runtime ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="year" class="col-sm-2 control-label">Year</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="year" id="year" placeholder="Année" value="<?= $year ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="genres" class="col-sm-2 control-label">Genre(s)</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="genres" id="genres" placeholder="Genre(s)" value="<?= $genres ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="writers" class="col-sm-2 control-label">Auteurs(s)</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="writers" id="writers" placeholder="Auteurs(s)" value="<?= $writers ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="actors" class="col-sm-2 control-label">Actor(s)</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="actors" id="actors" placeholder="Actor(s)" value="<?= $actors ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="directors" class="col-sm-2 control-label">Director(s)</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="directors" id="directors" placeholder="Director(s)" value="<?= $directors ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">Send</button>
						</div>
					</div>
				</form>

			</div><!--/.main -->

<?php include_once 'footer.php'; ?>