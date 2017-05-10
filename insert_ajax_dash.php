<?php

$FlightNo = $_POST["FlightNo"];	
$Fltdate = $_POST["Fltdate"];	
$kota = $_POST["kota"];	
include "DB_Function.php";

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


$transit = $daper_xPOB;
$transfer= $daper_Transit;
					
$route = $dbfunc->get_route_dataperflight($FlightNo, $Fltdate);

#Id	Fltdate	FlightNo	Route	Adult	Child	Infant	Transit	Crew	xCrew	POB	Transfer
$cek = $dbfunc->cekmcsysdata($FlightNo, $Fltdate);
if($cek<1){
	$insert = $dbfunc->insert_mcsysdata($Fltdate, $FlightNo, $route, $daper_Adult, $daper_Child, $daper_Infant, $transit, $daper_Crew, $daper_Pob, $transfer);
}

sleep(3);


include "Class_compare.php";
$compare = new Compare($kota);
$array_result=$compare->getdata($Fltdate);
foreach ($array_result as $key => $value) {
	# code...
	$fnoflt		= $value["fnoflt"];
	$FlightNo 	= $value["FlightNo"];
	$Fltdate 	= $value["Fltdate"];
			            	
	//dashboard
	$d_fno 	= $value["d_fno"];
	$d_paypax 	= $value["d_paypax"];
	$d_nonpaypax 	= $value["d_nonpaypax"];
	$d_totpax 	= $value["d_totpax"];

	//csv iata
	$c_fno 	= $value["c_fno"];
	$c_paypax 	= $value["c_paypax"];
	$c_nonpaypax 	= $value["c_nonpaypax"];
	$c_totpax 	= $value["c_totpax"];			            	

	//maxis
	$m_fno 	= $value["m_fno"];
	$m_paypax 	= $value["m_paypax"];
	$m_nonpaypax 	= $value["m_nonpaypax"];
	$m_totpax 	= $value["m_totpax"];			            	

	//selisih csv - dashboard
	$selisih_totpax = $value["s_csv_dashboard_totpax"];    
	$selisih_paypax = $value["s_csv_dashboard_paypax"];
	$selisih_nonpaypax = $value["s_csv_dashboard_nonpaypax"];

	//selisih maxis - dashboard
	$selisih_totpax2 = $value["s_dashboard_maxis_totpax"];
	$selisih_paypax2 = $value["s_dashboard_maxis_paypax"];
	$selisih_nonpaypax2 = $value["s_dashboard_maxis_nonpaypax"];
					            
	//row dashboard
	echo '<tr>';
		echo "<td>$Fltdate</td>";
		echo "<td>$d_fno</td>";
		echo "<td>DASHBOARD</td>";
		echo "<td>$d_paypax</td>";
		echo "<td>$d_nonpaypax</td>";
		echo "<td>$d_totpax</td>";
		echo '<td>-</td>';
	echo "</tr>";    

	//row csv iata
	echo '<tr>';
		echo "<td>-</td>";
		echo "<td>$c_fno</td>";
		echo "<td>CSV IATA</td>";
		echo "<td>$c_paypax</td>";
		echo "<td>$c_nonpaypax</td>";
		echo "<td>$c_totpax</td>";
		echo '<td>-</td>';
	echo "</tr>";    

	//row maxis
	if(empty($m_fno)){

		$action_mcs ='<button class="btn btn-success btn-xs insertBtn" id="'.$fnoflt.'">insert</button>';

	}else{
		$action_mcs ='<button class="btn btn-danger btn-xs deleteBtn" id="'.$fnoflt.'">update</button>';
	}
	echo '<tr id="' . $fnoflt . '">';
			echo "<td>-</td>";
			echo "<td>$m_fno</td>";
			echo "<td>MAXIS</td>";
			echo "<td>$m_paypax</td>";
			echo "<td>$m_nonpaypax</td>";
			echo "<td>$m_totpax</td>";
			echo "<td>$action_mcs</td>";
		echo "</tr>"; 


	if($selisih_totpax!=0 || $selisih_paypax!=0 || $selisih_nonpaypax !=0){
						
		echo "<tr style='background-color:#f2d3d3;'>";
	}else{
		echo "<tr style='background-color:#d8faff;'>";
	}
	echo "<td>-</td>";
	echo "<td>-</td>";
	echo "<td><b>Selisih CSV - DASHBOARD</B></td>";
	echo "<td>$selisih_paypax</td>";
	echo "<td>$selisih_nonpaypax</td>";
	echo "<td>$selisih_totpax</td>";
	echo "<td>-</td>";
	echo "</tr>";							    
						
	if($selisih_totpax2<>0 || $selisih_paypax2<>0 || $selisih_nonpaypax2 <>0){
						
		echo "<tr style='background-color:#ff867f;'>";
	}else{
		echo "<tr style='background-color:#d8facc;'>";
	}
		echo "<td>-</td>";
		echo "<td>-</td>";
		echo "<td><b>Selisih MAXIS-DASHBOARD</b></td>";
		echo "<td>$selisih_paypax2</td>";
		echo "<td>$selisih_nonpaypax2</td>";
		echo "<td>$selisih_totpax2</td>";
		echo "<td>-</td>";
	echo "</tr>";							    


}//FOREACH




?>