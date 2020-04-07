<?php
session_start();
if(!isset($_SESSION['cart']['food'])){
    session_destroy();
    
    session_start();
    header('Location: index.php');
    exit;
}
$db_host ='127.0.0.1';          // サーバーのホスト名
$db_name ='intern-form';       // データベース名
$db_user ='food';      // データベースのユーザー名
$db_pass ='intern-0302';      // データベースのパスワード
try {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=intern-form', $db_user,$db_pass);
} catch (PDOException $e) {
    exit('データベース接続失敗 ' . $e->getMessage());
}

$food = [];
if( isset($_SESSION['cart']['food']) ) {
    $food = $_SESSION['cart']['food'];
}



// ■【購入する】ボタンを押した時
if (isset($_POST["send"])) {
if ($_POST['send']) {
     // セッションに保存しておいた値の削除 2重複追加の防止のため
     unset($_SESSION['cart']['food']);
    // セッションの値の保存
     session_write_close();
    // セッションの再開
     session_start();
    // ■【データベース保存】
    // この時点では $food は配列なので、データベースに保存する為に文字列にする
    $food_str = implode(",", $food);
    // プリペアドステートメントを使い、安全にデータベースに登録されるようにしている
    // ■【注意点】orderではsqlの命令として、エラーになるので`order`としています。
    $sql = 'INSERT INTO `order` (name, email, food, created_at, updated_at) values(:name, :email, :food, :created_at, :updated_at )';
    $query = $dbh->prepare($sql);
    $query->bindValue(':name',       $_SESSION['cart']['name'],       PDO::PARAM_STR);
    $query->bindValue(':email',      $_SESSION['cart']['email'],      PDO::PARAM_STR);
    $query->bindValue(':food',       $food_str,    PDO::PARAM_STR);
    $query->bindValue(':created_at', date('Y-m-d H:i:s'),             PDO::PARAM_STR);
    $query->bindValue(':updated_at', date('Y-m-d H:i:s'),             PDO::PARAM_STR);
    $query->execute(); // データベースに保存される
    // ■【メール送信】
    mb_language("Japanese");
    mb_internal_encoding("UTF-8");
    $to      = 'From: ' . $_SESSION['cart']['email'];
    $from    = 'From: ' . $_SESSION['cart']['email'];
    $subject = '商品購入ページからのメール';
    $message = <<<EOF
注文を承りました。

■名前
{$_SESSION['cart']["name"]}

■メールアドレス
{$_SESSION['cart']['email']}

■食品
{$food_str}
EOF;

    mb_send_mail($to, $subject, $message, $from); // メール送信処理
    // ■【完了画面へリダイレクト】
    header('Location: complete.php');
    exit; // 必ず指定して残りの作業が行われないようにする
}
}
?>
<!DOCTYPE html>
<html lang="ja"><body>
<head>
    <meta charset="utf-8">
    <title>買い物カゴ</title>
    <link  href="assets/css/style.css"  rel="stylesheet" media="all"  />
</head>
<body>
    <h1 class="cheack">確認画面</h1>
    <h2 class="food-order">注文料理</h2>
    <table class="list-table" style="margin-bottom: 20px;">
        <?php foreach ( $food as $key => $value):?>
        <tr>
            <td><?= htmlspecialchars( $value, ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
        <?php endforeach;?>
    <table class="list-table" style="margin-bottom: 20px;">
      <h3 class="Orderer">注文者</h3> 
    <tr>
        <td><div>名前:</td><td><?= htmlspecialchars( $_SESSION['cart']['name'] ?? '',ENT_QUOTES, 'UTF-8') ?></div></td>
        <td><div>メールアドレス:</td><td><?=htmlspecialchars( $_SESSION['cart']['email'] ?? '',ENT_QUOTES, 'UTF-8')?></div></td>
    </div>
    </tr>
      <form action="confirm.php" method="POST">
    </table>
        <input type="submit" name="send" value="購入する" class="button">
    </form>
    <div><a href="cart.php">カート画面へ戻る</a></div>
</body>
</html>

