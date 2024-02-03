<?php
header("Content-Type: application/json; charset=UTF-8");

$host = 'localhost';
$user = 'exp33_23_04';
$password = 'EXP33_23_04';
$db = 'exp33_23_04';
$pdo = null;

try {
    // データベースに接続
    $pdo = new PDO('mysql:charset=UTF8;dbname=' . $db . ';host=' . $host, $user, $password);

    // データを取得するSQL文をセット
    $stmt = $pdo->prepare("SELECT AED_public.facility_name, AED_public_Locations.latitude, AED_public_Locations.longitude FROM AED_public JOIN AED_public_Locations ON AED_public.id = AED_public_Locations.id;");

    // SQL実行
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
} catch (PDOException $e) {
    // エラーメッセージを出力
    echo $e->getMessage();
}

$pdo = null;
?>