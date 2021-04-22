<?php
/* 外部ファイルを読み込んでsession_start関数でデータをWebサーバーに保存 */
require_once("./dbconnect.php");
include("./header.php");
session_start();

/**
 * empty関数: 引数でもらった値が存在しない、空もしくはnullだった場合trueを返す */
if(!empty($_SESSION['login'])) {
    echo "ログイン済みです<br>";
    echo "<a href=index.php>ホームに戻る</a>";
    exit;
}

if(isset($_SESSION['username'])!="") {
    header("Location: index.php");
}

if(isset($_POST['ログイン'])) {
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);

    $query = "SELECT * FROM login WHERE email='$email'";
    $result = $mysqli->$query($query);
    if(!$result) {
        print('クエリーが失敗しました。'.$mysqli->error);
        $mysqli->close();
        exit;
    }
    while($row=$result->FETCH_ASSOC()) {
        $db_hased_pwd=$row['password'];
        $id= $row['id'];
    }
    $result->close();
    
    if(password_verify($password, $dn_hased_pwd)) {
        $_SESSION['username'] = $id;
        header ("Location: index.php");
        exit;
    } else { ?>
        <div class="alert alert-danger" role="alert">メールアドレスとパスワードが一致しません</div>
    <?php }
}

    /**
     * isset関数: 引数でもらった変数に値が入っているかどうか。入っていてnullじゃなかったらtrue,そうじゃなかったらfalseを返す
     * 今回は変数errorに値が入ってなかったときに以下の処理をする */
    // if(!isset($error)) {
    //     /** "->": アロー演算子。左辺のインスタンス変数dbhから右辺のprepareメソッドを取り出す。Javaでいう「インスタンス変数名.メソッド」の"."の部分
    //      *  prepareメソッド: プリペアドステートメント。引数で指定したSQL文をセットしてユーザーからの入力を受け付ける準備をし、後から値を置き換える */
    //     $stmt = $dbh->prepare('SELECT COUNT(*) as cnt FROM login WHERE username=? and email=?');
    //     /* execute: プリペアドステートメントを実行する関数 */
    //     $stmt->execute(array(
    //             $_POST['username'],
    //             $_POST['email']
    //     ));
    //     $record = $stmt->fetch();
    //     if($record['cnt']>0) {
    //         $error['email'] = 'duplicate';
    //         $error['username'] = 'duplicate';
    //     }
    // }
?>
<div id="form">
    <form action="login.php" method="post">
    <h2>ログインフォーム</h2>
        <p><label>ユーザー名<br>
        <input type="text" name="username" required></label></p>
        <p><label>パスワード<br>
        <input type="password" name="password" required></label></p>
    <p class="submit"><input type="submit" value="ログイン"></p>
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