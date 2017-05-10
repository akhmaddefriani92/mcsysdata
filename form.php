<html>
<head>
	<?php 
		$date = date("Y-m-d", strtotime("-30 day"));
	?>
</head>
<body>
<center>
<form method="POST" action="curl_post_mcsys.php">
<h3>Write csv MAXIS</h3>
<table>
	<tr>
	<td>Kota</td>
	<td>:</td>
	<td>
		<select name="kota">
			<option >--Silahkan Pilih--</option>	
			<option value="DJB"> DJB - Jambi </option>
			<option value="HLP"> HLP - Jakarta </option>
			<option value="CGK"> CGK - Jakarta </option>
			<option value="PLM"> PLM - Palembang </option>
			<option value="PNK"> PNK - Pontianak </option>
			<option value="PKU"> PKU - Pekanbaru </option>
			<option value="PDG"> PDG - Padang </option>
			<option value="PGK"> PGK - Pangkal Pinang </option>
			<option value="BDO"> BDO - Bandung </option>
			<option value="KNO"> KNO - Medan </option>
		</select>
	</td>
	</tr>
	<tr>
		<td>Tanggal</td>
		<td>:</td>
		<td><input type='text' name='tanggal' value='<?php echo $date;?>'/></td>
	</tr>
	<tr>
	<td>Airline</td>
	<td>:</td>
	<td>
		<select name="airline">
			<option >--Silahkan Pilih--</option>	
			<option value="ALL"> ALL</option>
			<option value="GA"> GA </option>
		</select>
	</td>
	</tr>
	<tr>
	<td>Flight Type</td>
	<td>:</td>
	<td>
		<select name="flight_type">
			<option >--Silahkan Pilih--</option>	
			<option  value="ALL">ALL</option>
			<option value="D">DOM - Domestic</option>
			<!--<option value="I">INT - International</option>-->
		</select>
	</td>
	</tr>
	<tr>
		<td><input type='submit' name='submit' value='submit'/>
		</td>
	</tr>

</table>
</form>
</center>
</body>
</html>