<?php
// データベースに接続して指定したテーブルの全レコードを取得する関数
function getAllRecords($table_name)
{
    $host = 'localhost';
    $user = 'exp33_23_04';
    $password = 'EXP33_23_04';
    $db = 'exp33_23_04';

    $data = null;

    try {
        // データベースに接続
        $pdo = new PDO('mysql:charset=UTF8;dbname=' . $db . ';host=' . $host, $user, $password);

        // データを取得するSQL文をセット
        $stmt = $pdo->prepare('SELECT * FROM ' . $table_name);

        // SQL実行
        $res = $stmt->execute();

        // データを取得（連想配列で）
        if ($res) {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    } catch (PDOException $e) {
        // エラーメッセージを出力
        echo $e->getMessage();
    }

    // データベースの接続解除
    $pdo = null;

    // 取得したレコード(連想配列)を返却  
    return $data;
}
?>