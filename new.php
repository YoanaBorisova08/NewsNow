<?php require __DIR__ . '/views/header.view.php';
require __DIR__ . '/inc/functions.inc.php';
require __DIR__ . '/inc/db-connect.inc.php';

if(!empty($_GET['id'])){
  $stmtCount = $pdo->prepare('SELECT COUNT(*) AS `count` FROM `news`');
  $stmtCount->execute();
  $count = $stmtCount->fetch(PDO::FETCH_ASSOC)['count'];
  if($_GET['id']>=0 && $_GET['id']<=$count){
    $stmt = $pdo->prepare("SELECT * FROM news WHERE `id`=:id");
    $stmt->bindValue(':id', (int)$_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $currentNew = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
}
?>

<?php if(!empty($currentNew)): ?>
<div class="new new--active">
  <h2 class="new__content__title new__title--active">
  <?php echo e($currentNew['title']) ?>
  </h2>
  <p class="new__content__paragraph new__p--active">
    <?php echo nl2br(e($currentNew['full_text'])) ?>
  </p>
  <img
  src="uploads/<?php echo e($currentNew['photo']) ?>"
  alt="photo"
  class="new__content__image new__img--active"
  />
</div>

<a href="category.php?<?php echo http_build_query(['category' => $currentNew['category']]);?>" class="button">
  《《《 Back<br/> to <?php echo e($currentNew['category']); ?>
</a>
<?php endif; ?>
<?php require __DIR__ . '/views/footer.view.php'; ?>