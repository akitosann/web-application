<html>
<head>
<meta charset="utf-8">
<title>Array</title>
<link rel="stylesheet" href="quiz2.css" type="text/css">
</head>
<body>

<?php
// SQLiteデータベースからデータを取得
// 初期設定
$dsn = 'mysql:host=localhost;dbname=exp33_23_04;charset=utf8';
$user = 'exp33_23_04';
$password = 'EXP33_23_04';

try{
    //データベースに接続
    $db = new PDO($dsn, $user, $password);
}catch( PDOException $error ){
    echo "接続失敗:".$error->getMessage();
    die();
}
    
$x = $_POST['table'];
    
    
$stmt = $db->prepare("SELECT facility_name FROM kyukyuiryoukikan");
$stmt2 = $db->prepare("SELECT url FROM kyukyushashin ORDER BY id ASC");
$stmt3 = $db->prepare("SELECT location FROM kyukyuiryoukikan");
$res = $stmt->execute();
$res2 = $stmt2->execute();
$res3 = $stmt3->execute();
    
if($res){
    $data1 = $stmt->fetchAll();   
}
if($res2){
    $data2 = $stmt2->fetchAll();
}
if($res3){
    $data3 = $stmt3->fetchAll();
    
}
$db = null;

$data1_json = json_encode($data1);
$data2_json = json_encode($data2);
$data3_json = json_encode($data3);

?>

<div id="quiz-container">
        <question>この医療施設はどれ？</question><br>
        <facility facility id="facility"></facility>
</div>
<div id="button-area">
 
    <div class="button">
        <button onclick="checkAnswer(1)" id="button1" >
        </button>
    </div>
    <div class="button">
        <button  onclick="checkAnswer(2)" id="button2" >
        
        </button>
    </div>
    <div class="button">
        <button  onclick="checkAnswer(3)" id="button3" >
        </button>
    </div>



</div>

<div id="bottom-container">
    <div id="answer-container">
        <div id="message"></div>
        <div id="message2"></div>
        <div id="message3"></div>
    </div>
    <div id="next-button">
        <button  id = "nbutton" onclick="Question()" disabled>NEXT
        </button>
    </div>
    <div id="retry-button">
        <button  id = "rbutton" onclick="Reset()" disabled>RETRY
        </button>

    <div id="top-button">
        <button  id = "tbutton" onclick="Go_top()">TOP
        </button>
    </div>
</div>

<script>
var data1Array = JSON.parse(JSON.stringify(<?php echo $data1_json; ?>));
console.log(data1Array);
var data2Array = JSON.parse(JSON.stringify(<?php echo $data2_json; ?>));
console.log(data2Array);
var data3Array = JSON.parse(JSON.stringify(<?php echo $data3_json; ?>));
console.log(data3Array);

document.getElementById('top-button').style.visibility = 'hidden';

function arrayShuffle(array) {
  for(let i = (array.length - 1); 0 < i; i--){

    // 0〜(i+1)の範囲で値を取得
    let r = Math.floor(Math.random() * (i + 1));

    // 要素の並び替えを実行
    let tmp = array[i];
    array[i] = array[r];
    array[r] = tmp;
  }
  return array;
}

    var indexlist = [0, 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,20,21,22,23,24];
    var sarray = arrayShuffle(indexlist);

    var currentQuestion = 0;            
    var totalQuestions = 3; // トータルの問題数
    var playindex = 0;
    var correctAnswerIndex;

    function Go_top() {
            window.location.href = ".."; // リダイレクト
    }

    function Reset(){
        currentQuestion = 0; 
        playindex += 1; 
        sarray = arrayShuffle(indexlist);
        document.getElementById('top-button').style.visibility = 'hidden';
        var retryButton = document.getElementById("rbutton");
        retryButton.disabled = true;
        document.getElementById('next-button').style.visibility = 'visible';
        Question();
    }


    function checkAnswer(selected) {

        var messageElement = document.getElementById("message");
        var messageElement2 = document.getElementById("message2");
        var messageElement3 = document.getElementById("message3");
        if (selected == correctAnswerIndex+1) {
            messageElement.textContent = "正解です！";
        } else {
            messageElement.textContent = "不正解です。"; 
            messageElement2.textContent = " 正解は " + (correctAnswerIndex+1) + " 番目のボタンでした。";
        }
        messageElement3.textContent = "住所: " + (data3Array[sarray[(currentQuestion - 1) * 3 + correctAnswerIndex]]).location;

        // ボタンを無効化
        var button1 = document.getElementById("button1");
        var button2 = document.getElementById("button2");
        var button3 = document.getElementById("button3");

        button1.disabled = true;
        button2.disabled = true;
        button3.disabled = true;

        if(currentQuestion != totalQuestions){
        var nextButton = document.getElementById("nbutton");
        nextButton.disabled = false;
        }
        else{
        var retryButton = document.getElementById("rbutton");
        retryButton.disabled = false;
        document.getElementById('next-button').style.visibility = 'hidden';
        document.getElementById('top-button').style.visibility = 'visible';
        }
    }

    function Question() {
    currentQuestion++; // 現在の問題番号を増やす
    if(currentQuestion != 1 || playindex != 0){
        const element = document.getElementById('image1'); 
        element.remove();
        const element2 = document.getElementById('image2'); 
        element2.remove();
        const element3 = document.getElementById('image3'); 
        element3.remove();
        var nextButton = document.getElementById("nbutton");
        nextButton.disabled = true;
    }

    var messageElement = document.getElementById("message");
    var messageElement2 = document.getElementById("message2");
    var messageElement3 = document.getElementById("message3");
    messageElement.textContent = ""; // メッセージをクリア
    messageElement2.textContent = ""; // メッセージをクリア
    messageElement3.textContent = ""; // メッセージをクリア

        var button1 = document.getElementById("button1");
        var button2 = document.getElementById("button2");
        var button3 = document.getElementById("button3");

        let newimg1 = document.createElement('img');
        newimg1.src = (data2Array[sarray[(currentQuestion - 1) * 3]]).url;
        newimg1.id = "image1";
        button1.appendChild(newimg1);
        let newimg2 = document.createElement('img');
        newimg2.src = (data2Array[sarray[(currentQuestion - 1) * 3 + 1]]).url;
        newimg2.id = "image2";
        button2.appendChild(newimg2);
        let newimg3 = document.createElement('img');
        newimg3.src = (data2Array[sarray[(currentQuestion - 1) * 3 + 2]]).url;
        newimg3.id = "image3";
        button3.appendChild(newimg3);
        // 画面に新しい問題を表示する


        var rand = Math.floor(Math.random()*3);

        correctAnswerIndex = rand;

        var facility = document.getElementById("facility");
        facility.textContent = (data1Array[sarray[(currentQuestion - 1) * 3 + rand]]).facility_name; 

        // ボタンを有効化
        var button1 = document.getElementById("button1");
        var button2 = document.getElementById("button2");
        var button3 = document.getElementById("button3");

        button1.disabled = false;
        button2.disabled = false;
        button3.disabled = false;

        
    }
    

// 0から24の乱数を生成する関数
function getRandomNumber() {
    var r;
    while(1){
        if((r = Math.floor(Math.random() * 25) )!= 19)
        return r;
    }
}

</script>

<script>




Question();
</script>






</body>
</html>