<?php
if( !session_id() ) session_start();
if (!isset($_SESSION['admin'])){ header("Location: ../../index.php");exit;}

require_once '../../lib/Database.php';
require_once '../../lib/Kalender.php';
require_once '../layouts/header.php';
require_once '../layouts/navbar.php';
require_once '../layouts/sidebar.php';

?>
<div id="content">
    <div class="table-information">
        <div class="title"> <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp; Data Kategori </div>
        <div class="right">
            <a href="tambah.php" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> &nbsp; Add New
            </a>
        </div>
    </div>
    <div class="tables">
        <table class="table table-bordered table-condensed table-hover table-striped" id="example">
            <thead>
                <tr>
                    <th class="cx">No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Tipe Content</th>
                    <th>Tanggal</th>
                    <th class="action">Action</th>
                </tr>
               
            </thead>
            <tbody>
                <?php
                $data = Database::query('select id_kategori, nama_kategori, deskripsi, pilihan, tgl_perubahan FROM kategori')->result();
                $no = 1;
                foreach($data as $d) :
                ?>
                <tr>
                    <td><?=$no++?></td>
                    <td><?=$d['nama_kategori']?></td>
                    <td><?=$d['deskripsi']?></td>
                    <td><?=$d['pilihan']?></td>
                    <td><?=Kalender::tglWaktu($d['tgl_perubahan']);?></td>
                    <td>
                        <a href="edit.php?id=<?=$d['id_kategori']?>" class="btn btn-default btn-xs" aria-label="Left Align" title="Edit">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        </a>
                        <a href="hapus.php?id=<?=$d['id_kategori']?>" class="btn btn-default btn-xs" aria-label="Left Align" title="Hapus">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../layouts/footer.php'; ?>