<?php
session_start();
define('connection', true); 
require 'functions.php';
if(!isset($_SESSION['user'])){
    header("location:login.php");
    exit();
}
// request get (kalau gagal masuk k page1)
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM daftar_tim ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$num_contacts = $pdo->query('SELECT COUNT(*) FROM daftar_tim')->fetchColumn();
?>


<?=template_header('Read')?>

<div class="content read">
	<h2>Daftar Tim</h2>
	<a href="create.php" class="create-contact">Tambah Tim</a>
	<table>
        <thead>
            <tr>
                <td>Nama Tim</td>
                <td>Nama Ketua</td>
                <td>No. Telp</td>
                <td>Email Tim</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?=$contact['nama_tim']?></td>
                <td><?=$contact['ketua_tim']?></td>
                <td><?=$contact['notelp_ketua']?></td>
                <td><?=$contact['email_tim']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$contact['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$contact['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>