<?php
session_start();
if(isset($_SESSION['cart']["name"])){
$message = $_SESSION['cart']["name"].'さん、ご注文ありがとうございました';
session_destroy(); // セッションを削除
}
?>
<!DOCTYPE html>
<html lang="ja"><body>
<head>
    <meta charset="utf-8">
    <title>買い物カゴ</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link  href="assets/css/style.css"  rel="stylesheet" media="all"  />
</head>
<body>
    <h1>完了画面</h1>
    <p><?=htmlspecialchars($message ?? '',ENT_QUOTES, 'UTF-8')  ?></p>
    <div><a href="index.php">注文画面へ戻る</a></div>
</body>
</html>