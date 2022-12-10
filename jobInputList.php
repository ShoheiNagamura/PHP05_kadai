<?php
// 登録済み案件一覧ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー



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


//関数定義ファイルからDB接続関数呼び出す
$pdo = connect_to_db();

// 一覧表示用処理---------------------------------------------------------------

//selectのSQLクエリ用意
$sql = 'SELECT * FROM job_project order by update_time DESC';
$stmt = $pdo->prepare($sql);

//SQL実行するがまだデータの取得はできていない
try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

//fectchAllでデータの取得
if ($status == false) {
    $error = $stmt->errorInfo();
    exit('sqlError:' . $error[2]);
} else {
    // PHPではデータを取得するところまで実施
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}



// 取得したデータ件数を用意
$job_num = count($result);

$output = "";

foreach ($result as $record) {
    $output .= "
        <div class='job-item'>
            <div class='job-head'>
                <div class='jobName'>
                    <p class=''>{$record["jobName"]}</p>
                </div>
                <div class='job-headTime'>
                    <div class='created_time'>
                        <p class=''>掲載日：{$record["created_time"]}</p>
                    </div>
                    <div class='update_time'>
                        <p class=''>最終更新日：{$record["update_time"]}</p>
                    </div>
                </div>
            </div>

            <div class='status'>
                <p class=''>{$record["status"]}</p>
            </div>
            <div class='place'>
                <p class=''>場所：{$record["place"]}</p>
            </div>
            <div class='schedule'>
                <p class=''>日程：{$record["schedule"]}</p>
            </div>
            <div class='reward'>
                <p class=''>報酬：{$record["reward"]}円(税込)</p>
            </div>
            <div class='TransportationCosts'>
                <p class=''>交通費：{$record["TransportationCosts"]}</p>
            </div>
            <div class='deadline'>
                <p class=''>募集締切：{$record["deadline"]}</p>
            </div>
            <div class='content'>
                <p class=''>案件の内容：{$record["content"]}</p>
            </div>
            <tr class='Btn-area'>
                <td>
                    <a class='editBtn' href='jobEdit.php?id={$record["id"]}'>編集</a>
                </td>
                <td>
                    <a class='deleteBtn' href='jobDelete.php?id={$record["id"]}'>削除</a>
                </td>
            </tr>
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
            <a href="./selectmypage.php">
                <img src="./img/mypage.png" alt="マイページアイコン">
            </a>
        </nav>
    </header>

    <main>

        <div class="main-area">
            <h2>登録済みの案件一覧</h2>
            <h3 class="job_num"><?= $job_num ?>件を登録済み</h3>
            <div class="job-area">
                <?= $output ?>
            </div>
        </div>

    </main>


</body>

</html>