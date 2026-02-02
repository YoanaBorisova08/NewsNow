<?php
session_start();
if (empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require __DIR__ . '/views/header.view.php';
require __DIR__ . '/../inc/functions.inc.php';
require __DIR__ . '/../inc/db-connect.inc.php';
require_once __DIR__ . '/../inc/config.php'; 


$stmt = $pdo->prepare('SELECT `id`, `title`, `category`, `created_at` FROM news ORDER BY `created_at` DESC');
$stmt->execute();
$news = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Admin panel</h1>

<p>
  <a href="<?= BASE_URL ?>/admin/create.php">➕ Add news</a>
  |
  <a href="<?= BASE_URL ?>/index.php">Exit</a>
</p>

<table border="1" cellpadding="8">
  <thead>
    <tr>
      <th>Title</th>
      <th>Category</th>
      <th>Created at</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($news as $new): ?>
    <tr>
      <td><?php echo e($new['title'])?></td>
      <td><?php echo e($new['category'])?></td>
      <td><?php echo e($new['created_at'])?></td>
      <td>
        <a href="<?= BASE_URL ?>/admin/edit.php?id=<?php echo e($new['id'])?>">✏️</a>
        <a href="<?= BASE_URL ?>/admin/delete.php?id=<?php echo e($new['id'])?>">🗑</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>


<?php require __DIR__ . '/views/footer.view.php'; ?>