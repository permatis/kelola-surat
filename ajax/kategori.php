<?php

require_once '../lib/Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //$nomor = Database::query('select  COUNT(DISTINCT id_surat) as id from surat WHERE kategori_id = '.$_POST['id'])->result();
    //$nomor_surat = (empty($nomor) ? str_pad('1', 3 , '0', STR_PAD_LEFT) : str_pad($nomor[0]['id']+1, 3, '0', STR_PAD_LEFT));
    $kat = Database::query('SELECT nama_content, nama_string, tipe FROM kategori_content WHERE kategori_id = '.$_POST['id'])->result();
    $tipe = '';
    if (empty($kat)){ 
        return false;
    }else{
    foreach ($kat as $val) {
       switch ($val['tipe']) {
           case 'number':
               $tipe = '<input type="number" name="'.$val['nama_string'].'" placeholder="'.$val['nama_content'].'" class="form-control"/>';
               break;
           
           case 'textarea':
               $tipe = '<textarea name="'.$val['nama_string'].'" placeholder="'.$val['nama_content'].'" class="form-control" id="teks"></textarea>';
               break;
           
           default:
               $tipe = '<input type="text" name="'.$val['nama_string'].'" placeholder="'.$val['nama_content'].'" class="form-control"/>';
               break;
       }
       $data[] = array(
            'nama_content' => $val['nama_content'],
            'nama_string' => $val['nama_string'],
            'tipe'  => $tipe
        );
    }

    echo json_encode($data);
}
}