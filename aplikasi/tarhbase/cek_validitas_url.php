<?php
function cek_validitas_url($hasil){
$result[0] = $hasil[0];
$result[1] = $hasil[1];
$result[2] = $hasil[2];
$counter = 0;
/*	for($a = 0; $a < sizeof($hasil[3]); $a++){
		$query = mysql_query("select url from url where id_url = '".$hasil[3][$a]."'");
					while($row = mysql_fetch_array($query)){
						$url = $row[0];
					}
		$headers = get_headers($url,1);
		if(substr($headers[0],3,3) == "200"){
			$result[3][$counter] = $hasil[3][$a];
			$counter++;
		}
	}*/
return $hasil;	
}

?>