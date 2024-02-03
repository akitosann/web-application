<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
    <script src="./js/fukuijizakana.js"></script>
    <link rel="stylesheet" href="./css/table.css" type="text/css" />
    <title>SQL_table_show</title>
</head>

<body>
    <h1>テーブル一覧</h1>
    <div id="users">
        <input class="search" placeholder="Search" />
        <button class="sort" data-sort="id">
            idで並べ替え
        </button>
        <button class="sort" data-sort="flnm">
            flnmで並べ替え
        </button>
        <button class="sort" data-sort="genre">
            genreで並べ替え
        </button>
        <button class="sort" data-sort="url">
            urlで並べ替え
        </button>

        <table>
            <tbody class="list">
                <?php
                print_table('fukuijizakana');
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
function print_table($table_name)
{
    $host = 'localhost';
    $user = 'exp33_23_04';
    $password = 'EXP33_23_04';
    $db = 'exp33_23_04';

    $data = null;

    try {
        // (1) データベースに接続
        $pdo = new PDO('mysql:charset=UTF8;dbname=' . $db . ';host=' . $host, $user, $password);

        // (2) データを取得するSQL
        $stmt = $pdo->prepare("SELECT * FROM {$table_name}");

        // (4) SQL実行
        $res = $stmt->execute();

        // (5) データを取得
        if ($res) {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    } catch (PDOException $e) {
        // (6) エラーメッセージを出力
        echo $e->getMessage();
    }

    // カラム名表示
    print('<tr>');
    $keys = array_keys($data[0]);
    foreach ($keys as $key) {
        print "<th>" . $key . "</th>";
    }
    print('</tr>');


    for ($i = 0; $i < count($data); $i++) {
        print('<tr>');
        $keys = array_keys($data[$i]);
        for ($j = 0; $j < count($data[$i]); $j++) {
            echo "<td class='{$keys[$j]}'>{$data[$i][$keys[$j]]}</td>";
        }
        print('</tr>');
    }

    // (8) データベースの接続解除
    $pdo = null;
}
?>

<?php
function setButtons($table_name)
{
    $host = 'localhost';
    $user = 'exp33_23_04';
    $password = 'EXP33_23_04';
    $db = 'exp33_23_04';
    $pdo = null;

    try {
        // データベースに接続
        $pdo = new PDO('mysql:charset=UTF8;dbname=' . $db . ';host=' . $host, $user, $password);

        // データを取得するSQL文をセット
        $stmt = $pdo->prepare('SELECT * FROM ' . $table_name);

        // SQL実行
        $res = $stmt->execute();

        // データを取得（連想配列で）
        if ($res) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $data = array_keys($data);
        }

        foreach ($data as $column) {
            echo "<button class='sort' data-sort='{$column}'>";
            echo "{$column}で並び替え";
            echo "</button>";
        }

    } catch (PDOException $e) {
        // エラーメッセージを出力
        echo $e->getMessage();
    }

    $pdo = null;
}
?>