<?php
include "connect_db.php";
include "html_dom.php";
set_time_limit(-1);
require_once ("lib/LangDetector.php");
include "cek_keberadaan_abstraksi.php";
error_reporting(0);

//modul yg digunakan pada saat ekstraksi
include "tokenizing.php";
include "filtering_stoplist.php";
include "stemming.php";
include "tree.php";

require_once dirname(__DIR__).DIRECTORY_SEPARATOR.'ta'.DIRECTORY_SEPARATOR.'PDFBox.php';
require_once dirname(__DIR__).DIRECTORY_SEPARATOR.'ta'.DIRECTORY_SEPARATOR.'ExtractText.php';

$jar = __DIR__.DIRECTORY_SEPARATOR."pdfbox-app-1.8.4.jar";
$pdf_box = new PDFBox\PDFBox($jar);
$extract_text = new PDFBox\ExtractText($pdf_box);

//insert term dari DB ke tree
$query2 = mysql_query("select term,id_term from term");
$a = 0;
while($row = mysql_fetch_array($query2)){
	$term[$a] = $row[0];
	$id[$a] = $row[1];
	$a++;
}
$root_term= NULL;
if($a > 0)
	isi_tree_term($term, $root_term,0,$id);

$query = mysql_query("select url,id_url from url where status_ekstraksi = 0");
while($row = mysql_fetch_array($query)){
$headers = get_headers($row[0], 1);
if (substr($headers[0],9,3) == '200') {
	$homepage = file_get_contents($link);
	$root = NULL;
	$hasil_inorder = NULL;
	$temp = explode('.pdf',$row[0]);
	// jika panjang url masih sama dengan sebelumya, erarti buakan pdf karena blm terexplode
	if(check_URL($row[0]) == 1){ 
	$string = html_dom($row[0]);
	// explode string dengan titik untuk mendapatkan kalimat berdasarkan titik
	$string = explode('.',$string); 
	$l = new LangDetector(TRUE);
	$hasil = 0;
	for($a = 0; $a < 5; $a++) {
		$hasil += test_lang($string[$a],"en");
	}
		// jika ada satu saja dari kalimat tersebut yang terdeteksi berbahasa inggris
		if($hasil > 1) { 
						$id_url = $row[1];
						// masukan dalam  tabel halaman web
						mysql_query("insert into halaman_web values ('$id_url')"); 
							$content = html_dom($row[0]);
							$contents = tokenizing($content);
							$content = " ";	
							for($o = 0; $o < count($contents); $o++){
								$content .= $contents[$o].' ';
							}
							$content = filtering_stoplist($content);
							$porter = new PorterStemmer();
							for($o = 0 ; $o < count($content); $o++){
								$content[$o] =  $porter->Stem($content[$o]);
//								echo $content[$o].' ';
							}
							$query4 = mysql_query("select id_term from term order by id_term desc limit 0,1");
							$id_now = 0;
							while($row2 = mysql_fetch_array($query4)){
								$id_now = $row2[0];
							}
							$temp = $id_now;
							$id_now++;
							isi_tree_term($content, $root_term, 1,$id_now);
							isi_tree_frek_term($content, $root);
							$b = 0;
							inorder_frek_term($root, $b, $hasil_inorder);
//							echo '<hr>';
							for($o = 0; $o < count($hasil_inorder[0]); $o++){
								$id_term = search_tree($hasil_inorder[0][$o],$root_term);
								if($id_term > $temp || $id_term == 0)
									mysql_query("insert into term values('$id_term','".$hasil_inorder[0][$o]."','".substr($hasil_inorder[0][$o],0,3)."')");
								mysql_query("insert into pembobotan_web values('$row[1]','$id_term','".$hasil_inorder[1][$o]."',0)");
//								echo $id_term.' '.$hasil_inorder[0][$o].' '.$hasil_inorder[1][$o].'<br>';
							}
		}
		mysql_query("update url set status_ekstraksi = 1 where url = '$row[0]'");
	}
	else{
		$content = pdf_box($row[1], $row[0]);
		$abstrak = cek_keberadaan_abstraksi($content);	
		if(strlen($abstrak) > 50){
			$string = $abstrak ;
			$string = explode('.',$string);
			$l = new LangDetector(TRUE);
			$hasil = 0;
			for($a = 0; $a < 5; $a++) {
				$hasil += test_lang($string[$a],"en");
			}
			if($hasil > 0) {
					$query1 = mysql_query("select count(*) from pdf where abstraksi = '$abstrak'");
					if(mysql_fetch_array($query1)[0] == 0){
							$id_url = $row[1];
							mysql_query("insert into pdf values ('$id_url','$abstrak')");
							$content = file_get_contents($row[1].'.txt');
							$contents = tokenizing($content);
							$content = " ";	
							for($o = 0; $o < count($contents); $o++){
								$content .= $contents[$o].' ';
							}
							$content = filtering_stoplist($content);
							$porter = new PorterStemmer();
							for($o = 0 ; $o < count($content); $o++){
								$content[$o] =  $porter->Stem($content[$o]);
							}
							$query4 = mysql_query("select id_term from term order by id_term desc limit 0,1");
							$id_now = 0;
							while($row2 = mysql_fetch_array($query4)){
								$id_now = $row2[0];
							}
							$temp = $id_now;
							$id_now++;
							isi_tree_term($content, $root_term, 1,$id_now);
							isi_tree_frek_term($content, $root);
							$b = 0;
							inorder_frek_term($root, $b, $hasil_inorder);
							for($o = 0; $o < count($hasil_inorder[0]); $o++){
								$id_term = search_tree($hasil_inorder[0][$o],$root_term);
								if($id_term > $temp || $id_term == 0)
									mysql_query("insert into term values('$id_term','".$hasil_inorder[0][$o]."','".substr($hasil_inorder[0][$o],0,3)."')");
								mysql_query("insert into pembobotan_pdf values('$row[1]','$id_term','".$hasil_inorder[1][$o]."',0)");
							}
					}
			}
		}
		mysql_query("update url set status_ekstraksi = 1 where url = '$row[0]'");
	}
	}
	else {
		mysql_query("delete from url where id_url = " . $row[1]);
	}
}

function check_URL($url) {
	$temp = explode('.pdf',$url);
	if(strlen($url) == strlen($temp[0])) {
		return 1;
	}
	return 0;
}

function pdf_box($id_url, $url) {
	$filename = $id_url;
	file_put_contents($filename.".pdf",file_get_contents($url));
	$extract_text->parse(__DIR__.DIRECTORY_SEPARATOR. $filename . '.pdf');	
	$content =  file_get_contents($filename . '.txt');
	return $content;
}

function test_lang($txt,$expected)
{
    global $l;
    $out = $l->get_lang($txt);
    $first = array_shift($out);

    if ($first["lang"]==$expected) {
	return 1;
	} else {
	return 0;
    }
}

include "close_db.php";
?>