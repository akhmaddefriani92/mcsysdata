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
	// include "DB_Function.php";
	//$dbfunc = new DB_Function($kota);
	// include "csv_to_array.php";
	

	

	if(!file_exists("csv/".$filename)){
		echo "<script>
			alert('file csv tidak ada !');
			window.location=('compare_dash2.php');
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
			            include "Class_compare.php";
			            $compare = new Compare($kota);
			            $array_result=$compare->getdata($tanggal);
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

		             	</tbody>
		             </table> 
		             <?php
		             // echo "<pre>";
		             // 	print_r($array_result);
		             // echo "</pre>";
		             ?>



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
$('#tanggal').datepicker({
    	dateFormat:"yy-mm-dd"
    });	

	
	var table= $('#example').DataTable({
    	"bSort": false,
    	"sDom": '<"top">t<"bottom"ilp<"clear">>',
    	"paging":false,
    	// "scrollY":        "200px",
        //"scrollCollapse": true,
        //"paging":         false
    	 //"lengthMenu": [[12, 24 , 40,100 ], [12, 24, 40,100,"All"]]
    	 "lengthMenu": [[50, 100 , 125, 200 ], [50, 100 , 125, 200, "All"]]
    });

    $(".btn-default").attr('disabled', 'disabled');

});

</script>
<script type="text/javascript">
$(document).on('click', " tr td .insertBtn", function() {

	var datax = $(this).attr('id');
	// alert(datax);
	$(this).removeClass('btn-success').addClass('btn-default');
	$(this).html('<img src="ajax-loader.gif" class="img-circle"> ');
	var arr = datax.split('/');
		var FlightNo = arr[0];
		var Fltdate = arr[1];
		var kota = arr[2];

		// alert(FlightNo+' '+Fltdate);
		
		$.ajax({
		        type : 'POST',
		        url : 'insert_ajax_dash.php', //Here you will fetch records 
		        data :  'FlightNo='+FlightNo+'&Fltdate='+Fltdate+'&kota='+kota, //Pass $id
		        success : function(data){
		            //alert(data);
		            //location.reload();
		            $('.append_data').html(data);//Show fetched data from database       
		            
		        }
		});
		
});
</script>

<script type="text/javascript">
$(document).on('click', " tr td .insertBtn2", function() {

	var datax = $(this).attr('id');
	// alert(datax);
	$(this).removeClass('btn-warning').addClass('btn-default');
	$(this).html('<img src="ajax-loader.gif" class="img-circle"> ');

		var arr = datax.split('/');
		var FlightNo = arr[0];
		var PayingPax = arr[1];
		var NonPayPax = arr[2];
		var TotPayPax = arr[3];
		var Route = arr[4];
		var kota = arr[5];
		var Fltdate = arr[6];

		// alert(FlightNo+' '+Fltdate);
		
		$.ajax({
		        type : 'POST',
		        url : 'insert_ajax_iata.php', //Here you will fetch records 
		        data :  'FlightNo='+FlightNo+'&PayingPax='+PayingPax+'&NonPayPax='+NonPayPax+'&TotPayPax='+TotPayPax+'&Route='+Route+'&kota='+kota+'&Fltdate='+Fltdate, //Pass $id
		        success : function(data){
		            //alert(data);
		            //location.reload();
		            $('.append_data').html(data);//Show fetched data from database       
		            
		        }
		});
		
});
</script>

<script type="text/javascript">
$(document).on('click', " tr td .updateBtn2", function() {

	var datax = $(this).attr('id');
	// alert(datax);
	$(this).removeClass('btn-warning').addClass('btn-default');
	$(this).html('<img src="ajax-loader.gif" class="img-circle"> ');
	
		var arr = datax.split('/');
		var FlightNo = arr[0];
		var PayingPax = arr[1];
		var NonPayPax = arr[2];
		var TotPayPax = arr[3];
		var Route = arr[4];
		var kota = arr[5];
		var Fltdate = arr[6];

		// alert(FlightNo+' '+Fltdate);
		
		$.ajax({
		        type : 'POST',
		        url : 'update_ajax_iata.php', //Here you will fetch records 
		        data :  'FlightNo='+FlightNo+'&PayingPax='+PayingPax+'&NonPayPax='+NonPayPax+'&TotPayPax='+TotPayPax+'&Route='+Route+'&kota='+kota+'&Fltdate='+Fltdate, //Pass $id
		        success : function(data){
		            //alert(data);
		            //location.reload();
		            $('.append_data').html(data);//Show fetched data from database       
		            
		        }
		});
		
});
</script>


<script type="text/javascript">
$(document).on('click', " tr td .deleteBtn", function() {

	var datax = $(this).attr('id');
	// alert(datax);
	$(this).removeClass('btn-danger').addClass('btn-default');
	$(this).html('<img src="ajax-loader.gif" class="img-circle"> ');
	var arr = datax.split('/');
	var FlightNo = arr[0];
	var Fltdate = arr[1];
	var kota = arr[2];

	$.ajax({
		type : 'POST',
		url : 'update_ajax_dash.php', //Here you will fetch records 
		data :  'FlightNo='+FlightNo+'&Fltdate='+Fltdate+'&kota='+kota, //Pass $id
		success : function(data){
		     $('.append_data').html(data);//Show fetched data from database       

		}
	});

});
</script>
</body>
</html>

