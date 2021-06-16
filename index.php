<?php
define('CORE', true);
require_once('libs/lib.php');
@include('config.php');
defined('CONFIG') or setup();

clean_token(); clean_add_token(); ob_start();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="alternate" type="application/rss+xml" title="<?php display($config['team']); ?> Releases RSS Feed" href="rss.xml" />
	<link rel="shortcut icon" href="design/favicon.ico" />
	<title>Portal Rilisan <?php display($config['team']); ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="design/default.css" media="screen,projection" />
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
				<div class="col-md-3">
					<div id="menu">
						<ul>
							<li><a href="index.php?crk=releases&spg=1">Rilisan Terbaru</a></li>
							<li><a href="index.php?crk=search">Search Anime</a></li>
							<li><a href="index.php?crk=about">Tentang <?php display($config['accro']); ?></a></li>
							<li><a href="rss.xml" target="_blank">RSS</a></li>
							<li><a href="acp.php">Staff Only *</a></li>
						</ul>
					</div>
				</div>
				<div class="col-md-9">
					<div id="maincontent">
						<?php
							if(!empty($_GET['crk'])){
								$page = clean_var($_GET['crk']);
								if (pageExists($page)){
									require_once('portail/' . $page . '.php');
								}else{
									require_once('bugslogger.php');
								}
							}else{
								require_once('portail/releases.php');
							}
						?>
					</div>
				</div>
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
<?php ob_end_flush();?>
