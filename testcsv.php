<?php
include "csv_to_array.php";

$filename = "KNO2017-02-01.csv";
$file_csv ="csv/".$filename;
$csvdata = csv_to_array($filename=$file_csv, $delimiter=',');

print_r($csvdata);

?>