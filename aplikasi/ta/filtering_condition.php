<?php
include "combination.php";

function filtering_condition($token){
$b = 0;
$c = 0;
for($a = 0; $a < sizeof($token); $a++){
	if($token[$a] == "or"){
		$c = 0;
		$b = $b + 1;
		//echo '<hr>';
	}
	else if($token[$a] != "and"){
		$temp[$b][$c] = $token[$a];
		//echo $temp[$b][$c].' ';
		$c = $c + 1;
	}
}
//echo sizeof($temp);
if(sizeof($temp) > 1){
	$n = 0;
	for($a = 0; $a < sizeof($temp); $a++){
		$y = 0;
		for($c = 0; $c < sizeof($temp); $c++){
			if($c != $a){
				for($d = 0; $d < sizeof($temp[$c]); $d++){
					$x[$y] = $temp[$c][$d];
					$y = $y + 1;
				}
			}
		}
		$hasil_combination = combination($x);
		//echo sizeof($hasil_combination);
		$m = 0;
		for($d = 0; $d < sizeof($temp[$a]); $d++){
				$key_kombinasi[$n][$m] = $temp[$a][$d];
				$m++;
			}
			$n++;
		for($b = 1; $b < sizeof($hasil_combination); $b++){
			$m = 0;
			for($d = 0; $d < sizeof($temp[$a]); $d++){
				$key_kombinasi[$n][$m] = $temp[$a][$d];
				$m++;
			}
			for($c = 0; $c < sizeof($hasil_combination[$b]); $c++){
				$key_kombinasi[$n][$m] = $hasil_combination[$b][$c];
				$m++;
			}
			$n++;
		}
	}
}
else{
	$key_kombinasi[0] = $temp[0];
}
return $key_kombinasi;
}
?>