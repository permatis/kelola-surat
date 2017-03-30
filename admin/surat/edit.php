<?php
if( !session_id() ) session_start();
if (!isset($_SESSION['admin'])){ header("Location: ../../index.php");exit;}

require_once '../../lib/Database.php';
require_once '../../lib/tbs_class.php';
require_once '../../lib/tbs_plugin_opentbs.php';
require_once '../../lib/Image.php';

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $s = Database::query('select s.id_surat, s.nama_surat, s.nomor_surat, s.deskripsi, s.tgl_perubahan, s.kategori_id, s.tipe_arsip, f.id_filesurat, f.namafile FROM surat s INNER JOIN filesurat f ON s.filesurat_id = f.id_filesurat WHERE s.id_surat ='.$_GET['id'])->result();
    
    if(empty($s))header("Location:index.php");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data_surat = array_splice($_POST, 0, 5);
        $data_surat = array_merge($data_surat, array('tgl_pembuatan' => date("Y-m-d H:m:s")));
        if($_FILES['filesurat']['name'] != '' && $_FILES['filesurat']['type'] != ''){
            $ext = explode('.', $_FILES['filesurat']['name']);
            $extension = $ext[1];

            $namafile = rtrim(str_replace(' ', '_', $data_surat['nama_surat']),'_');
            $namafile = date("dmY").'-'.$namafile.'.'.$extension;
            $template = '../../assets/data/'.$_FILES['filesurat']['name'];
            $direktori_tujuan = '../../assets/file/';

            Database::query('DELETE FROM filesurat WHERE id_filesurat = '.$s[0]['id_filesurat'])->result();
            unlink($direktori_tujuan.$s[0]['namafile'].$extension);

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
            Database::update('surat', $id_filesurat)->where('id_surat', '=', $_GET['id'])->result();
        }
        Database::update('surat', $data_surat)->where('id_surat', '=', $_GET['id'])->result();
        header("Location:index.php");
    }
}else {
    header("Location:index.php");
}


require_once '../layouts/header.php';
require_once '../layouts/navbar.php';
require_once '../layouts/sidebar.php';

?>
<div id="content">
    <div class="table-information">
        <div class="title"> <span class="glyphicon glyphicon-file" aria-hidden="true"></span>&nbsp; Edit Surat </div>
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
                    <input type="text" name="nama_surat" placeholder="Nama Surat" class="form-control" value="<?=$s[0]['nama_surat']?>">
                </div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim incidunt, at ipsum illo eos ipsam veritatis vero fugiat nihil ratione magnam id! Maiores, distinctio aperiam. Architecto quam voluptatum ipsum. Ipsum?
            </div>
            <div class="form-group">
                <label for="nomor_surat" class="col-sm-2 control-label">Nomor Surat</label>
                <div class="col-sm-10">
                    <input type="text" name="nomor_surat" placeholder="Nomor Surat" class="form-control" value="<?=$s[0]['nomor_surat']?>">
                </div>
            </div>
            <div class="form-group">
                <label for="deskripsi" class="col-sm-2 control-label">Deskripsi</label>
                <div class="col-sm-10">
                    <textarea name="deskripsi" placeholder="Deskripsi" class="form-control ckeditor"><?=$s[0]['deskripsi']?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="filesurat" class="col-sm-2 control-label">File Surat  
                    <a data-toggle="tooltip" data-original-title="Max. ukuran file 2MB. Tipe file hanya JPG, JPEG, PNG, DOCX, ODT." id="filesurat">
                        <span class="glyphicon glyphicon-info-sign"></span>
                    </a>
                </label>
                <div class="col-sm-10">
                    <input type="file" name="filesurat" class="">
                </div>
            </div>
            <div class="form-group">
                <label for="kategori_id" class="col-sm-2 control-label">Kategori Surat</label>
                <div class="col-sm-10">
                    <select name="kategori_id" class="form-control" id="kategori_id">
                    <option value="">-- Pilih Kategori Surat --</option>
                        <?php
                        $kat = Database::query('SELECT id_kategori, nama_kategori FROM kategori')->result();
                        foreach ($kat as $k) : 
                        ?>
                        <option value="<?=$k['id_kategori']?>" <?php if($s[0]['kategori_id'] == $k['id_kategori']) echo 'selected';?>><?=$k['nama_kategori']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="tipe_arsip" class="col-sm-2 control-label">Tipe Arsip Surat</label>
                <div class="col-sm-10">
                    <select name="tipe_arsip" class="form-control" id="kategori_id">
                        <option value="">-- Pilih Tipe Arsip Surat --</option>
                        <option value="0" <?php if($s[0]['tipe_arsip'] == '0') echo 'selected';?>>Arsip Masuk</option>
                        <option value="1" <?php if($s[0]['tipe_arsip'] == '1') echo 'selected';?>>Arsip Keluar</option>
                    </select>
                </div>
            </div>
            <div id="group">
            <?php
            $kat = Database::query('SELECT nama_content, nama_string, tipe FROM kategori_content WHERE kategori_id = '.$s[0]['kategori_id'])->result();
            $tipe = '';
            if (!empty($kat)) {
                foreach ($kat as $val) :
                   switch ($val['tipe']) {
                       case 'number':
                           $tipe = '<input type="number" name="'.$val['nama_string'].'" placeholder="'.$val['nama_content'].'" class="form-control"/>';
                           break;
                       case 'textarea':
                           $tipe = '<textarea name="'.$val['nama_string'].'" placeholder="'.$val['nama_content'].'" class="form-control"></textarea>';
                           break;
                       default:
                           $tipe = '<input type="text" name="'.$val['nama_string'].'" placeholder="'.$val['nama_content'].'" class="form-control"/>';
                           break;
                   }
                    ?>
                    <div class="form-group">
                        <div class="col-sm-2 control-label" for="<?=$val['nama_string']?>"><?=$val['nama_content']?></div>
                        <div class="col-sm-10">
                            <?=$tipe?>
                        </div>
                    </div>
                <?php 
               endforeach;
            }
            ?>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php require_once '../layouts/footer.php'; ?>