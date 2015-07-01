<?php include_once 'header.php' ?>

			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h1 class="page-header">Tableau de bord</h1>

				<div class="row placeholders">
					<div class="col-xs-6 col-sm-3 placeholder">
						<img data-src="holder.js/200x200/auto/sky/text:<?= $count_movies ?> \n films" class="img-responsive" alt="Generic placeholder thumbnail">
						<h4>Nombre de films</h4>
						<span class="text-muted"><?= $count_movies ?></span>
					</div>
					<div class="col-xs-6 col-sm-3 placeholder">
						<img data-src="holder.js/200x200/auto/vine/text:<?= $count_users ?> \n inscriptions" class="img-responsive" alt="Generic placeholder thumbnail">
						<h4>Nombre d'inscriptions</h4>
						<span class="text-muted"><?= $count_users ?></span>
					</div>
					<div class="col-xs-6 col-sm-3 placeholder">
						<img data-src="holder.js/200x200/auto/social/text:42 \n commentaires" class="img-responsive" alt="Generic placeholder thumbnail">
						<h4>Nombre de commentaires</h4>
						<span class="text-muted">42</span>
					</div>
					<div class="col-xs-6 col-sm-3 placeholder">
						<img data-src="holder.js/200x200/auto/#5bc0de:#fff/text:18 \n messages" class="img-responsive" alt="Generic placeholder thumbnail">
						<h4>Nombre de messages</h4>
						<span class="text-muted">18</span>
					</div>
				</div>

				<div class="panel panel-warning">
					<div class="panel-heading">
						<h3 class="panel-title">Derniers messages</h3>
					</div>
					<div class="list-group">
						<a href="#" class="list-group-item">
							<h4 class="list-group-item-heading">Bob Arctor (2015/02/26)</h4>
							<p class="list-group-item-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam lacinia pharetra est at auctor. Integer maximus neque sodales metus congue, quis aliquet nisl rhoncus...</p>
						</a>
						<a href="#" class="list-group-item">
							<h4 class="list-group-item-heading">Johnny John (2015/02/15)</h4>
							<p class="list-group-item-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam lacinia pharetra est at auctor. Integer maximus neque sodales metus congue, quis aliquet nisl rhoncus...</p>
						</a>
					</div>
				</div>

				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Derniers commentaires</h3>
					</div>
					<div class="list-group">
						<a href="#" class="list-group-item">
							<h4 class="list-group-item-heading">Sarah Connor (2015/02/26)</h4>
							<p class="list-group-item-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam lacinia pharetra est at auctor. Integer maximus neque sodales metus congue, quis aliquet nisl rhoncus...</p>
						</a>
						<a href="#" class="list-group-item">
							<h4 class="list-group-item-heading">Bobby Ewing (2015/02/15)</h4>
							<p class="list-group-item-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam lacinia pharetra est at auctor. Integer maximus neque sodales metus congue, quis aliquet nisl rhoncus...</p>
						</a>
					</div>
				</div>

			</div>

<?php include_once 'footer.php' ?>