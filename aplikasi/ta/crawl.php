<?php
set_time_limit(0);
ini_set("memory_limit","-1");
include "connect_db.php";				//NIH KONEKNYA DARI SINI
include "libs/PHPCrawler.class.php";
//include "tree.php";

class MyCrawler extends PHPCrawler 
{
  public $list_link = array();
  function handleDocumentInfo($DocInfo) 
  {
	$hasil = $DocInfo->url;
	$link = explode("?",$hasil);
	
	if(isset($link[1])) {
		$wow = explode("&",$link[1]);
		if(isset($wow[1])) {
			$fix_link = $link[0] . "?" . $wow[0] . "&" . $wow[1];
		}
		else {
			$fix_link = $link[0] . "?" . $wow[0];
		}
		unset($link);
		unset($wow);
		$link[0] = $fix_link;
		unset($fix_link);
	}
	
	if(pathinfo(parse_url($link[0], PHP_URL_PATH), PATHINFO_EXTENSION) == "" || pathinfo(parse_url($link[0], PHP_URL_PATH), PATHINFO_EXTENSION) == "php" || pathinfo(parse_url($link[0], PHP_URL_PATH), PATHINFO_EXTENSION) == "html" || pathinfo(parse_url($link[0], PHP_URL_PATH), PATHINFO_EXTENSION) == "pdf" || pathinfo(parse_url($link[0], PHP_URL_PATH), PATHINFO_EXTENSION) == "htm") {
		$link[0] = rtrim($link[0], "/");
		$sama = 0;
		for($p = 0; $p < count($this->list_link); $p++) {
			if($link[0] == $this->list_link[$p]) {
				$sama = 1;
				break;
			}
		}
		if($sama == 0) {
			array_push($this->list_link,$link[0]);
		}
	}
    flush();
  }
}


$query = mysql_query("select URL from url where status_kunjungan = 0 limit 0,1");		//get url

/*$query2 = mysql_query("select URL from url");
$z = 0;
while($row = mysql_fetch_array($query2)){	
	$data[$z] = $row[0];
	$z++;
}

if(isset($data)) {
	$root = create_node_url();
	$root->isi = $data[0];
	$root->status = 1;
	isi_tree_url($data, $root, 1);
}*/

$crawler = new MyCrawler();
$a = 0;
while($row = mysql_fetch_array($query)){	
	$seed[$a] = $row[0];
	$a++;
}

//$crawler->list_link[0] = "http://vfu.bg/en/e-Learning/";
//$crawler->list_link[0] = "http://en.wikipedia.org/wiki/Main_Page";
$crawler->addURLFilterRule("#\.(jpg|jpeg|gif|png|js|css|ico|atom|src|exe|jsp|asp|txt|3gp|7z|aac|ace|aif|arj|asf|avi|bin|bz2|exe|gz|gzip|img|iso|lzh|m4a|m4v|mkv|mov|mp3|mp4|mpa|mpe|mpeg|mpg|msi|msu|ogg|ogv|plj|pps|ppt|qt|r0*|r1*|ra|rar|rm|rmvb|sea|sit|sitx|tar|tif|tiff|wav|wma|wmv|z|zip)$# i");
$o = 0;
do {
	$crawler->setTrafficLimit(10000 * 1024);
	$crawler->setURL($seed[$o]);		//urlnya
	$crawler->go();
//hapus nanti
//	for($n = $o; $n <= count($crawler->list_link) - $o; $n++) {
//		echo $crawler->list_link[$n];
//		echo "<br>";
//	}
//	echo '<hr>';
//sampe sini
	mysql_query("update url set status_kunjungan = 1 where url = '".$seed[$o]."'");		//put url
	$o++;
} while($crawler->list_link[$o] != NULL && $o < $a);

/*$data = $crawler->list_link;
if(isset($data)) {
	isi_tree_url($data, $root, 0);
}
$b = 0;
inorder_url($root, $b, $hasil_inorder);*/

$hasil_inorder = $crawler->list_link;
$insert = "";
$query = mysql_query("select id_url from url order by id_url desc limit 0,1");		//get url
while($row = mysql_fetch_array($query)) {
	$z = $row[0];
}
for ($a = 0; $a < count($hasil_inorder);$a++){
	//echo $hasil_inorder[$a].'<br>';
	if(get_unique_URL($hasil_inorder[$a]) == 0) {
		$x = $z + $a;
		insert_DB_URL($x, $hasil_inorder[$a]);
		//$insert .= "('',".$hasil_inorder[$a].",A,0,2014-05-05,0),";
	}
}

function get_unique_URL($id_url) {
	$query = mysql_query("select count(id_url) from url where url = '" . $id_url . "'");	//ini buat get url
	while($row = mysql_fetch_array($query)) {
		$status = $row[0];
	}
	return $status;
}

function insert_DB_URL($id_url, $url) {
	$parse = parse_url($url);
	$date = (Date("Y-m-d"));
	$domain = $parse['host'];
	if(substr($url,strlen($hasil_inorder[$a])-4,4) == '.pdf')
		mysql_query("insert into url values('$id_url','$url','$domain',1,'$date',0)")or die(mysql_error());		//put url
	else
		mysql_query("insert into url values('$id_url','$url','$domain',0,'$date',0)")or die(mysql_error());	//put url
}

//$insert = substr($insert,0,strlen($insert)-1);
//mysql_query('insert into url values "'.$insert.'"') or die(mysql_error());

include "close_db.php";
?>