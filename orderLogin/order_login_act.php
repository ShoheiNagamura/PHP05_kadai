<?php
//発注者ログイン処理ーーーーーーーーーーーーー

// var_dump($_POST);
// exit();

//セッションsタート
session_start();

// DB接続関数を読み込み
//ログインチェック関数を関数ファイルから読み込み
include('../functions/connect_to_db.php');
include('../functions/check_session_id');

// フォームPOSTから受け取った値を変数に入れる
$email = $_POST['email'];
$password = $_POST['password'];

//DB設定用関数呼び出し
$pdo = connect_to_db();

// フォームから受け取ったemailのものを受け取るセレクトを用意
$sql = 'SELECT * FROM order_users WHERE email=:email';

// SQLをセット
$stmt = $pdo->prepare($sql);
//SQLインジェクション対策のためにバインド変数でセット
$stmt->bindValue(':email', $email, PDO::PARAM_STR);

//トライキャッチの中でクエリ実行
try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// 実行したSQLのデータを引っ張ってきて$valに格納
$val = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($val);

// $valがfalseであればecho出力,Trueなら実行を抜ける
if ($val === false) {
    echo 'メールアドレスが登録されていません。';
    exit();
}

// フォームに入力されたパスワードとselectで取得したハッシュ化されたパスワードがあっていればセッション変数に値を格納
if (password_verify($_POST['password'], $val['password'])) {
    $_SESSION = array();
    $_SESSION['session_id'] = session_id();
    $_SESSION['id'] = $val['id'];
    $_SESSION['name'] = $val['name'];
    $_SESSION['email'] = $val['email'];
    $_SESSION['is_user'] = $val['is_user'];
    header("Location:../jobInputList.php");
    exit();
} else { //パスワードがあってなければ実行
    echo "<p>ログイン情報に誤りがあります</p>";
    echo "<a href=order_login.php>ログイン</a>";
}
