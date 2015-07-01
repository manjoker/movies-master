<?php
include_once 'header.php';

$query = $db->prepare('DESC movies');
$query->execute();
$db_fields = $query->fetchAll();

$required_exceptions = array(
	'id' => true,
	'slug' => true,
	'modified' => true,
	'rating' => true,
	'poster_flag' => true
);

$errors = array();
$fields = array();

foreach($db_fields as $field) {

	$field_name = $field['Field'];
	$field_type = PDO::PARAM_STR;
	if (strpos('int', $field['Type']) !== false) {
		$field_type = PDO::PARAM_INT;
	} else if ($field['Type'] == 'blob') {
		$field_type = 'blob';
	} else if ($field['Type'] == 'datetime') {
		$field_type = 'datetime';
	}
	$field_required = $field['Null'] == 'NO' ? true : false;
	$field_extra = $field['Extra'];

	if ($field_extra == 'auto_increment') {
		continue;
	}

	$fields[$field_name] = array(
		'type' => $field_type,
		'required' => $field_required
	);

	$$field_name = !empty($_POST[$field_name]) ? $_POST[$field_name] : '';

	if ($field_type == PDO::PARAM_INT) {
		$$field_name = intval($$field_name);
	}

	if (!empty($_POST)) {
		if ($field_required && !isset($required_exceptions[$field_name]) && empty($_POST[$field_name])) {
			$errors[$field_name] = true;
		}
	}
}

if (!empty($_POST) && empty($errors)) {

	$slug = cleanString($_POST['title']).'-'.$_POST['year'];

	$sql = 'INSERT INTO movies ';
	$set = '';
	foreach($fields as $fieldname => $field_params) {

		if ($field_params['type'] == 'blob') {
			continue;
		}

		if (empty($set)) {
			$set = 'SET ';
		} else {
			$set .= ', ';
		}

		$set .= $fieldname.' = :'.$fieldname;
	}
	$sql .= $set;

	echo $sql;

	$query = $db->prepare($sql);

	foreach($fields as $fieldname => $field_params) {

		if ($field_params['type'] == 'blob' || $field_params['type'] == 'datetime') {
			continue;
		}

		$query->bindValue($fieldname, $$fieldname, $field_params['type']);
	}
	$query->execute();

	$insert_id = $db->lastInsertId();

	if (!empty($insert_id)) {

	}
}


/*
$max_size = 2000000;

if (!empty($_FILES) && $_FILES['cover']['error'] == UPLOAD_ERR_OK && $_FILES['cover']['size'] < $max_size) {

	if (move_uploaded_file($_FILES['cover']['tmp_name'], 'upload/'.$_FILES['cover']['name']) === true) {
		echo 'Upload réussi';
	}
}
*/
?>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

				<?php

				echo @$sql;
				?>

				<?php if (!empty($errors)) { ?>
				<div class="alert alert-danger" role="alert">
				<?php
				foreach($errors as $fieldname => $error) {
					echo $fieldname.' error<br>';
				}
				?>
				</div>
				<?php } ?>

				<h1 class="page-header">Ajouter un film</h1>

				<form enctype="multipart/form-data" class="form-horizontal"  method="POST" novalidate>

					<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />

					<?php foreach($fields as $fieldname => $field_params) { ?>
					<div class="form-group">
						<label for="<?= $fieldname ?>" class="col-sm-2 control-label"><?= ucfirst($fieldname) ?></label>
						<div class="col-sm-10">
							<?php
							$input_type = $field_params['type'] == 'blob' ? 'file' : 'text';
							?>
							<input type="<?= $input_type ?>" class="form-control" name="<?= $fieldname ?>" id="<?= $fieldname ?>" placeholder="<?= ucfirst($fieldname) ?>" value="<?= $$fieldname ?>">
						</div>
					</div>
					<?php } ?>

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">Send</button>
						</div>
					</div>
				</form>

			</div><!--/.main -->

<?php include_once 'footer.php'; ?>