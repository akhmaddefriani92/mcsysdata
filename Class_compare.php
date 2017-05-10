<?php
class Compare{

	var $dbfunc ;
	var $kota;

	function __construct($param){

		require_once "DB_Function.php";
		$this->dbfunc = new DB_Function($param);
		$this->kota   = $param;	


	}

	public function getdata($tanggal){
		
		


		$mcsysdata = $this->dbfunc->mcsysdata($tanggal);	
		$mcsys_rows = count($mcsysdata)-1;
		foreach ($mcsysdata as $key => $value) {
		    # code...
		    $FlightNo_mcsys= trim($value["FlightNo"]);
		    $FlightNo_mcsys= $this->ambil_spasi_flightno($FlightNo_mcsys);
		    $mcsys["FlightNo"][$key] = $FlightNo_mcsys;
		    $mcsys["TotalPax"][$key] = $value["TotalPax"];
		    $mcsys["PayingPax"][$key] = $value["PayingPax"];
		    #$mcsys["NonPayingPax"][$key] = $value["NonPayingPax"]+$value["Transit"];
		    $mcsys["NonPayingPax"][$key] = $value["NonPayingPax"];
		    $mcsys["ChildPaying"][$key] = $value["ChildPaying"];
		    $mcsys["Infant"] [$key]= $value["Infant"];
		    $mcsys["Transfer"][$key]= $value["Transfer"];
		    $mcsys["Transit"][$key]= $value["Transit"];
		}
		             	

		$filename = $this->kota.$tanggal.".csv";			
		include "csv_to_array.php";
		$file_csv ="/var/www/mcsysdata/csv/".$filename;

		$csvdata = csv_to_array($filename=$file_csv, $delimiter=',');
			            #print_r($csvdata[0]);	
		$csvdata_rows = count($csvdata)-1;
			            #echo $csvdata_rows."<br>";
		function sortByIO($a, $b){
            $a = $a['Flight No.'];
            $b = $b['Flight No.'];

            if ($a == $b){
                return 0;
            }

            return ($a < $b) ? -1 : 1;
        }
                 
        usort($csvdata, 'sortByIO');
		foreach($csvdata as $key => $body){
			$csv["fltdate"][$key]=$body["Flight Date"];
			$csv["FlightNo"][$key]=str_replace(" ", "", $body["Flight No."]);
			$csv["Route"][$key]=trim($body["Route"]);
			$csv["PayingPax"][$key]=$body["Paying Pax"];
			$csv["NonPayingPax"][$key]=$body["Non-Paying Pax"];
			$csv["TotalPax"][$key]=$body["Total Pax"];
			#$csv["PSC"][$key]=$body["PSC (IDR)"];
			#echo $csv["FlightNo"][$key]."<br>";
		}
			            
		$dataperflight = $this->dbfunc->DataPerFlight($tanggal);
		$dataper_rows = count($dataperflight)-1;
		
		$array_result = array(); 	
		foreach ($dataperflight as $key => $value) {
		    # code...
		    $Fltdate = date("Y-m-d", strtotime($value["Fltdate"]));
			$FlightNo = trim($value["FlightNo"]);
		    $e_fno= $this->ambil_spasi_flightno($FlightNo);
							

		    $TotalPax = $value["TotalPax"];
		    $PayingPax = $value["PayingPax"];
		    $NonPayingPax = $value["NonPayingPax"]+$value["Transit"];
		    $ChildPaying = $value["ChildPaying"];

		    $Infant = $value["Infant"];
		    $Transfer = $value["Transfer"];
		    $Transit = $value["Transit"];

		    $fnoflt =$FlightNo."/".$Fltdate."/".$this->kota;
		             		
			$c_fno     = '';
			$c_totpax  = 0;
			$c_route  = '';
			$c_paypax  = 0;
			$c_nonpaypax = 0;
					        
			for ($i=0; $i<=$csvdata_rows; $i++){
				#echo $e_fno." gaga ".$csv["FlightNo"][$i]."<br>";
				if( $e_fno == $csv["FlightNo"][$i]){
										
					$c_fno     = $csv["FlightNo"][$i];
					$c_totpax  = $csv["TotalPax"][$i];
					$c_paypax  = $csv["PayingPax"][$i];
					$c_nonpaypax = $csv["NonPayingPax"][$i];
					$c_route	= $csv["Route"][$i];
									
					break;
				}
			}
			
			$mcs_fno     = '';
			$mcs_totpax  = 0;
			$mcs_paypax  = 0;
			$mcs_nonpaypax = 0;
					        
			for ($i=0; $i<=$mcsys_rows; $i++){
								// echo $e_fno." gaga ".$mcsys["FlightNo"][$i]."<br>";
				if( $e_fno == $mcsys["FlightNo"][$i]){
										
					$mcs_fno     = $mcsys["FlightNo"][$i];
					$mcs_totpax  = $mcsys["TotalPax"][$i];
					$mcs_paypax  = $mcsys["PayingPax"][$i];
					$mcs_nonpaypax = $mcsys["NonPayingPax"][$i];
					break;
										
				}
			}

			//selisih csv iata -  dashboard				
			$selisih_totpax = $c_totpax-$TotalPax;		
			$selisih_paypax = $c_paypax-$PayingPax;		
			$selisih_nonpaypax = $c_nonpaypax-$NonPayingPax;		
						    
			//selisih maxis - dashboard
			$selisih_totpax2 = $mcs_totpax-$TotalPax;		
			$selisih_paypax2 = $mcs_paypax-$PayingPax;		
			$selisih_nonpaypax2 = $mcs_nonpaypax-$NonPayingPax;		
						    
			if($selisih_totpax<>0 || $selisih_paypax<>0 || $selisih_nonpaypax <>0 || $selisih_totpax2<>0 || $selisih_paypax2<>0 || $selisih_nonpaypax2 <>0){
							
				$temp_array = array();
			    $temp_array["fnoflt"]    = $fnoflt;
			    $temp_array["dbkota"]    = $this->kota;
			    $temp_array["FlightNo"]  = $FlightNo;
			    $temp_array["Fltdate"]  = $Fltdate;
			                
			    //dataperflight
			    $temp_array["d_fno"]  = $e_fno;
			    $temp_array["d_paypax"]  = $PayingPax;
			    $temp_array["d_nonpaypax"]  = $NonPayingPax;
			    $temp_array["d_totpax"]  = $TotalPax;

			    //csv iata
				$temp_array["c_fno"] =$c_fno     ;
				$temp_array["c_totpax"]=$c_totpax  ;
				$temp_array["c_paypax"]=$c_paypax  ;
				$temp_array["c_nonpaypax"]=$c_nonpaypax ;
				$temp_array["c_route"]=$c_route ;

			    //maxis
			    $temp_array["m_fno"]  =$mcs_fno;
			    $temp_array["m_totpax"]=$mcs_totpax;
				$temp_array["m_paypax"]=$mcs_paypax;
				$temp_array["m_nonpaypax"]=$mcs_nonpaypax; 

				

				//selisih csv - dashboard
				$temp_array["s_csv_dashboard_totpax"]=$selisih_totpax ;
				$temp_array["s_csv_dashboard_paypax"]=$selisih_paypax ;
				$temp_array["s_csv_dashboard_nonpaypax"]=$selisih_nonpaypax;

				//selisih dashboard
				$temp_array["s_dashboard_maxis_totpax"]=$selisih_totpax2 ;
				$temp_array["s_dashboard_maxis_paypax"]=$selisih_paypax2 ;
				$temp_array["s_dashboard_maxis_nonpaypax"]=$selisih_nonpaypax2;

				array_push($array_result, $temp_array ); 
			}
		}

		return $array_result;
	}


	public function ambil_spasi_flightno($FlightNo){
			$string = preg_replace('/\s+/', '', $FlightNo);
	     	$fnolength = strlen($string);
	     	
	     	if ($fnolength == 5 ){
				$fno0  = substr_replace($FlightNo," ",2,-3);
				$fno0  = explode(" ",$fno0);
				$fno1 = $fno0[0];
				$fno2 = (int)$fno0[1];
			}
			else if ($fnolength == 6){
								
				$fno0  = substr_replace($FlightNo," ",2,-4);
				$fno0  = explode(" ",$fno0);
				$fno1 = $fno0[0];
				$fno2 =(int)$fno0[1]; 
								         
			}
								       
			else if  ($fnolength == 7){     
				$fno0  = substr_replace($FlightNo," ",2,-5);
				$fno0  = explode(" ",$fno0);
				$fno1 = $fno0[0];
				$fno2 = (int)$fno0[1];
								         //$fno22 = int($fno2); 
			}  
			else{
				$fno0 = explode(" ",$FlightNo);
				$fno1 = $fno0[0];
				$fno2 = $fno0[1];
			}
			
			$fno_result = $fno1.$fno2;

			return $fno_result;
		}


	public function  addspace($FlightNo){
		$FlightNo = preg_replace('/\s+/', '', $FlightNo);
	    $fnolength = strlen($FlightNo);

	     	if ($fnolength == 5 ){
				//$fno0  = substr_replace($FlightNo,"0",3,6);

				$huruf = substr($FlightNo, 0,2);
				$angka = substr($FlightNo, 2,6);
				$angka = "0".$angka;

				$hasil = $huruf." ".$angka;
			}
			else if ($fnolength == 4){
				
				$huruf = substr($FlightNo, 0,2);
				$angka = substr($FlightNo, 2,6);
				$angka = "00".$angka;		

				$hasil = $huruf." ".$angka;			
				
								         
			}  
			else if($fnolength==6){
				
				$huruf = substr($FlightNo, 0,2);
				$angka = substr($FlightNo, 2,6);
				$hasil = $huruf." ".$angka;
			}

		
		
		return $hasil;	
	}		
}




?>