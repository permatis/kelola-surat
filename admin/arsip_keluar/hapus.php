<?php 

require_once '../../lib/Database.php';
if(isset($_GET['id']) && !empty($_GET['id'])) {
    Database::query('DELETE FROM arsipkeluar WHERE id_arsipkeluar = '.$_GET['id'])->result();
    header("Location:index.php");
} else {
    header("Location:index.php");
}