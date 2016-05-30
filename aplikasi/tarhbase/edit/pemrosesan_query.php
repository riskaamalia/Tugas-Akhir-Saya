<?php
function pemrosesan_query($keyword,$status){
include "tokenizing.php";
include "filtering_stoplist_query.php";
include "stemming.php";
include "filtering_condition.php";
include "quick_sort.php";
include "connect_db1.php";
include "teshbase.php";

$keyword = tokenizing($keyword);
$token = ' ';
for($a = 0; $a < sizeof($keyword); $a++){
	$token .= $keyword[$a].' ';
}

$porter = new PorterStemmer();

$token = filtering_stoplist_query($token);
for($a = 0; $a < sizeof($token); $a++){
	$token[$a] =  $porter->Stem($token[$a]);
}

$key_kombinasi = filtering_condition($token);
for($a = 0; $a < sizeof($key_kombinasi); $a++){
	for($b = 0; $b < sizeof($key_kombinasi[$a]) - 1; $b++){
		for($c = $b + 1; $c < sizeof($key_kombinasi[$a]); $c++){
			if($key_kombinasi[$a][$b] > $key_kombinasi[$a][$c]){
				$temp = $key_kombinasi[$a][$b];
				$key_kombinasi[$a][$b] = $key_kombinasi[$a][$c];
				$key_kombinasi[$a][$c] = $temp;
			}
			else if($key_kombinasi[$a][$b] == $key_kombinasi[$a][$c]){
				$key_kombinasi[$a][$c] = NULL;
			}
		}
	}
}

for($a = 0; $a < sizeof($key_kombinasi); $a++){
	$counter = 0;
	for($b = 0; $b < sizeof($key_kombinasi[$a]); $b++){
		if($key_kombinasi[$a][$b] != NULL){
			$key_fix[$a][$counter] = $key_kombinasi[$a][$b];
			$counter++;
		}
	}
}
for($a = 0; $a < sizeof($key_fix); $a++){
	for($b = $a + 1; $b < sizeof($key_fix); $b++){
		if($key_fix[$a] == $key_fix[$b]){
			$key_fix[$b] = NULL;
		}
	}
}

$counter = 0;
$max_key = 0;
for($a = 0; $a < sizeof($key_fix); $a++){
	if(sizeof($key_fix[$a]) != 0){
		$key[$counter] = $key_fix[$a];
		if($max_key < sizeof($key_fix[$a])){
			$max_key = sizeof($key_fix[$a]);
			$token_max_key = $key_fix[$a];
		}
		$counter++;
	}
}

$query_pdf = "from pembobotan_pdf where id_term = ";	/*ini edit*/
$query_web = "from pembobotan_web where id_term = ";	/*ini edit*/
$counter = 0;
$query = new  hbase_stargate ();
for($a = 0; $a < sizeof($token_max_key); $a++){
	//$query = mysql_query("select id_term from term where term = '$token_max_key[$a]'");	/*ini edit*/
	$id_term = NULL;
	$obj_query = new  hbase_stargate ();	
	for ($i=0;$i< 48069;$i++) {
		$term[$i] = $obj_query -> select("term",$i,"term_info:TERM");
		if ($term[$i] == $token_max_key[$a]) {
			$id_term = $i;
		}
	}	
	
	/*while($row = mysql_fetch_array($query)){
		$id_term = $row[0];		//ini teh row isian kolom ke 0, yaitu field si id_term, nanti id_term di isi hasil select
	}*/
	if($id_term != NULL)
	{
	$query_pdf .= "'".$id_term."' or id_term = ";
	$query_web .= "'".$id_term."' or id_term = "; 
		
	$id_key[0][$counter] = $token_max_key[$a];
	$id_key[1][$counter] = $id_term;
	$counter++;
	}
}

if(substr($query_pdf,strlen($query_pdf) - 14,strlen($query_pdf)) == " or id_term = "){		/*isian id_term ini dari pembobotan*/
$query_pdf = substr($query_pdf,0,strlen($query_pdf) - 14).' order by id_url,id_term asc';	/*isian di ascending berdasarkan id url dan id term*/
/*isinya yang atas "from pembobotan_pdf where id_term = '15' order by id_url,id_term asc" */
$query_web = substr($query_web,0,strlen($query_web) - 14).' order by id_url,id_term asc';	/*ini edit*/

for($a = 0; $a < sizeof($key); $a++){
	for($b = 0; $b < sizeof($key[$a]); $b++){
		for($c = 0; $c < sizeof($id_key[0]); $c++){
			if($id_key[0][$c] == $key[$a][$b])
				$key[$a][$b] = $id_key[1][$c];
		}
	}
}

for($a = 0; $a < sizeof($key); $a++){
	for($b = 0; $b < sizeof($key[$a]) - 1; $b++){
		for($c = $b + 1; $c < sizeof($key[$a]); $c++){
			if($key[$a][$b] > $key[$a][$c]){
				$temp = $key[$a][$b];
				$key[$a][$b] = $key[$a][$c];
				$key[$a][$c] = $temp;
			}
		}
	}
}

for ($i=0;$i< 1114;$i++) {
$obj_query = new  hbase_stargate ();
	if($status == 2){
		//$query = mysql_query("select distinct(id_url) ".$query_pdf);	/*jika row sama, maka akan di ambil salah satunya*/
		/*isinya yang atas "from pembobotan_pdf where id_term = $id_term order by id_url,id_term asc" */
		for ($y=0;$y< 48069;$y++) {
			if ($y == $id_term) {
				$row_url[$i] = $obj_query -> select("url",$i,"url_pembobotan_pdf:".$y."=frekuensi");	//id_term ada 48068
				$id_url[0][$y] = $i;
				$id_url[1][$y] = 0;
			}
			else {
				$row_url[$i] = "b";	//salah
			}				
		}	
	}
	else{
		//$query = mysql_query("select distinct(id_url) ".$query_web);	/*jika row sama, maka akan di ambil salah satunya*/
		for ($y=0;$y< 48069;$y++) {
			if ($y == $id_term) {
				$row_url[$i] = $obj_query -> select("url",$i,"url_pembobotan_web:".$y."=frekuensi");	//id_term ada 48068
				$id_url[0][$y] = $i;
				$id_url[1][$y] = 0;
			}
			else {
				$row_url[$i] = "b";	//salah
			}				
		}		
	}
	/*$counter = 0;
	while($row = mysql_fetch_array($query)){
		$id_url[0][$counter] = $row[0];	//kaya yang atas
		$id_url[1][$counter] = 0;
		$counter++;
	}*/
}
if($status == 2){
	unset($temp);
	//$query = mysql_query("select * ".$query_pdf);	/*ini edit*/
	for ($y=0;$y< 48069;$y++) {
	if ($y == $id_term) {
		$row_url[$i] = $obj_query -> select("url",$i,"url_pembobotan_pdf:".$y."=frekuensi");	//id_term ada 48068
		$bobot[$i] =  $obj_query -> select("url",$i,"url_pembobotan_pdf:".$y."=bobot");
		$temp[0][$y] = $i;	//kaya yang atas
		$temp[1][$y] = $y;
		$temp[2][$y] = $bobot[$i];
	}
	else {
		$row_url[$i] = "b";	//salah
	}				
	}	

}
else{
	unset($temp);
	//$query = mysql_query("select * ".$query_pdf);	/*ini edit*/
	for ($y=0;$y< 48069;$y++) {
	if ($y == $id_term) {
		$row_url[$i] = $obj_query -> select("url",$i,"url_pembobotan_web:".$y."=frekuensi");	//id_term ada 48068
		$bobot[$i] =  $obj_query -> select("url",$i,"url_pembobotan_web:".$y."=bobot");
		$temp[0][$y] = $i;	//kaya yang atas
		$temp[1][$y] = $y;
		$temp[2][$y] = $bobot[$i];
	}
	else {
		$row_url[$i] = "b";	//salah
	}				
	}	
}
//$counter = 0;
//unset($temp);
/*while($row = mysql_fetch_array($query)){
	$temp[0][$counter] = $row[0];	//kaya yang atas
	$temp[1][$counter] = $row[1];
	$temp[2][$counter] = $row[3];
	$counter++;
}*/
$counter1 = 0;
$counter2 = 0;
for($a = 0; $a < sizeof($temp[0]); $a++){
	$result[$counter1][$counter2] = $temp[1][$a];
	$id_url[1][$counter1] += $temp[2][$a];
	$counter2++;
	if($temp[0][$a] != $temp[0][$a+1]){
		$counter1++;
		$counter2 = 0;
	}
}

$counter = 0;
for($a = 0; $a < sizeof($result); $a++){
	for($b = 0; $b < sizeof($key); $b++){
		if($key[$b] == $result[$a]){
			$hasil[0][$counter] = $id_url[0][$a];
			$hasil[1][$counter] = $id_url[1][$a];
			$hasil[2][$counter] = sizeof($result[$a]);
			$counter++;
			break;
		}
	}
}

$sort_hasil = quick_sort($hasil[1]);
for($a = 0; $a < sizeof($sort_hasil); $a++){
	for($b = 0; $b < sizeof($hasil[0]); $b++){
		if($hasil[1][$b] == $sort_hasil[$a]){
			//echo $hasil[0][$b].' '.$sort_hasil[$a].' '.$hasil[2][$b].'<br>';
			$hasil_akhir[0][$a] = $hasil[0][$b];
			$hasil_akhir[1][$a] = $hasil[2][$b];
			$hasil[1][$b] = NULL;
			break;
		}
	}
}
$counter = 0;
for($a = $max_key; $a > 0; $a--){
	for($b = 0; $b < sizeof($hasil_akhir[0]);$b++){
		if($hasil_akhir[1][$b] == $a){
			$hasil_akhir_fix[$counter] = $hasil_akhir[0][$b];
			$counter++;
		}
	}
}

return $hasil_akhir_fix;
}
else{
	return NULL;
}
}
?>
