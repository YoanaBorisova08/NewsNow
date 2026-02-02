<?php
session_start();
if (empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require __DIR__ . '/../inc/functions.inc.php';
require __DIR__ . '/../inc/db-connect.inc.php';
require_once __DIR__ . '/../inc/config.php'; 

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM news WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$news = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$news){
    die("News not found.");
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['confirm']) && $_POST['confirm'] === 'yes'){
        // Delete the news
        $pdo->prepare("DELETE FROM news WHERE id = :id")
            ->execute(['id' => $id]);

        if(!empty($news['photo']) && file_exists(__DIR__ . '/../uploads/' . $news['photo'])){
            unlink(__DIR__ . '/../uploads/' . $news['photo']);
        }

        header("Location: index.php?msg=deleted");
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
}
?>
<?php require __DIR__ . '/views/header.view.php'; ?>

<div class="confirm-box">
    <h2>Are you sure you want to delete this news?</h2>
    <p><strong><?php echo e($news['title']); ?></strong></p>
    <form method="post">
        <button type="submit" name="confirm" value="yes">Yes, delete</button>
        <button type="submit" name="confirm" value="no">Cancel</button>
    </form>
</div>

<?php require __DIR__ . '/views/footer.view.php'; ?>
