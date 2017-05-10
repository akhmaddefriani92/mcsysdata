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

// echo $sql = "insert into mcsysdata (Fltdate, FlightNo, Route, Adult, Child, Infant, Transit, Crew, Pob, Transfer ) values('$Fltdate', '$FlightNo', '$route', '$daper_Adult', '$daper_Child', '$daper_Infant', '$transit', '$daper_Crew', '$daper_Pob', '$transfer')";




?>