<?php
include_once 'header.php';

$query = $db->prepare('SELECT * FROM settings LIMIT 1');
$query->execute();
$settings = $query->fetch();

$settings_nav_color = !empty($settings['nav_color']) ? $settings['nav_color'] : '';
$settings_site_font = !empty($settings['site_font']) ? $settings['site_font'] : '';
$settings_block_color = !empty($settings['block_color']) ? $settings['block_color'] : '';
$settings_site_logo = !empty($settings['site_logo']) ? $settings['site_logo'] : '';

$nav_color = !empty($_POST['nav_color']) ? $_POST['nav_color'] : '';
$site_font = !empty($_POST['site_font']) ? $_POST['site_font'] : '';
$block_color = !empty($_POST['block_color']) ? $_POST['block_color'] : '';
$site_logo = !empty($_POST['site_logo']) ? $_POST['site_logo'] : '';

if (!empty($_POST)) {

	if (empty($settings)) {

		$query = $db->prepare('INSERT INTO settings SET nav_color = :nav_color, site_font = :site_font, block_color = :block_color, site_logo = :site_logo');

	} else {

		$query = $db->prepare('UPDATE settings SET nav_color = :nav_color, site_font = :site_font, block_color = :block_color, site_logo = 	:site_logo WHERE id = :id');
		$query->bindValue('id', $settings['id'], PDO::PARAM_INT);
	}

	$query->bindValue('nav_color', $nav_color, PDO::PARAM_STR);
	$query->bindValue('site_font', $site_font, PDO::PARAM_STR);
	$query->bindValue('block_color', $block_color, PDO::PARAM_STR);
	$query->bindValue('site_logo', $site_logo, PDO::PARAM_STR);
	$query->execute();

	$confirm = '<div class="alert alert-success" role="success">Les settings ont bien été enregistrés</div>';
	$confirm .= redirectJS('settings.php');
}
?>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<?php
				if (!empty($confirm)) {
					echo $confirm;
					exit();
				}
				?>
				<h1 class="page-header">Settings</h1>

				<form action="settings.php" enctype="multipart/form-data" class="form-horizontal"  method="POST" novalidate>

					<div class="form-group">
						<label for="nav_color" class="col-sm-2 control-label">Couleur navigation</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="nav_color" id="nav_color" placeholder="Couleur navigation" value="<?= $settings_nav_color ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="site_font" class="col-sm-2 control-label">Police du site</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="site_font" id="site_font" placeholder="Police du site" value="<?= $settings_site_font ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="block_color" class="col-sm-2 control-label">Couleur du bloc</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="block_color" id="block_color" placeholder="Couleur du bloc" value="<?= $settings_block_color ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="site_logo" class="col-sm-2 control-label">Logo du site</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="site_logo" id="site_logo" placeholder="Logo du site" value="<?= $settings_site_logo ?>">
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