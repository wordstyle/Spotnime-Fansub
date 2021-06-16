<?php

defined('CORE_ACP') or exit;

/**
 * Input
 */
$crackerName = $_GET['cracker'] ?? null;
$page        = isset($_GET['spg']) ? intval($_GET['spg']) : 1;
$token       = generate_token('delete');

/**
 * Releases count
 */
$query         = $db_link->query('SELECT COUNT(*) AS entries FROM releases;');
$totalReleases = $query->fetchColumn();

$totalCrackerReleases = 0;

if (!is_null($crackerName))
{
	$query = $db_link->prepare('SELECT COUNT(*) AS entries FROM releases WHERE cracker = ?;');

	$query->execute([ $crackerName ]);

	$totalCrackerReleases = $query->fetchColumn();
}

/**
 * Pagination
 */
$page = $page < 0 ? 0 : $page;

if ($page != 0)
{
	$premierMessageAafficher = ($page - 1) * $config['cracksparpage'];
}

$nombreDePages = (!is_null($crackerName)) ? ceil($totalCrackerReleases / $config['cracksparpage']) : ceil($totalReleases / $config['cracksparpage']);

/**
 * Releases
 */
$releases = null;

if (is_null($crackerName))
{
	if ($page === 0)
	{
		$releases = $db_link->prepare('SELECT * FROM releases');

		$releases->execute();
	}
	else
	{
		$releases = $db_link->prepare('SELECT * FROM releases ORDER BY date DESC LIMIT :offset, :limit;');

		$releases->bindParam('offset', $premierMessageAafficher, PDO::PARAM_INT);
		$releases->bindParam('limit', $config['cracksparpage'], PDO::PARAM_INT);

		$releases->execute();
	}
}
else
{
	if ($page === 0)
	{
		$releases = $db_link->prepare('SELECT * FROM releases WHERE cracker = ? ORDER BY date DESC;');

		$releases->execute([ $crackerName ]);
	}
	else
	{
		$releases = $db_link->prepare('SELECT * FROM releases WHERE cracker = :cracker ORDER BY date DESC LIMIT :offset, :limit;');

		$releases->bindParam('cracker', $crackerName, PDO::PARAM_STR);
		$releases->bindParam('offset', $premierMessageAafficher, PDO::PARAM_INT);
		$releases->bindParam('limit', $config['cracksparpage'], PDO::PARAM_INT);

		$releases->execute();
	}
}

?>
<h1>:: Hapus Rilisan ::</h1>
<?php if (!is_null($crackerName)) { ?>
<h1>oleh <?php display($crackerName); ?></h1>
<?php } ?>
<p>
	Total rilisan : <?php display($totalReleases); ?>
<?php if (!is_null($crackerName)) { ?>
	<br />
	Jumlah rilisan dari <b><?php display($crackerName); ?></b> : <?php display($totalCrackerReleases); ?>
<?php } ?>
</p>
<hr />
<form>
	<table border="0" cellpadding="3" cellspacing="0">
		<tr>
			<td><center>Nama file</center></td>
			<td>Episode</td>
			<td><center>URL</center></td>
			<td>Sumber</td>
			<td>Tanggal</td>
			<td>Tindakan</td>
		</tr>
<?php
	while ($release = $releases->fetch(PDO::FETCH_OBJ))
	{
?>
	<tr id="hide<?php echo($release->id); ?>">
		<td><a href="<?php display($release->url); ?>"><?php display($release->name); ?></a></td>
		<td><?php display($release->episode); ?></td>
		<td><?php display($release->url); ?></td>
		<td><b><a href="index.php?crk=delrelease&cracker=<?php display($release->cracker); ?>"><?php display($release->cracker); ?></a></b></td>
		<td><?php display($release->date); ?></td>
		<td>
			<span id="sure<?php echo($release->id); ?>" style="display:none">
				Yakin?<br>
				<button type="button" onclick="delrowsure(<?php echo($release->id); ?>); return false;">Ya</button>
				<button type="button" onclick="notsure(<?php echo($release->id); ?>); return false;">Tidak</button>
			</span>
			<span id="update<?php echo($release->id); ?>">
				<button type="button" onclick="delrow(<?php echo($release->id); ?>); return false;">Delete</button>
			</span>
		</td>
	</tr>
<?php }?>
	</table>
	<input type="hidden" id="token" value="<?php echo($token); ?>" />
</form>
<hr />
<div id="footerlinks">
	<center id="pagenums">Halaman :
<?php
	for ($i = 1 ; $i <= $nombreDePages; $i++)
	{
		if ($i != $page)
		{
			echo('<a href="' . $_SERVER['SCRIPT_NAME'] . '?crk=delrelease' . (!is_null($crackerName) ? '&cracker=' . htmlentities($crackerName, ENT_QUOTES) : '') . '&spg=' . $i . '">' . $i . '</a> ');
		}
		else
		{
			echo($i . ' ');
		}
	}
?>
</center>
	<a href="<?php echo($_SERVER['SCRIPT_NAME']); ?>?crk=delrelease&spg=0"><font face="fixedsys">[Tampilkan Semua Rilisan]</font></a>
</div>
