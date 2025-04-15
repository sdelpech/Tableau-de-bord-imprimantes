<?php 
	include "config.php";
	
	$pwd =  "";
	
	if(isset($_GET["srch"])){
		$search = $_GET["srch"];
	}
	else{
		$req_daily = "SELECT daily_b + daily_c as daily_tot, day FROM `printer_daily` order by day ASC ";
		$res_daily = $conn->query($req_daily);
		while($val_daily = $res_daily->fetch_assoc()){
			$courbe_daily = $courbe_daily . $val_daily["daily_tot"].",";
			$label_day = $label_day . "'".substr($val_daily["day"],0,10)."',";
		}
		$data_daily = "[".$courbe_daily."0]";
		$label_day = "[" . $label_day . "'Today']";
		$showcourbe = 1;
	}
	//echo $label_day;
	if($_GET["pwd"] == $pwd)
	{
	?>
	<!doctype html>
	<html lang="en">
  	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
		<meta name="generator" content="Hugo 0.104.2">
		<title>Imprimantes IUT</title>
	
		<link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/dashboard/">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
		<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
		<style>
	  	.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			user-select: none;
	  	}
	
	  	@media (min-width: 768px) {
			.bd-placeholder-img-lg {
		  	font-size: 3.5rem;
			}
	  	}
	
	  	.b-example-divider {
			height: 3rem;
			background-color: rgba(0, 0, 0, .1);
			border: solid rgba(0, 0, 0, .15);
			border-width: 1px 0;
			box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
	  	}
	
	  	.b-example-vr {
			flex-shrink: 0;
			width: 1.5rem;
			height: 100vh;
	  	}
	
	  	.bi {
			vertical-align: -.125em;
			fill: currentColor;
	  	}
	
	  	.nav-scroller {
			position: relative;
			z-index: 2;
			height: 2.75rem;
			overflow-y: hidden;
	  	}
	
	  	.nav-scroller .nav {
			display: flex;
			flex-wrap: nowrap;
			padding-bottom: 1rem;
			margin-top: -1px;
			overflow-x: auto;
			text-align: center;
			white-space: nowrap;
			-webkit-overflow-scrolling: touch;
	  	}
		</style>
		<!-- Custom styles for this template -->
		<link href="dashboard.css" rel="stylesheet">
		<script type="text/javascript">
			function clickPress(event) {
				if (event.keyCode == 13) {
					search = document.getElementById("Search").value
					window.location = "https://sylvain.delpe.ch/print/tdb.php?pwd=<?php echo $pwd?>&srch=" + search;
				}
			}
		</script>
  	</head>
  	<body>
		
	<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  	<a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="https://sylvain.delpe.ch/print/tdb.php?pwd=sknduqkvnoienzrjkbnlvkjnbelkrvl">Imprimantes</a>
  	<button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
  	</button>
  	<input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" id="Search" placeholder="Search" aria-label="Search" onkeypress="clickPress(event)">
  	<div class="navbar-nav">
  	</div>
	</header>
	
	<div class="container-fluid">
  	<div class="row">
		<main class="col-md-12 ms-sm-auto col-lg-12 px-md-12">
		<?php
			if($showcourbe == 1){
			?>
		   		<canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>				
			<?php
			}
		?>

	
	  	<h2>Imprimantes</h2>
	  	<div class="table-responsive">
			<table class="table table-striped table-sm">
		  	<thead>
				<tr>
			  	<th></th>
			  	<th scope="col">Nom</th>
			  	<th scope="col">IP</th>
			  	<th scope="col">SN</th>
			  	<th scope="col">Compteur Noir</th>
			  	<th scope="col">Couleur</th>
			  	<th scope="col">Total</th>
			  	<th scope="col">B</th>
			  	<th scope="col">C</th>
			  	<th scope="col">M</th>
			  	<th scope="col">Y</th>
			  	<th scope="col">24H</th>
				<th scope="col">J 365</th>  
				<th scope="col">Date</th>  
				</tr>
		  	</thead>
		  	<tbody>
		  	<?php
				$date_today=date("Y-m-d");
				$date = explode("-", $date_today);
				$date_jour = $date[2];
				$date_mois = $date[1];
				$date_year = $date[0];
				$date_today = $date_year."-".$date_mois."-".$date_jour;
				if(isset($_GET["srch"])){
					$search = $_GET["srch"];
					$req="WITH cte AS (
						SELECT p.*,
							   ROW_NUMBER() OVER (PARTITION BY p.print_ip ORDER BY p.print_timestamp DESC) AS rn
						FROM printer p
						WHERE p.print_ip IN (
							SELECT print_ip
							FROM print_name
							WHERE print_ip LIKE '%$search%' OR print_name LIKE '%$search%' OR print_serial LIKE '%$search%'
						)
					)
					SELECT *
					FROM cte
					WHERE rn = 1
					ORDER BY print_timestamp DESC;";
					//echo $req;
				}
				else{
		  			$req = "WITH cte AS (
						  SELECT p.*,
								 ROW_NUMBER() OVER (PARTITION BY p.print_ip ORDER BY p.print_timestamp DESC) AS rn
						  FROM printer p
						  WHERE p.print_ip IN (
							  SELECT print_ip
							  FROM print_name
						  )
					  )
					  SELECT *
					  FROM cte
					  WHERE rn = 1
					  ORDER BY print_timestamp DESC;";
					//echo $req;
				}
				$res_print = $conn->query($req);
				$i = 0;
				while($val_print = $res_print->fetch_assoc()){
					$i++;
					$ip = $val_print["print_ip"];
					$req_nom = "SELECT * FROM print_name WHERE print_ip = '$ip'";
					$nom = $conn->query($req_nom);
					$nom = $nom->fetch_assoc();
					
					
					
					$compteur_total = $val_print["print_cpt_b"] + $val_print["print_cpt_c"];
					$totdlt = $val_print["dlt_b"] + $val_print["dlt_c"];
					
					$dj365 = date('Y-m-d H:m:s', strtotime('-1 year'));
					$reqj365 = "SELECT sum(dlt_b), sum(dlt_c) FROM `printer` where print_timestamp > '$dj365' AND print_ip='$ip'";
					//echo $reqj365;
					$j365 = $conn->query($reqj365);
					$j365 = $j365->fetch_assoc();
					
					echo "<tr>";
					echo "<td>". $i ."</td>";
					echo "<td>". $nom["print_name"]."</td>";
					?><td><a href="http://<?php echo $val_print["print_ip"]?>"><?php echo $val_print["print_ip"]?></a></td>
					<?php
					echo "<td>". $nom["print_serial"]."</td>";
					echo "<td>". $val_print["print_cpt_b"] . "</td>";
					echo "<td>". $val_print["print_cpt_c"] . "</td>";
					echo "<td>". $compteur_total . "</td>";
					// Tonners
					?>
						<td>
							<div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="<?php  echo $val_print["print_ton_b"];  ?>" aria-valuemin="0" aria-valuemax="100">
						  	<div class="progress-bar bg-black" style="width: <?php  echo $val_print["print_ton_b"];  ?>%"><?php  echo $val_print["print_ton_b"];  ?></div>
							</div>
						</td>
						<td>
							<div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="<?php  echo $val_print["print_ton_c"];  ?>" aria-valuemin="0" aria-valuemax="100">
						  	<div class="progress-bar bg-info" style="width: <?php  echo $val_print["print_ton_c"];  ?>%"><?php  echo $val_print["print_ton_c"];  ?></div>
							</div>
						</td>
						<td>
							<div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="<?php  echo $val_print["print_ton_y"];  ?>" aria-valuemin="0" aria-valuemax="100">
						  	<div class="progress-bar bg-danger" style="width: <?php  echo $val_print["print_ton_y"];  ?>%"><?php  echo $val_print["print_ton_y"];  ?></div>
							</div>
						</td>
						<td>
							<div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="<?php  echo $val_print["print_ton_m"];  ?>" aria-valuemin="0" aria-valuemax="100">
						  	<div class="progress-bar bg-warning" style="width: <?php  echo $val_print["print_ton_m"];  ?>%"><?php  echo $val_print["print_ton_m"];  ?></div>
							</div>
						</td>
					<?php
					$prix365 = ($j365["sum(dlt_b)"]*$nom["cost_b"]) + ($j365["sum(dlt_c)"] * $nom["cost_c"]);
					$prix24 = ($val_print["dlt_b"]*$nom["cost_b"]) + ($val_print["dlt_c"]*$nom["cost_c"]) ;
					$montant24 = $montant24 + $prix24;
					$montant365 = $montant365 + $prix365;
					
					if(($prix365 != 0) ){
						echo "<td>". $totdlt . "<br>" . $prix24 . " €</td>";
						echo "<td>". $j365["sum(dlt_b)"] + $j365["sum(dlt_c)"] . "<br>" . $prix365  . "€</td>";						
					}
					else{
						echo "<td>". $totdlt ."</td>";
						echo "<td>". $j365["sum(dlt_b)"] + $j365["sum(dlt_c)"] . "</td>";
					}
					echo "<td>". $val_print["print_timestamp"]."</td>";
					echo "</tr>";
				}
		  	?>
			  <tr>
				  <td></td>
				  <td></td>
				  <td></td>
				  <td></td>
				  <td></td>
				  <td></td>
				  <td></td>
				  <td></td>
				  <td></td>
				  <td></td>
				  <td></td>
				  <td><?php echo $montant24?> €</td>
				  <td><?php echo $montant365?> €</td>
				  <td></td>
			  </tr>
		  	</tbody>
			</table>
	  	</div>
		</main>
  	</div>
	</div>
	
	
		<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
	
		<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
		<script type="text/javascript">
			(() => {
		  	'use strict'
			
		  	feather.replace({ 'aria-hidden': 'true' })
			
		  	// Graphs
		  	const ctx = document.getElementById('myChart')
		  	// eslint-disable-next-line no-unused-vars
		  	const myChart = new Chart(ctx, {
				type: 'line',
				data: {
			  	labels: <?php echo $label_day;?>,
			  	datasets: [{
					data:<?php echo $data_daily;?>,
					lineTension: 0,
					backgroundColor: 'transparent',
					borderColor: '#007bff',
					borderWidth: 4,
					pointBackgroundColor: '#007bff'
			  	}]
				},
				options: {
			  	scales: {
					yAxes: [{
				  	ticks: {
						beginAtZero: false
				  	}
					}]
			  	},
			  	legend: {
					display: false
			  	}
				}
		  	})
			})()
		</script>
  	</body>
	</html>
	<?php
	}
?>
