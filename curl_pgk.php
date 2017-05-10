<?php
include "Class_getcurl_domestik.php";
date_default_timezone_set('Asia/Jakarta');

$curl = new GetCurl();

echo $tanggal = date("Y-m-d", strtotime("-26 day"));

$jam = date("H:i");
if($jam>="10:00"){
 $tanggal = date("Y-m-d", strtotime($tanggal."+14 day"));	
}

#ALL untuk semua airlines
$airlines="GA";

$kota    = "PGK";

#ALL untuk semua
#D domestik
#I internasioanal
$flight_type="D";

$final = $curl->getdata($tanggal, $airlines, $kota, $flight_type);
#print_r($final);

$cek_row = count($final);

#echo "\r\n $cek_row \r\n";

$body='';
if($cek_row>=1){

	if($kota=="CGK"){
		$kota="CT3";
	}
		
		// $filename = "csv/".$kota.$tanggal.".csv";
		$filename = dirname(__FILE__)."/csv/".$kota.$tanggal.".csv";
		if (file_exists($filename)){
		
			$bodyx='file sudah ada '.$filename;

		
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
			

			//tulis header
			fputcsv($file, array_keys($header));

			foreach ($final as $row) {
			    //tulis csv
			    fputcsv($file, $row);

			}
		 	
		 	fclose($file);
		}


}else{
$body.= "data belum ada di web maxis $tanggal $kota $airlines";
}

if(!empty($body)){
	$to = "defri@mcojaya.com";
	$subject = "ambil data iata maxis $kota";
	$header = "From: admin@mcojaya.com"."\r\n".
				"CC: flightprcsv@mcojaya.com";	

	mail($to, $subject, $body, $header);
}
?>
