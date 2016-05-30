<?php
//include "tokenizing.php";
/*$string1 = "saya+dia";
$string2 = "1+2";
$token = tokenizing($string1);
for($a = 0; $a < sizeof($token); $a++){
	echo $token[$a].'<br>';
}
echo '<hr>';
$token = tokenizing($string2);
for($a = 0; $a < sizeof($token); $a++){
	echo $token[$a].'<br>';
}*/

/*include "filtering_stoplist.php";
	$content = "White is the color of milk and fresh snow, the color produced by the combination of all the colors of the visible spectrum.";
	$contents = tokenizing($content);

	$content = " ";	
	for($a = 0; $a < count($contents); $a++){
		$content .= $contents[$a].' ';
	}
	echo $content.'<hr>';
	$content = filtering_stoplist($content);
	for($a = 0; $a < count($content); $a++){
		echo $content[$a].' ';
	}*/
$connection = mysql_connect("localhost","root","");
mysql_select_db("ta_testing");
$query = mysql_query("select * from lsa_halaman_web");
$status = 0;
while($row = mysql_fetch_array($query)){
	echo $row[2].' ';
	$status++;
	if($status == 5){
		echo '<br>';
		$status = 0;
		}
}

?>