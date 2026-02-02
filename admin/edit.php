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

if(empty($news)){
    die("News not found.");
}

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
    UPDATE news
    SET title = :title,
        category = :category,
        short_text = :short_text,
        full_text = :full_text,
        photo = :p
    WHERE id = :id
    ");

    $stmt->execute([
        't' => $title,
        'c' => $category,
        's' => $short_text,
        'f' => $full_text,
        'p' => $imageName,
        'id' => $id
    ]);

    header('Location: index.php');
    exit();
    
}
?>


<?php require __DIR__ . '/views/header.view.php'; ?>

<h1 class="main-heading">Edit a new</h1>


<form method="POST" action="edit.php" enctype="multipart/form-data">
    <div class="form-group">
        <label class="form-group__label" for="title">Title:</label>
        <input
            class="form-group__input"
            type="text"
            id="title"
            name="title"
            required
            value="<?php echo e($news['title']); ?>"
            />
    </div>
    <div class="form-group">
        <label class="form-group__label" for="category">Category:</label>
        <select
            class="form-group__input"
            type="text"
            id="category"
            name="category"
            value="<?php echo e($news['category']); ?>"
            required
        >
        <option>sport</option>
        <option>politics</option>
        <option>celebrities</option>
        <option>health</option>
        <option>economy</option>
        </select>
    </div>
    <div class="form-group">
        <label class="form-group__label" for="short_text">Short text:</label>
        <textarea
            class="form-group__input"
            id="short_text"
            name="short_text"
            rows="3"
            required
        ><?php echo e($news['short_text']); ?></textarea>
    </div>
    <div class="form-group">
        <label class="form-group__label" for="full_text">Full text:</label>
        <textarea
            class="form-group__input"
            id="full_text"
            name="full_text"
            rows="6"
            required
        ><?php echo e($news['full_text']); ?></textarea>
    </div>
    <div class="form-group">
        <label class="form-group__label" for="image">Image:</label>
        <input
            class="form-group__input"
            type="file"
            id="image"
            name="image"
        />
    </div>
    <div class="form-submit">
        <button class="button">Save!</button>
    </div>
</form>

<?php require __DIR__ . '/views/footer.view.php'; ?>