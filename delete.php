<?php
session_start();

if(!isset($_GET["id"])) {
    header('Location: index.php');
    exit;
}



$db_host ='127.0.0.1';          // サーバーのホスト名
$db_name ='intern-form';       // データベース名
$db_user ='food';      // データベースのユーザー名
$db_pass ='intern-0302';      // データベースのパスワード
try {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=intern-form', $db_user,$db_pass);
    $stmt = $dbh->prepare('DELETE FROM `order` WHERE id = :id');
    $stmt->execute(array(':id' => $_GET["id"]));
} catch (PDOException $e) {
    exit('データベース接続失敗 ' . $e->getMessage());
}
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
<body>

<?php if (isset($_GET["id"])):?>
        <h1>削除しました</h1>
<?php endif ?>
    <a href=index.php>戻る</a>
</body>
</html>