<?php
	// Ce fichier sert à compter le nombre de pages couleur ou N/B imprimées dans les 24h.

function total_page($date_today,$ip){
	include "config.php";
	
	$date = explode("-", $date_today);
	$date_jour = $date[2];
	if($date_hier_jour<10){
		$date_hier_jour = "0".$date_hier_jour;
	}
	$date_mois = $date[1];

	$date_year = $date[0];
	$date_today = $date_year."-".$date_mois."-".$date_jour;
	
	$req = "SELECT sum(dlt_b) as tot_b, sum(dlt_c) as tot_c from printer where print_timestamp LIKE '$date_today%'";
	echo $req."<br>";
	$today = $conn->query($req);
	$today_cpt = $today->fetch_assoc();
	
	$totb = $today_cpt["tot_b"];
	$totc = $today_cpt["tot_c"];
	$ts = date("Y-m-d h:i:s");
	echo $totb . " " . $totc . "<br>";
	$res_insert = "INSERT INTO printer_daily VALUES (NULL,$totb,$totc,'$ts')";
	
	if ($conn->query($res_insert) === TRUE) {
	  echo "New record created successfully";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
	
}

if(isset($_GET["date"])){
	total_page($_GET["date"],$_GET["ip"]);
}
else{
	$date_today=date("Y-m-d");
	total_page($date_today,$_GET["ip"]);
}

?>