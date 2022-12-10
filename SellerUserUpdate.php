<?php
// 販売者ユーザー更新処理ーーーーーーーーーーーーーーーーー

//DB接続関数読み込み
include('./functions/connect_to_db.php');
include('./functions/check_session_id');


session_start();


if ($_SESSION['is_user'] == 1) {
    order_check_session_id();
} else {
    header("Location:./sellerLogin/seller_login.php");
    exit();
}


// 入力項目のチェック
if (
    !isset($_POST['name']) || $_POST['name'] == '' ||
    !isset($_POST['email']) || $_POST['email'] == ''
    // !isset($_POST['business_name']) || $_POST['business_name'] == '' ||
    // !isset($_POST['address']) || $_POST['address'] == '' ||
    // !isset($_POST['career']) || $_POST['career'] == '' ||
    // !isset($_POST['pr']) || $_POST['pr'] == ''
) {
    exit('ParamError');
}

$id = $_SESSION['id'];

$name = $_POST['name'];
$email = $_POST['email'];
$business_name = $_POST['business_name'];
$address = $_POST['address'];
$career = $_POST['career'];
$pr = $_POST['pr'];



// DB接続
$pdo = connect_to_db();

// SQL実行
$sql = 'UPDATE seller_users SET name=:name, email=:email , business_name=:business_name, address=:address, career=:career, pr=:pr,  update_time=now() WHERE id=:id';


$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':business_name', $business_name, PDO::PARAM_STR);
$stmt->bindValue(':address', $address, PDO::PARAM_STR);
$stmt->bindValue(':career', $career, PDO::PARAM_STR);
$stmt->bindValue(':pr', $pr, PDO::PARAM_STR);



try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:mypageSeller.php");
exit();
