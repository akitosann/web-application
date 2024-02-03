<?php
session_start();

try {
    if ($_SESSION['$Login_judgement'] == true) {
        echo json_encode($_SESSION['$Login_address']);
    } else {
        echo "not found";
    }
} catch (Exception $e) {
    // エラーメッセージを出力
    echo $e->getMessage();
}
?>