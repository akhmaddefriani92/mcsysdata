<?php
include "DB_Connect.php";
$connect = new DB_Connect();



session_start();

	
    /*
    if($_SESSION["tabel"]==$date1){
        $sTable ="Daily$date1";  
    }else{
        $sTable ="Daily$_SESSION[tabel]";  
    }    
    */
    
    $sIndexColumn = "Id";

	$aColumns = array(
					0 => 'Fltdate',
					1 => 'FlightNo',
					2 => 'Route',
					3 => 'Adult',
					4 => 'Child',
					5 => 'Infant',
					6 => 'Transit',
					7 => 'Crew',
					8 => 'xCrew',
					9 => 'POB',
					10 => 'Transfer'
					
				);


	
	  $tanggal = $_POST["tanggal"];
      $kota = $_POST["kota"];

      $dbhandle = $connect->connect($kota);

      if($kota=="CT3"){
        $kota="CGK";
      }

      $sTable ="mcsysdata";  

	/* Ordering */
    $sOrder = "";
    if ( isset( $_POST['iSortCol_0'] ) ) {
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_POST['iSortingCols'] ) ; $i++ ) {
            if ( $_POST[ 'bSortable_'.intval($_POST['iSortCol_'.$i]) ] == "true" ) {
                $sOrder .= $aColumns[ intval( $_POST['iSortCol_'.$i] ) ]."
                    ".addslashes( $_POST['sSortDir_'.$i] ) .", ";
            }
        }

        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" ) {
            $sOrder = "";
        }
    }


     /* Filtering */
    $sWhere = "where fltdate='" . $tanggal . "' and Route like '".$kota."%' and LEN(Route)=6";
    #if(!empty($requestData['sSearch'])){
    if ( isset($_POST['sSearch']) && $_POST['sSearch'] != "" ) {
        $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
            $sWhere .= $aColumns[$i]." LIKE '%".addslashes( $_POST['sSearch'])."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }


    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
        if ( isset($_POST['bSearchable_'.$i]) && $_POST['bSearchable_'.$i] == "true" && $_POST['sSearch_'.$i] != '' )  {
            if ( $sWhere == "" ) {
                $sWhere = "WHERE ";
            } else {
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumns[$i]." LIKE '%".addslashes($_POST['sSearch_'.$i])."%' ";
        }
    }


    /* Paging */
    $top = (isset($_POST['iDisplayStart']))?((int)$_POST['iDisplayStart']):0 ;
    $limit = (isset($_POST['iDisplayLength']))?((int)$_POST['iDisplayLength'] ):10;
    $sQuery = "SELECT TOP $limit ".implode(",",$aColumns)."
			    FROM $sTable
			    $sWhere ".(($sWhere=="")?" WHERE ":" AND ")." $sIndexColumn NOT IN
			     (
			        SELECT $sIndexColumn FROM
			        (
			            SELECT TOP $top ".implode(",",$aColumns)."
			            FROM $sTable
			                $sWhere
			                $sOrder
			            )
			            as [virtTable]
			        )
			        $sOrder";

     
    $rResult = mssql_query($sQuery, $dbhandle) or die("$sQuery: " . mssql_get_last_message());
  




    $sQueryCnt		= "SELECT * FROM $sTable $sWhere";
    $rResultCnt		= mssql_query($sQueryCnt, $dbhandle) ;
    $iFilteredTotal = mssql_num_rows( $rResultCnt );
  
    $sQuery = " SELECT * FROM $sTable where fltdate='" . $tanggal . "' and Route like '".$kota."%' and LEN(Route)=6 ";
    $rResultTotal = mssql_query($sQuery, $dbhandle) ;
    $iTotal = mssql_num_rows($rResultTotal);
       
    
    /*
    while ( $aRow = mssql_fetch_array( $rResult ) ) {
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
            if ( $aColumns[$i] != ' ' ) {
                $v = $aRow[ $aColumns[$i] ];
                $v = mb_check_encoding($v, 'UTF-8') ? $v : utf8_encode($v);
                $row[]=$v;
            }
        }
        If (!empty($row)) { $output['aaData'][] = $row; }
    }   
	*/
	$row = array();    	
	 while ( $aRow = mssql_fetch_array( $rResult ) ) {
            $nestedData = array();	
#Id  Fltdate FlightNo    Route   Adult   Child   Infant  Transit Crew    xCrew   POB Transfer			
            		$nestedData["Fltdate"] = date("Y-m-d", strtotime($aRow["Fltdate"]));
					$nestedData["FlightNo"] = $aRow["FlightNo"];
					$nestedData["Route"] = $aRow["Route"];
					$nestedData["Adult"] = $aRow["Adult"];
					$nestedData["Child"] = $aRow["Child"];
					$nestedData["Infant"] = $aRow["Infant"];
					$nestedData["Transit"] = $aRow["Transit"];
					$nestedData["Crew"] = $aRow["Crew"];
					$nestedData["xCrew"] = $aRow["xCrew"];
					$nestedData["POB"] = $aRow["POB"];
					$nestedData["Berat"] = $aRow["Berat"];
					$nestedData["Transfer"] = $aRow["Transfer"];
					$nestedData["aksi"]="<a class='btn btn-primary btn-xs'href='#myModal2' id='custId' data-toggle='modal' data-id='$aRow[id]'><i class='glyphicon glyphicon-pencil'></i></a>";
			$row[] = $nestedData;
		
    }   

    $output = array(
        "sEcho" => intval($_POST['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => $row
    );    
   
   #If (!empty($row)) { $output['aaData'][] = $row; }
	
    echo json_encode( $output );
?>