<?php
include_once 'header.php';

$query = $db->prepare('SELECT * FROM users ORDER BY register_date DESC LIMIT 10');
$query->execute();
$users = $query->fetchAll();
?>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h1 class="page-header">Utilisateurs</h1>

				<h2 class="sub-header">Liste des utilisateurs</h2>

				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Id</th>
								<th>Firstname</th>
								<th>Lastname</th>
								<th>Email</th>
								<th>Date d'inscription</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($users as $user) { ?>
							<tr>
								<td><?= $user['id'] ?></td>
								<td><?= $user['firstname'] ?></td>
								<td><?= $user['lastname'] ?></td>
								<td><?= $user['email'] ?></td>
								<td><?= date('d-m-Y H:i:s', strtotime($user['register_date'])) ?></td>
								<td><span class="label label-<?= getStatusClass($user['status']) ?>"><?= getStatusLabel($user['status']) ?></span></td>
								<td>
									<a href="mod_user.php?id=<?= $user['id'] ?>"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
									<a href="del_user.php?id=<?= $user['id'] ?>" onclick="if (!confirm('Etes-vous sur de vouloir supprimer l\'utilisateur '+escape('<?= $user['firstname'].' '.$user['lastname'] ?>'))) return false;"><span class="glyphicon glyphicon-remove"></span></a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

<?php include_once 'footer.php' ?>