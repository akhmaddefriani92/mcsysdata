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

#Id	Fltdate	FlightNo	Route	Adult	Child	Infant	Transit	Crew	xCrew	POB	Transfer

$transit = $daper_xPOB;
$transfer= $daper_Transit;

#echo $SQL = "update mcsysdata set Adult='$daper_Adult', Child='$daper_Child', Infant='$daper_Infant', Transit='$transit',  Crew='$daper_Crew', POB='$daper_Pob', Transfer='$transfer' where FlightNo='$FlightNo' and Fltdate='$Fltdate'";

$update = $dbfunc->update_ajax_mcs($daper_Adult, $daper_Child, $daper_Infant, $transit, $daper_Crew, $daper_Pob, $transfer, $FlightNo, $Fltdate);

?>