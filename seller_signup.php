<?php
// 販売者新規登録画面ーーーーーーーーーーーーーーーーーーーー


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
        <div class="signup-form">
            <h2>販売者アカウント新規登録</h2>
            <p>販売者をしたい方は下記からご登録ください</p>
            <form class="form-area" action="sellerUserCreate.php" method="POST">
                <label for="name">ユーザー名</label>
                <input type="text" id="name" name="name" placeholder="ユーザー名を入力してください">
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email" placeholder="メールアドレスを入力してください">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" placeholder="パスワードを入力してください">
                <label for="conf-password">確認パスワード</label>
                <input type="password" id="conf-password" name="conf-password" placeholder="パスワードを入力してください">
                <button>登録</button>
            </form>
        </div>


    </main>


</body>

</html>