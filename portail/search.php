<?php

defined('CORE') or exit;

$releases      = null;
$releasesCount = 0;

$searchtype = 'byname';

if (isset($_POST['searchtype']) && $_POST['searchtype'] === 'bycracker'){
	$searchtype = 'bycracker';
}

if (isset($_POST['q']) && is_string($_POST['q']) && strlen($_POST['q']) > 0){
	$q = $_POST['q'];

	if ($searchtype === 'bycracker'){
		$releases = $db_link->prepare('SELECT * FROM releases WHERE cracker LIKE ? ORDER BY date DESC;');
	}else{
		$releases = $db_link->prepare('SELECT * FROM releases WHERE name LIKE ? ORDER BY date DESC;');
	}

	$releases->execute([ '%' . $q . '%' ]);
	$releasesCount = $releases->rowCount();
}

?>
<h1>:: Search Rilisan Dari <?php display($config['team']); ?> ::</h1>
<?php if (!is_null($releases)) {
	?>
	<p>Query: "<font color="<?php display(($releasesCount > 0) ? 'green' : 'red'); ?>"><b><?php display($q); ?></b></font>" ini <?php display($releasesCount . ($releasesCount > 1) ? ' cocok dengan database!' : ' tidak cocok dengan rilisan apapun.'); ?>
	<br /><br />
	<?php
	if ($releasesCount != 0){
		while ($release = $releases->fetch(PDO::FETCH_OBJ)){ 
			echo('<a href="' . htmlentities($release->url) . '" target="_blank">' . htmlentities ($release->name) . '</a> ( Rilis : <font color="red">' . htmlentities($release->episode) . '</font> )<br/>');
		}
		?>
		<br />
		<a href="index.php?crk=search">Reset pencarian</a>
	<?php } else {?>
		<a href="index.php?crk=search">Klik di sini, kalau ingin reset</a>
	<?php }?>
</p>
<?php } else { ?>
	<p>Rilisan kami ditampung di dalam database. Gunakan kotak pencarian di bawah ini untuk memulai pencarian.</p>

	<form class="row" action="index.php?crk=search" method="post">
		<div class="col-9">
			<input id="textinput" class="form-control" name="q" placeholder="Pencarian..." type="text">
		</div>
		<div class="col-3">
			<input class="btn btn-block" name="submit" value="Cari" type="submit">
		</div>
		<div class="col-sm-6 mt-2">
			<i><input type="radio" name="searchtype" value="byname" checked="checked"> Cari menurut nama file</i>
		</div>
		<div class="col-sm-6 mt-2">
			<i><input type="radio" name="searchtype" value="bycracker"> Cari menurut nama Subber</i>
		</div>
	</form>
<?php } ?>
