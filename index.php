<?php require __DIR__ . '/views/header.view.php'; 
require __DIR__ . '/inc/db-connect.inc.php'; 
require __DIR__ . '/inc/functions.inc.php'; 

$stmt = $pdo->prepare('SELECT n.* FROM news n INNER JOIN (SELECT category, MAX(id) AS latest_id FROM news GROUP BY category
) AS latest ON n.id = latest.latest_id ORDER BY n.created_at DESC;');
$stmt->execute();
$latestCategories = $stmt->fetchAll();
?>

<h1 class="main-heading">The hot topics of today</h1>
<div class="news">
  <?php foreach($latestCategories as $c): ?>
  <div class="new">
      <div class="new__category">
        <a href="category.php?<?php echo http_build_query(['category' => $c['category']]); ?>" class="new__category__link"
          ><?php echo e($c['category']); ?></a
          >
      </div>
      <div class="new__content">
        <div class="new__content__text">
          <h2 class="new__content__title">
            <?php echo e($c['title']); ?>
          </h2>
          <p class="new__content__paragraph">
            <?php echo e($c['short_text']); ?>
          </p>
          <p class="new__content__date"><?php echo e($c['created_at']); ?></p>
        </div>
    <img
      src='uploads/<?php echo e($c['photo']); ?>'
      alt="photo"
      class="new__content__image"
    />
    </div>
  </div>
  <?php endforeach; ?>
</div>

<?php require __DIR__ . '/views/footer.view.php'; ?>
