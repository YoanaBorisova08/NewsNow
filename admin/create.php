<?php
session_start();
if (empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require __DIR__ . '/../inc/functions.inc.php';
require __DIR__ . '/../inc/db-connect.inc.php';
require_once __DIR__ . '/../inc/config.php'; 

if (!empty($_POST)) {
    $title = (string) (trim($_POST['title']) ??  '');
    $category = (string) ($_POST['category'] ?? '');
    $short_text = (string) (trim($_POST['short_text']) ?? '');
    $full_text = (string) (trim($_POST['full_text']) ?? '');
    if(!empty($_FILES['image']))
        $imageName = uploadAndResizeImage($_FILES['image'], ROOT_PATH . '/uploads/');
    else    
        $imageName = null;

    $stmt = $pdo->prepare("
      INSERT INTO news (`title`, `category`, `short_text`, `full_text`, `photo`, `created_at`)
      VALUES (:t, :c, :s, :f, :p, NOW())
    ");
    $stmt->execute([
        't' => $title,
        'c' => $category,
        's' => $short_text,
        'f' => $full_text,
        'p' => $imageName
    ]);

    header('Location: index.php');
    exit();
    
}
?>


<?php require __DIR__ . '/views/header.view.php'; ?>

<h1 class="main-heading">Add a new</h1>

<?php require __DIR__ . '/views/form.view.php'; ?>

<?php require __DIR__ . '/views/footer.view.php'; ?>