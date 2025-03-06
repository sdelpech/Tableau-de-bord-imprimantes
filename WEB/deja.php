<?php 
	//Ce fichier renvoi true ou false si des données concernant une imprimante ont déjà été envoyées. Il le fait aussi si une ligne a été ajoutée dans la journée pour print_daily
	include "config.php"; 
	$ip = $_GET["ip"];
	$quoi = $_GET["quoi"];
	$date_today=date("Y-m-d");
	if($quoi == "IP"){
		$req = "SELECT * FROM printer WHERE print_ip = '$ip' and print_timestamp like '$date_today%'";
		//echo $req;
		$test = $conn->query($req);
		$test = $test->fetch_assoc();
		if($test){
			echo "TRUE";  
		}
		else{
			echo "FALSE";
		}
	}
	if($quoi == "dlt"){
		$req = "SELECT * FROM printer_daily WHERE day like '$date_today%'";
		//echo $req;
		$test = $conn->query($req);
		$test = $test->fetch_assoc();
		if($test){
			echo "TRUE";  
		}
		else{
			echo "FALSE";
		}
	}

?>