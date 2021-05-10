<?php
/* dbconnect_post/phpに接続 */
require_once("./dbconnect.php");
require_once('./dbconnect_post.php');
session_start();

/* もしログインしていない状態で投稿ページに行こうとした場合ログアウト画面に自動遷移 */
if (!isset($_SESSION["USERNAME"])) {
    header("Location: logout.php");
    exit;
}

/* もし$_POST['post']が空じゃなかったら以下のtry～catch文を実行 */
if(!empty($_POST['post'])) {
    try {
        /* prepareメソッドでSQL文を準備しセットする */
        $stmt = $dbh->prepare('INSERT INTO post(post_content, username, url, genre) VALUES(:CONTENTS, :USERNAME, :URL, :GENRE)');
        /* SQL文に文字列変数を埋め込む（バインド）する */
        $stmt->bindParam(':CONTENTS', $_POST['post'], PDO::PARAM_STR);
        $stmt->bindParam(':USERNAME', $_SESSION["USERNAME"], PDO::PARAM_STR);
        $stmt->bindParam(':URL', $_POST['url'], PDO::PARAM_STR);
        $stmt->bindParam(':GENRE', $_POST['genre'], PDO::PARAM_STR);
        /* executeでSQL文実行 */
        $stmt->execute();
        /* index.phpをブラウザで表示 */
        header('Location: http://localhost/musichub/index.php');
        /* exit関数でtry～catch文を終了させる */
        exit();
    } catch (PDOException $e) {
        echo "データベース接続エラー".$e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>投稿フォーム</title>
</head>
<body id="post">
    <form action="" method="post">
        <textarea id="post" cols="230" rows="15" name="post" placeholder="お気に入りの曲を投稿してみよう！"></textarea><br>
        <input type="text" name="url" id="url" placeholder="埋め込みコードを貼り付けて下さい"><br>
        <select name="genre">
            <option value="" disabled selected style='display:none;'>ジャンルを指定</option>
            <option value="ロック">ロック</option>
            <option value="ポップ">ポップ</option>
            <option value="ヒップホップ">ヒップホップ</option>
            <option value="ジャズ">ジャズ</option>
            <option value="エレクトロニック">エレクトロニック</option>
        </select><br>
        <input type="submit" name="submit" value="投稿">
        <input type="button" value="ホームに戻る" onclick="location.href='index.php'">
    </form>
</body>
</html>