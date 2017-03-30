<?php 
require_once '../lib/Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$data = Database::query("SELECT s.id_surat, s.nama_surat FROM kategori k INNER JOIN surat s ON k.id_kategori = s.kategori_id WHERE k.id_kategori = ".$_POST['id']." AND s.tipe_arsip = 0")->result();
	if (empty($data)){ 
	     return false;
	}else{
		echo json_encode($data);
	}
}

