<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Load csv</title>
</head>

<body>
    <?php
    $host = 'localhost';
    $user = 'exp33_23_04';
    $password = 'EXP33_23_04';
    $db = 'exp33_23_04';
    $pdo = null;

    $fp = fopen('../static/AED_public.csv', 'r');

    $columns = fgetcsv($fp);
    while ($line = fgetcsv($fp)) {
        try {
            // データベースに接続
            $pdo = new PDO('mysql:charset=UTF8;dbname=' . $db . ';host=' . $host, $user, $password);

            // データを取得するSQL文をセット
            $stmt = $pdo->prepare('INSERT INTO AED_public (id, facility_name, location, tel, units) VALUES (:id, :facility_name, :location, :tel, :units)');
            print_r($line);

            // 値をセット
            $stmt->bindValue(':id', $line[0]);
            $stmt->bindValue(':facility_name', $line[1]);
            $stmt->bindValue(':location', $line[2]);
            $stmt->bindValue(':tel', $line[3]);
            $stmt->bindValue(':units', $line[4]);

            // SQL実行
            $stmt->execute();

        } catch (PDOException $e) {
            // エラーメッセージを出力
            echo $e->getMessage();
        }
    }

    $pdo = null;
    fclose($fp);
    ?>
</body>

</html>

<?php
?>