<html>
<title>MCsysdata</title>
<head>
<?php
	
	
	$yest= date("Y-m-d", strtotime("-30 days"));
	$kota='';
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
              <h3 class="navbar-text">Update Manifest MCSYSDATA</h3>
            </div>
        </div>
    </nav>
<div class="container">
 	<div class="form-group">

 	<form class="role-form" action="" method="POST" >  
        <div class="form-group">
	        <div class="col-xs-4">
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
				            <option value="PGK">PGK</option>

		                </select>
		    </div>
        </div>
        <div class="form-group">
        	 <div class="col-xs-4">
        	 <label>Tanggal</label>
        	 <input type="text" id="tanggal" name="tanggal" class="form-control" value="<?php echo $yest;?>">
        	 </div>
        </div>

        <div class="form-group">
        	 <div class="col-xs-4">
        	 <br>
        	 <button type="submit" name="submit" class="btn btn-success">Submit</button>
        	 </div>
        </div>
    </form>    
		<br><br>                                    
</div>

<?php
	if(isset($_POST["submit"])){

	
	$kota	= $_POST["kota"]	;
	$tanggal	= $_POST["tanggal"]	;
	
	$filename = $kota.$tanggal.".csv";			
	include "DB_Function.php";
	include "csv_to_array.php";
	

	$dbfunc = new DB_Function($kota);

	if(!file_exists("csv/".$filename)){
		echo "<script>
			alert('file csv tidak ada !');
			window.location=('compare_dash.php');
			</script>";

	}


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
	
?>	
	
<br><br>
    <div class="row">
        <div class="col-md-12">
	        <div class="panel panel-success">
	            <div class="panel-heading"	><h4>MCSYSDATA <?php echo $kota." ". $tanggal." CSV : ".$filename;?></h4></div>
		             <div class="panel-body">    
		             <table class="table table-striped table-hover" id="example">
		             	<thead>
		             	<th>Date</th>
		             	<th>FlightNo</th>
		             	<th>Source</th>
		             	
		             	<th>PayPax</th>
		             	<th>NonPayPax</th>
		             	<th>TotPax</th>
		             	<!--<th>CHD</th>
		             	<th>INF</th>
		             	<th>Transfer</th>
		             	<th>Transit</th>-->
		             	<th>action</th>
		             	</thead>
		             	<tbody class='append_data'>
		             	<?php
		             	#select convert(varchar(12),Fltdate,101) as Fltdate, FlightNo,sum(pob) as TotalPax,sum(Adult+Child) as PayingPax,Sum(Child) as ChildPaying,Sum(Infant) as Infant,0 as Transit,Sum(Transit) as Transfer,Sum(Infant+Transit+Transfer) as NonPayingPax From mcsysdata
		             	$mcsysdata = $dbfunc->mcsysdata($tanggal);	
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
							#$csv["PSC"][$key]=$body["PSC (IDR)"];


							#echo $csv["FlightNo"][$key]."<br>";
			            }
			            
			            $dataperflight = $dbfunc->DataPerFlight($tanggal);
		             	$dataper_rows = count($dataperflight)-1;
		             	foreach ($dataperflight as $key => $value) {
		             			# code...
		             	
					        $Fltdate = date("Y-m-d", strtotime($value["Fltdate"]));
					        $FlightNo = trim($value["FlightNo"]);
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
							         #echo $fno1." ".$fno2;  
							}  
							else{
							    $fno0 = explode(" ",$FlightNo);
							    $fno1 = $fno0[0];
							    $fno2 = $fno0[1];
							}

							$e_fno = $fno1.$fno2;
								

							#$mcsys["NonPayingPax"][$key] = $value["NonPayingPax"]+$value["Transit"];

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
					        #echo "<td>$ChildPaying</td>";
					        #echo "<td>$Infant</td>";
					        #echo "<td>$Tranfer</td>";
					        #echo "<td>$Transit</td>";
					        echo '<td>-</td>';
					        /*echo'<button class="btn btn-danger btn-xs deleteBtn" id="deleteBtn">update</button>';
					        
					     echo "<div class='links'>";
					     echo "<input type='hidden'name='FlightNo_text' class='FlightNo_text' value='$FlightNo'/>";
					     echo "<input type='hidden' name='Fltdate_text' class='Fltdate_text' value='$Fltdate'/>";
					     #echo "<input type='button' id='update_mcs' class='btn btn-danger btn-xs update_mcs' value='update'/>";
					     echo '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_person('."'".$FlightNo."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
					     echo"</div>";
							
					        echo "<span id='add'></span></td>";*/

					        #echo "<td><a class='btn btn-primary btn-xs'href='#myModal' id='custId' data-toggle='modal' data-id='$FlightNo/$Fltdate'>edit</a></td>";
					        echo "</tr>";

					        $c_fno     = '';
							$c_totpax  = 0;
							$c_paypax  = 0;
							$c_nonpaypax = 0;
					        
					        for ($i=0; $i<=$csvdata_rows; $i++){
								#echo $e_fno." gaga ".$csv["FlightNo"][$i]."<br>";
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
					        #echo "<td>-</td>";
					        #echo "<td>-</td>";
					        #echo "<td>-</td>";
					        #echo "<td>-</td>";
					        echo "<td>-</td>";
					        echo "</tr>";	

					        /*$d_fno     = $dataper["FlightNo"][$i];
							$d_totpax  = $dataper["TotalPax"][$i];
							$d_paypax  = $dataper["PayingPax"][$i];
							$d_nonpaypax = $dataper["NonPayingPax"][$i];
					        */
					        $mcs_fno     = '';
							$mcs_totpax  = 0;
							$mcs_paypax  = 0;
							$mcs_nonpaypax = 0;


					        for ($i=0; $i<=$mcsys_rows; $i++){
								// echo $e_fno." gaga ".$mcsys["FlightNo"][$i]."<br>";
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
					        #echo "<td>-</td>";
					        #echo "<td>-</td>";
					        #echo "<td>-</td>";
					        #echo "<td>-</td>";
					        
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
					        #echo "<td>-</td>";
					        #echo "<td>-</td>";
					        #echo "<td>-</td>";
					        #echo "<td>-</td>";
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
					        #echo "<td>-</td>";
					        #echo "<td>-</td>";
					        #echo "<td>-</td>";
					        #echo "<td>-</td>";
					        echo "<td>-</td>";
					        echo "</tr>";							    


		             	}
		             		
		             
		             	?>

		             	</tbody>
		             </table> 




		             </div>
		        </div>
		    </div>
		</div>
</div><!-- first container-->
<?php
}
?>
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="datatables/js/dataTables.bootstrap.js"></script>
<script src="datatables/js/jquery.dataTables.min.js"></script>

<!--modal -->
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog" role="document">
		<form action="update_data.php" method="post" >
			<div class="modal-content">
		        <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal">&times;</button>
		                <h4 class="modal-title">Edit Manifest Data</h4>
		            </div>
		            <div class="modal-body">
		                <div class="fetched-data">
		                    <!--Here Will show the Data-->
		                </div> 
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		                    <button type="submit" id="update" class="btn btn-primary" name='update'>Save</button>
		            </div>
		         </div>
				</form>
		    </div>
		</div>
<script type="text/javascript">
$(document).ready(function(){
	/*$('button.deleteBtn').click( function(){
 	 
 	  	var datax = $(this).closest('tr').attr('id');
		$(this).removeClass('btn-danger').addClass('btn-default');
		$(this).text('was updated');
 		//alert("Changed: " + this.id);
 	  	//$('button.deleteBtn').val('was update');
 	  	
  				//alert(id);
  		// alert(datax);
		var arr = datax.split('/');
		var FlightNo = arr[0];
		var Fltdate = arr[1];
		var kota = arr[2];

		

		//alert(FlightNo+' '+Fltdate);

		$.ajax({
		        type : 'POST',
		        url : 'update_ajax_data2.php', //Here you will fetch records 
		        data :  'FlightNo='+FlightNo+'&Fltdate='+Fltdate+'&kota='+kota, //Pass $id
		        success : function(data){
		            //$('#'+datax+' .add').html(data);//Show fetched data from database
		            //$('tr #add').html(data);//Show fetched data from database
		            //location.reload();
		            //alert(datax);
		        }
		});


	});*/

	$(function(){
		  var count = 3,
		      $btn = $('button.deleteBtn'); //Or which ever you want
		      //Change the label of $btn
		      $btn.val($btn.val()+' ('+count+')')
		      
		  $btn.click(function(){
		      $btn.val($btn.val().replace(count,count-1));
		      count--;
		      if(count==0) {
		            alert('test');
		            location.reload();
		            //return !$btn.attr('disabled','disabled');
		      }
		  })
	})

	$('button.insertBtn').click( function(){
 	 
 	  	var datax = $(this).closest('tr').attr('id');
		$(this).removeClass('btn-success').addClass('btn-default');
		$(this).val('was updated');
 		//alert("Changed: " + this.id);
 	  	//$('button.deleteBtn').val('was update');
 	  	
  				//alert(id);
  		
		var arr = datax.split('/');
		var FlightNo = arr[0];
		var Fltdate = arr[1];
		var kota = arr[2];

		// alert(FlightNo+' '+Fltdate);
		
		$.ajax({
		        type : 'POST',
		        url : 'insert_ajax_data.php', //Here you will fetch records 
		        data :  'FlightNo='+FlightNo+'&Fltdate='+Fltdate+'&kota='+kota, //Pass $id
		        success : function(data){
		            //alert(data);
		              location.reload();
		            // window.location.reload();
		            // window.location.reload(true);
		           // location.assign('compare_dash.php');
		            <?php
		            // header('Location: compare_dash.php');
		            ?>
		            // window.location = window.location.href+"&rnd="+Math.random();
		            // window.location = window.location.href;
		        }
		});
			

	});
	
});	

</script>

<script type="text/javascript">
$(document).ready(function(){
$('#tanggal').datepicker({
    	dateFormat:"yy-mm-dd"
    });	

	
	var table= $('#example').DataTable({
    	"bSort": false,
    	// "scrollY":        "200px",
        //"scrollCollapse": true,
        //"paging":         false
    	 //"lengthMenu": [[12, 24 , 40,100 ], [12, 24, 40,100,"All"]]
    	 "lengthMenu": [[50, 100 , 125, 200, -1 ], [50, 100 , 125, 200, "All"]],
    	 iDisplayLength: -1
    });

    $(".btn-default").attr('disabled', 'disabled');

});

</script>

<script type="text/javascript">
$(document).on('click', " tr td .deleteBtn", function() {

	var datax = $(this).attr('id');
	// alert(datax);
	
	var arr = datax.split('/');
	var FlightNo = arr[0];
	var Fltdate = arr[1];
	var kota = arr[2];

	$.ajax({
		type : 'POST',
		url : 'update_ajax_data2.php', //Here you will fetch records 
		data :  'FlightNo='+FlightNo+'&Fltdate='+Fltdate+'&kota='+kota, //Pass $id
		success : function(data){
		     $('.append_data').html(data);//Show fetched data from database       

		}
	});

});
</script>
</body>
</html>

