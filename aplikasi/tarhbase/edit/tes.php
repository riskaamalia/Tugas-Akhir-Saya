<?php
include "teshbase.php";

$id_term = NULL;
$banding = "pictur";
	$obj_query = new  teshbase ();	
	for ($i=0;$i< 48069;$i++) {
		$term[$i] = $obj_query -> select("term",$i,"term_info:TERM");
		if ($term[$i] == $banding) {
			$id_term = $i;
			echo "id term ".$id_term;
		}
	}

//$contoh2 = array();
//$contoh = new hbase_stargate ();		//dia ini objek
//$ROW = 1123;
//$contoh2 = $contoh -> ambil_nama_kolom("url",$ROW ,"url_info:URL");
//echo $contoh2;

//$contoh3 = $contoh -> select("url",$ROW ,"url_info:DOMAIN");
//$id_term ="15";
//$query_pdf = "from pembobotan_pdf where id_term = ";	/*ini edit*/	
//$query_pdf .= "'".$id_term."' or id_term = ";
//$query_pdf = substr($query_pdf,0,strlen($query_pdf) - 14).' order by id_url,id_term asc';	
//echo substr($query_pdf,strlen($query_pdf) - 14,strlen($query_pdf));
//echo $query_pdf;

//$query = mysql_query("select id_url_2,value from lsa_pdf where id_url_1 = '$id_url'");	/*ini edit*/
/*$obj_query = new  hbase_stargate ();
for ($i=1;$i< 1158;$i++) {		//looping sejumlah id row key di lsa_pdf
	$id_url_1[$i-1] = $obj_query -> select("lsa_halaman_pdf","id".$i,"lsa_halaman_pdf_info:ID_URL_1");
	if ($id_url_1[$i-1] == $id_url) {		
	$id_url_2[$i-1] = $obj_query -> select("lsa_halaman_pdf","id".$i,"lsa_halaman_pdf_info:ID_URL_2");
	$value[$i-1] = $obj_query -> select("lsa_halaman_pdf","id".$i,"lsa_halaman_pdf_info:VALUE");		
	echo $id_url_2[$i-1]." ".$value[$i-1]."<br>";
	}
}
*/
?>