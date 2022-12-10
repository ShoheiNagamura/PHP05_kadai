<?php
// 案件登録処理ーーーーーーーーーーーーーーーーー

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

if (
    !isset($_POST['jobName']) || $_POST['jobName'] == '' ||
    !isset($_POST['status']) || $_POST['status'] == '' ||
    !isset($_POST['place']) || $_POST['place'] == '' ||
    !isset($_POST['reward']) || $_POST['reward'] == '' ||
    !isset($_POST['schedule']) || $_POST['schedule'] == '' ||
    !isset($_POST['TransportationCosts']) || $_POST['TransportationCosts'] == '' ||
    !isset($_POST['deadline']) || $_POST['deadline'] == '' ||
    !isset($_POST['content']) || $_POST['content'] == ''
) {
    exit('ParamError');
}


$tax = 1.1;

$jobName = $_POST['jobName'];
$status = $_POST['status'];
$reward = $_POST['reward'] * $tax;
$place = $_POST['place'];
$schedule = $_POST['schedule'];
$TransportationCosts = $_POST['TransportationCosts'];
$deadline = $_POST['deadline'];
$content = $_POST['content'];


//関数定義ファイルから関数呼び出す
$pdo = connect_to_db();

$sql = 'INSERT INTO job_project(id, jobName, status, reward, place, schedule,TransportationCosts,deadline, content,created_time, update_time) 
        VALUES (NULL, :jobName ,:status, :reward, :place, :schedule, :TransportationCosts, :deadline, :content,now(), now())';

$stmt = $pdo->prepare($sql);

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

//画面遷移
header('Location:jobInputList.php');
exit();
