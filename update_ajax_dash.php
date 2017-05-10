<?php

$FlightNo = $_POST["FlightNo"];	
$Fltdate = $_POST["Fltdate"];	
$kota = $_POST["kota"];	
include_once "DB_Function.php";
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


include "Class_compare.php";
$compare = new Compare($kota);
$array_result=$compare->getdata($Fltdate);
foreach ($array_result as $key => $value) {
			            	# code...
			            	$fnoflt		= $value["fnoflt"];
			            	$FlightNo 	= $value["FlightNo"];
			            	$Fltdate 	= $value["Fltdate"];
			            	$dbkota     = $value["dbkota"];
			            	
			            	//dashboard
			            	$d_fno 	= $value["d_fno"];
			            	$d_paypax 	= $value["d_paypax"];
			            	$d_nonpaypax 	= $value["d_nonpaypax"];
			            	$d_totpax 	= $value["d_totpax"];

			            	//csv iata
							$c_fno 	= trim($value["c_fno"]);
			            	$c_paypax 	= trim($value["c_paypax"]);
			            	$c_nonpaypax 	= trim($value["c_nonpaypax"]);
			            	$c_totpax 	= trim($value["c_totpax"]);
			            	$c_route 	= $value["c_route"];
			            	$c_route  = str_replace("-", "", $c_route);
			            	$c_route  = str_replace("3", "", $c_route);
			            	$c_route  = substr($c_route, 0,6);


			            	$csvmcsys = $c_fno."/".$c_paypax."/".$c_nonpaypax."/".$c_totpax."/".$c_route."/".$dbkota."/".$Fltdate; 			            	

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

								$action_mcs = '<button class="btn btn-success btn-xs insertBtn" id="'.$fnoflt.'" >insert from dataper</button> <button class="btn btn-warning btn-xs insertBtn2" id="'.$csvmcsys.'" >insert from iata</button>';

							}else{
								$action_mcs = '<button class="btn btn-danger btn-xs deleteBtn" id="'.$fnoflt.'">update from dataper</button> <button class="btn btn-warning btn-xs updateBtn2" id="'.$csvmcsys.'" >update from iata</button>';
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