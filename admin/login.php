<?php require __DIR__ . '/views/header.view.php';
require __DIR__ . '/../inc/functions.inc.php';
require __DIR__ . '/../inc/db-connect.inc.php';
require_once __DIR__ . '/../inc/config.php';

session_start();

if ($_POST) {
    $user =null;
    try{
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :u");
        $stmt->bindValue(':u', trim($_POST['username']));
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
        require ROOT_PATH . '/errors/invalid_login_page.php';
        die();
    }

    if (!empty($user) && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['admin'] = true;
        header('Location: index.php');
        exit;
    }else{
        require ROOT_PATH . '/errors/invalid_login_page.php';
        die();
    }
}
?>


<h1 class="main-heading">Admin panel</h1>

<form method="post">
    <div class="form-group">
        <label class="form-group__label" for="username">Username:</label>
        <input
            class="form-group__input"
            type="text"
            id="username"
            name="username"
            required
            />
    </div>
    <div class="form-group">
        <label class="form-group__label" for="password">Password:</label>
        <input
            class="form-group__input"
            type="password"
            id="password"
            name="password"
            required
            />
    </div>
  <button type="submit" class="button">Log in</button>
</form>



<?php require __DIR__ . '/views/footer.view.php'; ?>