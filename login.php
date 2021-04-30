<?php
/* 全てのエラーを表示する。ini_setの引数の1はエラー表示、0は表示しない */
error_reporting(E_ALL);
ini_set('display_errors', '1');

/* 外部ファイルを読み込んでsession_start関数でデータをWebサーバーに保存 */
require_once("./dbconnect.php");
include("./header.php");
session_start();

/* empty関数: 引数でもらった値が存在しない、空もしくはnullだった場合trueを返す */
if(!empty($_SESSION['login'])) {
    echo "ログイン済みです<br>";
    echo '<a href="./index.php">ホームに戻る</a>';
    exit();
}

if(isset($_SESSION['id'])!="") {
    header('Location: http://localhost/musichub/index.php');
}

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql ="SELECT * FROM login WHERE username=:username";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch();
    
    
    if(password_verify($password, $row['password'])) {
        $name = $row['username'];
        $user = "SELECT * FROM login WHERE username = '$name'";
        $statement = $dbh->prepare($user);
        $statement->execute();
        foreach ($statement as $row) {
            $row['username'];
        }
        $_SESSION["USERNAME"] = $row['username'];
        header('Location: http://localhost/musichub/index.php');
    }
}
?>

<div id="form">
    <form action='login.php' method="post">
    <h2>ログインフォーム</h2>
        <?php if(isset($_POST['login']) && !password_verify($password, $row['password'])): ?>
            <p class="error">！ユーザー名もしくはパスワードが一致しません</p>
        <?php endif ?>
        <p><label>ユーザー名<br>
        <input type="text" name="username" required></label></p>
        <p><label>パスワード<br>
        <input type="password" name="password" required></label></p>
    <p class="submit"><input type="submit" name="login" value="ログイン"></p>
    <a href="signup.php">会員登録はこちら</a>
    </form>
</div>
<!-- if(isset($_POST['username'])) {
    $dsn='mysql:
    name=login;charset=utf-8';
    $username='ユーザー名';
    $password='パスワード';
    $dbh = new PDO($dsn,$username,$password);
    $stmt = $dbh->prepare("INSERT INTO USER VALUES(:username, :email, :password)");
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':password', $_POST['password']);
    $stmt->execute();
} -->