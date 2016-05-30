<?php
	set_time_limit(0);
	while(true) {
		include "himpun_data.php";
		include "pembobotan.php";
		
		$connection = mysql_connect("localhost","root","");
		mysql_select_db("maintenance");
		$query = mysql_query("select DB_aktif from maintenance");
		while($row = mysql_fetch_array($query)){
			$db_aktif = $row[0];
		}
		if($db_aktif == "ta") {
			mysql_select_db("ta2");
			$query = mysql_query("select count(id_url) from halaman_web");
			while($row = mysql_fetch_array($query)) {
				$jumlah_web = $row[0] * $row[0];
			}
			$query = mysql_query("select count(id_url) from pdf");
			while($row = mysql_fetch_array($query)) {
				$jumlah_pdf = $row[0] * $row[0];
			}
			do {
				sleep(60 * 60 * 24);
				$query = mysql_query("select count(ID_URL_1) from lsa_halaman_web");
				while($row = mysql_fetch_array($query)) {
					$current_jumlah_web = $row[0];
				}
				$query = mysql_query("select count(ID_URL_1) from lsa_pdf");
				while($row = mysql_fetch_array($query)) {
					$current_jumlah_pdf = $row[0];
				}
			} while($current_jumlah_web != $jumlah_web && $current_jumlah_pdf != $jumlah_pdf);
		}
		else {
			mysql_select_db("ta");
			$query = mysql_query("select count(id_url) from halaman_web");
			while($row = mysql_fetch_array($query)) {
				$jumlah_web = $row[0] * $row[0];
			}
			$query = mysql_query("select count(id_url) from pdf");
			while($row = mysql_fetch_array($query)) {
				$jumlah_pdf = $row[0] * $row[0];
			}
			do {
				sleep(60 * 60 * 24);
				$query = mysql_query("select count(ID_URL_1) from lsa_halaman_web");
				while($row = mysql_fetch_array($query)) {
					$current_jumlah_web = $row[0];
				}
				$query = mysql_query("select count(ID_URL_1) from lsa_pdf");
				while($row = mysql_fetch_array($query)) {
					$current_jumlah_pdf = $row[0];
				}
			} while($current_jumlah_web != $jumlah_web && $current_jumlah_pdf != $jumlah_pdf);
		}
		
		include "maintenance.php";
		
		maintenance();
		
		$connection = mysql_connect("localhost","root","yoga372");
		mysql_select_db("maintenance");
		$query = mysql_query("select DB_aktif from maintenance");
		while($row = mysql_fetch_array($query)){
			$db_aktif = $row[0];
		}
		mysql_close($connection);
		
		if($db_aktif == "ta"){
			$connection = mysql_connect("localhost","root","yoga372");
			mysql_select_db("ta2");
			mysql_query("delete from pembobotan_pdf");
			mysql_query("delete from pembobotan_web");
			mysql_query("delete from lsa_halaman_web");
			mysql_query("delete from lsa_pdf");
			mysql_query("delete from term");
			mysql_query("delete from halaman_web");
			mysql_query("delete from pdf");
			mysql_query("delete from url");
			mysql_close($connection);
			$connection = mysql_connect("localhost","root","yoga372");
			mysql_select_db("ta");
			$query = mysql_query("select id_url,url,domain,status_kunjungan from url");
			$string = "insert into url values ";
			$date = (Date("Y-m-d"));
			while($row = mysql_fetch_array($query)) {
				$string .= "(".$row[0].",'".$row[1]."','".$row[2]."',".$row[3].",'$date',0),";
			}
			$string = substr($string,0,-1);
			mysql_close($connection);
			$connection = mysql_connect("localhost","root","yoga372");
			mysql_select_db("ta2");
			mysql_query($string);
			mysql_close($connection);
		}
		else {
			$connection = mysql_connect("localhost","root","yoga372");
			mysql_select_db("ta");
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
			$connection = mysql_connect("localhost","root","yoga372");
			mysql_select_db("ta2");
			$query = mysql_query("select id_url,url,domain,status_kunjungan from url");
			$string = "insert into url values ";
			$date = (Date("Y-m-d"));
			while($row = mysql_fetch_array($query)) {
				$string .= "(".$row[0].",'".$row[1]."','".$row[2]."',".$row[3].",'$date',0),";
			}
			$string = substr($string,0,-1);
			mysql_close($connection);
			$connection = mysql_connect("localhost","root","yoga372");
			mysql_select_db("ta");
			mysql_query($string);
			mysql_close($connection);
		}
	}
?>