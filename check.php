<?php
require("./dbconnect.php");
session_start();

if(!isset($_SESSION['join'])) {
    header('Location: signup.php');
    exit();
}

if(!empty($_POST['check'])) {
    $hash = password_hash($_SESSION['join']['password'], PASSWORD_BCRYPT);

    $statement = $dbh->prepare("INSERT INTO login SET username=?, email=?, password=?");
    $statement ->execute(array(
        $_SESSION['join']['username'],
        $_SESSION['join']['email'],
        $hash
    ));

    unset($_SESSION['join']);
    header('Location: success.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>確認画面</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
    <link rel="stylesheet" href="https://unpkg.com/sanitize.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="content">
        <form action="" method="POST">
            <input type="hidden" name="check" value="checked">
            <h1>入力情報の確認</h1>
            <h2>こちらの内容で登録してよろしいですか？</h2>
            <?php if(!empty($error) && $error == "error"): ?>
                <p class="error">＊登録に失敗しました</p>
            <?php endif ?>
            <hr>
            <div class="control">
                <p>ユーザー名</p>
                <p><span class="fas fa-angle-double-right"></span><span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['username'], ENT_QUOTES); ?></span></p>
            </div>
            <div class="control">
                <p>メールアドレス</p>
                <p><span class="fas fa-angle-double-right"></span><span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES); ?></span></p>
            </div>

            <br>
            <a href="signup.php"><button type="button" class="back-btn">修正</button></a>
            <button type="submit"class="next-btn">登録</button>
        </form>
    </div>
</body>
</html>