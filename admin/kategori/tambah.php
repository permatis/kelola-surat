<?php
if( !session_id() ) session_start();
if (!isset($_SESSION['admin'])){ header("Location: ../../index.php");exit;}

require_once '../../lib/Database.php';
require_once '../../lib/Image.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //tabel kategori
    $kat = Database::query('select id_kategori from kategori')->result();
    $id_kat = (empty($kat) ? '1' : $kat[count($kat)-1]['id_kategori']+1);

    $data_kategori = array_splice($_POST, 0, 3);
    $data_kategori = array_merge($data_kategori, array('tgl_pembuatan' => date("Y-m-d H:m:s"),'tgl_perubahan' => date("Y-m-d H:m:s"), 'id_kategori' => $id_kat));
    
    Database::insert('kategori', $data_kategori);

    if(!empty($_POST['data_input']) && !empty($_POST['type_input'])){
        foreach ($_POST['data_input'] as $key => $value) {
            $data_content[] = [
                'kategori_id'   => $id_kat,
                'nama_content'  => ucwords(strtolower($value)),
                'nama_string'   => strtolower(preg_replace("/[^A-Za-z0-9]/", "", $value)),
                'tipe'          => $_POST['type_input'][$key],
            ];
        }
        foreach ($data_content as $k => $v) {
            foreach ($v as $ky => $val) {
                $data[$ky] = "'".$val."'";
            }
            $datas[] = "(".implode(',', $data).")";
        }
        Database::query("INSERT INTO kategori_content (kategori_id, nama_content, nama_string, tipe) VALUES ".implode(',', $datas))->result();
    }
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
                    <input type="text" name="nama_kategori" placeholder="Nama Kategori" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="deskripsi" class="col-sm-2 control-label">Deskripsi</label>
                <div class="col-sm-10">
                    <textarea name="deskripsi" placeholder="Deskripsi" class="form-control" id="deskripsi"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="nama_kategori" class="col-sm-2 control-label">Pilih Isi Content</label>
                <div class="col-sm-10">
                    <label><input type="radio" name="pilihan" value="statis"> Statis</label> &nbsp;
                    <label><input type="radio" name="pilihan" value="dinamis"> Dinamis</label>
                </div>
            </div>

            <div id="data_input" style="display: none;">
                <div class="form-group">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                        <input type="button" id="tambah" value="Tambahkan input" class="btn btn-default btn-sm">
                    </div>
                </div>
                <div class="data_inputs">
                    <div class="form-group">  
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" name="data_input[]" placeholder="Data Input" class="form-control" disabled="disabled">
                                </div>
                                <div class="col-sm-6">
                                    <select name="type_input[]" class="form-control" disabled="disabled">
                                        <option value="text">Text</option>
                                        <option value="number">Number</option>
                                        <option value="textarea">Textarea</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
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