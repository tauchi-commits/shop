<?php
session_start();

$food = []; // foreachでループ処理させる為に配列にしておく

$errors = []; // エラー内容を格納する配列
$wordcount=8;//文字数制限
$value="";
// 商品がセッションに保存されていたら
if( isset($_SESSION['cart']['food']) ) {
    $food = $_SESSION['cart']['food'];
    /* $food
    array(2) {
      [0]=>
      string(9) "商品１"
      [1]=>
      string(9) "商品２"
    }
     */
}
// ■【確認する】ボタンを押した時
if (isset($_POST["send"])) {
if ($_POST['send']) {
    // 名前・メールアドレス・商品　これらをセッションで持った状態にする
    $_SESSION['cart']['name'] = $_POST['name'];
    $_SESSION['cart']['email'] = $_POST['email'];
    // $food　はすでに「$_SESSION['cart']['food']」の値になっている
    // ■【エラー判定】
    /* 「エラー判定1」
     * 商品を格納している配列（$food）が空の場合
     */
    if( !count($food)) {
        $errors[] = "商品を選択してください";
    }
    /* 「エラー判定2」
     * 配列　$errors にエラー内容を格納
     * 名前「$_POST['name']」が入力されているか（必須）
     * メールアドレス「$_POST['email']」が入力されているか（必須）
     */
    $word=strlen($_POST['name']);//入力された文字の長さを所得している
    if($word>$wordcount){
        $errors[] = "8文字以内で入力してください";
    }
    if( !strlen($_POST['name'])){
        $errors[] = "名前を入力してください";
    }
    if( !strlen($_POST['email'])){
        $errors[] = "メールアドレスを入力してください";
    }

    if(!empty($_POST['email']) && !preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\?\*\[|\]%'=~^\{\}\/\+!#&\$\._-])*@([a-zA-Z0-9_-])+\.([a-zA-Z0-9\._-]+)+$/", $_POST['email'])){
        $errors[] = "メールアドレスが無効です";
    }
    if(!empty($_POST['name'])&&preg_match('/[\xF0-\xF7][\x80-\xBF][\x80-\xBF][\x80-\xBF]/', $_POST['name'])) {
        $errors[]='絵文字を使わないでください';
    }
    if(!empty($_POST['name'])&&preg_match('/(?:\xEE[\x80\x81\x84\x85\x88\x89\x8C\x8D\x90-\x9D\xAA-\xAE\xB1-\xB3\xB5\xB6\xBD-\xBF]|\xEF[\x81-\x83])[\x80-\xBF]/',$_POST['name'])) {
        $errors[]='絵文字を使わないでください';
    }
    if (!empty($_POST['name'])&&!preg_match("/^[ぁ-んァ-ヶー一-龠]+$/u",$_POST['name'])) {
        $errors[]='日本語入力でお願いします';
    }
    // 確認画面へのリダイレクト　エラーが起きなかった時
    if ( !count($errors) ) {
        // 確認画面へ行く
        header('Location: confirm.php');
        exit; // 必ず指定して残りの作業が行われないようにする
    }
}
}
$i=null;//何かしらの値を宣言しないとエラーメッセージがでる。
?>

<!DOCTYPE html>
<html lang="ja"><body>
<head>
    <meta charset="utf-8">
    <title>買い物カゴ</title>
    <link  href="assets/css/style.css"  rel="stylesheet" media="all"  />
</head>
<body>

    <?php if(count($errors)): // エラーが設定されている時 ?>
    <h1>エラー</h1>
    <div class="errors">
        <p>エラーが発生しました</p>
        <ul>
            <?php foreach ($errors as $error_key => $error_value): ?>
            <li><?= htmlspecialchars($error_value, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif ?>

    <form action="clear.php" method="POST">
    <h1>カートの中身</h1>
    <table class="list-table2" style="margin-bottom: 20px;">
        <?php foreach ($food as $key => $value):$i++;?>
        <tr>
         <td><?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?></td>
         <td><label><input type="radio" name="delete" value="<?=$key?>">取り消し選択</label></td>
        </tr>
        <?php endforeach; ?>
        </table>
        <input type="submit" name="send" value="取り消し" class="button">
    </form>
    <h1>注文者情報入力</h1>
    
    <form action="cart.php" method="POST">
        <div class="mail-item">
            <label class=mail-items>
                <input type="text"  placeholder="名前" name="name" value="<?= htmlspecialchars($post_values['cart']['name'] ?? '',ENT_QUOTES, 'UTF-8') ?>">
        </label>
        </div>
        <div class="mail-item">
            <label>
                <input type="text"  placeholder="メールアドレス" name="email" value="<?= htmlspecialchars($post_values['cart']['email'] ?? '',ENT_QUOTES, 'UTF-8') ?>">
            </label>
        </div>
        <input type="submit" name="send" value="確認する" class="button">
    </form>
    <div><a href="index.php">メニュー画面へ戻る</a></div>
                
</body>
</html>