<?php
if( !session_id() ) session_start();
if (!isset($_SESSION['admin'])){ header("Location: ../../index.php");exit;}

require_once '../../lib/Database.php';
require_once '../../lib/tbs_class.php';
require_once '../../lib/tbs_plugin_opentbs.php';
require_once '../../lib/Image.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_surat = array_splice($_POST, 0, 5);
    $data_surat = array_merge($data_surat, array('tgl_pembuatan' => date("Y-m-d H:m:s"), 'tgl_perubahan' => date("Y-m-d H:m:s")));
//var_dump($data_surat);
    if($_FILES['filesurat']['name'] != '' && $_FILES['filesurat']['type'] != ''){

        $ext = explode('.', $_FILES['filesurat']['name']);
        $extension = $ext[1];

        $namafile = rtrim(str_replace(' ', '_', $data_surat['nama_surat']),'_');
        $namafile = date("dmY").'-'.$namafile.'.'.$extension;
        $template = '../../assets/data/'.$_FILES['filesurat']['name'];
        $direktori_tujuan = '../../assets/file/';

        $filesurat = Database::query('select id_filesurat from filesurat')->result();
        $id_filesurat = (empty($filesurat) ? '1' : $filesurat[count($filesurat)-1]['id_filesurat']+1);

        if($_FILES['filesurat']['type'] == 'application/msword' || $_FILES['filesurat']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
            $tbs = new clsTinyButStrong;
            $tbs->plugin(TBS_INSTALL, OPENTBS_PLUGIN);
            $tbs->LoadTemplate($template, OPENTBS_ALREADY_UTF8);
            if(!empty($_POST)){
                $surat = array_merge(array('nomor_surat' => $data_surat['nomor_surat']), $_POST);
                $tbs->mergeField('surat', $surat);
            }else{
                $tbs->mergeField('surat', array('nomor_surat' => $data_surat['nomor_surat']));
            }
            $tbs->Show(OPENTBS_FILE, $direktori_tujuan.$namafile); 
            Database::query("INSERT INTO filesurat (id_filesurat, nama, namafile, tgl_pembuatan, tgl_perubahan) VALUES ('".$id_filesurat."','".$data_surat['nama_surat']."','".$namafile."','".date("Y-m-d H:m:s")."','".date("Y-m-d H:m:s")."')")->result();
        }else {
            //simpan gambar
            $img = new Image();
            $img->save($direktori_tujuan);
            $img->imageFile;
            Database::query("INSERT INTO filesurat (id_filesurat, nama, namafile, tgl_pembuatan, tgl_perubahan) VALUES ('".$id_filesurat."','".$img->imageName."','".$img->imageFile."','".date("Y-m-d H:m:s")."','".date("Y-m-d H:m:s")."')")->result();
        }

        $id_filesurat = array_merge($data_surat, array('filesurat_id' => $id_filesurat));
        $id_filesurat = array_map(function($str) {
            return "'".$str."'";
        }, $id_filesurat);
        Database::query("INSERT INTO surat (nama_surat, nomor_surat, deskripsi,  kategori_id, tipe_arsip, tgl_pembuatan, tgl_perubahan, filesurat_id) VALUES (".implode(',', $id_filesurat).")")->result();
    }else {
        Database::insert('surat', $data_surat);
    }
    header("Location:index.php");
}


require_once '../layouts/header.php';
require_once '../layouts/navbar.php';
require_once '../layouts/sidebar.php';

?>
<div id="content">
    <div class="table-information">
        <div class="title"> <span class="glyphicon glyphicon-file" aria-hidden="true"></span>&nbsp; Buat Surat </div>
        <div class="right">
            <a href="index.php" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> &nbsp; Back
            </a>
        </div>
    </div>
    <div class="tables">
        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_surat" class="col-sm-2 control-label">Nama Surat</label>
                <div class="col-sm-10">
                    <input type="text" name="nama_surat" placeholder="Nama Surat" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="nomor_surat" class="col-sm-2 control-label">Nomor Surat</label>
                <div class="col-sm-10">
                    <input type="text" name="nomor_surat" placeholder="Nomor Surat" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="deskripsi" class="col-sm-2 control-label">Deskripsi</label>
                <div class="col-sm-10">
                    <textarea name="deskripsi" placeholder="Deskripsi" class="form-control ckeditor"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="filesurat" class="col-sm-2 control-label">File Surat 
                    <a data-toggle="tooltip" data-original-title="Max. ukuran file 2MB. Tipe file hanya JPG, JPEG, PNG, DOCX, ODT." id="filesurat">
                        <span class="glyphicon glyphicon-info-sign"></span>
                    </a>
                </label>
                <div class="col-sm-10">
                    <input type="file" name="filesurat" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="kategori_id" class="col-sm-2 control-label">Kategori Surat</label>
                <div class="col-sm-10">
                    <select name="kategori_id" class="form-control" id="kategori_id">
                        <option value="">Pilih Kategori Surat</option>
                        <?php
                        $kat = Database::query('SELECT id_kategori, nama_kategori FROM kategori')->result();
                        foreach ($kat as $k) : 
                        ?>
                        <option value="<?=$k['id_kategori']?>"><?=$k['nama_kategori']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="tipe_arsip" class="col-sm-2 control-label">Tipe Arsip Surat</label>
                <div class="col-sm-10">
                    <select name="tipe_arsip" class="form-control">
                        <option value="">Pilih Tipe Arsip Surat</option>
                        <option value="0">Arsip Masuk</option>
                        <option value="1">Arsip Keluar</option>
                    </select>
                </div>
            </div>
            <div id="group">
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