<?php
class DB_Connect {
	
	function __construct() {
	
	}
	
	function __destruct() {
	
	}
	
	public function connect($params){
		#echo "db_connect".$params."<br>";
		if ($params == "DJB")
		{
			$dbhandle  = mssql_connect("172.16.20.201","sa","hello") or die ("koneksi error DJB");
						 mssql_select_db("fpdjb", $dbhandle);
		     return $dbhandle;
			
		}
		elseif ($params == "KNO"){
			$dbhandle = mssql_connect("172.16.20.201","sa","hello") or die("koneksi error KNO");
						mssql_select_db("fpmes", $dbhandle);
			return $dbhandle;
		}
		elseif ($params == "BDO")
		{
			$dbhandle  = mssql_connect("172.16.20.201","sa","hello") or die ("koneksi error BDO");
						 mssql_select_db("fpbdo", $dbhandle);
	
			return $dbhandle;
		}
		elseif ($params == "HLP"){
			$dbhandle = mssql_connect("172.16.20.201","sa","hello") or die("koneksi error HlP");
						mssql_select_db("fphlp", $dbhandle);
			return $dbhandle;
		}
		
		elseif ($params == "PDG")
		{
			$dbhandle  = mssql_connect("172.16.20.201","sa","hello") or die ("koneksi error PDG");
				         mssql_select_db("fppdg", $dbhandle);
			return $dbhandle;
		}
		elseif ($params == "PKU")
		{
			$dbhandle = mssql_connect("172.16.20.201","sa","hello") or die("koneksi error PKU");
				        mssql_select_db("fppku", $dbhandle);
			return $dbhandle;
		}
		
		elseif ($params == "PLM")
		{
			$dbhandle  = mssql_connect("172.16.20.201","sa","hello") or die ("koneksi error PLM");
				         mssql_select_db("fpplm", $dbhandle);
			return $dbhandle;			 
		}
		elseif ($params == "PNK")
		{
			$dbhandle = mssql_connect("172.16.20.201","sa","hello") or die("koneksi error PNK");
				        mssql_select_db("fppnk", $dbhandle);
			return $dbhandle;
		}
		
		elseif ($params == "CT3")
		{
		       $dbhandle = mssql_connect("172.16.20.201","sa","hello") or die("koneksi error CGK");
		                   mssql_select_db("fpct3", $dbhandle);
		       return $dbhandle;
		}

		elseif ($params == "PGK")
		{
		       $dbhandle = mssql_connect("172.16.20.201","sa","hello") or die(mssql_get_last_message());
		                   mssql_select_db("fppgk", $dbhandle);
		       return $dbhandle;
		}

		elseif ($params == "DJB205")
		{
			$dbhandle  = mssql_connect("172.16.20.205","sa","hello") or die ("koneksi error DJB");
						 mssql_select_db("fpdjb", $dbhandle);
		     return $dbhandle;
			
		}
		elseif ($params == "KNO205"){
			$dbhandle = mssql_connect("172.16.20.205","sa","hello") or die("koneksi error KNO");
						mssql_select_db("fpmes", $dbhandle);
			return $dbhandle;
		}
		elseif ($params == "BDO205")
		{
			$dbhandle  = mssql_connect("172.16.20.205","sa","hello") or die ("koneksi error BDO");
						 mssql_select_db("fpbdo", $dbhandle);
	
			return $dbhandle;
		}
		elseif ($params == "HLP205"){
			$dbhandle = mssql_connect("172.16.20.205","sa","hello") or die("koneksi error HlP");
						mssql_select_db("fphlp", $dbhandle);
			return $dbhandle;
		}
		
		elseif ($params == "PDG205")
		{
			$dbhandle  = mssql_connect("172.16.20.205","sa","hello") or die ("koneksi error PDG");
				         mssql_select_db("fppdg", $dbhandle);
			return $dbhandle;
		}
		elseif ($params == "PKU205")
		{
			$dbhandle = mssql_connect("172.16.20.205","sa","hello") or die("koneksi error PKU");
				        mssql_select_db("fppku", $dbhandle);
			return $dbhandle;
		}
		
		elseif ($params == "PLM205")
		{
			$dbhandle  = mssql_connect("172.16.20.205","sa","hello") or die ("koneksi error PLM");
				         mssql_select_db("fpplm", $dbhandle);
			return $dbhandle;			 
		}
		elseif ($params == "PNK205")
		{
			$dbhandle = mssql_connect("172.16.20.205","sa","hello") or die("koneksi error PNK");
				        mssql_select_db("fppnk", $dbhandle);
			return $dbhandle;
		}
		
		elseif ($params == "CT3205")
		{
		       $dbhandle = mssql_connect("172.16.20.205","sa","hello") or die("koneksi error CGK");
		                   mssql_select_db("fpct3", $dbhandle);
		       return $dbhandle;
		}

		elseif ($params == "PGK205")
		{
		       $dbhandle = mssql_connect("172.16.20.205","sa","hello") or die(mssql_get_last_message());
		                   mssql_select_db("fppgk", $dbhandle);
		       return $dbhandle;
		}
		
		
		elseif ($params == "204")
		{
			$dbhandle = mssql_connect("172.16.20.204", "sa", "hello");
						 mssql_select_db("airlines", $dbhandle);
			return $dbhandle;
		}
		elseif ($params == "48")
		{
			$dbhandle = mysql_connect("10.10.10.48", "root", "mcojaya");
						 mysql_select_db("compare", $dbhandle);
			return $dbhandle;
		}

		
	}
	
	
	
	public function close($params){
		mssql_close();
		//mssql_close($dbhandle2);
	}
}
?>