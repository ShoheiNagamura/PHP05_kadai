<?php
// 案件一覧画面ーーーーーーーーーーーーーーーーーーー

// 関数ファイルの読み込み
include('./functions/check_session_id.php');
include('./functions/connect_to_db.php');

session_start();


// DB接続
$pdo = connect_to_db();

$sql = 'SELECT * FROM job_project LEFT OUTER JOIN
    (SELECT jobProject_id, COUNT(id) AS interest_count FROM interest GROUP BY jobProject_id) AS result_table
    ON  job_project.id = result_table.jobProject_id order by update_time DESC';
$stmt = $pdo->prepare($sql);

//SQL実行するがまだデータの取得はできていない
try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

if ($status == false) {
    $error = $stmt->errorInfo();
    exit('sqlError:' . $error[2]);
} else {
    // PHPではデータを取得するところまで実施
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 存在したら値を変数に格納
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
}

// 登録されている案件件数を変数に格納
$job_num = count($result);

// ヘッダー用
$headerOutput = "";

// メイン用
$output = "";


// 認証状態に応じてヘッダーの表示を分ける
// 発注者でログインしている場合
if (isset($_SESSION['is_user']) && $_SESSION['is_user'] === 0) {
    $headerOutput = "
        <header>
            <div class='header-title'>
                <a href='./index.php'>
                    <h1>ご依頼マッチングサイト</h1>
                </a>
            </div>
            <nav>
                <ul class='header-nav'>
                    <a href='./jobList.php'>
                        <li>案件一覧</li>
                    </a>
                    <a href='./search_list.php'>
                        <li>依頼できる人一覧</li>
                    </a>
                    <li class='job'>案件管理
                        <ul class='job-down'>
                            <a href='./jobInput.php'>
                                <li class='job-input'>案件登録</li>
                            </a>
                            <a href='./jobInputList.php'>
                                <li class='job-list'>案件管理一覧</li>
                            </a>
                        </ul>
                    </li>
                    <li class='login-out'>
                        <a href='./LogOut/orderLogout.php'>ログアウト</a>
                    </li>
                    <a href='./selectmypage.php'>
                        <img src='./img/mypage.png' alt='マイページアイコン'>
                    </a>
                </ul>
            </nav>
        </header>
    ";
    // 販売者でログインしている場合
} else if (isset($_SESSION['is_user']) && $_SESSION['is_user'] === 1) {
    $headerOutput = "
        <header>
            <div class='header-title'>
                <a href='./index.php'>
                    <h1>ご依頼マッチングサイト</h1>
                </a>
            </div>
            <nav>
                <ul class='header-nav'>
                    <a href='./jobList.php'>
                        <li>案件一覧</li>
                    </a>
                    <a href='./search_list.php'>
                        <li>依頼できる人一覧</li>
                    </a>
                    <li class='login'>
                        <a href='./LogOut/sellerLogout.php'>ログアウト</a>
                    </li>
                </ul>
                <a href='./selectmypage.php'>
                    <img src='./img/mypage.png' alt='マイページアイコン'>
                </a>
            </nav>
        </header>
    ";
    // ログインしていない場合
} else {
    $headerOutput = '  
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
            </nav>
        </header>
    ';
}

// var_dump($result['id']);
if (isset($_SESSION["id"])) {
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
                <p class=''>案件の内容：<br>{$record["content"]}</p>
            </div>
            <button class='application-btn'>応募する</button>
            <a href='./interest/interest_create.php?sellerUser_id={$user_id}&jobProject_id={$record["id"]}'>興味あり{$record["interest_count"]}</a>
        </div>
    ";
    }
} else {
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
                <p class=''>案件の内容：<br>{$record["content"]}</p>
            </div>
        </div>
    ";
    }
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
    <?= $headerOutput ?>

    <main>
        <div class="main-area">
            <h2>案件一覧</h2>
            <h3 class="job_num"><?= $job_num ?>件が登録されています</h3>
            <p>応募には登録が必要です。</p>
            <div class="job-area">
                <?= $output ?>
            </div>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- <script>
        const hoge = <?= json_encode($_SESSION['id']) ?>;
        console.log(hoge);

        if (!hoge) {
            $('.application-btn').hide();
        }
    </script> -->


</body>

</html>