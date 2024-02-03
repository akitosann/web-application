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

    $fp = fopen('../static/fukuijizakana.csv', 'r');

    $columns = fgetcsv($fp);
    while ($line = fgetcsv($fp)) {
        try {
            // データベースに接続
            $pdo = new PDO('mysql:charset=UTF8;dbname=' . $db . ';host=' . $host, $user, $password);

            // データを取得するSQL文をセット
            $stmt = $pdo->prepare('INSERT INTO fukuijizakana (id, flnm, genre, url) VALUES(:id, :flnm, :genre, :url)');
            print_r($line);

            // 値をセット
            $stmt->bindValue(':id', $line[0]);
            $stmt->bindValue(':flnm', $line[1]);
            $stmt->bindValue(':genre', $line[2]);
            $stmt->bindValue(':url', $line[3]);

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