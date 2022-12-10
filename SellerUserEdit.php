<?php
// 販売者ユーザー編集画面ーーーーーーーーーーーーーーーーー

//DB接続関数読み込み
include('./functions/connect_to_db.php');
include('./functions/check_session_id');

session_start();
if ($_SESSION['is_user'] == 1) {
    seller_check_session_id();
} else {
    header("Location:./orderLogin/seller_login.php");
    exit();
}



// id受け取り
$id = $_SESSION['id'];


// DB接続
$pdo = connect_to_db();


// SQL実行
$sql = 'SELECT * FROM seller_users WHERE id=:id';
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
        </nav>
    </header>

    <main>
        <h2 class="">プロフィールを編集</h2>
        <form class="" action="./SellerUserUpdate.php" method="POST">
            <div class="">
                <label for="name">お名前（必須）</label>
                <input type="text" id="name" name="name" placeholder="お名前をご入力ください" value="<?= $result['name'] ?>">
            </div>
            <div class=" ">
                <label for="email">メールアドレス（必須）</label>
                <input type="text" id="email" name="email" placeholder="メールアドレスをご入力ください" value="<?= $result['email'] ?>">
            </div>
            <div class=" ">
                <label for="business_name">会社名(個人)</label>
                <input type="text" id="business_name" name="business_name" placeholder="会社名または個人名をご入力ください" value="<?= $result['business_name'] ?>">
            </div>
            <div class=" ">
                <label for="address">ご住所または活動地域</label>
                <input type="text" id="address" name="address" placeholder="ご住所または活動地域をご入力ください" value="<?= $result['address'] ?>">
            </div>
            <div class=" ">
                <label for="career">経歴</label>
                <textarea id="career" name="career" placeholder="ご住所または活動地域をご入力ください" cols="30" rows="10"><?= $result['career'] ?></textarea>
            </div>
            <div class=" ">
                <label for="pr">PR</label>
                <textarea id="pr" name="pr" placeholder="PRしたいことをご記載ください" cols="30" rows="10"><?= $result['pr'] ?></textarea>
            </div>

            <button class="">変更を保存</button>
            <input type="hidden" name="id" value="<?= $id ?>">
        </form>
        <a href="./mypageSeller.php"><button class="return">戻る</button></a>
    </main>


</body>

</html>