<?php
session_start();
$db_host ='127.0.0.1';          // サーバーのホスト名
$db_name ='intern-form';       // データベース名
$db_user ='food';      // データベースのユーザー名
$db_pass ='intern-0302';      // データベースのパスワード
try {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=intern-form', $db_user,$db_pass);
} catch (PDOException $e) {
    exit('データベース接続失敗 ' . $e->getMessage());
}
// ボタン「商品を追加」が押された時
$errors = [];
if (isset($_POST["send"])) {
if ($_POST['send']) {
    //echo '■「チェック」■■■■■■■■■■■■■■■■■';
    // ■「商品が選択されていない時」エラー判定
    if(!isset($_POST['food'])) {
        $errors = [
            '商品を選択してください',
        ];
    }
    // 配列　$errors にエラー内容を格納
    // エラーが起きなかった時
    if ( !count($errors) ) {
        // セッションに商品の値を保存
        $_SESSION['cart']['food'][] = $_POST['food'];
        // カート画面へ行く
       header('Location: cart.php');
       exit; // 必ず指定して残りの作業が行われないようにする
    }
}
}

// 注文履歴取得
$sql = 'select * from `order`';
$stmt = $dbh->query($sql);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC); // データベースに登録されている全ての注文内容を連想配列で取得
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>商品一覧</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link  href="assets/css/style.css"  rel="stylesheet" media="all"  />
</head>
<body　bgcolor="black" text="黒">
<header>
<div class="header-left">
    <h1 class="top-header">中華料理店</h1>
</div>
<div class="header-right">
 <ul>
    <a href="cart.php" class="cart">カートを見る</a>
 </ul>    
</div>
</header>
<h1 class="order">注文画面</h1>
    <?php if (count($errors)): // エラーが設定されている時 ?>
        <div class="errors">
            <p>エラーが発生しました</p>
            <ul>
                <?php foreach ($errors as $error_key => $error_value):?>
                    <li><?= htmlspecialchars($error_value, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach;?>
            </ul>
        </div>
    <?php endif ?>
<h2 class="foods">料理一覧</h2>
    <form action="index.php" method="POST"> 
<div class="menu-card-wrapper">    
<div class="menu">

    <div class="menu-card">
    <div class="menu-card-inner">
           <img class="menu-image" src="gazou/food.jpg" alt="焼きめし"> 
        <br><label><input type="radio" name="food" value="焼き飯" >焼き飯定食</label></br>
     </div>
     </div>

     <div class="menu-card1">
    <div class="menu-card-inner">
           <img class="menu-image" src="gazou/food2.jpg" alt="餃子定食"> 
        <br><label><input type="radio" name="food" value="餃子定食">餃子飯定食</label></br>
    </div>
    </div>

        <div class="menu-card2">
    <div class="menu-card-inner">
           <img class="menu-image" src="gazou/food3.jpg" alt="天津飯定食"> 
        <br><label><input type="radio" name="food" value="天津飯定食">天津飯定食</label></br>
      </div>
     </div>

     
     <div class="menu-card3">
    <div class="menu-card-inner">
           <img class="menu-image" src="gazou/food4.jpg" alt="麻婆豆腐"> 
       　 <br><label><input type="radio" name="food" value="麻婆豆腐">麻婆豆腐定食</label></br>
    </div>
    </div>
    </div>
    </div>
        <input type="submit" name="send" value="商品を追加" class="button">
    </form>
    <table class="list-table" style="margin-bottom: 20px;">
    <h3 class="Order-history">注文履歴</h3>
    <form action="index.php" method="POST"> 
    <?php foreach ($orders as $order):?>
    <tr>
        <td>【名前】<?= htmlspecialchars($order['name'], ENT_QUOTES, 'UTF-8') ?></td>
        <td>【メールアドレス】<?= htmlspecialchars($order['email'], ENT_QUOTES, 'UTF-8') ?></td>
        <td>【購入日時】<?= htmlspecialchars($order['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
       <td><a href=delete.php?id=<?=$order["id"]?> class="cart">削除</a></td>
    </tr>
    <?php endforeach;?>
    </table>
</body>
</html>
