<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Admintasia | Powerful backend admin user interface</title>
	<link href="style.css" rel="stylesheet" media="all" />
	<link href="" rel="stylesheet" title="style" media="all" />
	<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
	<script type="text/javascript" src="js/superfish.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.7.2.js"></script>
	<script type="text/javascript" src="js/tooltip.js"></script>
	<script type="text/javascript" src="js/tablesorter.js"></script>
	<script type="text/javascript" src="js/tablesorter-pager.js"></script>
	<script type="text/javascript" src="js/cookie.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	<!--[if IE 6]>
	<link href="css/ie6.css" rel="stylesheet" media="all" />
	
	<script src="js/pngfix.js"></script>
	<script>
	  /* EXAMPLE */
	  DD_belatedPNG.fix('.logo, .other ul#dashboard-buttons li a');

	</script>
	<![endif]-->
	<!--[if IE 7]>
	<link href="css/ie7.css" rel="stylesheet" media="all" />
	<![endif]-->
</head>
<body>
	<div id="header">
		<div id="top-menu">
			<a href="#" title="My account">My account</a> |
			<a href="#" title="Settings">Settings</a> |
			<a href="#" title="Contact us">Contact us</a>
			
			<span>Logged in as <a href="#" title="Logged in as admin">admin</a></span>
			| <a href="#" title="Edit profile">Edit profile</a>
			| <a href="#" title="Logout">Logout</a>
		</div>
		<div id="sitename">
			<a href="index.php" class="logo float-left" title="Admintasia">Admintasia</a>
			<div class="button float-right">
				<a href="#" id="dialog_link" class="btn ui-state-default ui-corner-all"><span class="ui-icon ui-icon-newwin"></span>Open Dialog</a>
				<a href="#" id="login_dialog" class="btn ui-state-default ui-corner-all"><span class="ui-icon ui-icon-image"></span>Open Login Box</a>
			</div>
			<div id="login" title="Members Login">
				<form action="#" method="post" enctype="multipart/form-data" class="forms" name="form" >
					<ul>
						<li>
							<label for="email" class="desc">
								Email:
							</label>
							<div>
								<input type="text" tabindex="1" maxlength="255" value="" class="field text full" name="email" id="email" />
							</div>
						</li>
						<li>
							<label for="password" class="desc">
								Password:
							</label>
							<div>
								<input type="text" tabindex="1" maxlength="255" value="" class="field text full" name="password" id="password" />
							</div>
						</li>
					</ul>
				</form>
			</div>
			<div id="dialog" title="Dialog Title">
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
			</div>
		</div>
		<ul id="navigation" class="sf-navbar">
			<li>
				<a href="index.php">Dashboard</a>
				<ul>
					<li><a href="index.php">Administration</a></li>
					<li><a href="forms.php">Forms</a></li>
					<li><a href="tables.php">Tables</a></li>
					<li><a href="msg.php">Response Messages</a></li>
				</ul>
			</li>
			<li>
				<a href="#">Dummy menu</a>
				<ul>
					<li>
						<a href="#">Menu item 1</a>
						<ul>
							<li><a href="#">Subitem 1</a></li>
							<li><a href="#">Subitem 2</a></li>
						</ul>
					</li>
					<li>
						<a href="#">Menu item 2</a>
					</li>
					<li>
						<a href="#">Menu item 3</a>
					</li>
					<li>
						<a href="#">Menu item 4</a>
						<ul>
							<li><a href="#">Subitem 1</a></li>
							<li>
								<a href="#">Subitem 2</a>
								<ul>
									<li><a href="#">Subitem 1</a></li>
									<li>
										<a href="#">Subitem 2</a>
										<ul>
											<li><a href="#">Subitem 1</a></li>
											<li>
												<a href="#">Subitem 2</a>
											</li>
										</ul>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						<a href="#">Menu item 5</a>
						<ul>
							<li><a href="#">Subitem 1</a></li>
							<li><a href="#">Subitem 2</a></li>
						</ul>
					</li>
					<li>
						<a href="#">Menu item 6</a>
					</li>
					<li>
						<a href="#">Menu item 7</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#">Layout Options</a>
				<ul>
					<li>
						<a href="three-columns-layout.php">Three columns</a>
					</li>
					<li>
						<a href="two-column-layout.php">Two columns</a>
					</li>
					<li>
						<a href="three-column-small-layout.php">One big, two small</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#">Available components</a>
				<ul>
					<li>
						<a href="accordion.php">Accordion</a>
					</li>
					<li>
						<a href="tabs.php">Tabs</a>
					</li>
					<li>
						<a href="overlays.php">Overlays</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>