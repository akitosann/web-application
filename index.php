<?php
session_start();
?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <title>トップページ</title>
    <meta name="description" content="サイトの説明文">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
</head>

<?php
    if (isset($_POST['action'])) {
        unset($_SESSION['$Login_judgment']);
        unset($_SESSION['$Login_name']);
    }
?>

<body id = "body">
    <header>
        <a class = "titlemenu" href="#body">トップページ</a>
        <ul class = "page-link">
            <li><a href="#area-1">救急医療マップ</a></li>
            <li><a href="#area-2">医療施設クイズ</a></li>
            <li><a href="#area-3">避難所検索</a></li>
            <li><a href="#area-4">その他</a></li>
        <?php
        if($_SESSION['$Login_judgment'] == TRUE){
        ?>  
            <li>
                <form action="" method="post">
                    <button class = "logoutmenu" type="submit" name="action">
                        <?php echo($_SESSION['$Login_name'])?>様<br>ログアウト
                    </button>
                </form>
            </li>
        <?php
        }else{
        ?>
				<li class = "action-link"><a class = "sign-upmenu" href="html/sign-up.php">新規登録</a></li>
                <li class = "action-link"><a class = "loginmenu" href="html/login.php">ログイン</a></li>
            </ul>
        <?php
        }
        ?>
        
    </header>

    <div class = "top">
        <h1 class = "title">緊急時対策サイト</h1>
        <div id="video-area">
            <video id="video" poster="" webkit-playsinline playsinline muted autoplay loop>
                <source src="img/background.mp4" type="video/mp4">
                <p>動画を再生できる環境ではありません。</p>
            </video>
        </div>
        
    </div>
    
    <main>
        <div>
            <h2 class="text-center">コンテンツ</h2>
        </div>
        <div class = "center" id = "area-1">
            <ul class="contents co1">
                <li class="contents-a box">
                    <a href="app/emergency-map">救急医療マップ</a>
                </li>
            </ul>
        </div>
        <div class = "center" id = "area-2">
            <ul class="contents co2">
                <li class="contents-b box">
                    <a href="quiz/quiz.html">医療施設クイズ</a>
                </li>
            </ul>
        </div>
        <div class = "center" id = "area-3">
            <ul class="contents co3">
				<li class="contents-c box">
                    <a href="html/contents.php">避難所検索</a>
                </li>
            </ul>
        </div>

    </main>

    <footer id = "area-4">
		<div>
        	<ul class="">
				<li class="">
                	<a href="app/easy-viewDB">使用データベース</a>
            	</li>
        	</ul>
		</div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="js/index.js" async></script>
</body>


</html>