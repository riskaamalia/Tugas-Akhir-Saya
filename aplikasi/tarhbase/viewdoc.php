<?php 
include "koneksi_thrift.php";

$url = $_GET["url"];
$status = $_GET["s"];
if($url == NULL || ($status != 1 && $status != 2)){
	header("Location: index.php");
}
include "similarity.php";
$result = similarity($url,$status);
if($status == 1){
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>show demo</title>
  <style>
  #kota101{
	  top:50px;
	  right:0px;
	  width:500px;
	  height:auto;
	  z-index:255;
	  position:fixed;
  }
  </style>
  <script src="jquery-1.10.2.js"></script>
  <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link  href="css/button2.css" rel="stylesheet" type="text/css" >
    <style type="text/css">
<!--
.style1 {
	font-size: large
}
-->
    </style>
</head>
<body>
<button class="push_button blue style1 style1" >Similar Document</button>
<pre style="display: none;" id="kota101" class="section">

<table>
<?php
for($r = 0; $r < sizeof($result) && $r < 10; $r++){
		try {
				$transport->open();
				$table = 'url';
				$column = 'url_info:URL';
				$values = ($client->get($table,$result[$r], $column, null));

				foreach ($values as $k=>$v) {
					 $url1 = $v ->value;
				}

				$transport->close();

			} catch (TException $e) {
				print 'TException: '.$e->__toString().' Error: '.$e->getMessage()."\n";
		}
		$content = file_get_contents($url1);
		$title = explode("<title>",$content);
		$title = explode("</title>",$title[1]);
		$title = $title[0];
?>
	<tr>
     	<td><a href="viewdoc.php?url=<?php echo $result[$r]?>&s=<?php echo $status?>"><?php echo $title?></a></td>
    </tr>
<?php
}
?>
</table>

</pre>
<?php
include "teshbase.php";
$obj_url = new  teshbase ();
$url = $obj_url -> select("url",$url,"url_info:URL");
$content = file_get_contents($url);
echo $content;
?>
<script>
var status = 0;
$( "button" ).click(function() {
	if(status == 0){
  		$( "pre" ).show( "slow" );
		status = 1;
	}
	else{
		$( "pre" ).hide( 1000 );
		status = 0;
	}
});
</script>
</body>
</html>
<?php
}
else if($status == 2){
?>
<?php
$filename = '748.pdf'; /* Note: Always use .pdf at the end. */
header("Content-type: application/pdf");
header("Content-Length: " . filesize($filename));
readfile($filename);
}
?>