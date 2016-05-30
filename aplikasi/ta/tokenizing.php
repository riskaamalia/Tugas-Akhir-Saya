<?php
function tokenizing($content) {
	$content = strtolower($content);
	$content = str_replace(";"," ",$content);
	$content = str_replace("("," ",$content);
	$content = str_replace(")"," ",$content);
	$content = str_replace("?"," ",$content);
	$content = str_replace("!"," ",$content);
	$content = str_replace("\""," ",$content);
	$content = str_replace("'"," ",$content);
	$content = str_replace("["," ",$content);
	$content = str_replace("]"," ",$content);
	$content = str_replace("_"," ",$content);
	$content = str_replace("="," ",$content);
	$content = str_replace("<"," ",$content);
	$content = str_replace(">"," ",$content);
	$content = str_replace("{"," ",$content);
	$content = str_replace("}"," ",$content);
	$content = str_replace("&nbsp"," ",$content);
	$content = trim($content);
	$content = preg_replace("/\s+/"," ",$content);
	$counter1 = 0;
	$counter2 = 0;
	$token[0] = "";
	while(substr($content,$counter1,1) != NULL) {
		$char = substr($content,$counter1,1);
		if(((ord($char) >= 97) && (ord($char) <= 122)) || ((ord($char) >= 48) && (ord($char) <= 57))) {
			$token[$counter2] .= $char;
		}
		else if((ord($char) == 46) || (ord($char) == 44) || (ord($char) == 58) || (ord($char) == 43) || (ord($char) == 42)) {
			if(((ord(substr($content,$counter1+1,1)) >= 48) && (ord(substr($content,$counter1+1,1)) <= 57))) {
				$token[$counter2] .= $char;
			}
			else if(((ord(substr($content,$counter1+1,1)) >= 97) && (ord(substr($content,$counter1+1,1)) <= 122))){
				$counter2++;
				$token[$counter2] = "";
			}
		}
		else if(ord($char) == 32) {
			if(strlen($token[$counter2]) > 0) {
				$counter2++;
				$token[$counter2] = "";
			}
		}
		else if(ord($char) == 45){
			if((ord(substr($content,$counter1-1,1)) >= 97) && (ord(substr($content,$counter1-1,1)) <= 122) && (ord(substr($content,$counter1+1,1)) >= 97) && (ord(substr($content,$counter1+1,1)) <= 122)){
				$token[$counter2] .= $char;
			}
			else if((ord(substr($content,$counter1-1,1)) >= 97) && (ord(substr($content,$counter1-1,1)) <= 122) && (ord(substr($content,$counter1+1,1)) >= 48) && (ord(substr($content,$counter1+1,1)) <= 57)){
				$counter2++;
				$token[$counter2] = "";
			}
			else if((ord(substr($content,$counter1-1,1)) >= 48) && (ord(substr($content,$counter1-1,1)) <= 57) && (ord(substr($content,$counter1+1,1)) >= 48) && (ord(substr($content,$counter1+1,1)) <= 57)){
				$token[$counter2] .= $char;
			}
		}
		else if(ord($char) == 47){
			if((ord(substr($content,$counter1-1,1)) >= 97) && (ord(substr($content,$counter1-1,1)) <= 122) && (ord(substr($content,$counter1+1,1)) >= 97) && (ord(substr($content,$counter1+1,1)) <= 122)){
				$counter2++;
				$token[$counter2] = "";
			}
			else if((ord(substr($content,$counter1-1,1)) >= 97) && (ord(substr($content,$counter1-1,1)) <= 122) && (ord(substr($content,$counter1+1,1)) >= 48) && (ord(substr($content,$counter1+1,1)) <= 57)){
				$counter2++;
				$token[$counter2] = "";
			}
			else if((ord(substr($content,$counter1-1,1)) >= 48) && (ord(substr($content,$counter1-1,1)) <= 57) && (ord(substr($content,$counter1+1,1)) >= 48) && (ord(substr($content,$counter1+1,1)) <= 57)){
				$token[$counter2] .= $char;
			}
		}
		$counter1++;
	}
	return $token;
}
?>