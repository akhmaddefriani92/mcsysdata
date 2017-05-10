
<html>
<title>Compare Count</title>
<head>
<?php
	
	
	$yest= date("Y-m-d", strtotime("-1 days"));
?>	    
	    
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/jquery-ui.min.css" rel="stylesheet">
  <link href="datatables/css/jquery.dataTables.min.css" rel="stylesheet">

    	
<style>
.table{
	font-size: small;
	text-align: left;
	

}

</style>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
              <h3 class="navbar-text">Compare Count Pax</h3>
            </div>
        </div>
    </nav>
<div class="container">
 	
 	<div class="row">
        <div class="col-xs-offset-3 col-xs-6 col-xs-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                          <form role="form" action="" method="POST" >  
                            <div class="row">
	                            <div class="col-xs-6">
		                            <div class="form-group form-group-sm">  
		                              		<label for="tanggal" >Kota</label>
		                                    <select name="kota" class="form-control">
		                                    	<option>--Silahkan Pilih--</option>
		                                    	<option value="KNO">KNO</option>
				                                <option value="PDG">PDG</option>
				                                <option value="PLM">PLM</option>
				                                <option value="PKU">PKU</option>
				                                <option value="DJB">DJB</option>
				                                <option value="PNK">PNK</option>
				                                <option value="HLP">HLP</option>
				                                <option value="BDO">BDO</option>
				                                <option value="CT3">CT3</option>

		                                    </select>
		                            </div>
                            	</div>
		                        <div class="col-xs-6">
		                            <div class="form-group form-group-sm">
		                              <label for="flightno"> Tanggal</label>
		                                <input type="text" id="tanggal" name="tanggal" class="form-control" value="<?php echo $yest;?>"/>
		                            </div>
		                        </div>
		                    </div>
		                    
                            
                    	<button type="submit" class="btn btn-primary" name="cari">  Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php
	
if (isset($_POST["cari"])){
			$kota	= $_POST["kota"]	;
			$tanggal= $_POST["tanggal"]	;
			
			include "DB_Function.php";
			include "Class_Function.php";
			include "csv_to_array.php";

			$dbfunc = new DB_Function($kota);
			$compare = new Class_Function();

		?> 
	

	<center><h3 class="page-header">Kota <b><?php echo $kota;?></b> Tanggal : <b><?php echo $tanggal;?></b></h3></center>
		<?php
			
			/*PROSES AMBIL DATA CSV*/
			require_once "ClassCSV/parsecsv.lib.php";
            
            if ($kota=="KNO"){
                $kota1 ="MES"; 
            }else{
                $kota1=$kota;
            }
            
            $datecsv  = date("dMY", strtotime($tanggal));
                
            $filename = $kota1."-".$datecsv.".csv";
                
            $cekcsv = $dbfunc->CekCsv($tanggal, $kota);
            if ($cekcsv>=1){
	            $csvdata = $dbfunc->ListCsvData($tanggal, $kota);
				$csv_rows= count($csvdata)-1;    
			    
			    foreach ($csvdata as $key => $value) {
			        # code...
			        $cv["flightno"][$key] = trim($value["flightno"]);
			        $cv["totalpax"][$key] = trim($value["totalpax"]);
			        $cv["payingpax"][$key] = trim($value["payingpax"]);
			        $cv["child"][$key] = $value["child"];
			        $cv["infant"] [$key]= $value["infant"];
			        $cv["transfer"][$key]= $value["transfer"];
			        $cv["transit"][$key]= $value["transit"];
			        $cv["dateflight"][$key]=$value["dateflight"];
			    }
			}    

          $file_csv ="/var/www/compare_count/csv/".$filename;
            $csv = new parseCSV($file_csv);
            #print_r($csv->data);
            
             $data = csv_to_array($filename=$file_csv, $delimiter=';');
             #print_r($data[0]);


            foreach ($data as $key => $body): ?>
                        
            <?php #foreach ($row as $value): ?>
                <?php
                    #$body = explode(";", $value);
                        	$t_dateflight = date("Y-m-d", strtotime($body["DateFlight"]));
                            $t_flightno = trim($body["FlightNo"]);
                            $t_totalpax = trim($body["TotalPax"]);
                            $t_adult = $body["AdultPaying"];
                            $t_child = $body["ChildPaying"];
                            $t_infant = $body["Infant"];
                            $t_transit = $body["Transit"];
                            $t_transfer = $body["Transfer"];
                            $t_divert = $body["Divert"];
                            $t_missed = $body["Missed"];
                            $t_crew = $body["Crew"];
                            $t_extracrew = $body["ExtraCrew"];
                            $t_payingpax = trim($body["PayingPax"]);
                            $t_nonpayingpax = $body["NonPayingPax"];
                            $t_fromto = $body["FromTo"];

                            $cek = $dbfunc->CekCsvData($t_dateflight, $t_flightno, $kota );
                            if($cek<1){
                                	$insert_csvdata = $dbfunc->InsertCsvData($t_dateflight, $t_flightno, $kota, $t_totalpax, $t_adult, $t_child, $t_infant, $t_transit, $t_transfer, $t_divert, $t_missed, $t_crew, $t_extracrew, $t_payingpax, $t_nonpayingpax, $t_fromto);
                                if(!$insert_csvdata){
                                			echo "gagal insert";
                                }
                            }
                            /*
                            elseif($cek>=1){
                            	
                            		for ($i=0; $i<=$csv_rows; $i++){
										if($t_flightno == $cv["flightno"][$i] && $t_totalpax != $cv["totalpax"][$i] || $t_flightno == $cv["flightno"][$i] && $t_payingpax != $cv["payingpax"][$i]){
										  		#echo $t_flightno."\r\n";
										  		
										  	$update = $dbfunc->UpdateCsvData($t_dateflight, $t_flightno, $kota, $t_totalpax, $t_adult, $t_child, $t_infant, $t_transit, $t_transfer, $t_divert, $t_missed, $t_crew, $t_extracrew, $t_payingpax, $t_nonpayingpax);
										
											break;	
										}
										
									}	
                            	
                            }
                            */

                ?>
                <?php# endforeach; ?>
            <?php endforeach;
            sleep(5);
            ?>

        <div class="row">
        	<div class="col-md-12">
	        	<div class="panel panel-success">
	                <div class="panel-heading"	><h4>Compare Dataperflight, DATACSV & MCSYSDATA</h4></div>
		             <div class="panel-body">    
		             <table class="table table-striped table-hover" id="example">
		             	<thead>
		             	<th>Date</th>
		             	<th>FlightNo</th>
		             	<th>Source</th>
		             	<th>TotPax</th>
		             	<th>PayPax</th>
		             	<th>CHD</th>
		             	<th>INF</th>
		             	<th>Transfer+Transit</th>
		             	</thead>
		             	<tbody>
		             	<?php
		             		

		             		$dataperflight = $dbfunc->DataPerFlight($tanggal);
		             		
		             		if($kota == "CT3"){
								$kota2 = "CGK";
							}else{
								$kota2 =$kota;
							}
							$mcsysdata = $dbfunc->mcsysdata($tanggal, $kota2);

		             		$csvdata = $dbfunc->ListCsvData($tanggal, $kota);

		             		$csv_rows= count($csvdata)-1;
		             		foreach ($csvdata as $key => $value) {
		             			# code...
		             				$cv["flightno"][$key] = trim($value["flightno"]);
		             				$cv["totalpax"][$key] = $value["totalpax"];
		             				$cv["payingpax"][$key] = $value["payingpax"];
		             				$cv["child"][$key] = $value["child"];
		             				$cv["infant"] [$key]= $value["infant"];
		             				$cv["transfer"][$key]= $value["transfer"];
		             				$cv["transit"][$key]= $value["transit"];
		             				$cv["dateflight"][$key]=$value["dateflight"];
		             		}
		             		
							
		             		$i=0;

		             		$mcs_rows = count($mcsysdata)-1;
		             		foreach ($mcsysdata as $key => $value) {
		             			# code...
		             				$mcs["FlightNo"][$key] = trim($value["FlightNo"]);
		             				$mcs["TotalPax"][$key] = $value["TotalPax"];
		             				$mcs["PayingPax"][$key] = $value["PayingPax"];
		             				$mcs["ChildPaying"][$key] = $value["ChildPaying"];
		             				$mcs["Infant"] [$key]= $value["Infant"];
		             				$mcs["Transfer"][$key]= $value["Transfer"];
		             				$mcs["Transit"][$key]= $value["Transit"];
		             				
		             		}

		             		
		             		foreach ($dataperflight as $key => $row) {
		             			# code...
		             		 	
		             			$DateFlight = $row["DateFlight"];
		             			$FlightNo = trim($row["FlightNo"]);
		             			$TotalPax = $row["TotalPax"];
		             			$PayingPax = $row["PayingPax"];
		             			$ChildPaying = $row["ChildPaying"];
		             			$Infant = $row["Infant"];
		             			$Transfer = $row["Transfer"];
		             			$Transit = $row["Transfer"];
		             			#$TnT    = $Transfer+$Transit;
		             			$TnT = $row["Transfer"] + $row["Transit"];

		             			#echo "fno1 -> ".$FlightNo."  fno2-> ".$cv["flightno"][$i]."<br>";
		             			echo "<tr style='background-color:#f9f9f9;'>";
		             			echo "<td>$DateFlight</td>";
		             			echo "<td>$FlightNo</td>";
		             			echo "<td>DataPerFlight</td>";
		             			echo "<td>$TotalPax</td>";
								echo "<td>$PayingPax</td>";
								echo "<td>$ChildPaying</td>";
								echo "<td>$Infant</td>";
								echo "<td>$TnT</td>";
								echo "</tr>";	
								
										$c_fno ="";
										$c_totpax  = 0;
										$c_paypax  = 0;
										$c_infant  = 0;
										$c_child   = 0;
										$c_transfer= 0;
										$c_transit= 0;
										$c_tnt    = 0;


							
								for ($i=0; $i<=$csv_rows; $i++){
									if( $FlightNo == $cv["flightno"][$i]){
										$c_fno     = $cv["flightno"][$i];
										$c_totpax  = $cv["totalpax"][$i];
										$c_paypax  = $cv["payingpax"][$i];
										$c_infant  = $cv["infant"][$i];
										$c_child   = $cv["child"][$i];
										$c_transfer= $cv["transfer"][$i];
										$c_transit= $cv["transit"][$i];
										$c_tnt    = $c_transfer + $c_transit;
										
									
										break;
										
									}
								}	
							
								echo "<tr style='background-color:#f5f5dc;'>";
								            echo "<td style='background-color:#f9f9f9;'>  </td>";
								            echo "<td style='background-color:#f9f9f9;'>".$c_fno."</td>";
								            echo "<td>CSVDATA</td>";
								            echo "<td>".$c_totpax."</td>";
								            echo "<td>".$c_paypax."</td>";
								            echo "<td>".$c_child."</td>";
								            echo "<td>".$c_infant."</td>";
								            echo "<td>".$c_tnt."</td>";
						        	echo "</tr>";		
								
						        		#break;
										$mcs_fno ="";
										$mcs_totpax  = '';
										$mcs_paypax  = '';
										$mcs_infant  = '';
										$mcs_child   = '';
										$mcs_transfer= '';
										$mcs_transit= '';
										$mcs_tnt    = '';

								for ($i=0; $i<=$mcs_rows; $i++){
									if( $FlightNo == $mcs["FlightNo"][$i]){
										
										$mcs_fno     = $mcs["FlightNo"][$i];
										$mcs_totpax  = $mcs["TotalPax"][$i];
										$mcs_paypax  = $mcs["PayingPax"][$i];
										$mcs_infant  = $mcs["Infant"][$i];
										$mcs_child   = $mcs["ChildPaying"][$i];
										$mcs_transfer= $mcs["Transfer"][$i];
										$mcs_transit= $mcs["Transit"][$i];
										$mcs_tnt    = $mcs_transfer + $mcs_transit;
									
										break;
										
									}
								}

								echo "<tr style='background-color:#e0f9d1;'>";
								            echo "<td style='background-color:#f9f9f9;'>  </td>";
								            echo "<td style='background-color:#f9f9f9;'>".$mcs_fno."</td>";
								            echo "<td>MCSYSDATA</td>";
								            echo "<td>".$mcs_totpax."</td>";
								            echo "<td>".$mcs_paypax."</td>";
								            echo "<td>".$mcs_child."</td>";
								            echo "<td>".$mcs_infant."</td>";
								            echo "<td>".$mcs_tnt."</td>";
						        	echo "</tr>";						

						        $selisih_ctotpax = $TotalPax-$c_totpax;		
						        $selisih_cpaypax = $PayingPax-$c_paypax;		
						        $selisih_cchd = $ChildPaying-$c_child;
						        $selisih_cinf=$Infant-$c_infant;
						        $selisih_ctnt=$TnT-$c_tnt;

						        
						        
						        #SELISIH DATA PERFLIGHT - CSV
						        if ($selisih_ctotpax != 0 || $selisih_cpaypax != 0){ 	
						        echo "<tr style='background-color:#f2d3d3;'>";
								}else{
									echo "<tr style='background-color:#d8faff;'>";
								}
								            echo "<td style='background-color:#f9f9f9;'> </td>";
								            echo "<td style='background-color:#f9f9f9;'> </td>";
								            echo "<td><b>Selisih DataPerFlight-CSV</b></td>";
								            echo "<td><b>".$selisih_ctotpax."</b></td>";
								            echo "<td><b>".$selisih_cpaypax."</b></td>";
								            echo "<td><b>".$selisih_cchd."</b></td>";
								            echo "<td><b>".$selisih_cinf."</b></td>";
								            echo "<td><b>".$selisih_ctnt."</b></td>";
						        		echo "</tr>";	

						        $selisih_mcstotpax = $TotalPax-$mcs_totpax;		
						        $selisih_mcspaypax = $PayingPax-$mcs_paypax;		
						        $selisih_mcschd = $ChildPaying-$mcs_child;
						        $selisih_mcsinf=$Infant-$mcs_infant;
						        $selisih_mcstnt=$TnT-$mcs_tnt;		

						        if ($selisih_mcstotpax != 0 || $selisih_mcspaypax != 0){ 	
						        echo "<tr style='background-color:#f7b9a8;'>";
								}else{
									echo "<tr style='background-color:#c1f2d9;'>";
								}
								            echo "<td style='background-color:#f9f9f9;'> </td>";
								            echo "<td style='background-color:#f9f9f9;'> </td>";
								            echo "<td><b>Selisih DataPerFlight-MCSYS</b></td>";
								            echo "<td><b>".$selisih_mcstotpax."</b></td>";
								            echo "<td><b>".$selisih_mcspaypax."</b></td>";
								            echo "<td><b>".$selisih_mcschd."</b></td>";
								            echo "<td><b>".$selisih_mcsinf."</b></td>";
								            echo "<td><b>".$selisih_mcstnt."</b></td>";
						        		echo "</tr>";	




								#$i++;	
								
		             		}
		             		
		             		
		             	?>

		             	</tbody>
		             </table> 




		             </div>
		        </div>
		    </div>
		</div>             




<?php
}//cari
?>	

	





</div><!-- first container-->

<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="datatables/js/dataTables.bootstrap.js"></script>
<script src="datatables/js/jquery.dataTables.min.js"></script>



<script type="text/javascript">
 $(document).ready(function() {

   var table= $('#example').DataTable({
    	"bSort": false,
    	 "lengthMenu": [[15, 45 , 100 ], [15, 45, 100,"All"]]
    });
   table
	 .search( '' )
	 .columns().search( '' )
	 .draw();
    	//"order": [[ 2, "asc" ]]
    $('#tanggal').datepicker({
    	dateFormat:"yy-mm-dd"
    });	

    //});
    	

    /*
    $('#myModal').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
        $.ajax({
            type : 'POST',
            url : 'detail.php', //Here you will fetch records 
            data :  'rowid='+ rowid, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });  	
    */ 
        
});
</script>

</body>
</html>

