<ol class="breadcrumb">
	<?php
       	$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
       	$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
       	$segments[3] = ($segments[3] == 'index.php') ? '' : ($segments[3]);
   	?>
      <?=$segments[3]?>
    	<li><a href="../index.php">Home</a></li>
    	<li class="active">
    		<?php if(empty($segments[4]) && $segments[4] = 'index.php'): ?>
    			<?=ucfirst($segments[3])?>
    		<?php else: ?>
    			<a href="index.php"><?=ucfirst($segments[3])?></a>
    		<?php endif; ?>
    	</li>
    <?php if(!empty($segments[4]) && $segments[4] != 'index.php'): ?>
    	<li class="active"><?=ucfirst(explode('.', $segments[4])[0])?></li>
    <?php endif; ?>
</ol>