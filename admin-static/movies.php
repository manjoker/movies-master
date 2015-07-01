<?php
include_once 'header.php';

$query = $db->prepare('SELECT * FROM movies ORDER BY year DESC LIMIT 10');
$query->execute();
$movies = $query->fetchAll();
?>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h1 class="page-header">Films</h1>

				<a href="add_movie.php"><button class="btn btn-primary">Ajouter un film</button></a>

				<h2 class="sub-header">Liste des films</h2>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Id</th>
								<th>Cover</th>
								<th>Title</th>
								<th>Year</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($movies as $movie) { ?>
							<tr>
								<td><?= $movie['id'] ?></td>
								<td><img src="<?= getCover($movie['id']) ?>" width="50"></td>
								<td><?= $movie['title'] ?></td>
								<td><?= $movie['year'] ?></td>
								<td>
									<a href="mod_movie.php?id=<?= $movie['id'] ?>"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
									<a href="del_movie.php?id=<?= $movie['id'] ?>" onclick="if (!confirm('Etes-vous sur de vouloir supprimer le film '+escape('<?= $movie['title'] ?>'))) return false;"><span class="glyphicon glyphicon-remove"></span></a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

<?php include_once 'footer.php' ?>