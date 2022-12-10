<?php
// 発注者マイページーーーーーーーーーーーーーーーーーーーー

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

$id = $_SESSION['id'];
// var_dump($id);
// exit();

// DB接続
$pdo = connect_to_db();

// SQL実行
$sql = 'SELECT * FROM order_users WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($result);
// echo '</pre>';
// exit();
$output = "";
foreach ($result as $record) {
    $output .= "
        <div class='order-mypage-area'>
            <tr class='mypage-item-name'>
                <td class='mypage-name-title'>お名前：</td>
                <td class='mypage-name'>{$record["name"]}</td>
            </tr><br>
            <tr class='mypage-item-email'>
                <td class='mypage-email-title'>メールアドレス：</td>
                <td class='mypage-email'>{$record['email']}</td>
            </tr><br>
            <tr class='mypage-item-created_time'>
                <td class='mypage-created_time-title'>アカウント作成日：</td>
                <td class='mypage-created_time'>{$record['created_time']}</td>
            </tr>
        </div>
        <div class='order-mypage-button'>
            <a href='./OrderUserEdit.php'><button>プロフィール編集</button></a>
            <a href='./LogOut/orderLogout.php'><button>ログアウト</button></a>
            <a href='./orderUserDelete.php?id={$record['id']}'><button>アカウントを削除</button></a>
        </div>
    ";
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&family=Zen+Kurenaido&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <title>PHP課題02</title>
</head>

<body>
    <header>
        <div class="header-title">
            <a href="./index.php">
                <h1>ご依頼マッチングサイト</h1>
            </a>
        </div>
        <nav>
            <ul class="header-nav">
                <a href="./jobList.php">
                    <li>案件一覧</li>
                </a>
                <a href="./search_list.php">
                    <li>依頼できる人一覧</li>
                </a>
                <li class="signup">新規登録
                    <ul class="signup-down">
                        <a href="./order_signup.php">
                            <li class="order-signup">発注者登録</li>
                        </a>
                        <a href="./seller_signup.php">
                            <li class="seller-signup">販売者登録</li>
                        </a>
                    </ul>
                </li>
                <li class="login">ログイン
                    <ul class="login-down">
                        <a href="./orderLogin/order_login.php">
                            <li class="order-login">発注者ログイン</li>
                        </a>
                        <a href="./sellerLogin/seller_login.php">
                            <li class="seller-login">販売者ログイン</li>
                        </a>
                    </ul>
                </li>
                <li class="job">案件管理
                    <ul class="job-down">
                        <a href="./jobInput.php">
                            <li class="job-input">案件登録</li>
                        </a>
                        <a href="./jobInputList.php">
                            <li class="job-list">案件管理一覧</li>
                        </a>
                    </ul>
                </li>
            </ul>
            <!-- <a class="mypage-img" href="./mypage.php">
                <img class="mypage-img" src="./img/mypage.png" alt="マイページアイコン">
            </a> -->
        </nav>
    </header>

    <div class="mypage-main">
        <h2>発注者マイページ</h2>
        <?= $output ?>
    </div>


</body>

</html>