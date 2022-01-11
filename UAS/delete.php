<?php
define('connection', true); 
require 'functions.php';
$msg = '';
if (isset($_GET['id'])) {

    $stmt = $pdo->prepare('SELECT * FROM daftar_tim WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }

    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {

            $stmt = $pdo->prepare('DELETE FROM daftar_tim WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Tim Berhasil Dihapus! ';
        } else {

            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>


<?=template_header('Delete')?>

<div class="content delete">
	<h2>Hapus Tim <?=$contact['nama_tim']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Apa kamu yakin ingin menghapus tim <?=$contact['nama_tim']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$contact['id']?>&confirm=yes">Ya</a>
        <a href="delete.php?id=<?=$contact['id']?>&confirm=no">Tidak</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>