<?php 
require_once '../../lib/Database.php';
require_once '../../lib/Image.php';
if(isset($_GET['id']) && !empty($_GET['id'])) {
    Database::query('DELETE FROM arsipmasuk WHERE surat_id = '.$_GET['id'])->result();
    Database::query('DELETE FROM arsipkeluar WHERE surat_id = '.$_GET['id'])->result();

    $filesurat = Database::query('SELECT f.id_filesurat, f.namafile FROM filesurat f INNER JOIN surat s ON f.id_filesurat = s.filesurat_id WHERE s.id_surat = '.$_GET['id'])->result();
    if(!empty($filesurat)){
        unlink('../../assets/file/'.$filesurat[0]['namafile']);
        Database::query('DELETE FROM filesurat WHERE id_filesurat = '.$filesurat[0]['id_filesurat'])->result();
        Database::query('DELETE FROM surat WHERE id_surat = '.$_GET['id'])->result();
    }

    Database::query('DELETE FROM surat WHERE id_surat = '.$_GET['id'])->result();
    header("Location:index.php");
} else {
    header("Location:index.php");
}