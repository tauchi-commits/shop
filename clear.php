<?php
session_start();
$i=-1;//削除する番号を決める
if(isset($_POST['delete'])) {//配列に値がなければ処理されない
    $food = []; // foreachでループ処理させる為に配列にしておく
    $food = $_SESSION['cart']['food'];//foodに商品を入れている   
        $i=$_POST['delete'];//押されてボタンの番号を代入している
            switch ($_POST['delete']) {
                case $i:
                    unset($_SESSION['cart']['food'][$i]);//指定した商品の削除
                    $_SESSION['cart']['food'] = array_values($_SESSION['cart']['food']);//連番をつなげている
                    break;
            }
        }
    ?>
<!DOCTYPE html>
<html lang="ja"><body>
<head>
    <meta charset="utf-8">
    <title>買い物カゴ</title>
</head>
<body>

    <?php if (isset($_POST['delete'])):?>
        <h1>取り消しました</h1>
    <?php else : ?>
        <h1>取り消す商品がありません</h1>
    <?php endif ?>
<div><a href="cart.php">戻る</a></div>
</body>
</html>

