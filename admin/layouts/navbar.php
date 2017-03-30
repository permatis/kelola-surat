<div id="header">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../../home.php">Aplikasi Pengolahan Surat MTs Sholihiyyah</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle profile-image" data-toggle="dropdown">
                            <img src="<?php echo ($segments[3] == 'index.php') ? '../assets/images/gravatar.jpg' : '../../assets/images/gravatar.jpg'; ?>" class="img-circle avatar-img"> <?=$_SESSION['admin']?>&nbsp;<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="fa fa-cog"></i> Account</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo ($segments[3] == 'index.php') ? '../logout.php' : '../../logout.php'; ?>"><i class="fa fa-sign-out"></i> Sign-out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>