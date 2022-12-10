<?php

// order用 ログイン状態のチェック関数
function order_check_session_id()
{
    if (!isset($_SESSION["session_id"]) || $_SESSION["session_id"] != session_id()) {
        header('Location:./orderLogin/order_login.php');
        exit();
    } else {
        session_regenerate_id(true);
        $_SESSION["session_id"] = session_id();
    }
}


// seller用 ログイン状態のチェック関数 
function seller_check_session_id()
{
    if (!isset($_SESSION["session_id"]) || $_SESSION["session_id"] != session_id()) {
        header('Location:./sellerLogin/seller_login.php');
        exit();
    } else {
        session_regenerate_id(true);
        $_SESSION["session_id"] = session_id();
    }
}


// // aprikesyonチェック 
// function apl_check_session_id()
// {
//     if (!isset($_SESSION["session_id"]) || $_SESSION["session_id"] != session_id()) {
//         return $api_result = true;
//     } else {
//         session_regenerate_id(true);
//         $_SESSION["session_id"] = session_id();
//     }
// }
