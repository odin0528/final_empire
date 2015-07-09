<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<?php include($this->getLayoutPath() . '/head.php'); ?>
</head>
<body>
	<?php include($this->getLayoutPath() . '/header.php'); ?>
	<div id="page-wrapper">
		<div id="main-wrapper">
			<div id="main-content">
				<?php include($this->getViewPath() . '/'.$this->_view);?>
			</div>
			<div class="clearfix"></div>
		</div>
<?php include('sidebar.php'); ?>
	</div>
	<div class="clearfix"></div>
<?php include('footer.php'); ?>
</body>
</html>