<?php
class DB_Function {
	
	private $db;
	private $getcount;
	
	var $db204;
	var $db201;
	var $db205;
	var $db48;
	var $dbairport;
	function __construct($params){
		#echo "db function".$params."<br>";
		require_once 'DB_Connect.php';
		$this->db 	= new DB_Connect();
		$this->dbairport= $params;
		$this->db201=$this->db->connect($params);
		$this->db205=$this->db->connect($params."205");
		$this->db204=$this->db->connect("204");
		$this->db48=$this->db->connect("48");
		
		
	}
	
	function __destruct(){
		
	}
	
	public function qry($sql,$return_format,$server)
    {
    	$arrayResult = array();
        $query = mssql_query($sql, $server) OR die(mssql_get_last_message());
        switch ($return_format)
        {
            case 1:
                $result = mssql_num_rows($query);
                return $result;
                break;
            case 2:
				while($row = mssql_fetch_assoc($query)){
					$arrayResult[] = $row;
				}				
                return $arrayResult;
                break;
            default:
                return $query;
        }
    }
	
    public function querymcsysdata($tgl){
		if($this->dbairport=="CT3"){
			$this->dbairport="CGK";
		}
		$SQL  = "SELECT * FROM mcsysdata WHERE fltdate='" . $tgl . "' and Route like '".$this->dbairport."%' and LEN(Route)=6 order by flightno";

		
		$arrayResult = array();
		$arrayResult = $this->qry($SQL,2,$this->db201);
		$this->getcount = $this->qry($SQL,1,$this->db201);
		return $arrayResult;
	
	}

	public function getmcsysdata($id){
		
		$SQL  = "SELECT * FROM mcsysdata WHERE Id=$id";
		$arrayResult = array();
		$arrayResult = $this->qry($SQL,0,$this->db201);
		
		return $arrayResult;
	
	}

	public function getmcsysdata2($date, $flightno){
		
		$SQL  = "SELECT * FROM mcsysdata WHERE flightno='$flightno' and fltdate='$date'";
		$arrayResult = array();
		$arrayResult = $this->qry($SQL,0,$this->db201);
		
		return $arrayResult;
	
	}

	public function updatemcsysdata($Adult, $Child, $Infant, $Transit, $Crew, $xCrew, $POB, $Transfer, $id){
		
		 $SQL  = "update mcsysdata set Adult='$Adult', Child='$Child', Infant='$Infant', Transit='$Transit', Crew='$Crew', xCrew='$xCrew', POB='$POB', Transfer='$Transfer' where id=$id";
		$arrayResult = array();
		$arrayResult = $this->qry($SQL,0,$this->db201);
		
		return $arrayResult;
	
	}

	public function getdataperflight($Flightno, $Fltdate){
		
		$SQL  = "SELECT * FROM dataperflight WHERE Flightno='$Flightno' and Fltdate='$Fltdate'";
		$query = mssql_query($SQL, $this->db201) or die(mssql_get_last_message());
		$row = mssql_fetch_assoc($query);

		return $row;

	}

	public function getdataperflight2($Flightno, $Fltdate){
		
	echo	$SQL  = "SELECT SUM(adult) as Adult, sum(child) as Child, sum(Pob) as Pob,sum(infant) as Infant, sum(Transit) as Transit, sum(XPOB) as xPOB, sum(Crew) as Crew  FROM dataperflight WHERE Flightno='$Flightno' and Fltdate='$Fltdate'";
		$query = mssql_query($SQL, $this->db201) or die(mssql_get_last_message());
		$row = mssql_fetch_assoc($query);

		return $row;

	}

	public function ambildataperflight($Fltdate){
		
		$SQL  = "SELECT FlightNo,SUM(adult) as Adult, sum(child) as Child, sum(Pob) as Pob,sum(infant) as Infant, sum(Transit) as Transit, sum(XPOB) as xPOB, sum(Crew) as Crew  FROM dataperflight WHERE Fltdate='$Fltdate' and (FlightNo like 'GA%' or  FlightNo like 'MI%' or FlightNo like 'MH%')group by FlightNo";
		$query = mssql_query($SQL, $this->db201) or die(mssql_get_last_message());
		while ($row = mssql_fetch_assoc($query)){
				$data[]=$row;
		}

		return $data;

	}

	public function get_route_dataperflight($Flightno, $Fltdate){
		
		$SQL  = "SELECT route FROM dataperflight WHERE Flightno='$Flightno' and Fltdate='$Fltdate' order by id";
		$query = mssql_query($SQL, $this->db201) or die(mssql_get_last_message());
		$row = mssql_fetch_assoc($query);
		$route = $row["route"];

		return $route;

	}

	public function update_ajax_mcs($daper_Adult, $daper_Child, $daper_Infant, $transit, $daper_Crew, $daper_Pob, $transfer, $FlightNo, $Fltdate){
	echo $SQL = "update mcsysdata set Adult='$daper_Adult', Child='$daper_Child', Infant='$daper_Infant', Transit='$transit',  Crew='$daper_Crew', POB='$daper_Pob', Transfer='$transfer' where FlightNo='$FlightNo' and Fltdate='$Fltdate'";
	$arrayResult = $this->qry($SQL,0,$this->db201);
		
		return $arrayResult;
	
	}



	public function mcsysdata($tgl){
		if($this->dbairport=="CT3"){
			$this->dbairport="CGK";
		}
		$SQL = "select convert(varchar(12),Fltdate,101) as Fltdate, FlightNo,sum(pob) as TotalPax,sum(Adult+Child) as PayingPax,Sum(Child) as ChildPaying,Sum(Infant) as Infant,0 as Transit,Sum(Transit) as Transfer,Sum(Infant+Transit+Transfer) as NonPayingPax From mcsysdata where fltdate='$tgl' and route like '".$this->dbairport."%'  and (FlightNo like 'GA%' or  FlightNo like 'MI%' or FlightNo like 'MH%') group by Flightno,Fltdate order by flightno";
		$arrayResult = $this->qry($SQL,2,$this->db201);
		$this->getcount = $this->qry($SQL,1,$this->db201);
		return $arrayResult;


	}
	

	public function cekmcsysdata($FlightNo, $FlightDate){
		$sql = "select Flightno from mcsysdata where FlightNo='$FlightNo' and FltDate='$FlightDate'";
		$query = mssql_query($sql, $this->db201) or die (mssql_get_last_message());
		$numrow = mssql_num_rows($query);

		return $numrow;

	}


	public function cekcsvmcsys($FlightNo, $FlightDate){
		$sql = "select * from csv_mcsys where FlightNo='$FlightNo' and FlightDate='$FlightDate'";
		$query = mysql_query($sql, $this->db48) or die (mysql_error());
		$numrow = mysql_num_rows($query);

		return $numrow;

	}

	public function insert_mcsysdata($Fltdate, $FlightNo, $route, $daper_Adult, $daper_Child, $daper_Infant, $transit, $daper_Crew, $daper_Pob, $transfer){
		$sql = "insert into mcsysdata (Fltdate, FlightNo, Route, Adult, Child, Infant, Transit, Crew, Pob, Transfer ) values('$Fltdate', '$FlightNo', '$route', '$daper_Adult', '$daper_Child', '$daper_Infant', '$transit', '$daper_Crew', '$daper_Pob', '$transfer')";
		$arrayResult = $this->qry($sql,0,$this->db201);

		// echo $sql."<br>";
		
		return $arrayResult;


	}

	public function insert_mcsysdata_iata($Fltdate, $FlightNo, $Route, $Adult, $Transitx, $Pob, $Infant, $Child){
		echo $sql = "insert into mcsysdata (Fltdate, FlightNo, Route, Adult,  Transit, Pob, Child, Infant, Transfer) values('$Fltdate', '$FlightNo', '$Route', '$Adult', '$Transitx', '$Pob', '$Child', '$Infant', '0')";
		$arrayResult = $this->qry($sql,0,$this->db201);

		
		return $arrayResult;


	}
	#No.	Flight Date	Flight No.	Airport	Route	Paying Pax	Non-Paying Pax	Total Pax	PSC (IDR)

	public function insert_csv_mcsys($FlightNo, $FlightDate, $Route, $PayingPax, $NonPayingPax, $TotalPax, $PSC ){
		$sql = "insert into csv_mcsys(FlightNo, FlightDate, Route, PayingPax, NonPayingPax, TotalPax, PSC) values ('$FlightNo', '$FlightDate', '$Route', '$PayingPax', '$NonPayingPax', '$PSC')"; 
		$query = mysql_query($sql, $this->db48) or die (mysql_error());
		return $query;

	}

	public function update_mcsysdata_iata($Adultx, $Transitx, $Pob, $Infant, $Child, $FlightNo ,$Fltdate){
		echo $sql = "update mcsysdata set Adult='$Adultx', Transit='$Transitx', Pob='$Pob', Infant='$Infant', Child='$Child', Transfer='0' where FlightNo='$FlightNo' and Fltdate='$Fltdate'";

		$arrayResult = $this->qry($sql,0,$this->db201);

		
		return $arrayResult;

	}


	public function querydataperflight($tgl, $kota){
		
		#$SQL  = "SELECT Child, Infant, FlightNo, Adult, Pob, Route, xPOB, isnull(transit,0)+isnull(xpob,0) as transfer FROM dataperflight WHERE fltdate='" . $tgl . "' order by flightno";
		$SQL  = "SELECT Child, Infant, FlightNo, Adult, Pob, xPOB, Route, xPOB as transit, Transit as transfer  FROM dataperflight WHERE fltdate='" . $tgl . "' and Route like '$kota%' and LEN(Route)=6 order by flightno";
		$arrayResult = array();
		$arrayResult = $this->qry($SQL,2,$this->db201);
		$this->getcount = $this->qry($SQL,1,$this->db201);
		return $arrayResult;
	
	}

	public function DataPerFlight($date){
		#$SQL  = "select *from dataperflight where  fltdate='$date'"; 
		 $SQL = "select convert(varchar(12),Fltdate,101) as Fltdate,FlightNo,sum(pob+infant) as TotalPax,sum(Adult) as PayingPax,Sum(Child) as ChildPaying,Sum(Infant) as Infant, sum(xpob) as Transit,Sum(Transit) as Transfer,0 as Divert,0 as Missed,0 as Crew,0 as ExtraCrew,Sum(Infant+Transit) as NonPayingPax From Dataperflight where fltdate='$date' and  (FlightNo like 'GA%' or  FlightNo like 'MI%' or FlightNo like 'MH%')  group by Flightno,Fltdate order by flightno";
		$arrayResult = array();
		$arrayResult = $this->qry($SQL,2,$this->db201);
		$this->getcount = $this->qry($SQL,1,$this->db201);
		return $arrayResult;
	}



	public function DataperFlight205($tgl){
		
		$SQL  = "SELECT Child, Infant, FlightNo, Adult, Pob, Route,  xPOB as Transit, Transit as Transfer FROM dataperflight WHERE fltdate='" . $tgl . "' order by flightno";
		#$SQL  = "SELECT Child, Infant, FlightNo, Adult, Pob, xPOB, Route, xPOB as transit, Transit as transfer  FROM dataperflight WHERE fltdate='" . $tgl . "' and Route like '$kota%' and LEN(Route)=6 order by flightno";
		$arrayResult = array();
		$arrayResult = $this->qry($SQL,2,$this->db205);
		$this->getcount = $this->qry($SQL,1,$this->db205);
		return $arrayResult;
	
	}

	public function querypax($tgl, $CodeAirport){

		$SQL1= "SELECT Child, Adult,Crew,No_Penerbangan,Arr_Code, Jumlah  FROM pax WHERE Tanggal='" . $tgl . "' and Dep_Code='$CodeAirport' order by No_Penerbangan";
		$arrayResult = array();
		$arrayResult = $this->qry($SQL1,2,$this->db204);
		$this->getcount = $this->qry($SQL1,1,$this->db204);
		
		return $arrayResult;
	}
	

	public function querypax2($tgl, $fno, $CodeAirport){

		$SQL1= "SELECT Child, Adult,Crew,No_Penerbangan,Arr_Code, Jumlah  FROM pax WHERE Tanggal='" . $tgl . "' and Dep_Code='$CodeAirport' and No_Penerbangan='$fno' order by No_Penerbangan";
		$arrayResult = array();
		$arrayResult = $this->qry($SQL1,2,$this->db204);
		$this->getcount = $this->qry($SQL1,1,$this->db204);
		
		return $arrayResult;
	}

	public function spsummarize($tgl, $CodeAirport){
		$SQL2= "SET ANSI_NULLS ON;SET ANSI_WARNINGS ON;exec report_boarding_summarize '" . $tgl . "','" . $tgl . "','',''"; 
		$arrayResult = $this->qry($SQL2,0, $this->db201);
		
		return $arrayResult;
	}

	public function reportsummarize($tgl, $CodeAirport){
		#$SQL = "SELECT     FLIGHTNO,ROUTE,FLTDATE,POB,XPAX,CHILD,isnull(INFANT,0) as Infant,CREW,TRANSIT, ISNULL(b.Tipe, '0') AS DOMINT FROM dbo.DataperFlight a LEFT OUTER JOIN  Dashboard.dbo.Kota b ON SUBSTRING(a.Route, 4, 3) = b.Kode  WHERE   Fltdate BETWEEN '$tgl' AND '$tgl' AND SUBSTRING(ROUTE,1,3)='$CodeAirport'";
		$SQL= "report_boarding_summary_new '".$tgl."','".$tgl."','',''"; 
		$query = mssql_query($SQL, $this->db201) or die(mssql_get_last_message());
		while ($row=mssql_fetch_assoc($query)){
				$data[]= $row;
		}
		#print_r($data);
		return $data;
	}

	public function spsummarize2($tgl){
		$SQL= "exec report_boarding_summarize '" . $tgl . "','" . $tgl . "','',''"; 
		$query = mssql_query($SQL, $this->db201) or die(mssql_get_last_message());
		while ($row=mssql_fetch_assoc($query)){
				$data[]= $row;
		}
		#print_r($data);
		return $data;	
		
		
	}

	public function dailypaxfno($tgl, $fno){
		$tglpax = date("jMY", strtotime($tgl));
		$SQL= "select top 10 barcode,status from daily$tglpax where flightno='$fno'"; 
		$query = mssql_query($SQL, $this->db201) or die(mssql_get_last_message());
		while ($row=mssql_fetch_assoc($query)){
				$data[]= $row;
		}
		#print_r($data);
		return $data;	
		
		
	}

	public function CountPax($tgl, $flightno){
		$SQL2= "select count(nama) as total from daily$tgl where flightno='$flightno'"; 
		$arrayResult = $this->qry($SQL2,0, $this->db201);
		$row  = mssql_fetch_assoc($arrayResult);
		$total = $row["total"];
		
		return $total;
	}

	public function CountRemarkInter($tgl, $flightno){
		$SQL2= "select count(nama) as total from daily$tgl where flightno='$flightno'"; 
		$arrayResult = $this->qry($SQL2,0, $this->db201);
		$row  = mssql_fetch_assoc($arrayResult);
		$total = $row["total"];
		
		return $total;
	}
	

	public function tabledaily($tgl){
		$tglpax = date("jMY", strtotime($tgl));
		$SQL= "select top 20 *from daily$tglpax "; 
		$query = mssql_query($SQL, $this->db201) or die(mssql_get_last_message());
		while ($row=mssql_fetch_assoc($query)){
				$data[]= $row;
		}
		#print_r($data);
		return $data;	
		
		
	}


	public function getnumrows(){
                return $this->getcount;
        }


	
}
?>