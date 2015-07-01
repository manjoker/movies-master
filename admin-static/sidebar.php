<?php
$pages = array(
	'index.php' => array('Tableau de bord', -1),
	'stats.php' => array('Statistiques', -1),
	'reports.php' => array('Rapports', -1),
	'movies.php' => array('Films', $count_movies),
	'users.php' => array('Utilisateurs', $count_users),
	'comments.php' => array('Commentaires', -1),
	'messages.php' => array('Messages', -1)
);
?>
			<div id="sidebar-left" class="col-sm-3 col-md-2 sidebar">
				<ul class="nav nav-sidebar">
					<?php
					foreach ($pages as $page_url => $page_options) {
						$active = '';
						if ($current_page == $page_url) {
							$active = 'active';
						}

						if (isAllowedAccess($page_url, $_SESSION['status'])) {
					?>
					<li class="<?= $active ?>">
						<a href="<?= $page_url ?>">
							<?= $page_options[0] ?>
							<?php if ($page_options[1] >= 0) { ?>
							<span class="badge"><?= $page_options[1] ?></span>
							<?php } ?>
						</a>
					</li>
					<?php
						}
					}
					?>
				</ul>

				<a href="javascript:void(0);" onclick="jQuery('#sidebar-left').hide();">
					<span class="glyphicon glyphicon-chevron-left"></span>
				</a>
			</div>