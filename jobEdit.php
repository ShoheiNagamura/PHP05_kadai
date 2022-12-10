<?php
// 案件編集処理ーーーーーーーーーーーーーーーーーーーーーーーーー



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



// id受け取り
$id = $_GET['id'];


// DB接続
$pdo = connect_to_db();


// SQL実行
$sql = 'SELECT * FROM job_project WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$result = $stmt->fetch(PDO::FETCH_ASSOC);

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
        <h2 class="jobTitle">案件内容編集</h2>
        <form class="jobUpdate" action="./jobUpdate.php" method="POST">
            <div class="jobNameArea jobInputAreaItem">
                <label for="jobName">案件名（必須）</label>
                <input type="text" id="jobName" name=" jobName" placeholder="案件名をご入力ください" value="<?= $result['jobName'] ?>">
            </div>
            <div class="statusArea jobInputAreaItem">
                <label for="status">募集状況（必須）</label>
                <select name="status" id="status" value="<?= $result['status'] ?>">
                    <option value="募集中">募集中</option>
                    <option value="急募">急募</option>
                    <option value="募集終了">募集終了</option>
                </select>
            </div>
            <div class="placeArea jobInputAreaItem">
                <label for="place">場所（必須）</label>
                <input type="text" id="place" name="place" placeholder="お仕事の場所をご入力ください" value="<?= $result['place'] ?>">
            </div>
            <div class="scheduleArea jobInputAreaItem">
                <label for="schedule">日程</label>
                <input type="text" id="schedule" name="schedule" placeholder="日程をご自由にご記載ください" value="<?= $result['schedule'] ?>">
            </div>
            <div class="rewardArea jobInputAreaItem">
                <label for="reward">報酬</label>
                <input type="text" id="reward" name="reward" placeholder="報酬金額を入力してださい" value="<?= $result['reward'] ?>">
            </div>
            <div class="TransportationCostsArea jobInputAreaItem">
                <label for="TransportationCosts">交通費</label>
                <input type="text" id="TransportationCosts" name="TransportationCosts" placeholder="交通費の金額をご入力ださい" value="<?= $result['TransportationCosts'] ?>">
            </div>
            <div class="deadlineArea jobInputAreaItem">
                <label for="deadline">募集期限</label>
                <input class="input-date" type="date" id="deadline" name="deadline" value="<?= $result['deadline'] ?>">
            </div>
            <div class="contentArea jobInputAreaItem">
                <label for="content">案件内容</label>
                <textarea name="content" id="content" cols="70" rows="10" placeholder="案件の内容を詳しくご記載ください"><?= $result['content'] ?></textarea>
            </div>
            <button class="jobInputArea-btn">更新</button>
            <input type="hidden" name="id" value="<?= $id ?>">
        </form>
        <a href="./jobInputList.php"><button class="return">戻る</button></a>

    </main>


</body>

</html>