<?php
if( !session_id() ) session_start();
if (!isset($_SESSION['admin'])){ header("Location: ../admin.php");exit;}

require_once 'layouts/header.php';
require_once 'layouts/navbar.php';
require_once 'layouts/sidebar.php';
?>
<div id="content">
    <div class="table-information">
            <div class="content">
            <div class="title"> <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp; Halaman Administration</div>
            </div>
    </div>
    <div class="tables">
        <h3 class="text-center">Selamat Datang di Halaman Utama.</h3>
    </div>
</div>
<?php require_once 'layouts/footer.php'; ?>
