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
        <div class="title"> <span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span>&nbsp; Data Arsip Masuk </div>
        <div class="right">
            <a href="tambah.php" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> &nbsp; Add New
            </a>
        </div>
    </div>
    <div class="tables">
        <div class="row">
            <label class="col-xs-1 control-label">Pilih Tahun</label>
            <div class="col-xs-2">
            <select id="tahun" class="form-control">
                <?php 
                    for ($i=2012; $i <= date("Y") ; $i++) { 
                        echo "<option value='".$i."' ".(($i== date('Y')) ? 'selected':'').">".$i."</option>";
                    }
                ?>
            </select>
            </div>
        </div>
        <table class="table table-bordered table-condensed table-hover table-striped" id="example">
            <thead>
                <tr>
                    <th class="cx">No</th>
                    <th>Tanggal</th>
                    <th>Nama Surat</th>
                    <th>Kategori Surat</th>
                    <th>Pengirim</th>
                    <th>Keperluan</th>
                    <th>Keterangan</th>
                    <th class="action">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data = Database::query('select ap.*, s.nama_surat, k.nama_kategori FROM arsipmasuk ap INNER JOIN surat s ON s.id_surat = ap.surat_id INNER JOIN kategori k ON s.kategori_id = k.id_kategori GROUP BY s.kategori_id, ap.pengirim')->result();
                $no = 1;
                foreach($data as $d) :
                ?>
                <tr>
                    <td><?=$no++?></td>
                    <td><?=Kalender::tglNormal($d['tanggal']);?></td>
                    <td><?=$d['nama_surat']?></td>
                    <td><?=$d['nama_kategori']?></td>
                    <td><?=$d['pengirim']?></td>
                    <td><?=$d['keperluan']?></td>
                    <td><?=$d['keterangan']?></td>
                    <td>
                        <a href="edit.php?id=<?=$d['id_arsipmasuk']?>" class="btn btn-default btn-xs" aria-label="Left Align" title="Edit">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        </a>
                        <a href="hapus.php?id=<?=$d['id_arsipmasuk']?>" class="btn btn-default btn-xs" aria-label="Left Align" title="Hapus">
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