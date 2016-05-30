<?php

function html_dom($url_web)
{
	$content = "";
	$a = 0;
	$status = 0;
	$homepage = file_get_contents($url_web);
	do{
	$char = substr($homepage,$a,1);
		if($char == '<'){
		if(substr($homepage,$a+1,1) == 'p')
			$status = 1;
		else if(substr($homepage,$a+2,1) == 'p' && $status == 1)
			{$content = $content." ";
			$status = 0;}
		else if(substr($homepage,$a+1,2) == 'h1')
			$status = 2;
		else if(substr($homepage,$a+1,3) == '/h1' && $status == 2)
			{$content = $content." ";
			$status = 0;}
		else if(substr($homepage,$a+1,2) == 'h2')
			$status = 3;
		else if(substr($homepage,$a+1,3) == '/h2' && $status == 3)
			{$content = $content." ";
			$status = 0;}
		else if(substr($homepage,$a+1,2) == 'h3')
			$status = 4;
		else if(substr($homepage,$a+1,3) == '/h3' && $status == 4)
			{$content = $content." ";
			$status = 0;}
		
		do{
			$a++;
			$char = substr($homepage,$a,1);
			}while($char != '>');
		}
		else {
			if($status == 1 || $status == 2 || $status == 3 || $status == 4)
				$content = $content.$char;
		}
	$a++;
	}while($char != NULL);
	return $content;
}

?>