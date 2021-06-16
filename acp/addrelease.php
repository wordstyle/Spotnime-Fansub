<?php

defined('CORE_ACP') or exit;

if (isset($_POST['releasename'], $_POST['url'], $_POST['cracker'])){
	if (!empty($_POST['releasename']) AND !empty($_POST['url']) AND !empty($_POST['episode']) AND !empty($_POST['cracker'])){
		if (check_token('add', 600, false)){
			$releasename 	= $_POST['releasename'];
			$episode		= $_POST['episode'];
			$url         	= $_POST['url'];
			$cracker     	= $_POST['cracker'];

			$query = $db_link->prepare('INSERT INTO releases (name, episode, url, cracker) VALUES (?, ?, ?, ?);');

			$query->execute([
				$releasename, $episode, $url, $cracker
			]);

			echo('<font class="btn btn-success btn-block mb-2">Rilisan berhasil ditambahkan.</font>');

			include('rss.php');
		}else{
			echo('<font class="btn btn-danger btn-block mb-2">Token salah! Silakan coba lagi.</font>');
		}
	}
}

?>
<h1>:: Penambahan Rilisan Baru ::</h1>
<hr />
<form class="row" action="<?php echo($_SERVER['SCRIPT_NAME']); ?>?crk=addrelease" method="POST">
	<div class="col-3">
		<div align="right">Judul :</div>
	</div>
	<div class="col-9">
		<input class="form-control" type="text" name="releasename"/>
	</div>

	<div class="col-3 mt-3">
		<div align="right">Link : </div>
	</div>
	<div class="col-9 mt-3">
		<input class="form-control" type="text" name="url" placeholder="https://" />
	</div>

	<div class="col-3 mt-3">
		<div align="right">Episode : </div>
	</div>
	<div class="col-9 mt-3">
		<input class="form-control" type="text" name="episode" placeholder="Episode 1 / Movie" />
	</div>

	<div class="col-3 mt-3">
		<div align="right">Subber : </div>
	</div>
	<div class="col-9 mt-3">
		<input class="form-control" type="text" name="cracker" placeholder="Spotnime" />
	</div>

	<div class="col-12 mt-3">
		<div align="right">
			<button class="btn btn-primary btn-block" type="submit" value="Tambahkan">Publikasi</button>
		</div>
	</div>
	<input type="hidden" name="token" value="<?php echo(generate_token('add')); ?>"/>
</form>
