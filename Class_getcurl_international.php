<?php
class GetCurlInternational{
	
	function __construct(){

		require_once "simple_html_dom.php";
	}	


		
	public function getdata($tanggal, $airlines, $kota, $flight_type){

		$username = 'mco.jaya';
		$password = 'mcojaya';
		$loginUrl = 'https://mcsys.angkasapura2.co.id/login';

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
		#$tanggal = $_POST["tanggal"];
		$date_begin=$tanggal;

		#f_date_end	
		$date_end=$tanggal;

		#f_airline_code	
		$airline=$airlines;
		#f_airport_code	
		#$kota = $_POST["kota"];
		$airport=$kota;
		#f_flight_type	
		$flight=$flight_type;

		//Set the post parameters
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'f_date_begin='.$date_begin.'&f_date_end='.$date_end.'&f_airline_code='.$airline.'&f_airport_code='.$airport.'&f_flight_type='.$flight);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		//set the URL to the protected file
		curl_setopt($ch, CURLOPT_URL, $url_iata);

		//execute the request
		$content = curl_exec($ch);

		//mulai parsing html
		$html_base = new simple_html_dom();
		// Load HTML from a string
		$html_base->load($content);


		function array_merge_recursive_distinct ( array &$array1, array &$array2 ){
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


		$final = array();

		$data1 =array();
		$data2 = array();
		$data3 = array();
		$payingpax =array();
		$nonpaying =array();
		$totalpax =array();
		//$filter1 = "GA";

		//parsing html flightno
		foreach($html_base->find('td[style="text-align: center"]') as $key=> $e){
		    #echo $e->innertext. "\r\n";
		    $data1[]=$e->innertext;
		    
			
		}

		//parsing html route
		foreach($html_base->find('span[class="text-international"]') as $e){
			    #echo $e->plaintext. "\r\n";
			    $data2[]=$e->plaintext;
		}



		foreach($html_base->find('span[class="text-domestic"]') as $e){
			    #echo $e->plaintext. "\r\n";
			    $data3[]=$e->plaintext;
		}

		//ambil rute
		foreach($html_base->find('div[class="pull-left"]') as $e){
			    #echo $e->plaintext. "\r\n";
			    $dataz[]=$e->plaintext;
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
		$array_flightno1 = array_filter($data1, function ($item) use ($input) {
		    if (stripos($item, $input) !== false) {
		        return true;
		    }
		    return false;
		});

		$input="MH";
		$array_flightno2 = array_filter($data1, function ($item) use ($input) {
		    if (stripos($item, $input) !== false) {
		        return true;
		    }
		    return false;
		});

		$input="MI";
		$array_flightno3 = array_filter($data1, function ($item) use ($input) {
		    if (stripos($item, $input) !== false) {
		        return true;
		    }
		    return false;
		});

		$array_flightnox = array_merge_recursive_distinct($array_flightno1, $array_flightno2);
		if(count($array_flightno3>1)){
			$array_flightno = array_merge_recursive_distinct($array_flightnox, $array_flightno3);
		}	

		//gabung rute domestik dan international
		$input=$kota;
		$array_rt = array_filter($dataz, function ($item) use ($input) {
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
		foreach (array_values($array_rt) as $key => $value) {
				
			$rute = trim($value);
			#$rute = str_replace("(Domestic)", "", $rute);
			$rute = str_replace(" ", "", $rute);
			$rute = str_replace("<br>", "", $rute);
			//$rute = substr($rute, 0,7);
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



			


		//menggabungkan semua kolom array
		$test = array_merge_recursive_distinct($array_flightdate, $array_fno);
		$test1 = array_merge_recursive_distinct($test,$array_rute);
		$test2 = array_merge_recursive_distinct($test1, $array_paying);
		$test3 = array_merge_recursive_distinct($test2, $array_nonpaying);
		$final = array_merge_recursive_distinct($test3, $array_totalpax);

		return $final;

	}

}
?>