<?php
// マイページ遷移処理ーーーーーーーーーーーーーーーーーーー

include('./functions/check_session_id');

session_start();

$id = $_SESSION['id'];
$is_user = $_SESSION['is_user'];

if ($is_user == 0) {
    order_check_session_id();
    header('Location:./mypageOrder.php');
} elseif ($is_user == 1) {
    seller_check_session_id();
    header('Location:./mypageSeller.php');
} else {
    header('Location:./index.php');
}
