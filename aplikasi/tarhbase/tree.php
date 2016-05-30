<?php

	class node_url {
		public $isi;
		public $kiri;
		public $kanan;
		public $status;
	}
	
	class node_term {
		public $isi;
		public $kiri;
		public $kanan;
		public $id;
	}
	
	class node_frek_term {
		public $isi;
		public $kiri;
		public $kanan;
		public $frekuensi;
	}
	
	function isi_tree_url($list_data, &$root, $status) { // crawling
		$p_current;
		for($a = 0; $a < count($list_data); $a++) {
			$p_current = $root;
			while(true) {
				if($list_data[$a] > $p_current->isi) {
					if($p_current->kanan == NULL) {
						$p_new = create_node_url();
						$p_current->kanan = $p_new;
						$p_current = $p_new;
						$p_current->isi = $list_data[$a];
						$p_current->status = $status;
						break;
					}
					$p_current = $p_current->kanan;
				}
				else if($list_data[$a] < $p_current->isi) {
					if($p_current->kiri == NULL) {
						$p_new = create_node_url();
						$p_current->kiri = $p_new;
						$p_current = $p_new;
						$p_current->isi = $list_data[$a];
						$p_current->status = $status;
						break;
					}
					$p_current = $p_current->kiri;
				}
				else {
					break;
				}
			}
		}
	}
	
	function isi_tree_frek_term($list_data, &$root) {
		$p_current;
		if($root == NULL) {
			$root = create_node_frek_term();
			$root->isi = $list_data[0];
			$root->frekuensi = 1;			
		}
		for($a = 1; $a < count($list_data); $a++) {
			$p_current = $root;
			while(true) {
				if($list_data[$a] > $p_current->isi) {
					if($p_current->kanan == NULL) {
						$p_new = create_node_frek_term();
						$p_current->kanan = $p_new;
						$p_current = $p_new;
						$p_current->isi = $list_data[$a];
						$p_current->frekuensi = 1;
						break;
					}
					$p_current = $p_current->kanan;
				}
				else if($list_data[$a] < $p_current->isi) {
					if($p_current->kiri == NULL) {
						$p_new = create_node_frek_term();
						$p_current->kiri = $p_new;
						$p_current = $p_new;
						$p_current->isi = $list_data[$a];
						$p_current->frekuensi = 1;
						break;
					}
					$p_current = $p_current->kiri;
				}
				else {
					$p_current->frekuensi++;
					break;
				}
			}
		}
	}
	
	function isi_tree_term($list_data, &$root,$status,&$i) {
		$p_current;
		if($root == NULL) {
			$root = create_node_frek_term();
			$root->isi = $list_data[0];
			$root->id = $i[0];			
		}
		for($a = 1; $a < count($list_data); $a++) {
			$p_current = $root;
			while(true) {
				if($list_data[$a] > $p_current->isi) {
					if($p_current->kanan == NULL) {
						$p_new = create_node_term();
						$p_current->kanan = $p_new;
						$p_current = $p_new;
						$p_current->isi = $list_data[$a];
						if($status == 0){
							$p_current->id = $i[$a];
						}
						else{
							$p_current->id = $i;
							$i++;
						}
						break;
					}
					$p_current = $p_current->kanan;
				}
				else if($list_data[$a] < $p_current->isi) {
					if($p_current->kiri == NULL) {
						$p_new = create_node_term();
						$p_current->kiri = $p_new;
						$p_current = $p_new;
						$p_current->isi = $list_data[$a];
						if($status == 0){
							$p_current->id = $i[$a];
						}
						else{
							$p_current->id = $i;
							$i++;
						}
						break;
					}
					$p_current = $p_current->kiri;
				}
				else {
					break;
				}
			}
		}
	}
	
	function create_node_url() {
		$p_new = new node_url();
		$p_new->isi = NULL;
		$p_new->kanan = NULL;
		$p_new->kiri = NULL;
		$p_new->status = NULL;
		return $p_new;
	}
	
	function create_node_frek_term() {
		$p_new = new node_frek_term();
		$p_new->isi = NULL;
		$p_new->kanan = NULL;
		$p_new->kiri = NULL;
		$p_new->frekuensi = NULL;
		return $p_new;
	}
	
	function create_node_term() {
		$p_new = new node_term();
		$p_new->isi = NULL;
		$p_new->kanan = NULL;
		$p_new->kiri = NULL;
		$p_new->id = NULL;
		return $p_new;
	}
	
	function inorder_url($p, &$b, &$hasil_inorder) {
		if($p->kiri != NULL) {
			inorder_url($p->kiri, $b, $hasil_inorder);
		}
		if($p->status == 0) {
			$hasil_inorder[$b] = $p->isi;
			$b++;
		}
		if($p->kanan != NULL) {
			inorder_url($p->kanan, $b, $hasil_inorder);
		}
	}
	
	function inorder_frek_term($p, &$b, &$hasil_inorder) {
		if($p->kiri != NULL) {
			inorder_frek_term($p->kiri, $b, $hasil_inorder);
		}
		$hasil_inorder[0][$b] = $p->isi;
		$hasil_inorder[1][$b] = $p->frekuensi;
		$b++;
		if($p->kanan != NULL) {
			inorder_frek_term($p->kanan, $b, $hasil_inorder);
		}
	}
	
	function search_tree($term,$root){
		$p = $root;
		while($p != NULL){
			if($term > $p->isi){
				$p = $p->kanan;
			}
			else if($term < $p->isi){
				$p = $p->kiri;
			}
			else{
				return $p->id;
			}
		}
	}
	
	function echo_tree($root){
		$p = $root;
		if($p->kiri != NULL) {
			echo_tree($p->kiri);
		}
		echo $p->isi.'<br>';
		if($p->kanan != NULL) {
			echo_tree($p->kanan);
		}
	}
	
?>