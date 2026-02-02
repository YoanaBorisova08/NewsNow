<?php require __DIR__ . '/views/header.view.php';
require __DIR__ . '/inc/functions.inc.php';
require __DIR__ . '/inc/db-connect.inc.php';

if(!empty($_GET['category'])){ 
  $stmtGetCategories = $pdo->prepare("SELECT DISTINCT `category` FROM news;");
  $stmtGetCategories->execute();
  $categories = $stmtGetCategories->fetchAll(PDO::FETCH_COLUMN);

  if(in_array($_GET['category'], $categories) ){ 
    $perPage = 3;
    $page = (int) ($_GET['page'] ?? 1);
    if($page<0) $page=0;
    $offset=($page-1)*$perPage;

    $stmtCount = $pdo->prepare('SELECT COUNT(*) AS `count` FROM `news` WHERE category = :category');
    $stmtCount->bindValue(':category', $_GET['category']);
    $stmtCount->execute();
    $count = $stmtCount->fetch(PDO::FETCH_ASSOC)['count'];

    $numPages = ceil($count/$perPage);

    $stmtC = $pdo->prepare("SELECT * FROM news WHERE category = :category ORDER BY `created_at` DESC LIMIT :limit OFFSET :offset;");
    $stmtC->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
    $stmtC->bindValue(':offset', (int)$offset,  PDO::PARAM_INT);
    $stmtC->bindValue(':category', $_GET['category']);
    $stmtC->execute();
    $newsFromCategory = $stmtC->fetchAll();

  }
}

?>
<?php if(empty($newsFromCategory)): ?>
  <h1 class="main-heading">No news for this category.</h1>
<?php else: ?>
  <h1 class="main-heading"><?php echo e($_GET['category']) ?></h1>

  <div class="news">
    <?php foreach($newsFromCategory as $new): ?>
      <div class="new">
      <div class="new__content">
        <div class="new__content__text">
          <p class="new__content__date"><?php echo e($new['created_at']) ?></p>
          <a href="new.php?<?php echo http_build_query(['id' => $new['id']]) ?>" class="new__link"
          ><h2 class="new__content__title">
            <?php echo e($new['title']) ?>
          </h2></a>
          <p class="new__content__paragraph">
            <?php echo e($new['short_text']) ?>
          </p>
        </div>
          <img
          src="uploads/<?php echo e($new['photo']) ?>"
          alt="<?php echo e($new['title']) ?>"
          class="new__content__image"
          />
      </div>
    </div>
  <?php endforeach; ?>
  </div>


  <?php if ($numPages>1): ?>
      <ul class="pagination">
        <?php if($page>1): ?>
        <li class="pagination__li">
          <a href="category.php?<?php echo http_build_query(['category' => $_GET['category'], 'page' => $page-1]); ?>" class="pagination__link">⏴</a>
        </li>
        <?php endif; ?>
        <?php for($x=1; $x<=$numPages; $x++): ?>
          <li class="pagination__li">
            <a href="category.php?<?php echo http_build_query(['category' => $_GET['category'], 'page' => $x]); ?>" class="pagination__link <?php if ($page===$x): ?>pagination__link--active<?php endif; ?>">
              <?php echo e($x); ?>
            </a>
          </li>
        <?php endfor; ?>
        <?php if($page<$numPages): ?>
          <li class="pagination__li">
            <a href="category.php?<?php echo http_build_query(['category' => $_GET['category'], 'page' => $page+1]); ?>" class="pagination__link">⏵</a>
          </li>
        <?php endif; ?>
      </ul> 
  <?php endif; ?>
  
<?php endif;?>
<?php require __DIR__ . '/views/footer.view.php'; ?>