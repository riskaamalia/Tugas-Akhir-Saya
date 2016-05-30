<?php
	function TF_IDF() {
		$query = mysql_query("select distinct(id_url) from pembobotan_pdf");	//get ke pembobotan pdf jika row isi sama, maka hanya di ambil satu aja
		$counter = 0;
		while($row = mysql_fetch_array($query)) {	//hasilnya di insert ke variabel $row
			$id_url[$counter] = $row[0];
			$counter++;
		}
		$N = get_N($id_url);
		for($counter = 0; $counter < $N; $counter++) {
			$query = mysql_query("select id_term, frekuensi from pembobotan_pdf where id_url = " . $id_url[$counter]); //get ke pembobotan pdf
			$counter1 = 0;
			//$insert = 'insert into pembobotan_pdf values ';
			while($row = mysql_fetch_array($query)) {
				$n = get_n($row[0]);
				$wij = count_TF_IDF($row[1], $N, $n);
				mysql_query("update pembobotan_pdf set bobot = " . $wij . " where id_url = " . $id_url[$counter] . " and id_term = " . $row[0]);	//put pembobotan pdf
				//$insert .= "(".$id_url[$counter].",".$row[0].",".$wij."),";
			}
			/*$insert = substr($insert,0,strlen($insert) - 1);
			if($insert != "insert into pembobotan_pdf values"){
				mysql_query($insert);
			}*/
		}
		$query = mysql_query("select distinct(id_url) from pembobotan_web");	//get pembobotan web
		$counter = 0;
		while($row = mysql_fetch_array($query)) {
			$id_url[$counter] = $row[0];
			$counter++;
		}
		$N = get_N($id_url);
		for($counter = 0; $counter < $N; $counter++) {
			$query = mysql_query("select id_term, frekuensi from pembobotan_web where id_url = " . $id_url[$counter]);	//get pembobotan web
			$counter1 = 0;
			//$insert = 'insert into pembobotan_web values ';
			while($row = mysql_fetch_array($query)) {
				$n = get_n($row[0]);
				$wij = count_TF_IDF($row[1], $N, $n);
				mysql_query("update pembobotan_web set bobot = " . $wij . " where id_url = " . $id_url[$counter] . " and id_term = " . $row[0]); //put pembobotan web
				//$insert .= "(".$id_url[$counter].",".$row[0].",".$wij."),";
			}
			/*$insert = substr($insert,0,strlen($insert) - 1);
			if($insert != "insert into pembobotan_web values"){
				mysql_query($insert);
			}*/
		}
	}
	
	function get_N($id_url) {
		return count($id_url);
	}
	
	function get_n($id_term) {		
		$query1 = mysql_query("select count(id_url) from pembobotan_pdf where id_term = " . $id_term); //get pembobotan pdf
		$n = mysql_fetch_array($query1)[0];
		return n;
	}
	
	function count_TF_IDF($frekuensi, $N, $n) {
		$wij = $frekuensi * ((log10($N/$n)) + 1);
		return $wij;
	}
?>