<?php
// 販売者一覧画面ーーーーーーーーーーーーーーーーーーーーーーーーー

//DB接続関数読み込み
include('./functions/connect_to_db.php');
include('./functions/check_session_id.php');

session_start();


//関数定義ファイルからDB接続関数呼び出す
$pdo = connect_to_db();

//selectのSQLクエリ用意
$sql = 'SELECT * FROM seller_users order by update_time DESC';
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





foreach ($result as $record) {
    $output .= "
        <div class='seller-items'>
            <p class='seller-item seller-name'>{$record["name"]}</p>
            <p class='seller-item seller-name_kana'>{$record["name_kana"]}</p>
            <p class='seller-item seller-update_time'>更新日: {$record["update_time"]}</p>
            <a href = './sellerDetail.php'><button>詳しく</button>
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
    <?= $headerOutput ?>


    <main>
        <div class="main-area">
            <h2>ご依頼する方をお選びください</h2>
            <div class="hoge-area">
                <?= $output ?>
            </div>
        </div>


    </main>


</body>

</html>