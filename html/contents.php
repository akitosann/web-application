<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>避難所検索</title>
	<link rel="stylesheet" href="../css/contents.css">
</head>

<?php
	try{
		$pdo = new PDO("mysql:host=localhost;dbname=exp33_23_04;charset=utf8;", "exp33_23_04", "EXP33_23_04");
		
		$result_rows = $pdo->query("SELECT * FROM EvacuationData");
		$row = $result_rows->fetchAll();
	}catch(PDOException $e){
		echo 'Error:'.$e->getMessage();
	}
	$pdo=null;
	
	if($_SESSION['$Login_judgment'] == true){
		$address = $_SESSION['$Login_address'];
	}else{
		if($_POST['prefecture'] != null){
			$_SESSION["prefecture"] = $_POST['prefecture'];
			$_SESSION["city"] = $_POST['city'];
			$_SESSION["street_number"] = $_POST['street_number'];
		}
		
		if($_SESSION["prefecture"] != null){
			$address = $_SESSION["prefecture"].$_SESSION["city"].$_SESSION["street_number"];
		}else{
			$address = "福井県福井市文京３丁目９−１";
		}
	}

	

	$url = "https://msearch.gsi.go.jp/address-search/AddressSearch?q=" . urlencode($address);
	$json = file_get_contents($url);
	$arr = json_decode($json);
	
	$la = 0;
	$lo = 0;
	$count = 0;

	foreach ($arr as $element) {
		$la += (double)$element->geometry->coordinates[1];
		$lo += (double)$element->geometry->coordinates[0];
		$count++;
	}

	$la /= $count;
	$lo /= $count;

	$element;

	foreach($row as $i => $r){
		$ms[$i] = $row[$i]["m"] = abs($la - $r['latitude']) + abs($lo - $r['longitude']);
  	}

	
	
	array_multisort($ms,  SORT_ASC, $row);

	$tmp = 0;
	if (isset($_POST["btn0"])) {
		$tmp = 0;
	}else if(isset($_POST["btn1"])) {
		$tmp = 1;
	}else if(isset($_POST["btn2"])) {
		$tmp = 2;
	}else if(isset($_POST["btn3"])) {
		$tmp = 3;
	}else if(isset($_POST["btn4"])) {
		$tmp = 4;
	}

	
	  
	$src = "https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d500!2d" .
	$row[$tmp]['longitude'] . "!3d" . $row[$tmp]['latitude'] . 
	"!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMzXCsDQwJzA2LjciTiAxMznCsDM5JzAyLjUiRQ!5e0!3m2!1sja!2sjp" ;
?>

<body>
	<header>
        <a class = "titlemenu menu" href="http://fecsisv.fecs.eng.u-fukui.ac.jp/~exp33-23-04/">トップページ</a>
    </header>


	<main>
		<?php if($_SESSION['$Login_judgment'] == false){ ?>
		<form action="" method="post">
			<label>
				<span>都道府県</span>
				<select name="prefecture">
					<option value="福井県">福井県</option>
				</select>
			</label>
			<label>
				<span>市区町村</span>
				<select name="city">
					<option value="あわら市">あわら市</option>
					<option value="池田町">池田町</option>
					<option value="永平寺町">永平寺町</option>
					<option value="越前市">越前市</option>
					<option value="越前町">越前町</option>
					<option value="おおい町">おおい町</option>
					<option value="大野市">大野市</option>
					<option value="小浜市">小浜市</option>
					<option value="勝山市">勝山市</option>
					<option value="坂井市">坂井市</option>
					<option value="鯖江市">鯖江市</option>
					<option value="高浜町">高浜町</option>
					<option value="敦賀市">敦賀市</option>
					<option value="福井市">福井市</option>
					<option value="南越前町">南越前町</option>
					<option value="美浜町">美浜町</option>
					<option value="若狭町">若狭町</option>
				</select>
			</label>
			<label>
				<span>町名・番地</span>
				<input type="text" name="street_number" autocomplete="shipping address-line1">
			</label>
			<button type="submit">送信</button>
		</form>
		<?php }else{?>
		<div>
			<h1><?php echo($_SESSION['$Login_name']); ?>様の住所:<?php echo($_SESSION['$Login_address']); ?></h1>
		</div>
		<?php }?>

		<?php
			for($i = 0; $i <  5; $i++){
		?>
				<form action="" method="post">
					<button class = "name_btn" type="submit" name= "btn<?php echo($i); ?>"><?php echo($row[$i]['name']); ?></button>
				</form>
		<?php
			}
		?>
		
		<br>
		<br>
		<br>
		<br>
		<div>
			<h1><?php echo($row[$tmp]['name']); ?></h1>
			<p>住所:<?php echo($row[$tmp]['address']); ?></p>
		</div>
		
		<iframe src=<?php echo($src);?>
		width="100%" height="550" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
	</main>
	
	
	</body>


</html>