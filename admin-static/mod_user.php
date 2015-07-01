<?php
include_once 'header.php';

$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

if (empty($id)) {
	exit('Undefined user id');
}

$query = $db->prepare('SELECT * FROM users WHERE id = :id');
$query->bindValue('id', $id, PDO::PARAM_INT);
$query->execute();
$user = $query->fetch();

if (empty($user)) {
	exit('Undefined user');
}

$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : $user['firstname'];
$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : $user['lastname'];
$email = isset($_POST['email']) ? $_POST['email'] : $user['email'];
$status = isset($_POST['status']) ? intval($_POST['status']) : $user['status'];

$errors = array();

if (!empty($_POST)) {

	if (empty($email)) {
		$errors[] = "L'email est obligatoire";
	}

	if (empty($errors)) {

		$query = $db->prepare('UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email, status = :status WHERE id = :id');
		$query->bindValue('firstname', $firstname, PDO::PARAM_STR);
		$query->bindValue('lastname', $lastname, PDO::PARAM_STR);
		$query->bindValue('email', $email, PDO::PARAM_STR);
		$query->bindValue('status', $status, PDO::PARAM_INT);
		$query->bindValue('id', $id, PDO::PARAM_INT);
		$query->execute();

		$confirm = '<div class="alert alert-success" role="success">L\'utilisateur a bien été modifié</div>';
		$confirm .= redirectJS('users.php');
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

				<h1 class="page-header">Modifier un utilisateur</h1>

				<form action="mod_user.php?id=<?= $id ?>" class="form-horizontal"  method="POST" novalidate>

					<div class="form-group">
						<label for="firstname" class="col-sm-2 control-label">Prénom</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="firstname" id="firstname" placeholder="Prénom" value="<?= $firstname ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="lastname" class="col-sm-2 control-label">Nom</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="lastname" id="lastname" placeholder="Nom" value="<?= $lastname ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?= $email ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="status" class="col-sm-2 control-label">Statut</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="status" id="status" placeholder="Statut" value="<?= $status ?>">
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