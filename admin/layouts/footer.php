    <div id="footer">
        <nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
            <div class="container-fluid">
                <label class="footer-time">Wednesday, 01-04-2015 01:09:01</label>
                <label class="footer-copyright">Copyright © 2015. All rights reserved.</label>
            </div>
        </nav>
    </div>
    <?php 
    $_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 
    $segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
    $uri = 'http://'.$_SERVER['SERVER_NAME'].'/'.$segments[1].'/';
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.chosen-select').chosen({no_results_text: "Maaf, data yang anda cari tidak ada!"});
            $("#filesurat").tooltip({placement : 'bottom'});
            var oTable = $('#example').dataTable({
                "sPaginationType": "full_numbers",
                "bFilter": true,
                "sDom": 'T<"clear">lfrtip', 
                "oTableTools": { 
                    "sSwfPath": "<?=$uri?>assets/vendor/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf" ,
                    "aButtons": [
                            { 
                                "sExtends": "csv", 
                                "sTitle": "<?=strtoupper($title);?> MASUK MTs SHOLIHIYYAH", 
                                "sFileName": "*.csv",
                                "mColumns": function ( dtSettings ) {
                                    var api = new $.fn.dataTable.Api( dtSettings );
                                    return api.columns(":not(:last)").indexes().toArray();
                                },
                                "oSelectorOpts": { 
                                    filter: 'applied', 
                                    order: 'current' 
                                } 
                            },
                            { 
                                "sExtends": "xls", 
                                "sTitle": "<?=strtoupper($title);?> MASUK MTs SHOLIHIYYAH", 
                                "sFileName": "*.xls",
                                "mColumns": function ( dtSettings ) {
                                    var api = new $.fn.dataTable.Api( dtSettings );
                                    return api.columns(":not(:last)").indexes().toArray();
                                },
                                "oSelectorOpts": { 
                                    filter: 'applied', 
                                    order: 'current' 
                                } 
                            },
                            { 
                                "sExtends": "pdf",
                                "sTitle": "<?=strtoupper($title);?> MASUK MTs SHOLIHIYYAH", 
                                "sFileName": "*.pdf",
                                "sPdfOrientation": "landscape",
                                "mColumns": function ( dtSettings ) {
                                    var api = new $.fn.dataTable.Api( dtSettings );
                                    return api.columns(":not(:last)").indexes().toArray();
                                },
                                "oSelectorOpts": { 
                                    filter: 'applied', 
                                    order: 'current' 
                                } 
                            },
                            "print"] 
                }
            });

            oTable.fnFilter($('#tahun').find(":selected").text(), $('.tables tr th:contains("Tanggal")').index()); 

            $('#tahun').on('change',function(){
                oTable.fnFilter($(this).val(), $('.tables tr th:contains("Tanggal")').index()); 
            });

            $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
            $(".datepicker").each(function() {    
                $(this).datepicker('setDate', $(this).val());
            });
            $(".filesurat").fancybox();
        });


        $(document).ready(function() {
            $('.chosen-select').chosen({no_results_text: "Maaf, data yang anda cari tidak ada!"});
            
            $("input:radio[name=pilihan]").click(function() {
                var value = $(this).val();
                if(value == 'dinamis'){
                    $('#data_input').show();
                    $('input[name="data_input[]"]').removeAttr('disabled');
                    $('select[name="type_input[]"]').removeAttr('disabled');
                }else{
                    $('#data_input').hide();
                    $('input[name="data_input[]"]').prop('disabled', true);
                    $('select[name="type_input[]"]').prop('disabled', true);
                }
            });
            $('#tambah').click(function(){
                $('#data_input').append('<div class="data_inputs"><div class="form-group"><div class="col-sm-2"></div><div class="col-sm-10"><div class="row"><div class="col-sm-6"><input type="text" name="data_input[]" placeholder="Data Input" class="form-control"></div><div class="col-sm-6"><select name="type_input[]" class="form-control"><option value="text">Text</option><option value="number">Number</option><option value="textarea">Textarea</option></select></div></div><div id="hapus_input">&nbsp;<a href="javascript:void(0);" id="hapus" title="Hapus Input">x</a></div></div></div>');
            });
            $(document).on("click", "a#hapus" , function() {
                $(this).closest('.data_inputs').remove();
                if($('.data_inputs').size() == 1)
                {
                    $('#hapus').remove();
                }
            });
            
            $('#kategori_id').change(function(){
                if($('#group:not(:empty')){
                    $("#group").empty();
                }
                var id = $(this).val();
                    var dataHTML = '';
                $.ajax({
                    type: "POST",
                    url: '../../ajax/kategori.php',
                    data: 'id='+id,
                    dataType: 'json',
                }).done(function(data){
                    $.each(data, function(k,v){
                        $('#group').append('<div class="form-group"><label for="'+v.nama_string+'" class="col-sm-2 control-label">'+v.nama_content+'</label><div class="col-sm-10">'+v.tipe+'</div></div>');
                    });
                }). fail(function(data){
                    $("#group").empty();
                });
                return false;
            });
            
            $('#kat_masuk').change(function(){
                if($('#surats:not(:empty')){
                    $("#surats").empty();
                }
                var id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: '../../ajax/arsipmasuk.php',
                    data: 'id='+id,
                    dataType: 'json',
                }).done(function(data){
                    $('#surats').append('<option value="">Pilh surat</option>');
                    $.each(data, function(k,v){
                        $('#surats').append('<option value="'+v.id_surat+'">'+v.nama_surat+'</option>');
                    });
                }). fail(function(data){
                    $("#surats").empty();
                    $('#surats').append('<option value="">Pilh surat</option>');
                });
                return false;
            });
            
            $('#kat_keluar').change(function(){
                if($('#surats:not(:empty')){
                    $("#surats").empty();
                }
                var id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: '../../ajax/arsipkeluar.php',
                    data: 'id='+id,
                    dataType: 'json',
                }).done(function(data){
                    $('#surats').append('<option value="">Pilh surat</option>');
                    $.each(data, function(k,v){
                        $('#surats').append('<option value="'+v.id_surat+'">'+v.nama_surat+'</option>');
                    });
                }). fail(function(data){
                    $("#surats").empty();
                    $('#surats').append('<option value="">Pilh surat</option>');
                });
                return false;
            });
        });
    </script>
</body>
</html>