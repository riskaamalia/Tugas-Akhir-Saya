<?php
error_reporting(0);
$page = $_GET["page"];
$keyword = $_GET["key"];
$status = $_GET["s"];
if($status == NULL || ($status != 1 && $status != 2))
	header("Location: result.php?key=$keyword&page=1&s=1");
include "pemrosesan_query.php";
include "cek_validitas_url.php";
$result = pemrosesan_query($keyword,$status);
$hasil = cek_validitas_url($result);
$jumlah_hasil = 5;
$max_page = intval(sizeof($hasil)/$jumlah_hasil);
if($max_page < sizeof($hasil)/$jumlah_hasil)
	$max_page++;
if(($page == NULL || $page < 1 || $page > $max_page)&& $max_page > 0)
	header("Location: result.php?key=$keyword&page=1&s=$status");

include "html_dom_q.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" href="css/styles.css" />
<link rel="shortcut icon" href="../favicon.ico"> 
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link href="css/hexaflip.css" rel="stylesheet" type="text/css">
<link href="css/demo.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/tabs.css">
<script src="js/jquery.js"></script>

</head>

<body>

<div id="pageResult">

<div id="column1">
  <img src="img/logo.png" width="83" height="85"/></div>
<div id"column2"><form id="searchbox" action="">
    <input id="search" type="text" value="<?php echo $keyword?>" name="key">
    <input type="hidden" name="page" value="1"/>
    <input type="hidden" name="s" value="1"/>
    <input name="submit" type="submit" id="submit" value="Search">
</form></div>


	<div id="webresult">
	  <div class="tabContaier">
        <ul>
        <?php
        if($status == 1){
		?>
          <li><a class="active" href="result.php?key=<?php echo $keyword ?>&page=1&s=1">Web</a></li>
          <li><a href="result.php?key=<?php echo $keyword ?>&page=1&s=2">PDF</a></li>
		<?php
		}
		else{
		?>  
         <li><a  href="result.php?key=<?php echo $keyword ?>&page=1&s=1">Web</a></li>
          <li><a  class="active" href="result.php?key=<?php echo $keyword ?>&page=1&s=2">PDF</a></li>
		<?php
		}
		?>  
        </ul>
	    <!-- //Tab buttons -->
        <div class="tabDetails">
          <div id="tab1" class="tabContents">
            <div class="webResult">
            <?php
			if($status == 1){
			if(sizeof($hasil) > 0){
				for($a = ($page-1)*$jumlah_hasil; $a < sizeof($hasil) && $a < $page*$jumlah_hasil; $a++){
				$query = mysql_query("select url from url where id_url = '".$hasil[$a]."'");
				while($row = mysql_fetch_array($query)){
					$url = $row[0];
				}
				$content = file_get_contents($url);
				$title = explode("<title>",$content);
				$title = explode("</title>",$title[1]);
				$title = $title[0];
				$content = explode(' ',html_dom_q($content));
			?>
              <h3><a href="viewdoc.php?url=<?php echo $hasil[$a]?>&s=1" target="_blank"><?php echo $title?></a></h3>
              <p>
              <?php
			  for($b = 0; $b < 200 && $b < sizeof($content); $b++){
				  echo $content[$b].' ';
				  }
			  ?>
              </p>
            <?php
			}
			}
			else{
				echo "No result";
			}
			}			
			?>
            <?php
			if($status == 2){
			if(sizeof($hasil) > 0){
				for($a = ($page-1)*$jumlah_hasil; $a < sizeof($hasil)&& $a < $page*$jumlah_hasil; $a++){
				$query = mysql_query("select url from url where id_url = '".$hasil[$a]."'");
				while($row = mysql_fetch_array($query)){
					$url = $row[0];
				}
				$content = file_get_contents($hasil[$a].'.txt');
				$content = explode(' ',$content);
				if(substr($url,-4,4) == '.pdf'){
					$title = explode('/',$url);
					$titlefix = $title[sizeof($title)-1];
				}
				else{
					$title = explode('.pdf',$url);
					$title1 = explode('=',$title[0]);
					$titlefix = $title1[sizeof($title1)-1];
				}
			?>
              <h3><a href="viewdoc.php?url=<?php echo $hasil[$a]?>&s=2"><?php echo $titlefix ?></a></h3>
              <p>
              <?php
			  for($b = 0; $b < 200 && $b < sizeof($content); $b++){
				  echo $content[$b].' ';
			  }
			  ?>
              </p>
            <?php
			}
			}
			else{
				echo "No result";
			}
			}			
			?>
            </div>
          </div>
          <!-- //tab1 -->
          <!--Pagination Start-->
          <div class="archive-pages">
            <ul>
            <?php
			$previous_page = $page - 1;
			if($previous_page < 1)
				$previous_page = 1;
			$next_page = $page + 1;
			if($next_page > $max_page)
				$next_page = $max_page;
			$last_page = $max_page;
			?>
              <li class="first"><a href="result.php?key=<?php echo $keyword ?>&page=1&s=<?php echo $status?>" title="first page">first page</a></li>
              <li class="previous"><a href="result.php?key=<?php echo $keyword ?>&page=<?php echo $previous_page?>&s=<?php echo $status?>" title="previous page">previous page</a></li>
              <?php
			  $jumlah_halaman = $max_page - $page;
			  if($jumlah_halaman < 5){
			  	if($page - $jumlah_halaman <= 0)
					$awal = 1;
					else
					$awal = $page - 4 + $jumlah_halaman;
				if($awal < 1)
					$awal = 1;
			  	for($a = $awal; $a < $page; $a++){
				?>
                	<li><a href="result.php?key=<?php echo $keyword ?>&page=<?php echo $a?>&s=<?php echo $status?>"><?php echo $a?></a></li>
                <?php
				}
			  }
			  ?>
              <li class="selected"><?php echo $page?></li>
			  <?php
			  for($a = $page+1; $a < sizeof($hasil)/$jumlah_hasil + 1 && $a < $page + 5; $a++){
			  ?>
              <li><a href="result.php?key=<?php echo $keyword ?>&page=<?php echo $a?>&s=<?php echo $status?>"><?php echo $a?></a></li>
              <?php
			  }
			  ?>
              <li class="next"><a href="result.php?key=<?php echo $keyword ?>&page=<?php echo $next_page ?>&s=<?php echo $status?>" title="next page">next page</a></li>
              <li class="last"><a href="result.php?key=<?php echo $keyword ?>&page=<?php echo $last_page ?>&s=<?php echo $status?>" title="last page">last page</a></li>
            </ul>
          </div>
          <!--End-->
        </div>
	    <!-- //tab Details -->
      </div>
	  <!-- //Tab Container -->
</div>
<script type="text/javascript" src="js/tabs.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".tabContents").hide(); // Hide all tab content divs by default
		$(".tabContents:first").show(); // Show the first div of tab content by default
		
		$(".tabContaier ul li a").click(function(){ //Fire the click event
			
			var activeTab = $(this).attr("href"); // Catch the click link
			$(".tabContaier ul li a").removeClass("active"); // Remove pre-highlighted link
			$(this).addClass("active"); // set clicked link to highlight state
			$(".tabContents").hide(); // hide currently visible tab content div
			$(activeTab).fadeIn(); // show the target tab content div by matching clicked link.
			
			return false; //prevent page scrolling on tab click
		});
	});
</script>
</body>
</html>
<?php
include "close_db.php";
?>