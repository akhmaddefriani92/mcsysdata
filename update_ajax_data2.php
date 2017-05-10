<?php

$FlightNo = $_POST["FlightNo"];	
$Fltdate = $_POST["Fltdate"];	
$kota = $_POST["kota"];	
include "DB_Function.php";
include "csv_to_array.php";
$dbfunc = new DB_Function($kota);
$row_daper = $dbfunc->getdataperflight2($FlightNo, $Fltdate);
#print_r($row_daper);


// $daper_Fltdate = date("Y-m-d", strtotime($row_daper["Fltdate"]));
// $daper_FlightNo= $row_daper["FlightNo"];
// $daper_Route= $row_daper["Route"];
$daper_Adult= $row_daper["Adult"]-$row_daper["Child"];
$daper_Child= $row_daper["Child"];
$daper_Infant= $row_daper["Infant"];
$daper_Transit= $row_daper["Transit"];
$daper_Pob= $row_daper["Pob"]+$row_daper["Infant"];
$daper_xPOB= $row_daper["xPOB"];
$daper_Crew= $row_daper["Crew"];

#Id	Fltdate	FlightNo	Route	Adult	Child	Infant	Transit	Crew	xCrew	POB	Transfer

$transit = $daper_xPOB;
$transfer= $daper_Transit;

// echo $SQL = "update mcsysdata set Adult='$daper_Adult', Child='$daper_Child', Infant='$daper_Infant', Transit='$transit',  Crew='$daper_Crew', POB='$daper_Pob', Transfer='$transfer' where FlightNo='$FlightNo' and Fltdate='$Fltdate'";

$update = $dbfunc->update_ajax_mcs($daper_Adult, $daper_Child, $daper_Infant, $transit, $daper_Crew, $daper_Pob, $transfer, $FlightNo, $Fltdate);
sleep(1);

function ambil_spasi_flightno($FlightNo){
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


$mcsysdata = $dbfunc->mcsysdata($Fltdate);	
$mcsys_rows = count($mcsysdata)-1;
		             	
foreach ($mcsysdata as $key => $value) {
# code...
	$FlightNo_mcsys= trim($value["FlightNo"]);
	$FlightNo_mcsys= ambil_spasi_flightno($FlightNo_mcsys);
	/*$dataper["FlightNo"][$key] = trim($value["FlightNo"]);*/
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
	$filename = $kota.$Fltdate.".csv";				             	
	$file_csv ="/var/www/mcsysdata/csv/".$filename;

	$csvdata = csv_to_array($filename=$file_csv, $delimiter=',');
	#print_r($csvdata[0]);	
	$csvdata_rows = count($csvdata)-1;
	#echo $csvdata_rows."<br>";
	function sortByIO($a, $b){
        $a = $a['Flight No.'];
        $b = $b['Flight No.'];

        if ($a == $b)
        {
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
	
	}

	$dataperflight = $dbfunc->DataPerFlight($Fltdate);
	$dataper_rows = count($dataperflight)-1;
	foreach ($dataperflight as $key => $value) {
		# code...
		$Fltdate = date("Y-m-d", strtotime($value["Fltdate"]));
		$FlightNo = trim($value["FlightNo"]);
		$string = preg_replace('/\s+/', '', $FlightNo);
     	$fnolength = strlen($string);
		$e_fno= ambil_spasi_flightno($FlightNo);					

		
		$TotalPax = $value["TotalPax"];
		$PayingPax = $value["PayingPax"];
		$NonPayingPax = $value["NonPayingPax"]+$value["Transit"];
		$ChildPaying = $value["ChildPaying"];
		$Infant = $value["Infant"];
		$Transfer = $value["Transfer"];
		$Transit = $value["Transit"];
		$fnoflt =$FlightNo."/".$Fltdate."/".$kota;
		
		echo '<tr>';
				echo "<td>$Fltdate</td>";
				echo "<td>$e_fno</td>";
				echo "<td>dashboard 201</td>";
				echo "<td>$PayingPax</td>";
				echo "<td>$NonPayingPax</td>";
				echo "<td>$TotalPax</td>";
				echo '<td>-</td>';
		echo "</tr>";

		$c_fno     = '';
		$c_totpax  = 0;
		$c_paypax  = 0;
		$c_nonpaypax = 0;
					        
		for ($i=0; $i<=$csvdata_rows; $i++){
			
			if( $e_fno == $csv["FlightNo"][$i]){
										
				$c_fno     = $csv["FlightNo"][$i];
				$c_totpax  = $csv["TotalPax"][$i];
				$c_paypax  = $csv["PayingPax"][$i];
				$c_nonpaypax = $csv["NonPayingPax"][$i];
									
				break;
										
			}
		}
							
		echo "<tr>";
				echo "<td>-</td>";
				echo "<td>$c_fno</td>";
				echo "<td>csv maxis (iata)</td>";
				echo "<td>$c_paypax</td>";
				echo "<td>$c_nonpaypax</td>";
				echo "<td>$c_totpax</td>";
				echo "<td>-</td>";
		echo "</tr>";	

					        
		$mcs_fno     = '';
		$mcs_totpax  = 0;
		$mcs_paypax  = 0;
		$mcs_nonpaypax = 0;

		for ($i=0; $i<=$mcsys_rows; $i++){
			
			if( $e_fno == $mcsys["FlightNo"][$i]){
										
				$mcs_fno     = $mcsys["FlightNo"][$i];
				$mcs_totpax  = $mcsys["TotalPax"][$i];
				$mcs_paypax  = $mcsys["PayingPax"][$i];
				$mcs_nonpaypax = $mcsys["NonPayingPax"][$i];
									
				break;
										
			}
		}

		if(empty($mcs_fno)){

			$action_mcs = "<button class='btn btn-success btn-xs insertBtn' id='insertBtn'>insert</button>";

		}else{
			$action_mcs = '<button class="btn btn-danger btn-xs deleteBtn" id="'.$fnoflt.'">update</button>';
		}
							

			echo '<tr  id="' . $fnoflt . '">';
					echo "<td>-</td>";
					echo "<td>$mcs_fno</td>";
					echo "<td>maxis 201</td>";
					echo "<td>$mcs_paypax</td>";
					echo "<td>$mcs_nonpaypax</td>";
					echo "<td>$mcs_totpax</td>";
					echo "<td>$action_mcs</td>";
			echo "</tr>";	

			$selisih_totpax = $c_totpax-$TotalPax;		
			$selisih_paypax = $c_paypax-$PayingPax;		
			$selisih_nonpaypax = $c_nonpaypax-$NonPayingPax;		
						
			if($selisih_totpax!="0" || $selisih_paypax!='0' || $selisih_nonpaypax !='0'){
						
				echo "<tr style='background-color:#f2d3d3;'>";
			}else{
				echo "<tr style='background-color:#d8faff;'>";
			}
			echo "<td>-</td>";
			echo "<td>-</td>";
			echo "<td>Selisih csv maxis-dashboard</td>";
			echo "<td>$selisih_paypax</td>";
			echo "<td>$selisih_nonpaypax</td>";
			echo "<td>$selisih_totpax</td>";
			echo "<td>-</td>";
			echo "</tr>";							    
						    
			$selisih_totpax2 = $mcs_totpax-$TotalPax;		
			$selisih_paypax2 = $mcs_paypax-$PayingPax;		
			$selisih_nonpaypax2 = $mcs_nonpaypax-$NonPayingPax;		
						    
			if($selisih_totpax2<>0 || $selisih_paypax2<>'0' || $selisih_nonpaypax2 <>'0'){
						
				echo "<tr style='background-color:#ff867f;'>";
			}else{
				echo "<tr style='background-color:#d8facc;'>";
			}
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>Selisih mcsys201-dashboard</td>";
				echo "<td>$selisih_paypax2</td>";
				echo "<td>$selisih_nonpaypax2</td>";
				echo "<td>$selisih_totpax2</td>";
				echo "<td>-</td>";
				echo "</tr>";							    


	}
?>