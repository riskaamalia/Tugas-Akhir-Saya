<?php
$myURL = 'Combinations.htm';
$content = file_get_contents($myURL);
$content = explode("<title>",$content);
$content = explode("</title>",$content[1]);
echo $content[0];
?>