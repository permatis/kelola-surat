<?php 
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
$uri = 'http://'.$_SERVER['SERVER_NAME'].'/'.$segments[1].'/';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Template</title>
    <link rel="stylesheet" type="text/css" href="<?=$uri?>assets/vendor/datatables/media/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="<?=$uri?>assets/vendor/datatables/extensions/TableTools/css/dataTables.tableTools.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$uri?>assets/vendor/jqueryui/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$uri?>assets/vendor/jqueryui/jquery-ui.theme.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$uri?>assets/vendor/jqueryui/latoja.datepicker.css">
    <link rel="stylesheet" type="text/css" href="<?=$uri?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$uri?>assets/css/bootstrap-chosen.css">
    <link rel="stylesheet" type="text/css" href="<?=$uri?>assets/css/fileinput.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$uri?>assets/vendor/fancybox/jquery.fancybox.css">
    <link rel="stylesheet" type="text/css" href="<?=$uri?>assets/css/admin.css">
    <script type="text/javascript" charset="utf8" src="<?=$uri?>assets/js/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="<?=$uri?>assets/vendor/fancybox/jquery.fancybox.js"></script>
    <script type="text/javascript" charset="utf8" src="<?=$uri?>assets/vendor/datatables/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="<?=$uri?>assets/vendor/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
    <script type="text/javascript" charset="utf8" src="<?=$uri?>assets/vendor/jqueryui/jquery-ui.min.js"></script>
    <script type="text/javascript" charset="utf8" src="<?=$uri?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="<?=$uri?>assets/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" charset="utf8" src="<?=$uri?>assets/vendor/ckeditor/ckeditor.js"></script>
    <script src="<?=$uri?>assets/js/fileinput.min.js"></script>
    <script src="<?=$uri?>assets/js/chosen.jquery.js"></script>
    <script src="<?=$uri?>assets/js/style.js"></script>
</head>

<body>
<?php
$title = ''; 
?>
    