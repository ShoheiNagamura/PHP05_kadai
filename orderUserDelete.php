<?php
// 発注者ユーザー削除処理ーーーーーーーーーーーーーーーーーーーーーー

include('./functions/check_session_id');
include('./functions/connect_to_db.php');

session_start();

if ($_SESSION['is_user'] == 0) {
    order_check_session_id();
} else {
    header("Location:./orderLogin/order_login.php");
    exit();
}

$id = $_SESSION['id'];

$pdo = connect_to_db();

$sql = 'DELETE FROM order_users WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// session情報の全削除
$_SESSION = array();

// ブラウザに保存した情報の有効期限を操作
setcookie(session_name(), '', time() - 42000, '/');

// session領域自体をを破壊
session_destroy();

header("Location:index.php");
exit();
