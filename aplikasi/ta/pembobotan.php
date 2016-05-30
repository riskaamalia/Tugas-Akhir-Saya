<?php
	set_time_limit(0);
	ini_set("memory_limit","-1");
	include "connect_db.php";
	include "TF_IDF.php";
	
	TF_IDF();
	//exec("matlab -nodesktop -nodisplay -r \"lsa_pdf\"");
	
	include "close_db.php";
?>