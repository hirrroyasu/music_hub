<?php
require_once('./dbconnect.php');
session_start();
$output = '';
// if (isset($_SESSION['id'])) {
//   $output = 'Logoutしました。';
// } else {
//   $output = 'SessionがTimeoutしました。';
// }
//セッション変数のクリア
$_SESSION = array();
//セッションクッキーも削除
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 1800,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
  }
//セッションクリア
session_destroy();
if (!$_SESSION) {
  $output = 'Logoutしました。';
  } else {
  $output = 'SessionがTimeoutしました。';
  }

echo $output;
echo '<br>';
echo '<a href="./login.php">ログインする</a>';
