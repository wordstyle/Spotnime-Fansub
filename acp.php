<?php

session_start();

define('CORE_ACP', true);

require_once('libs/lib.php');

@include('config.php');

defined('CONFIG') or setup();

clean_token();

if (!isset($_GET['crk']))
{
	clean_add_token();
}
else
{
	if ($_GET['crk'] != 'addrelease')
	{
		clean_add_token();
	}
	else if ($_GET['crk'] != 'editrlz')
	{
		clean_edit_token();
	}
}

$wrong = '';

if (isset($_POST['pass']))
{
	if ($_POST['pass'] === $config['pass'])
	{
		$_SESSION['pass'] = $config['pass'];
	}
	else
	{
		$wrong = '<br><font color="red">Password Lu Salah Gan!</font>';
	}
}

ob_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="alternate" type="application/rss+xml" title="<?php display($config['team']); ?> Releases RSS Feed" href="rss.xml" />
	<link rel="shortcut icon" href="design/favicon.ico" />
	<title>Portal Rilisan <?php echo $config['team']; ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="design/default.css" media="screen,projection" />
	<script type="text/javascript" src="js/acp.js"></script>
</head>
<body>


	<div id="contentwrapper" class="mt-2 mb-2">
		<div class="container container-header">
			<div class="row">
				<div class="col-md-12">
					<div id="banner">
						<img src="<?php echo(get_banner()); ?>" width="100%" alt="Banner" />
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<?php if (isset($_SESSION['pass']) && $_SESSION['pass'] === $config['pass']){
					$page = 'acp/accueil.php';

					if (!empty($_GET['crk'])){
						$file = clean_var($_GET['crk']);

						if (file_exists('acp/' . $file . '.php')){
							$page = 'acp/' . $file . '.php';
						}else{
							$page = 'bugslogger.php';
						}
					}?>
					<div class="col-md-3">
						<div id="menu">
							<ul>
								<li><a href="index.php?crk=releases">Rilisan</a></li>
								<li><a href="acp.php?crk=about">Tentang</a></li>
								<li><a href="acp.php?crk=modifabout"> Edit "Tentang" *</a></li>
								<li><a href="acp.php?crk=addrelease"> Buat Rilisan Baru *</a></li>
								<li><a href="acp.php?crk=modifrlz"> Edit Rilisan *</a></li>
								<li><a href="acp.php?crk=delrelease"> Delete Rilisan *</a></li>
								<li><a href="acp.php?crk=rss"> Update RSS feed *</a></li>
								<li><a href="acp.php?crk=editconfig"> Edit Config.php *</a></li>
								<li><a href="acp.php?crk=uninstall"> Uninstall XRS *</a></li>
								<li><a href="acp.php?crk=logout"> Logout *</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-9">
						<div id="maincontent">
							<?php require_once($page); ?>
						</div>
					</div>
				<?php } else { ?>
					<div class="col-12">
						<div id="maincontent">
							<hr />
							<p style="text-align:center;">Masukkan Password</p>
							<form class="row" action="acp.php" method="post">
								<div class="col-9">
									<input class="form-control" type="password" name="pass" />
								</div>
								<div class="col-3">
									<input class="form-control" type="submit" value="Enter"/>
								</div>
							</form>
							<center><?php echo($wrong); ?></center>
							<hr />
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<div id="footer">
			<p>Portal Rilisan <?php display($config['team']); ?> v1.0.0</p>
			<p>&copy; <?php display(date('Y') . ' ' . $config['team']); ?></p>
		</div>
	</div>


	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
<?php
ob_end_flush();
