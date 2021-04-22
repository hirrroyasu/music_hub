<?php
    /* 外部ファイルを読み込んでsession_start関数でデータをWebサーバーに保存 */
    require_once("./dbconnect.php");
    session_start();
    if(!isset($_SESSION['username'])) {
        header("Location: login.php");
    }
    /* idからユーザ名を取得 */
    $query = "SELECT * FROM login WHERE id=".$_SESSION['username']."";
    $result = $mysqli->query($query);

    if(!$result) {
        print ('クエリーが失敗しました。'.$mysqli->error);
        $mysqli->close();
        exit;
    }
    /* ユーザ情報の取り出し */
    while($row = $result->FETCH_ASSOC()) {
        $username = $row['username'];
        $email = $row['email'];
    }
    /* DB切断 */
    $result->close();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ホーム -MusicHub</title>
</head>
<body>
    <h1>ホーム</h1>
</body>
</html>