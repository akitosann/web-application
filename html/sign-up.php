<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
    <link rel="stylesheet" href="../css/sign-up.css">
</head>

<?php
  try{
    $pdo = new PDO("mysql:host=localhost;dbname=exp33_23_04;charset=utf8;", "exp33_23_04", "EXP33_23_04");
    
    $result_rows = $pdo->query("SELECT * FROM User_information");
    $row = $result_rows->fetchAll();
  }catch(PDOException $e){
    echo 'Error:'.$e->getMessage();
  }

  $Signup_judgment = TRUE;

  foreach($row as $r){
    if($r['email'] == $_POST['email']){
        $Signup_judgment = FALSE;
    }
  }

  if($Signup_judgment == TRUE && $_POST['email'] != NULL){
    try{
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        
        $sql = 'INSERT INTO User_information (name, email, password, address) values (?, ?, ?, ?)';
        $stmt = $pdo->prepare($sql);
        $flag = $stmt->execute(array($name, $email, $password, $address));
        $pdo=null;
    }catch(PDOException $e){
        echo 'Error:'.$e->getMessage();
    }
    header('Location:login.php');
    exit;
  }
  $pdo=null;
?>

<body>
    <header>
        <a class = "titlemenu menu" href="http://fecsisv.fecs.eng.u-fukui.ac.jp/~exp33-23-04/">トップページ</a>
        <a class = "loginmenu menu" href="login.php">ログイン</a>
    </header>
    <div class="register-container">
        <div class="register-box">
            <h2>新規登録</h2>
            <form action="" method="post">
                <div class="input-group">
                    <label for="username">ユーザー名:</label>
                    <input type="text" id="username" name="name" required>
                </div>
                <div class="input-group">
                    <label for="email">メールアドレス:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">パスワード:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="input-group">
                    <label for="address">住所:</label>
                    <input type="address" id="address" name="address" required>
                </div>
                <button type="submit">登録する</button>
                <?php
                if($Signup_judgment == FALSE && $_POST['email'] != NULL){
                    ?>
                    <h4>既に使用されているメールアドレスです</h2>
                <?php
                }
                ?>
            </form>
        </div>
    </div>
</body>
</html>