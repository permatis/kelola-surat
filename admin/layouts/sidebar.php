<div id="sidebar">
    <div class="menu-information">
        Menu Information
    </div>
    <ul class="sidebar-nav">
        <?php 
        $_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 
        $segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
        $uri = 'http://'.$_SERVER['SERVER_NAME'].'/'.$segments[1].'/admin/';
        ?>
        <li <?php if($segments[3] == 'index.php') echo 'class="active"'; ?>><a href="<?=$uri?>index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp; Dashboard</a></li>
        <li <?php if($segments[3] == 'kategori') echo 'class="active"'; ?>><a href="<?=$uri?>kategori/index.php"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp; Kategori</a></li>
        <li <?php if($segments[3] == 'surat') echo 'class="active"'; ?>><a href="<?=$uri?>surat/index.php"><span class="glyphicon glyphicon-file" aria-hidden="true"></span>&nbsp; Surat</a></li>
        <li <?php if($segments[3] == 'arsip_masuk' || $segments[3] == 'arsip_keluar') echo 'class="active"'; ?>>
            <a href="#" class="submenu">
            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbsp; Arsip</span>
            </a>
            <ul class="submenu tree">
                <li <?php if($segments[3] == 'arsip_masuk') echo 'class="active"'; ?>><a href="<?=$uri?>arsip_masuk/index.php"><span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span>&nbsp; Arsip Masuk</a></li>
                <li <?php if($segments[3] == 'arsip_keluar') echo 'class="active"'; ?>><a href="<?=$uri?>arsip_keluar/index.php"><span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span>&nbsp; Arsip Keluar</a></li>
            </ul>
        </li>
    </ul>
</div>