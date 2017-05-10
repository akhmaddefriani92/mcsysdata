<?php
include "DB_Function.php";

$kota=$_POST["kota"];
$tanggal=$_POST["tanggal"];

$dbfunc = new DB_Function($kota);


$data = $dbfunc->querymcsysdata($tanggal);	
print_r($data);
echo "<tr><td>sdsadsa</td></tr>";
?>