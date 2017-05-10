<html>
<title>MCsysdata</title>
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
	
			
	include "DB_Function.php";
	

	$dbfunc = new DB_Function($kota);
	
?>	
	
		<br><br>
    <div class="row">
        <div class="col-md-12">
	        <div class="panel panel-success">
	            <div class="panel-heading">
	            <div class="row">	
	            <div class="col-md-4">
	            <h4>MCSYSDATA <?php echo $kota." ". $tanggal;?></h4>
	            
	            </div>
	            <div class="col-md-4">
	            <button class='btn btn-default btn-sm' id="myrefresh">Refresh</button>
	            </div>	
	            </div>
	            </div>
		             <div class="panel-body">    
		             <table class="table table-striped table-hover" id="example">
		             	<thead>
		             	<th>Date</th>
		             	<th>FlightNo</th>
		             	<th>Route</th>
		             	<th>Adult</th>
		             	<th>CHD</th>
		             	<th>INF</th>
		             	<th>Transit</th>
		             	<th>Crew</th>
		             	<th>xCrew</th>
		             	<th>Pob</th>
		             	<th>Transfer</th>
		             	<th>Action</th>
		             	</thead>
		             	<tbody>
		             	<?php
		             		
		             	
		             	
		             	$data = $dbfunc->querymcsysdata($tanggal);	
		             	foreach ($data as $key => $row) {
		             			# code...
		             	#Id	Fltdate	FlightNo	Route	Adult	Child	Infant	Transit	Crew	xCrew	POB	Transfer	

					        $Fltdate = date("Y-m-d", strtotime($row["Fltdate"]));
					        $FlightNo = trim($row["FlightNo"]);
					        $Route = $row["Route"];
					        $Adult = $row["Adult"];
					        $Child = $row["Child"];
					        $Infant = $row["Infant"];
					        $Transit = $row["Transit"];
					        $Crew = $row["Crew"];
					        $xCrew = $row["xCrew"];
					        $POB = $row["POB"];
					        $Transfer = $row["Transfer"];
		             	
					        echo "<tr>";
					        echo "<td>$Fltdate</td>";
					        echo "<td>$FlightNo</td>";
					        echo "<td>$Route</td>";
					        echo "<td>$Adult</td>";
					        echo "<td>$Child</td>";
					        echo "<td>$Infant</td>";
					        echo "<td>$Transit</td>";
					        echo "<td>$Crew</td>";
					        echo "<td>$xCrew</td>";
					        echo "<td>$POB</td>";
					        echo "<td>$Transfer</td>";
					        echo "<td><a class='btn btn-primary btn-xs'href='#myModal' id='custId' data-toggle='modal' data-id='$row[Id]'>edit</a></td>";
					        echo "</tr>";


		             	}
		             		
		             		
		             	?>

		             	</tbody>
		             </table> 




		             </div>
		        </div>
		    </div>
		</div>             




	


<?php
}
?>


</div><!-- first container-->

<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="datatables/js/dataTables.bootstrap.js"></script>
<script src="datatables/js/jquery.dataTables.min.js"></script>

<!--modal -->
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog" role="document">
		<form action="update_data.php" id='form_update' method="post" >
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
 $(document).ready(function() {

 	// var kota ="<?php echo $kota;?>";
 	//alert(kota);

   var table= $('#example').DataTable({
    	//"bSort": false,
    	// "scrollY":        "200px",
        //"scrollCollapse": true,
        //"paging":         false
    	 "lengthMenu": [[10, 20 , 40,100 ], [10, 20, 40,100,"All"]]
    });

//   table
//	 .search( '' )
//	 .columns().search( '' )
//	 .draw();
    	//"order": [[ 2, "asc" ]]
    $('#tanggal').datepicker({
    	dateFormat:"yy-mm-dd"
    });	

    //});
    	

    
    $('#myModal').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
        //alert(rowid);
        $.ajax({
            type : 'POST',
            url : 'edit_data.php', //Here you will fetch records 
            data :  'rowid='+ rowid+'&kota='+kota, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });  	
    
    /*
    $("#update").click(function() {
		//e.preventDefault();
		var data = $('#form_update').serialize()

		$.ajax({
            url : 'update_data.php',
            type: "POST",
            data: data,
            dataType: "JSON",
            success: function(data)
            {
               //if success close modal and reload ajax table
              // $('#modal_form').modal('hide');
               //location.reload(true);
               //reload_table();
               //window.history.back();
               window.history.go(0)
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error update data');
                window.history.go(0)
            }
        });
	});
    */
    $("#myrefresh").click(function(e) {
		e.preventDefault();
		console.log("refresh success");
		location.reload(true);
	});

	 $('#myModal').modal('hide');
	
	 /*
	 setTimeout(function(){
   		window.location.reload(1);
	}, 5000);
    */
        
});
  
</script>


</body>
</html>

