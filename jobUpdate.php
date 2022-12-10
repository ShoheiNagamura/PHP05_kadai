<?php
// 案件更新処理ーーーーーーーーーーーーーーーーーーーーーーー


//DB接続関数読み込み
include('./functions/connect_to_db.php');
include('./functions/check_session_id');


session_start();
// var_dump($_SESSION['is_user']);
// exit();

if ($_SESSION['is_user'] == 0) {
    order_check_session_id();
} else {
    header("Location:./orderLogin/order_login.php");
    exit();
}


// 入力項目のチェック
if (
    !isset($_POST['jobName']) || $_POST['jobName'] == '' ||
    !isset($_POST['status']) || $_POST['status'] == '' ||
    !isset($_POST['reward']) || $_POST['reward'] == '' ||
    !isset($_POST['place']) || $_POST['place'] == '' ||
    !isset($_POST['schedule']) || $_POST['schedule'] == '' ||
    !isset($_POST['TransportationCosts']) || $_POST['TransportationCosts'] == '' ||
    !isset($_POST['deadline']) || $_POST['deadline'] == '' ||
    !isset($_POST['content']) || $_POST['content'] == ''
    // !isset($_POST['id']) || $_POST['id'] == ''

) {
    exit('ParamError');
}

$tax = 1.1;


$id = $_POST['id'];
$jobName = $_POST['jobName'];
$status = $_POST['status'];
$reward = $_POST['reward'] * $tax;
$place = $_POST['place'];
$schedule = $_POST['schedule'];
$TransportationCosts = $_POST['TransportationCosts'];
$deadline = $_POST['deadline'];
$content = $_POST['content'];


// DB接続
$pdo = connect_to_db();

// SQL実行
$sql = 'UPDATE job_project SET jobName=:jobName, status=:status, reward=:reward, place=:place, schedule=:schedule, TransportationCosts=:TransportationCosts, deadline=:deadline, content=:content, update_time=now() WHERE id=:id';


$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':jobName', $jobName, PDO::PARAM_STR);
$stmt->bindValue(':status', $status, PDO::PARAM_STR);
$stmt->bindValue(':reward', $reward, PDO::PARAM_INT);
$stmt->bindValue(':place', $place, PDO::PARAM_STR);
$stmt->bindValue(':schedule', $schedule, PDO::PARAM_STR);
$stmt->bindValue(':TransportationCosts', $TransportationCosts, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);


try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:jobInputList.php");
exit();
