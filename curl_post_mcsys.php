<?php
$username = 'mco.jaya';
$password = 'mcojaya';
$loginUrl = 'https://mcsys.angkasapura2.co.id/login';
 
include 'Class_getcurl_international.php';
$curl = new GetCurlInternational();


$tanggal = $_POST["tanggal"];
$kota = $_POST["kota"];
$airline = $_POST["airline"];
$flight_type = $_POST["flight_type"];



$final = $curl->getdata($tanggal, $airline, $kota, $flight_type);


$cek_row = count($final)-1;

if($cek_row>1){
	#print_r($final);
	if($kota=="CGK"){
		$kota="CT3";
	}

	include "DB_Function.php";
	$dbfunc = new DB_Function($kota);

	
	$filename = dirname(__FILE__)."/csv/".$kota.$tanggal.".csv";
	
	if (file_exists($filename)){
		
		#echo "file sudah ada \r\n";
		echo "<script>
			alert('file sudah ada');
			window.location=('form.php');
			</script>";
	}else{

		
		//tulis ke csv
		$file = fopen($filename,"w");
		$header= array(
	            "Flight Date" => "Flight Date",
	            "Flight No." => "Flight No.",
	            "Route" => "Route",
	            "Paying Pax" => "Paying Pax" ,
	            "Non-Paying Pax" => "Non-Paying Pax",
	            "Total Pax" => "Total Pax"
	        );

		
		fputcsv($file, array_keys($header));

		foreach ($final as $row) {
	       fputcsv($file, $row);

	       // if(!fputcsv($file, $row))
        //     die('Something happened during the write of the line '. $row);

	 	}
		 fclose($file);

		




		 echo "<script>
		 	var filename=\"$filename\";
			alert('success write csv '+filename);
			window.location=('form.php');
			</script>";
		
	}

	/*//ambil dataperflight
		$dataperflight = $dbfunc->ambildataperflight($tanggal);

		foreach ($dataperflight as $key => $value) {
				# code...

			$FlightNo = $value["FlightNo"];
			$daper_Adult= $value["Adult"]-$value["Child"];
			$daper_Child= $value["Child"];
			$daper_Infant= $value["Infant"];
			$daper_Transit= $value["Transit"];
			$daper_Pob= $value["Pob"]+$value["Infant"];
			$daper_xPOB= $value["xPOB"];
			$daper_Crew= $value["Crew"];

			$transit = $daper_xPOB;
			$transfer= $daper_Transit;

			$route = $dbfunc->get_route_dataperflight($FlightNo, $tanggal);

			//cek flightno sudah ada di table mcsys db daerah belum
			$cek_mcsys = $dbfunc->cekmcsysdata($FlightNo, $tanggal); 
			if($cek_mcsys<1){
				$insert = $dbfunc->insert_mcsysdata($tanggal, $FlightNo, $route, $daper_Adult, $daper_Child, $daper_Infant, $transit, $daper_Crew, $daper_Pob, $transfer);
			}

		}*/



}else{
	echo "<script>
			alert('data array kurang');
			window.location=('form.php');
			</script>";
}



?>
