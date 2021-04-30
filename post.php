<?php
/* dbconnect_post/phpに接続 */
require_once('./dbconnect_post.php');

/* もし$_POST['post']が空じゃなかったら以下のtry～catch文を実行 */
if(!empty($_POST['post'])) {
    try {
        /* prepareメソッドでSQL文を準備しセットする */
        $stmt = $dbh->prepare('INSERT INTO post(post_content) VALUES(:CONTENTS)');
        /* SQL文に文字列変数を埋め込む（バインド）する */
        $stmt->bindParam(':CONTENTS', $_POST['post'], PDO::PARAM_STR);
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
    <title>投稿フォーム</title>
</head>
<body>
    <form action="" method="post">
        <textarea id="post" cols="230" rows="15" name="post" placeholder="お気に入りの曲を投稿してみよう！"></textarea><br>
        <input type="submit" name="submit" value="投稿">
        <input type="button" value="ホームに戻る" onclick="history.back()">
    </form>
</body>
</html>