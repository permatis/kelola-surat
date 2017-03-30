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
        <div class="title"> <span class="glyphicon glyphicon-file" aria-hidden="true"></span>&nbsp; <?php $title = 'Data Surat'; echo $title; ?> </div>
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
                    <th>Nama Surat</th>
                    <th>Nomor Surat</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>File</th>
                    <th class="action">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data = Database::query('select s.id_surat, s.nama_surat, s.nomor_surat, s.deskripsi, s.tgl_perubahan, f.nama, f.namafile, k.nama_kategori FROM surat s LEFT OUTER JOIN filesurat f ON s.filesurat_id = f.id_filesurat LEFT OUTER JOIN kategori k ON s.kategori_id = k.id_kategori')->result();
                $no = 1;
                foreach($data as $d) :
                ?>
                <tr>
                    <td><?=$no++?></td>
                    <td><?=$d['nama_surat']?></td>
                    <td><?=$d['nomor_surat']?></td>
                    <td><?=$d['deskripsi']?></td>
                    <td><?=Kalender::tglWaktu($d['tgl_perubahan']);?></td>
                    <td><?=$d['nama_kategori']?></td>
                    <td>
                        <?php
                            $ext = explode('.', $d['namafile']);
                            $extension = $ext[1];
                            $direktori_tujuan = '../../assets/file/';

                            $gambar = array('png', 'jpg', 'jpeg');
                            $doc = array('doc', 'docx', 'odt');

                            if(in_array($extension, $gambar)){
                                echo '<a class="filesurat" rel="group" href="'.$direktori_tujuan.$d['namafile'].'">'.$d['nama'].'</a>';
                            }elseif(in_array($extension, $doc)){
                                echo '<a href="'.$direktori_tujuan.$d['namafile'].'">'.$d['nama'].'</a>';
                            }else{
                                echo $d['nama'];
                            }
                        ?>
                    </td>
                    <td>
                        <a href="edit.php?id=<?=$d['id_surat']?>" class="btn btn-default btn-xs" aria-label="Left Align" title="Edit">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        </a>
                        <a href="hapus.php?id=<?=$d['id_surat']?>" class="btn btn-default btn-xs" aria-label="Left Align" title="Hapus">
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