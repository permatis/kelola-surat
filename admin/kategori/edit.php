<?php
if( !session_id() ) session_start();
if (!isset($_SESSION['admin'])){ header("Location: ../../index.php");exit;}

require_once '../../lib/Database.php';
require_once '../../lib/Image.php';

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $k = Database::query('SELECT * FROM kategori WHERE id_kategori ='.$_GET['id'])->result();
    if(empty($k))header("Location:index.php");
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //tabel kategori
        $data_kategori = array_splice($_POST, 0, 3);
        $data_kategori = array_merge($data_kategori, array('tgl_perubahan' => date("Y-m-d H:m:s")));
        foreach ($data_kategori as $a => $b) {
            $dk[] = $a."='".$b."'";
        }
        Database::query("UPDATE kategori SET ".implode(',', $dk)." WHERE id_kategori = ".$_GET['id'])->result();
        if($data_kategori['pilihan'] == 'statis') {
            if($k[0]['pilihan'] == 'dinamis'){
                Database::query('DELETE FROM kategori_content WHERE kategori_id ='. $_GET['id'])->result();
            }
        }

        if(!empty($_POST['data_input']) && !empty($_POST['type_input'])){
            Database::query('DELETE FROM kategori_content WHERE kategori_id ='. $_GET['id'])->result();

            foreach ($_POST['data_input'] as $key => $value) {
                $data_content[] = [
                    'kategori_id'   => $_GET['id'],
                    'nama_content'  => ucwords(strtolower($value)),
                    'nama_string'   => strtolower(preg_replace("/[^A-Za-z0-9]/", "", $value)),
                    'tipe'          => $_POST['type_input'][$key],
                ];
            }
            foreach ($data_content as $k => $v) {
                foreach ($v as $ky => $val) {
                    $vs[$ky] = "'".$val."'";
                }
                $nilai[] = "(".implode(',', $vs).")";
            }
            Database::query("INSERT INTO kategori_content (kategori_id, nama_content, nama_string, tipe) VALUES ".implode(',', $nilai))->result();
        }
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
        <div class="title"> <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp; Buat Kategori </div>
        <div class="right">
            <a href="index.php" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> &nbsp; Back
            </a>
        </div>
    </div>
    <div class="tables">
        <form action="" method="post" id="kategori" class="form-horizontal">
            <div class="form-group">
                <label for="nama_kategori" class="col-sm-2 control-label">Nama Kategori</label>
                <div class="col-sm-10">
                    <input type="text" name="nama_kategori" placeholder="Nama Kategori" class="form-control" value="<?=$k[0]['nama_kategori']?>">
                </div>
            </div>
            <div class="form-group">
                <label for="deskripsi" class="col-sm-2 control-label">Deskripsi</label>
                <div class="col-sm-10">
                    <textarea name="deskripsi" placeholder="Deskripsi" class="form-control" id="deskripsi"><?=$k[0]['nama_kategori']?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="nama_kategori" class="col-sm-2 control-label">Pilih Isi Content</label>
                <div class="col-sm-10">
                    <label><input type="radio" name="pilihan" value="statis" <?php if($k[0]['pilihan'] == 'statis') echo 'checked="checked"';?>> Statis</label> &nbsp;
                    <label><input type="radio" name="pilihan" value="dinamis" <?php if($k[0]['pilihan'] == 'dinamis') echo 'checked="checked"';?>> Dinamis</label>
                </div>
            </div>

            <div id="data_input" <?php echo ($k[0]['pilihan'] == 'dinamis') ? 'style="display: block;"' : 'style="display: none;"' ?>>
                <div class="form-group">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                        <input type="button" id="tambah" value="Tambahkan input" class="btn btn-default btn-sm">
                    </div>
                </div>
                <?php
                if($k[0]['pilihan'] == 'dinamis') :
                    $data_input = Database::query('SELECT * FROM kategori_content WHERE kategori_id = '.$k[0]['id_kategori'])->result();
                    foreach ($data_input as $i) :
                ?>
                <div class="data_inputs">
                    <div class="form-group">  
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" name="data_input[]" placeholder="<?=$i['nama_content']?>" class="form-control" <?php if($k[0]['pilihan'] != 'dinamis'): ?>disabled="disabled"<?php endif;?> value="<?=$i['nama_content']?>">
                                </div>
                                <div class="col-sm-6">
                                    <select name="type_input[]" class="form-control" <?php if($k[0]['pilihan'] != 'dinamis'): ?>disabled="disabled"<?php endif;?>>
                                        <option value="text"<?php if($i['tipe'] == 'text') echo 'selected'; ?>>Text</option>
                                        <option value="number"<?php if($i['tipe'] == 'number') echo 'selected'; ?>>Number</option>
                                        <option value="textarea"<?php if($i['tipe'] == 'textarea') echo 'selected'; ?>>Textarea</option>
                                    </select>
                                </div>
                            </div>
                            <div id="hapus_input">&nbsp;<a href="javascript:void(0);" id="hapus" title="Hapus Input">x</a></div>
                        </div>
                    </div>
                </div>
                <?php
                    endforeach; 
                    else : 
                ?>
                <div class="data_inputs">
                    <div class="form-group">  
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" name="data_input[]" placeholder="Data Input" class="form-control" <?php if($k[0]['pilihan'] != 'dinamis'): ?>disabled="disabled"<?php endif;?>>
                                </div>
                                <div class="col-sm-6">
                                    <select name="type_input[]" class="form-control" <?php if($k[0]['pilihan'] != 'dinamis'): ?>disabled="disabled"<?php endif;?>>
                                        <option value="text">Text</option>
                                        <option value="number">Number</option>
                                        <option value="textarea">Textarea</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
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