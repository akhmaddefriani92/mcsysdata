<?php
session_start();
error_reporting(E_ALL);

  
$id = $_POST['id']; //escape string
$kota = $_POST['kota']; 
#Id Fltdate FlightNo  Route Adult Child Infant  Transit Crew  xCrew POB Transfer
$Fltdate = $_POST['Fltdate']; 
$FlightNo = $_POST['FlightNo']; 
$Route = $_POST['Route']; 
$Adult = $_POST['Adult']; 
$Child = $_POST['Child']; 
$Infant = $_POST['Infant']; 
$Transit = $_POST['Transit']; 
$Crew = $_POST['Crew']; 
$xCrew = $_POST['xCrew']; 
$POB = $_POST['POB']; 
$Transfer = $_POST['Transfer']; 

include "DB_Function.php";
$funcdb = new DB_Function($kota);  


$update = $funcdb->updatemcsysdata($Adult, $Child, $Infant, $Transit, $Crew, $xCrew, $POB, $Transfer, $id);



     
?>