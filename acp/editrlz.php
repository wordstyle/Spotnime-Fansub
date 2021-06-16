<?php

defined('CORE_ACP') or exit;

function redirectToEditPage(){
    header('Location: acp.php?crk=modifrlz');
    exit;
}

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])){
    redirectToEditPage();
}

$id = intval($_GET['id']);

if ($id === 0){
    redirectToEditPage();
}

$release_query = $db_link->prepare('SELECT * FROM releases WHERE id = ?');

$release_query->execute([ $id ]);

if ($release_query->rowCount() !== 1){
    redirectToEditPage();
}

if (isset($_POST['releasename'], $_POST['url'], $_POST['cracker'])){
    if (!empty($_POST['releasename']) AND !empty($_POST['url']) AND !empty($_POST['cracker']) AND !empty($_POST['episode'])){
        if (check_token('edit', 600, false)){
            $releasename    = $_POST['releasename'];
            $episode        = $_POST['episode'];
            $url            = $_POST['url'];
            $cracker        = $_POST['cracker'];

            $query = $db_link->prepare('UPDATE releases SET name = ?, episoded = ?, url = ?, cracker = ? WHERE id = ?;');

            $query->execute([
                $releasename, $episode, $url, $cracker, $id
            ]);

            echo('<font class="btn btn-success btn-block mb-2">Rilisan berhasil diubah.</font>');
        }else{
            echo('<font class="btn btn-danger btn-block mb-2">Tokenmu salah! Silakan Coba lagi.</font>');
        }
    }
}

$release_query->execute([ $id ]);

$release = $release_query->fetch(PDO::FETCH_OBJ);

?>
<h1>:: Edit Release ::</h1>
<hr />
<form class="row" action="<?php echo($_SERVER['SCRIPT_NAME']); ?>?crk=editrlz&id=<?php echo($release->id); ?>" method="POST">
    <div class="col-3">
        <div align="right">Judul :</div>
    </div>
    <div class="col-9">
        <input type="hidden" name="token" value="<?php echo(generate_token('edit')); ?>"/>
        <input class="form-control" type="text" name="releasename" value="<?php display($release->name); ?>" />
    </div>

    <div class="col-3 mt-3">
        <div align="right">Link : </div>
    </div>
    <div class="col-9 mt-3">
        <input class="form-control" type="text" name="url" value="<?php display($release->url); ?>" placeholder="https://" />
    </div>

    <div class="col-3 mt-3">
        <div align="right">Episode : </div>
    </div>
    <div class="col-9 mt-3">
        <input class="form-control" type="text" name="episode" value="<?php display($release->episode); ?>" placeholder="Episode 1 / Movie" />
    </div>

    <div class="col-3 mt-3">
        <div align="right">Subber : </div>
    </div>
    <div class="col-9 mt-3">
        <input class="form-control" type="text" name="cracker" value="<?php display($release->cracker); ?>" placeholder="Spotnime" />
    </div>

    <div class="col-12 mt-3">
        <div align="right">
            <button class="btn btn-primary btn-block" type="submit" value="Ubah">Perbarui</button>
        </div>
    </div>
</form>
