<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<?php
  try{
    $pdo = new PDO("mysql:host=localhost;dbname=exp33_23_04;charset=utf8;", "exp33_23_04", "EXP33_23_04");
    
    $result_rows = $pdo->query("SELECT * FROM User_information");
    $row = $result_rows->fetchAll();
    $pdo=null;
  }catch(PDOException $e){
    echo 'Error:'.$e->getMessage();
  }

  $_SESSION['$Login_judgment'] = FALSE;

  foreach($row as $r){
    if($r['email'] == $_POST['email'] && $r['password'] == $_POST['password']){
        $_SESSION['$Login_judgment'] = TRUE;
        $_SESSION['$Login_name'] = $r['name'];
        $_SESSION['$Login_email'] = $r['email'];
        $_SESSION['$Login_address'] = $r['address'];
        header('Location:..');
        exit;
    }
  }
?>

<body>
    <header>
        <a class = "titlemenu menu" href="http://fecsisv.fecs.eng.u-fukui.ac.jp/~exp33-23-04/">トップページ</a>
        <a class = "sign-upmenu menu" href="sign-up.php">新規登録</a>
    </header>

    <div class="login-container">
        
        <div class="login-box">
            <h2>ログイン</h2>
            <form action="" method="post">
                <div class="input-group">
                    <label for="username">メールアドレス:</label>
                    <input type="text" id="username" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">パスワード:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">ログイン</button>
                <?php
                if($_SESSION['$Login_judgment'] == FALSE && $_POST['email'] != NULL){
                    ?>
                    <h4>メールアドレスまたはパスワードが間違っています</h2>
                <?php
                }
                ?>
            </form>
            
        </div>
    </div>
</body>

</html>
