<?php
define('connection', true); 
require 'functions.php';
$msg ='';
if (!empty($_POST)) {

    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    $namatim = isset($_POST['nama']) ? $_POST['nama'] : '';
    $ketuatim = isset($_POST['ketua']) ? $_POST['ketua'] : '';
    $notelpketua = isset($_POST['notelp']) ? $_POST['notelp'] : '';
    $emailtim = isset($_POST['emailtim']) ? $_POST['emailtim'] : '';

    // insert ke dalam tabel daftar_tim
    $stmt = $pdo->prepare('INSERT INTO daftar_tim VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$id, $namatim, $ketuatim, $notelpketua, $emailtim]);
    // pesan jika berhasil
    $msg = 'Berhasil Ditambahkan!';
}
?>


<?=template_header('Tambah')?>

<div class="content update">
	<h2>Tambah Tim</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="nama">Nama Tim</label>
        <input type="text" name="id" value="auto" id="id">
        <input type="text" name="nama" id="nama">
        <label for="ketua">Nama Ketua Tim</label>
        <label for="notelp">No. Telp Ketua</label>
        <input type="text" name="ketua" id="ketua">
        <input type="text" name="notelp" id="notelp">
        <label for="emailtim">Email Tim</label>
        <input type="text" name="emailtim" id="emailtim">
        <input type="submit" value="Tambah">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>