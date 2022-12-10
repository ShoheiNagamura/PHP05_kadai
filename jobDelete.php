<?php
// 案件削除処理ーーーーーーーーーーーーーーーーーーーーーーーーー


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

// データ受け取り
$id = $_GET['id'];

// DB接続
include('./functions/connect_to_db.php');
include('./functions/check_session_id');

$pdo = connect_to_db();


// SQL実行

$sql = 'DELETE FROM job_project WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:jobInputList.php");
exit();
