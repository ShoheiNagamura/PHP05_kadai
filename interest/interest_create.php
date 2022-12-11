<?php

include('../functions/check_session_id.php');
include('../functions/connect_to_db.php');

$sellerUser_id = $_GET['sellerUser_id'];
$jobProject_id = $_GET['jobProject_id'];


$pdo = connect_to_db();


$sql = 'SELECT COUNT(*) FROM interest WHERE sellerUser_id=:sellerUser_id AND jobProject_id=:jobProject_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':sellerUser_id', $sellerUser_id, PDO::PARAM_STR);
$stmt->bindValue(':jobProject_id', $jobProject_id, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$interest_count = $stmt->fetchColumn();
// まずはデータ確認
// var_dump($interest_count);
// exit();

if ($interest_count !== 0) {
    $sql = 'DELETE FROM interest WHERE sellerUser_id=:sellerUser_id AND jobProject_id=:jobProject_id';
} else {
    $sql = 'INSERT INTO interest (id, sellerUser_id, jobProject_id, created_at) VALUES (NULL, :sellerUser_id, :jobProject_id, now())';
}

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':sellerUser_id', $sellerUser_id, PDO::PARAM_INT);
$stmt->bindValue(':jobProject_id', $jobProject_id, PDO::PARAM_INT);


try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}


header("Location:../jobList.php");
exit();
