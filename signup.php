<?php
/* 外部ファイルを読み込んでsession_start関数でデータをWebサーバーに保存 */
require("./dbconnect.php");
include("./header.php");
session_start();

/**
 * empty関数: 引数でもらった値が存在しない、空もしくはnullだった場合trueを返す
 * $_POST: スーパーグローバル関数。HTTP POSTで渡された値を取得する変数。HTMLで記述されたformタグからの値を受け取る */
if(!empty($_POST)) {
    /**
     * isset関数: 引数でもらった変数に値が入っているかどうか。入っていてnullじゃなかったらtrue,そうじゃなかったらfalseを返す
     * 今回は変数errorに値が入ってなかったときに以下の処理をする */
    if(!isset($error)) {
        /** "->": アロー演算子。左辺のインスタンス変数dbhから右辺のprepareメソッドを取り出す。Javaでいう「インスタンス変数名.メソッド」の"."の部分
         *  prepareメソッド: プリペアドステートメント。引数で指定したSQL文をセットしてユーザーからの入力を受け付ける準備をし、後から値を置き換える */
        $stmt1 = $dbh->prepare('SELECT COUNT(*) as usercnt FROM login WHERE username=?');
        $stmt2 = $dbh->prepare('SELECT COUNT(*) as emailcnt FROM login WHERE email=?');
        /* execute: プリペアドステートメントを実行する関数 */
        $stmt1->execute(array($_POST['username']));
        $stmt2->execute(array($_POST['email']));
        $record1 = $stmt1->fetch();
        $record2 = $stmt2->fetch();
        if($record1['usercnt']>0) {
            $error['username'] = 'duplicate';
        }
        if ($record2['emailcnt']>0) {
            $error['email'] = 'duplicate';
        }
    }
    if(!isset($error)) {
        $_SESSION['join'] = $_POST;
        header('Location: check.php');
        exit();
    }

}
?>
<div id="form">
    <form action="" method="post">
    <h2>アカウント作成</h2>
    <div class="control">
        <p><label>ユーザー名<span class="required">必須<br></span>
        <input type="text" name="username" required></label></p>
        <?php if(!empty($error["username"]) && $error['username'] == 'blank'): ?>
            <p class="error">＊ユーザー名を入力してください</p>
        <?php elseif(!empty($error["username"]) && $error['username'] == 'duplicate'): ?>
            <p class="error">！このユーザー名は登録済みです</p>
        <?php endif ?>
    </div> 
    <div class="control">
        <p><label>メールアドレス<span class="required">必須<br></span>
        <input type="text" name="email" required></label></p>
        <?php if(!empty($error["email"]) && $error['email'] == 'blank'): ?>
            <p class="error">＊メールアドレスを入力してください</p>
        <?php elseif(!empty($error["email"]) && $error['email'] == 'duplicate'): ?>
            <p class="error">！このメールアドレスは登録済みです</p>
        <?php endif ?>
    </div>
    <div class="control">
        <p><label>パスワード<span class="required">必須<br></span>
        <input type="password" name="password" required></label></p>
        <?php if(!empty($error["password"]) && $error['password'] == 'blank'): ?>
        <p class="error">＊パスワードを入力してください</p>
        <?php endif ?>
    </div>
    <p class="submit"><input type="submit" value="登録"></p>
    <a href="login.php">ログインはこちら</a>
    </form>
</div>

<!-- if(isset($_POST['username'])) {
    $stmt = $dbh->prepare("INSERT INTO USER VALUES(:username, :email, :password)");
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':password', $_POST['password']);
    $stmt->execute();
} -->