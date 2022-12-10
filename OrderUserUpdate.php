<?php
// 発注者ユーザー更新処理ーーーーーーーーーーーーーーーーーーーーーーー

//DB接続関数読み込み
include('./functions/connect_to_db.php');
include('./functions/check_session_id');


session_start();


if ($_SESSION['is_user'] == 0) {
    order_check_session_id();
} else {
    header("Location:./orderLogin/order_login.php");
    exit();
}


// 入力項目のチェック
if (
    !isset($_POST['name']) || $_POST['name'] == '' ||
    !isset($_POST['email']) || $_POST['email'] == ''
) {
    exit('ParamError');
}

$id = $_SESSION['id'];

$name = $_POST['name'];
$email = $_POST['email'];



// DB接続
$pdo = connect_to_db();

// SQL実行
$sql = 'UPDATE order_users SET name=:name, email=:email , update_time=now() WHERE id=:id';


$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);



try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:mypageOrder.php");
exit();
