<?php
require_once('./dbconnect.php');
require_once('./dbconnect_post.php');
session_start();

if (!isset($_SESSION["USERNAME"])) {
    header("Location: logout.php");
    exit;
}
try {
    $sql = 'SELECT * FROM post';
    $stmt = $dbh->query($sql);

    $row_count = $stmt->rowCount();
    while($row = $stmt->fetch()) {
        $rows[] = $row;

        $dbh = null;
    }
} catch(PDOException $e) {
    echo "Error!".$e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>ホーム -MusicHub</title>
</head>
<body id="index">
<header id="top">
	<h1><a href="index.php">MusicHub</a></h1>
</header>
    <p class="welcome">ようこそ、<?php echo htmlspecialchars($_SESSION["USERNAME"], ENT_QUOTES); ?>さん！</p>
    <nav>
        <ul>
            <a href="./index.php"><li>Top</li></a>
            <a href="./genre.php"><li>ジャンル別投稿一覧</li></a>
            <a href="./mypage.php"><li>マイページ</li></a>
            <a href="./logout.php"><li>ログアウト</li></a>
        </ul>
    </nav>
    <a href="./post.php" class="btn btn--orange btn--radius">投稿する</a>

    <?php
    foreach($rows as $row) {
        echo htmlspecialchars($row['post_content'], ENT_QUOTES, 'UTF-8').'<br />';
    }
    ?>
</body>
</html>