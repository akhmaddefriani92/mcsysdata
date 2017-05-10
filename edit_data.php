<?php
session_start();
error_reporting(E_ALL);

  
$id = $_POST['rowid']; //escape string
$kota = $_POST['kota']; //escape string
include "DB_Function.php";
$funcdb = new DB_Function($kota);  
$row = $funcdb->getmcsysdata($id);
$data = mssql_fetch_assoc($row);

$fltdate = date("Y-m-d", strtotime($data["Fltdate"]));

//print_r($data);

echo "
  <input type='hidden' name='id' value='$id'/>
  <input type='hidden' name='kota' value='$kota'/>
  <div class='row'>
        <div class='col-md-4'>
          <label>Tanggal</label>  
          <input type='text' class='form-control' name='Fltdate' value='$fltdate'/>
        </div>

        <div class='col-md-4'> 
           <label>FlightNo</label> 
           <input type='text' class='form-control' name='FlightNo' value='$data[FlightNo]' />
        </div>

        <div class='col-md-4'> 
          <label>Route</label> 
          <input type='text' class='form-control' name='Route' value='$data[Route]' />
         </div>
  </div> ";
       
        echo"
        <div class='row'><br>
                  
                  <div class='col-md-3'> 
                   <label>Adult</label> 
                    <input type='text' class='form-control' name='Adult' value='$data[Adult]'/>
                  </div>

                  <div class='col-md-3'> 
                   <label>Child</label> 
                    <input type='text' class='form-control' name='Child' value='$data[Child]'/>
                  </div>

                  <div class='col-md-3'> 
                   <label>Infant</label> 
                    <input type='text' class='form-control' name='Infant' value='$data[Infant]'/>
                  </div>

                  <div class='col-md-3'> 
                   <label>Transit</label> 
                    <input type='text' class='form-control' name='Transit' value='$data[Transit]'/>
                  </div>
        </div>

        <div class='row'><br>
        
                  <div class='col-md-3'> 
                   <label>Crew</label> 
                    <input type='text' class='form-control' name='crew' value='$data[crew]' />
                  </div>

                  <div class='col-md-3'> 
                   <label>xCrew</label> 
                    <input type='text' class='form-control' name='xCrew' value='$data[xCrew]' />
                  </div>

                  <div class='col-md-3'> 
                   <label>POB</label> 
                    <input type='text' class='form-control' name='POB' value='$data[POB]' />
                  </div>

                  <div class='col-md-3'> 
                   <label>Transfer</label> 
                    <input type='text' class='form-control' name='Transfer' value='$data[Transfer]' />
                  </div>
        </div>

        ";
 
          
     
?>