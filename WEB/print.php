<?php
	// Ce fichier récupère les infos de chaque imprimante envoyées par les requests du script python
	include "config.php";
	
	function null($valeur){
		if($valeur=""){
			return "NULL";
		}
		else{
			return $valeur;
		}
	}
	echo $_POST["tkn"];
	if($_POST["tkn"] == "PASSWORD")
	{
		$conn = new mysqli($host, $user, $pass, $database);
		// Check connection
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		}
		// récupération des valeurs
		$ip = $_POST["ip"];
		$cpt_b = $_POST["cpt_b"];
		$cpt_c = $_POST["cpt_c"];
		$ton_b = $_POST["ton_b"];
		$ton_c = $_POST["ton_c"];
		$ton_y = $_POST["ton_y"];
		$ton_m = $_POST["ton_m"];
		
		// calcul des deltas depuis hier
		$req_last = "SELECT print_cpt_b, print_cpt_c FROM printer where print_ip = '$ip' ORDER BY `printer`.`print_timestamp` DESC LIMIT 0,1";
		$last= $conn->query($req_last);
		$dlast = $last->fetch_assoc();
		$delta_b = $cpt_b - $dlast["print_cpt_b"];
		if($cpt_c != "NULL"){
			$delta_c = $cpt_c - $dlast["print_cpt_c"];
		}
		else{
			$delta_c = 0;
		}
		$ts = date("Y-m-d h:i:s");
		echo $ts;
		//insertion en BDD
		$sql = "INSERT INTO printer VALUE(NULL,'$ts','$ip',$cpt_b,$cpt_c,$delta_b,$delta_c,$ton_b,$ton_c,$ton_y,$ton_m)";
		//echo $sql;
		if ($conn->query($sql) === TRUE) {
		  echo "New record created successfully";
		} else {
		  echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		$conn->close();

	}
	else{
		echo "bad token";
	}	
	
?>	