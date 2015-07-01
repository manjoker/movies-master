<?php
include_once 'header.php';


// On récupère la liste des genres
$query = $db->prepare('SELECT genre_label, genre_name FROM genres ORDER BY genre_name ASC');
$query->execute();
$genres = $query->fetchAll();

// Stats du nombre de films par genre
$query = $db->prepare('SELECT :genre_name as genre_name, COUNT(*) as count_genre FROM movies WHERE genres LIKE :genre_label');
$query->bindParam('genre_name', $genre_name);
$query->bindParam('genre_label', $genre_label);

$_count_movie_genres = array();
foreach($genres as $genre) {
	$genre_name = $genre['genre_name'];
	$genre_label = '%'.$genre['genre_label'].'%';
	$query->execute();
	$result = $query->fetch();
	$_count_movie_genres[$result['genre_name']] = (int) $result['count_genre'];
}

arsort($_count_movie_genres);

$_count_movie_genres = array_slice($_count_movie_genres, 0, 10);

$count_movie_genres = array(array('Genre', 'Nombre de films'));
foreach($_count_movie_genres as $genre_label => $count_movie_genre) {
	$count_movie_genres[] = array($genre_label, $count_movie_genre);
}

// Stats des connexions par heure
$query = $db->prepare('SELECT HOUR(visit_date) as visit_hour, MINUTE(visit_date) as visit_minute, COUNT(*) as visit_count FROM visits WHERE DAY(visit_date) = DAY(NOW()) GROUP BY HOUR(visit_date), MINUTE(visit_date)');
$query->execute();
$results = $query->fetchAll();

$connexion_hour_minutes = array();
foreach($results as $result) {
	$connexion_hour_minutes[$result['visit_hour']][$result['visit_minute']] = $result['visit_count'];
}

$hours = range(9, 18);
$minutes = range(0, 59);
$ticks = range(9.5, 17.5, 0.5);

$connexion_data = array();
foreach($hours as $hour) {

	foreach($minutes as $minute) {

		$hour_minute = array($hour, $minute, 0);

		$connexion_hour_minute = 0;
		if (!empty($connexion_hour_minutes[$hour][$minute])) {
			$connexion_hour_minute = (int) $connexion_hour_minutes[$hour][$minute];
		}

		$connexion_data[] = array($hour_minute, $connexion_hour_minute);
	}
}

$connexion_ticks = array();
foreach($ticks as $tick) {
	$connexion_ticks[] = array(floor($tick), (isDecimal($tick) ? 30 : 0), 0);
}

// Stats des films par année
$query = $db->prepare('SELECT year, COUNT(*) as count_movies FROM movies GROUP BY year ORDER BY year ASC');
$query->execute();
$count_movie_years = $query->fetchAll();

$movie_data = array();
foreach($count_movie_years as $count_movie_year) {
	$year = (string)$count_movie_year['year'];
	$count_movie = (int)$count_movie_year['count_movies'];
	//$count_movie = intval($count_movie_year['count_movies']);
	$movie_data[] = array($year, $count_movie);
}
?>
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

		<h1 class="page-header">Statistiques</h1>

		<div id="gauge_chart" style="width: 600px; height: 200px; margin: 0 auto;"></div>
		<div id="pie_chart" style="width: 100%; height: 600px;"></div>
		<div id="line_chart" style="width: 100%; height: 500px;"></div>
		<div id="bar_chart" style="width: 100%; height: 500px;"></div>

	</div>

	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
	google.load("visualization", "1", {packages:["line", "corechart", "gauge"]});
	google.setOnLoadCallback(drawCharts);

	function drawCharts() {
		drawGaugeChart();
		drawPieChart();
		drawLineChart();
		drawBarChart();
	}

	function drawGaugeChart() {

		var data = google.visualization.arrayToDataTable([
			['Label', 'Value'],
			['Memory', 80],
			['CPU', 55],
			['Network', 68]
		]);

		var options = {
			width: 600, height: 200,
			greenFrom:0, greenTo: 75,
			yellowFrom:75, yellowTo: 90,
			redFrom: 90, redTo: 100,
			minorTicks: 5
		};

		var chart = new google.visualization.Gauge(document.getElementById('gauge_chart'));

		chart.draw(data, options);

		setInterval(function() {
			data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
			chart.draw(data, options);
		}, 13000);
		setInterval(function() {
			data.setValue(1, 1, 40 + Math.round(60 * Math.random()));
			chart.draw(data, options);
		}, 5000);
		setInterval(function() {
			data.setValue(2, 1, 60 + Math.round(20 * Math.random()));
			chart.draw(data, options);
		}, 26000);
	}

	function drawPieChart() {
		var data = google.visualization.arrayToDataTable(<?= json_encode($count_movie_genres) ?>);

		var options = {
			title: 'Repartition des film par genre',
			is3D: true
		};

		var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
		chart.draw(data, options);
	}

	function drawLineChart() {

		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Année');
		data.addColumn('number', 'Nombre de films');

		data.addRows(<?= json_encode($movie_data) ?>);

		var options = {
			title: 'Nombre de films par annee',
			width: '100%',
			height: 500
		};

		var chart = new google.visualization.LineChart(document.getElementById('line_chart'));

		chart.draw(data, options);
	}

	function drawBarChart() {

		var data = new google.visualization.DataTable();
		data.addColumn('timeofday', 'Heure');
		data.addColumn('number', 'Connexions');

		data.addRows(<?= json_encode($connexion_data) ?>);

		var options = {
			title: 'Nombre de connexions par heure',
			width: '100%',
			height: 500,
			hAxis: {
	        	ticks: <?= json_encode($connexion_ticks) ?>
	        },
	        colors: ['#DB4437']
		};

		var chart = new google.visualization.ColumnChart(document.getElementById('bar_chart'));

		chart.draw(data, options);
	}

	</script>

<?php include_once 'footer.php' ?>