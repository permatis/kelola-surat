<?php 
require_once '../../lib/Database.php';
if(isset($_GET['id']) && !empty($_GET['id'])) {
    Database::query('DELETE FROM kategori_content WHERE kategori_id = '.$_GET['id'])->result();
    Database::query('UPDATE surat SET kategori_id = 0 WHERE kategori_id = '.$_GET['id'])->result();
    Database::query('DELETE FROM kategori WHERE id_kategori = '.$_GET['id'])->result();
    header("Location:index.php");
} else {
    header("Location:index.php");
}