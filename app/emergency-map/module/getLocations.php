<?php
header("Content-Type: application/json; charset=UTF-8");

$host = 'localhost';
$user = 'exp33_23_04';
$password = 'EXP33_23_04';
$db = 'exp33_23_04';
$pdo = null;

// POSTリクエストからデータを受け取る
$data = file_get_contents("php://input");
$data = json_decode($data, true);

try {
    // データベースに接続
    $pdo = new PDO('mysql:charset=UTF8;dbname=' . $db . ';host=' . $host, $user, $password);

    // データを取得するSQL文をセット
    $stmt = $pdo->prepare("INSERT INTO AED_public_Locations VALUES (:id, :lat, :lng)");

    // 値をセット
    $stmt = 

    // SQL実行
    $stmt->execute();

    echo json_encode($data);
} catch (PDOException $e) {
    // エラーメッセージを出力
    echo $e->getMessage();
}

$pdo = null;
?>