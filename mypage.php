<?php
require_once('./dbconnect.php');
session_start();

if (!isset($_SESSION["USERNAME"])) {
    header("Location: logout.php");
    exit;
} else {
    $username = $_SESSION["USERNAME"];
    $sql ="SELECT email FROM login WHERE username = :username";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $email = $stmt->fetchColumn();
 }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>マイページ</title>
</head>
<body id="mypage">
<header id="top">
	<h1><a href="mypage.php">マイページ</a></h1>
</header>
<nav>
    <ul>
        <a href="./index.php"><li>Top</li></a> 
        <a href="./genre.php"><li>ジャンル別投稿一覧</li></a>
        <a href="./mypage.php"><li>マイページ</li></a>
        <a href="./logout.php"><li>ログアウト</li></a>
    </ul>
</nav>
<div id="mypage">
    <p>・ユーザー名：<?php echo htmlspecialchars($_SESSION["USERNAME"], ENT_QUOTES) ?></p>
    <p>・メールアドレス：<?php echo htmlspecialchars($email, ENT_QUOTES) ?></p>
    
</div>
</body>
</html>