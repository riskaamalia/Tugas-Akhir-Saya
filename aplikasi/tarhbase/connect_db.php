<?php
$connection = mysql_connect("localhost","root","");		//full konek DB
mysql_select_db("maintenance");							//select ke DB maintenance

$query = mysql_query("select DB_aktif from maintenance");		//get db aktif
while($row = mysql_fetch_array($query)){
	$db_aktif = $row[0];
}
mysql_close($connection);

if($db_aktif == "ta"){
	$connection = mysql_connect("localhost","root","");
	mysql_select_db("ta2");						//select db aja cenah
}
else{
	$connection = mysql_connect("localhost","root","");
	mysql_select_db("ta");							//select db aja cenah
}

//$connection = mysql_connect("mysql.serversfree.com","u219956913_101","kota101");
//mysql_select_db("u219956913_101");
?>