<?php 

require_once '../../lib/Database.php';
if(isset($_GET['id']) && !empty($_GET['id'])) {
    Database::query('DELETE FROM arsipmasuk WHERE id_arsipmasuk = '.$_GET['id'])->result();
    header("Location:index.php");
} else {
    header("Location:index.php");
}