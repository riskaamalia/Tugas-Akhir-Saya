<?php
function combination($token){
$count = 0;
	for($i = 1; $i < (1 << sizeof($token)); $i++){
	$b = 0;
		for($j = 0; $j < sizeof($token); $j++){
			if($i & (1 << $j)){
				$hasil_combination[$count][$b] = $token[$j];
				$b = $b + 1;
			}
		}
		$count = $count + 1;
	}
return $hasil_combination;
}

?>