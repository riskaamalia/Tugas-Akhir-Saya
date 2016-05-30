<?php
include "quick_sort.php";
include "connect_db1.php";
function similarity($id_url,$status){
	if($status == 0){
		$query = mysql_query("select id_url_2,value from lsa_pdf where id_url_1 = '$id_url'");
		}
	else if($status == 1){
		$query = mysql_query("select id_url_2,value from lsa_halaman_web where id_url_1 = '$id_url'");	
	}
	$counter = 0;
	while($row = mysql_fetch_array($query)){
		if($row[0] != $id_url){
			$similar[0][$counter] = $row[0];
			$similar[1][$counter] = $row[1];
			$counter++;
		}
	}
	
	$sort_similar = quick_sort($similar[1]);
	for($a = 0; $a < 10; $a++){
		for($b = 0; $b < sizeof($similar[0]); $b++){
			if($sort_similar[$a] == $similar[1][$b] && $sort_similar[$a] >= 0.5){
				$result[$a] = $similar[0][$b];
				$similar[1][$b] = NULL;
				break;
			}
		}
	}
	return $result;
}
?>