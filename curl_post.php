<?php
$username = 'mco.jaya';
$password = 'mcojaya';
$loginUrl = 'https://mcsys.angkasapura2.co.id/login';
 

include('simple_html_dom.php');
//init curl
$ch = curl_init();
 
//Set the URL to work with
curl_setopt($ch, CURLOPT_URL, $loginUrl);
 
// ENABLE HTTP POST
curl_setopt($ch, CURLOPT_POST, 1);
 
 
//Set the post parameters
curl_setopt($ch, CURLOPT_POSTFIELDS, 'username='.$username.'&password='.$password);
 
//Handle cookies for the login
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
 
//Setting CURLOPT_RETURNTRANSFER variable to 1 will force cURL
//not to print out the results of its query.
//Instead, it will return the results as a string return value
//from curl_exec() instead of the usual true/false.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 
//execute the request (the login)
$store = curl_exec($ch);
 
//the login is now done and you can continue to get the
//protected content.

$url_iata='https://mcsys.angkasapura2.co.id/iata/summary';
//Set the URL to work with
curl_setopt($ch, CURLOPT_URL, $loginUrl);
 
// ENABLE HTTP POST
curl_setopt($ch, CURLOPT_POST, 1);

#f_date_begin	
$tanggal = $_POST["tanggal"];
$date_begin=$tanggal;

#f_date_end	
$date_end=$tanggal;

#f_airline_code	
$airline="GA";
#f_airport_code	
$kota = $_POST["kota"];
$airport=$kota;
#f_flight_type	
$flight="D";

//Set the post parameters
curl_setopt($ch, CURLOPT_POSTFIELDS, 'f_date_begin='.$date_begin.'&f_date_end='.$date_end.'&f_airline_code='.$airline.'&f_airport_code='.$airport.'&f_flight_type='.$flight);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
//set the URL to the protected file
curl_setopt($ch, CURLOPT_URL, $url_iata);

//execute the request
$content = curl_exec($ch);
/*
$html = file_get_html($url_iata);
echo $html->find('td[style="text-align: center"]', 1)->plaintext.'<br><hr>';
*/

// Create a DOM object
$html_base = new simple_html_dom();
// Load HTML from a string
$html_base->load($content);

/*
//get all category links
foreach($html_base->find('tbody') as $element) {
    #echo "<pre>";
    print_r( $element->tr );
    #echo "</pre>";
}
*/
$final = array();

$data1 =array();
$data2 = array();
$payingpax =array();
$nonpaying =array();
$totalpax =array();
$filter1 = "GA";

//parsing html flightno
foreach($html_base->find('td[style="text-align: center"]') as $key=> $e){
    #echo $e->innertext. "\r\n";
    $data1[]=$e->innertext;
	
}

//parsing html route
foreach($html_base->find('span[class="text-domestic"]') as $e){
	    #echo $e->plaintext. "\r\n";
	    $data2[]=$e->plaintext;


}

//parsing html payingpax
foreach($html_base->find('span[class="text-paying-pax"]') as $e){
		     $payingpax[]=$e->plaintext;
}

//parsing html nonpayingpax
foreach($html_base->find('span[class="text-nonpaying-pax"]') as $e){
		$nonpaying[]=$e->innertext;
}

//parsing html totalpayingpax
foreach($html_base->find('span[class="text-total-pax"]') as $e){
		$totalpax[]=$e->innertext;
}

#print_r($totalpax);
//cari flightno
$input="GA";
$array_flightno = array_filter($data1, function ($item) use ($input) {
    if (stripos($item, $input) !== false) {
        return true;
    }
    return false;
});

$input="201";
$array_fltdate = array_filter($data1, function ($item) use ($input) {
    if (stripos($item, $input) !== false) {
        return true;
    }
    return false;
});

#print_r($array_fltdate);

//ambil jumlah paying pax
foreach ($payingpax as $key => $value) {
	# code...
	$pay = strlen($value);
		#echo $pay."\r\n";
	if($pay>=7){
			
		unset($payingpax[$key]);

	}

}


//cari flightno
$array_fno = array();	
foreach (array_values($array_flightno) as $key => $value) {
	# code...
    $array_fno[$key]["FlightNo"]    = $value;
}

//cari fltdate
$array_flightdate = array();	
foreach (array_values($array_fltdate) as $key => $value) {
	# code...
    $array_flightdate[$key]["Fltdate"]    = $value;
}


//cari route
$array_rute = array();	
foreach ($data2 as $key => $value) {
		
	$rute = trim($value);
	$rute = str_replace("(Domestic)", "", $rute);
	$rute = str_replace(" ", "", $rute);
	$rute = substr($rute, 0,7);
	$array_rute[$key]["Route"]    = $rute;

}	    


//cari payingpax	
$array_paying = array();
foreach (array_values($payingpax) as $key => $value) {
	    	# code...
	    	#$temp_array = array();
	    	$temp_array["PayingPax"]    = $value; 
	    $array_paying[$key]["PayingPax"]    = $value;	
}



//cari nonpaying
$array_nonpaying=array();	    	
foreach ($nonpaying as $key => $value) {
	    		# code...
	    		#$temp_array = array();
	$temp_array["NonPayingPax"]    = $value; 	    		
	$array_nonpaying[$key]["NonPayingPax"]    = $value;	
				
}


//cari total pax
$array_totalpax=array();	    	
foreach ($totalpax as $key => $value) {
	# code...
	#$temp_array = array();
	$temp_array["TotalPax"]    = $value; 	    							
	$array_totalpax[$key]["TotalPax"]    = $value;	
}	



function array_merge_recursive_distinct ( array &$array1, array &$array2 )
{
  $merged = $array1;

  foreach ( $array2 as $key => &$value )
  {
    if ( is_array ( $value ) && isset ( $merged [$key] ) && is_array ( $merged [$key] ) )
    {
      $merged [$key] = array_merge_recursive_distinct ( $merged [$key], $value );
    }
    else
    {
      $merged [$key] = $value;
    }
  }

  return $merged;
}

//menggabungkan semua kolom array
$test = array_merge_recursive_distinct($array_flightdate, $array_fno);
$test1 = array_merge_recursive_distinct($test,$array_rute);
$test2 = array_merge_recursive_distinct($test1, $array_paying);
$test3 = array_merge_recursive_distinct($test2, $array_nonpaying);
$final = array_merge_recursive_distinct($test3, $array_totalpax);

$cek_row = count($final)-1;

if($cek_row>1){
	#print_r($final);
	if($airport=="CGK"){
		$airport="CT3";
	}
	$filename = "csv/".$airport.$date_begin.".csv";
	$folder = $_SERVER['DOCUMENT_ROOT'].$filename;
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

	       if(!fputcsv($file, $row))
            die('Something happened during the write of the line '. $row);

	 	}
		 fclose($file);

		 echo "<script>
			alert('success write csv');
			window.location=('form.php');
			</script>";
		
	}

}else{
	echo "<script>
			alert('data array kurang');
			window.location=('form.php');
			</script>";
}



?>
