<?php
include "quick_sort.php";
include "koneksi_thrift.php";
function similarity($id_url,$status){
		if($status == 0){
		//$query = mysql_query("select id_url_2,value from lsa_pdf where id_url_1 = '$id_url'");
			try {
		    $transport->open();
		    $table = 'lsa_halaman_pdf';
		    $column1 = 'lsa_halaman_pdf_info:ID_URL_2';
		    $column2 = 'lsa_halaman_pdf_info:VALUE';
		    $filter = 'lsa_halaman_pdf_info:ID_URL_1';
		    $loop_row = 0;
		    $counter = 0;
		    while ($loop_row < 1157) {	//di terminal pake count 't1' untuk jumlah row
		    	$nilai_filter = ($client->get($table, $loop_row, $filter, null));
		    	foreach ($nilai_filter as $k=>$v) {
		        	$hasil_filter = $v ->value;
		        	$values = ($client->get($table, $loop_row, $column1, null));
					foreach ($values as $k=>$v) {
					    $hasil = $v ->value; 
					}
		        	if ($hasil_filter == $id_url && $hasil == $id_url ) {
					    $values2 = ($client->get($table, $loop_row, $column2, null));
					    foreach ($values2 as $k=>$v) {
					        $hasil2 = $v ->value;
					        $similar[0][$counter] = $hasil;
							$similar[1][$counter] = $hasil2;
							$counter++; 
					    }		        		
		        	} 
		    	}
		    	$loop_row++;
		    }

		    $transport->close();

		} catch (TException $e) {
		    print 'TException: '.$e->__toString().' Error: '.$e->getMessage()."\n";
		}

		}
		else if($status == 1){
			try {
			    $transport->open();
			    $table = 'lsa_halaman_web';
			    $column1 = 'lsa_halaman_web_info:ID_URL_2';
			    $column2 = 'lsa_halaman_web_info:VALUE';
			    $filter = 'lsa_halaman_web_info:ID_URL_1';
			    $loop_row = 0;
			    $counter = 0;
			    while ($loop_row < 628850) {	//di terminal pake count 't1' untuk jumlah row
			    	$nilai_filter = ($client->get($table, $loop_row, $filter, null));
			    	foreach ($nilai_filter as $k=>$v) {
			        	$hasil_filter = $v ->value;
			        	$values = ($client->get($table, $loop_row, $column1, null));
						foreach ($values as $k=>$v) {
						    $hasil = $v ->value; 
						}
			        	if ($hasil_filter == $id_url && $hasil == $id_url ) {
						    $values2 = ($client->get($table, $loop_row, $column2, null));
						    foreach ($values2 as $k=>$v) {
						        $hasil2 = $v ->value;
						        $similar[0][$counter] = $hasil;
								$similar[1][$counter] = $hasil2;
								$counter++; 
						    }		        		
			        	} 
			    	}
			    	$loop_row++;
			    }

			    $transport->close();

			} catch (TException $e) {
			    print 'TException: '.$e->__toString().' Error: '.$e->getMessage()."\n";
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
