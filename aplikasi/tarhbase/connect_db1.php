<?php
$connection = mysql_connect("localhost","root","");
mysql_select_db("maintenance");						//sama kaya konek db yang satunya

$query = mysql_query("select DB_aktif from maintenance");
while($row = mysql_fetch_array($query)){
	$db_aktif = $row[0];
}
mysql_close($connection);

if($db_aktif == "ta"){
	$connection = mysql_connect("localhost","root","");
	mysql_select_db("ta");
}
else{
	$connection = mysql_connect("localhost","root","");
	mysql_select_db("ta2");
}
//$connection = mysql_connect("mysql.serversfree.com","u219956913_101","kota101");
//mysql_select_db("u219956913_101");
?>