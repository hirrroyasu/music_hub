<?php
try {
    /* PDO: PHP Data Objectの略。DBへの接続や使用を簡単にしてくれるクラス */
    $dbh = new PDO('mysql:dbname=login;host=127.0.0.1;charset=utf8mb4', 'root', 'Fabric28');
} catch (PDOException $e) {
    echo "データベース接続エラー".$e->getMessage();
}