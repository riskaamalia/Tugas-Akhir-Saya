<?php
function cek_keberadaan_abstraksi($content){
$list_word = tokenizing($content);
for($a = 0; $a <= 2000 && $a < strlen($content); $a++){
	if(substr($list_word[$a],0,8) == "abstract")
	break;
}

if($a != 2001){
	for($b = $a + 1; $b <= 3000 && $b < strlen($content); $b++){
		if($list_word[$b] == "introduction")
		break;
	}
}

$abstrak = "";
if($b != 3001){
	for($c = $a + 1; $c <= $b - 1 && $c < strlen($content); $c++){
		$abstrak .= ' '.$list_word[$c];
	}
}
return $abstrak;
}

?>