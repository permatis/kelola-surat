<?php
if( !session_id() ) session_start();
if (!isset($_SESSION['admin'])){ header("Location: ../../index.php");exit;}

require_once '../../lib/Database.php';
require_once '../../lib/tbs_class.php';
require_once '../../lib/tbs_plugin_opentbs.php';
require_once '../../lib/Image.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    Database::insert('arsipkeluar', $_POST);
    header("Location:index.php");
}


require_once '../layouts/header.php';
require_once '../layouts/navbar.php';
require_once '../layouts/sidebar.php';

?>
<div id="content">
    <div class="table-information">
        <div class="title"> <span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span>&nbsp; Buat Arsip Keluar </div>
        <div class="right">
            <a href="index.php" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> &nbsp; Back
            </a>
        </div>
    </div>
    <div class="tables">
        <form action="" method="post" class="form-horizontal">
            <div class="form-group">
                <label for="tanggal" class="col-sm-2 control-label">Tanggal Keluar</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <label class="input-group-btn" for="date-fld">
                            <span class="btn btn-default">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </label>
                        <input type="text" class="form-control datepicker" name="tanggal" placeholder="Tanggal Keluar"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="kategori_id" class="col-sm-2 control-label">Kategori Surat</label>
                <div class="col-sm-10">
                    <select name="kategori_id" class="form-control" id="kat_keluar">
                        <option value="">Pilih Kategori Surat</option>
                        <?php
                        $kat = Database::query('SELECT k.id_kategori, k.nama_kategori FROM kategori k INNER JOIN surat s ON k.id_kategori = s.kategori_id WHERE s.tipe_arsip = 1')->result();
                        foreach ($kat as $k) : 
                        ?>
                        <option value="<?=$k['id_kategori']?>"><?=$k['nama_kategori']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="surat_id" class="col-sm-2 control-label">Nama Surat</label>
                <div class="col-sm-10">
                    <select name="surat_id" class="form-control" id="surats">
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="kepada" class="col-sm-2 control-label">Kepada</label>
                <div class="col-sm-10">
                    <input type="text" name="kepada" placeholder="Kepada" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="keperluan" class="col-sm-2 control-label">Keperluan</label>
                <div class="col-sm-10">
                    <textarea name="keperluan" placeholder="Keperluan" class="form-control ckeditor"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="keterangan" class="col-sm-2 control-label">Keterangan</label>
                <div class="col-sm-10">
                    <textarea name="keterangan" placeholder="Keterangan" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php require_once '../layouts/footer.php'; ?>