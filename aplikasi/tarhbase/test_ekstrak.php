<?php
	set_time_limit(0);
	error_reporting(0);
	include "html_dom.php";
	include "tokenizing.php";
	include "filtering_stoplist.php";
	include "stemming.php";
	include "tree.php";
	
	$url = "http://en.wikipedia.org/wiki/Computer";
	$content = html_dom($url);
	$contents = tokenizing($content);
	$content = " ";	
	for($o = 0; $o < count($contents); $o++){
		$content .= $contents[$o].' ';
	}
	$content = filtering_stoplist($content);
	$porter = new PorterStemmer();
	for($o = 0 ; $o < count($content); $o++){
		$content[$o] =  $porter->Stem($content[$o]);
		echo $content[$o] . " ";
	}
	echo "<hr>";
	$id_now = 0;
	$temp = $id_now;
	isi_tree_term($content, $root_term, 1,$id_now);
	isi_tree_frek_term($content, $root);
	$b = 0;
	inorder_frek_term($root, $b, $hasil_inorder);
	for($a = 0; $a < count($hasil_inorder[0]); $a++) {
		echo $hasil_inorder[0][$a] . " ";
	}
	echo "<hr>";
	$root = NULL;
	$hasil_inorder = NULL;
	$url = "http://en.wikipedia.org/wiki/Laptop";
	$content = html_dom($url);
	$contents = tokenizing($content);
	$content = " ";	
	for($o = 0; $o < count($contents); $o++){
		$content .= $contents[$o].' ';
	}
	$content = filtering_stoplist($content);
	$porter = new PorterStemmer();
	for($o = 0 ; $o < count($content); $o++){
		$content[$o] =  $porter->Stem($content[$o]);
		echo $content[$o] . " ";
	}
	echo "<hr>";
	$id_now = 0;
	$temp = $id_now;
	isi_tree_term($content, $root_term, 1,$id_now);
	isi_tree_frek_term($content, $root);
	$b = 0;
	inorder_frek_term($root, $b, $hasil_inorder);
	for($a = 0; $a < count($hasil_inorder[0]); $a++) {
		echo $hasil_inorder[0][$a] . " ";
	}
	echo "<hr>";
	$root = NULL;
	$hasil_inorder = NULL;
	$url = "http://en.wikipedia.org/wiki/Earth";
	$content = html_dom($url);
	$contents = tokenizing($content);
	$content = " ";	
	for($o = 0; $o < count($contents); $o++){
		$content .= $contents[$o].' ';
	}
	$content = filtering_stoplist($content);
	$porter = new PorterStemmer();
	for($o = 0 ; $o < count($content); $o++){
		$content[$o] =  $porter->Stem($content[$o]);
		echo $content[$o] . " ";
	}
	echo "<hr>";
	$id_now = 0;
	$temp = $id_now;
	isi_tree_term($content, $root_term, 1,$id_now);
	isi_tree_frek_term($content, $root);
	$b = 0;
	inorder_frek_term($root, $b, $hasil_inorder);
	for($a = 0; $a < count($hasil_inorder[0]); $a++) {
		echo $hasil_inorder[0][$a] . " ";
	}
	echo "<hr>";
	$root = NULL;
	$hasil_inorder = NULL;
	$url = "http://en.wikipedia.org/wiki/Indonesia";
	$content = html_dom($url);
	$contents = tokenizing($content);
	$content = " ";	
	for($o = 0; $o < count($contents); $o++){
		$content .= $contents[$o].' ';
	}
	$content = filtering_stoplist($content);
	$porter = new PorterStemmer();
	for($o = 0 ; $o < count($content); $o++){
		$content[$o] =  $porter->Stem($content[$o]);
		echo $content[$o] . " ";
	}
	echo "<hr>";
	$id_now = 0;
	$temp = $id_now;
	isi_tree_term($content, $root_term, 1,$id_now);
	isi_tree_frek_term($content, $root);
	$b = 0;
	inorder_frek_term($root, $b, $hasil_inorder);
	for($a = 0; $a < count($hasil_inorder[0]); $a++) {
		echo $hasil_inorder[0][$a] . " ";
	}
	echo "<hr>";
	$root = NULL;
	$hasil_inorder = NULL;
	$url = "http://en.wikipedia.org/wiki/Republik_Indonesia";
	$content = html_dom($url);
	$contents = tokenizing($content);
	$content = " ";	
	for($o = 0; $o < count($contents); $o++){
		$content .= $contents[$o].' ';
	}
	$content = filtering_stoplist($content);
	$porter = new PorterStemmer();
	for($o = 0 ; $o < count($content); $o++){
		$content[$o] =  $porter->Stem($content[$o]);
		echo $content[$o] . " ";
	}
	echo "<hr>";
	$id_now = 0;
	$temp = $id_now;
	isi_tree_term($content, $root_term, 1,$id_now);
	isi_tree_frek_term($content, $root);
	$b = 0;
	inorder_frek_term($root, $b, $hasil_inorder);
	for($a = 0; $a < count($hasil_inorder[0]); $a++) {
		echo $hasil_inorder[0][$a] . " ";
	}
?>