<?php
/*$connection = mysql_connect("localhost","root","");
mysql_select_db("maintenance");

$query = mysql_query("select DB_aktif from maintenance");
while($row = mysql_fetch_array($query)){
	$db_aktif = $row[0];
}
mysql_close($connection);

if($db_aktif == "ta"){
	$connection = mysql_connect("localhost","root","");
	mysql_select_db("ta2");
	mysql_query("delete from frekuensi_term_pdf");
	mysql_query("delete from frekuensi_term_web");
	mysql_query("delete from frontier");
	mysql_query("delete from halaman_web");
	mysql_query("delete from inverted_index_pdf");
	mysql_query("delete from inverted_index_web");
	mysql_query("delete from lsa_halaman_web");
	mysql_query("delete from lsa_pdf");
	mysql_query("delete from pdf");
	mysql_query("delete from term");
	mysql_query("delete from url");
	mysql_close($connection);
	$connection = mysql_connect("localhost","root","");
	mysql_select_db("ta");
	$query = mysql_query("select id_url,url,domain,status_kunjungan from url");
	$string = "insert into url values ";
	$date = (Date("Y-m-d"));
	while($row = mysql_fetch_array($query)){
	$string .= "(".$row[0].",'".$row[1]."','".$row[2]."',".$row[3].",'$date',0),";
	}
	$string = substr($string,0,-1);
	mysql_close($connection);
	$connection = mysql_connect("localhost","root","");
	mysql_select_db("ta2");
	mysql_query($string);
	mysql_close($connection);
	
}*/
	function maintenance() {
		$connection = mysql_connect("localhost","root","yoga372");
		mysql_select_db("maintenance");
		$query = mysql_query("select DB_aktif from maintenance");
		while($row = mysql_fetch_array($query)) {
			$db_aktif = $row[0];
		}
		$date = (Date("Y-m-d"));
		if($db_aktif == "ta") {
			mysql_query("update maintenance set DB_aktif = 'ta2', akhir_maintenance = '" . $date . "'");
		}
		else {
			mysql_query("update maintenance set DB_aktif = 'ta', akhir_maintenance = '" . $date . "'");
		}
		mysql_close($connection);
	}
?>