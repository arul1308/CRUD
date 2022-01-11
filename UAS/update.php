<?php
define('connection', true); 
require 'functions.php';
$msg = '';
if (isset($_GET['id'])) {
    if (!empty($_POST)) {

        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $namatim = isset($_POST['nama']) ? $_POST['nama'] : '';
        $ketuatim = isset($_POST['ketua']) ? $_POST['ketua'] : '';
        $notelpketua = isset($_POST['notelp']) ? $_POST['notelp'] : '';
        $emailtim = isset($_POST['emailtim']) ? $_POST['emailtim'] : '';
        

        $stmt = $pdo->prepare('UPDATE daftar_tim SET id = ?, nama_tim = ?, ketua_tim = ?, notelp_ketua = ?, email_tim = ? WHERE id = ?');
        $stmt->execute([$id, $namatim, $ketuatim, $notelpketua, $emailtim, $_GET['id']]);
        $msg = 'Update Berhasil';
    }
    $stmt = $pdo->prepare('SELECT * FROM daftar_tim WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('TIM TIDAK ADA');
    }
} else {
    exit('ID TIDAK TERDAFTAR');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Update Tim ke-<?=$contact['id']?></h2>
    <form action="update.php?id=<?=$contact['id']?>" method="post">
        <label for="id">ID</label>
        <label for="nama">Nama Tim</label>
        <input type="text" name="id" value="<?=$contact['id']?>" id="id">
        <input type="text" name="nama" value="<?=$contact['nama_tim']?>" id="nama">
        <label for="ketua">Nama Ketua Tim</label>
        <label for="notelp">No. Telp Ketua</label>
        <input type="text" name="ketua" value="<?=$contact['ketua_tim']?>" id="ketua">
        <input type="text" name="notelp" value="<?=$contact['notelp_ketua']?>" id="notelp">
        <label for="emailtim">Email Tim</label>
        <input type="text" name="emailtim" value="<?=$contact['email_tim']?>" id="email">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>