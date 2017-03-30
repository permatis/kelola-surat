<?php
if( !session_id()) session_start();
if (isset($_SESSION['admin'])) header("Location: admin/index.php");

require_once 'lib/Database.php';
require_once 'lib/Kriptografi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $decrypted = Kriptografi::check(array('email' => $_POST['email'], 'password' => $_POST['password']), 'users');
    
    if($decrypted == TRUE){ 
        $nama = Database::query("SELECT nama FROM users WHERE email ='".$_POST['email']."'")->result();
        $_SESSION['admin'] = $nama[0]['nama'];
        header("Location: admin/index.php");
    }else {
        $error = 'Email / password salah.';
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Aplikasi Pengolahan Surat</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <style type="text/css">
    body {
        margin-top: 100px;
        background-color: transparent;
    }
    
    html { 
        background: url('assets/images/letter.jpg') no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
    #loginbox {
        margin-top: 30px;
    }

    #form > div {
        margin-bottom: 25px;
    }

    #form > div:last-child {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .panel {    
        background-color: rgba(2555,255,255,.3);
        border-radius: 0px;
        border: 1px solid #2B579A;
    }

    .panel-body {
        padding-top: 30px;
        background-color: rgba(2555,255,255,.3);
    }

    .panel-default>.panel-heading {
        background-color: #2B579A;
        color: #fff;
        border-radius: 0;
        border: 1px solid #2B579A;
    }
    </style>
</head>
<body>
    
<div class="container">    
    <div id="loginbox" class="mainbox col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3"> 
        <?php if(isset($error)):?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Warning!</strong> <?=$error?>
        </div>
        <?php endif; ?>
        <div class="panel panel-default" >
            <div class="panel-heading">
                <div class="panel-title text-center">Login Aplikasi Pengolahan Surat <br> MTs Sholihiyyah</div>
            </div>     
            <div class="panel-body" >
                <form name="form" id="form" class="form-horizontal" enctype="multipart/form-data" method="POST">
                   
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input type="text" class="form-control" name="email" value="" placeholder="Email">                                        
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>                                                                  

                    <div class="form-group">
                        <!-- Button -->
                        <div class="col-sm-12 controls">
                            <button type="submit" href="#" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-log-in"></i> Log in</button>                          
                        </div>
                    </div>

                </form>     

            </div>                     
        </div>  
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 5000);
});
</script>
</body>
</html>