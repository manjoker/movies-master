<?php
include_once 'header.php';

$title = !empty($_POST['title']) ? $_POST['title'] : '';
$year = !empty($_POST['year']) ? intval($_POST['year']) : '';
$genres = !empty($_POST['genres']) ? $_POST['genres'] : '';
$synopsis = !empty($_POST['synopsis']) ? $_POST['synopsis'] : '';
$directors = !empty($_POST['directors']) ? $_POST['directors'] : '';
$writers = !empty($_POST['writers']) ? $_POST['writers'] : '';
$actors = !empty($_POST['actors']) ? $_POST['actors'] : '';
$runtime = !empty($_POST['runtime']) ? intval($_POST['runtime']) : '';
$rating = 0;
$slug = '';

$errors = array();

if (!empty($_POST)) {

	if (empty($title)) {
		$errors[] = 'Le titre est obligatoire';
	}
	if (empty($year)) {
		$errors[] = "L'année est obligatoire";
	}

	if (empty($errors)) {

		$slug = cleanString($title).'-'.$year;

		$query = $db->prepare('INSERT INTO movies (title, year, genres, synopsis, directors, writers, actors, rating, runtime, slug) VALUES (:title, :year, :genres, :synopsis, :directors, :writers, :actors, :rating, :runtime, :slug)');
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
		$query->execute();

		$insert_id = $db->lastInsertId();

		if (!empty($insert_id)) {

			$max_size = 2000000;

			if (!empty($_FILES) && $_FILES['cover']['error'] == UPLOAD_ERR_OK && $_FILES['cover']['size'] < $max_size) {

				move_uploaded_file($_FILES['cover']['tmp_name'], '../covers/'.$insert_id.'.png');
			}

			$confirm = '<div class="alert alert-success" role="success">Le film a bien été ajouté</div>';
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

				<h1 class="page-header">Ajouter un film</h1>

				<form enctype="multipart/form-data" class="form-horizontal"  method="POST" novalidate>

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
							<!--<div id="wysiwyg"></div>-->
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
							<button id="btn-submit" type="submit" class="btn btn-default">Send</button>
						</div>
					</div>
				</form>

			</div><!--/.main -->

			<script>
			/*
			$(document).ready(function() {
				$('#editor').wysiwyg();
				$('#btn-submit').click(function() {
					var html = $('#editor').html();
				});
			});
			*/
			</script>

<?php include_once 'footer.php'; ?>