<?php

$dsn = $_ENV['DSN'];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];
$users_list = '';
$name = $_GET['name'] ?? '';

try {
    $pdo = new PDO($dsn, $db_user, $db_pass);
    $sql = "SELECT id, name, email FROM users WHERE name LIKE '%{$name}%'";

    $users = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $row) {
        $users_list .= '<tr>';
        $users_list .= "<td>{$row['id']}</td>";
        $users_list .= "<td>{$row['name']}</td>";
        $users_list .= "<td>{$row['email']}</td>";
        $users_list .= '</tr>';
    }
} catch (PDOException $e) {
    exit($e->getMessage());
}

?>

<!DOCTYPE html>
<html>
<head>

    <?php readfile('base_html/head.html') ?>

    <title>SQLインジェクション</title>
</head>
<body class="d-flex flex-column">

    <?php readfile('base_html/header.html') ?>

    <div class="container">
        <h1 class="m-4 text-center">SQLインジェクション</h1>
        <p>
            SQLインジェクションの脆弱性のある検索機能です。<br>
            ユーザのパスワードを入手してみましょう。
        </p>
        <p><a href="./sources/sqli_src.php" target="_blank">ソースコードを開く</a></p>
        <button class="btn btn-primary m-2" type="button" data-toggle="collapse" data-target="#hint" aria-expanded="false" aria-controls="hint">
            ヒントを表示
        </button>
        <div class="collapse m-4" id="hint">
            <p>ユーザ情報は「users」テーブルにあり、パスワードは「password」カラムです。</p>
        </div>

        <?php readfile('answer_html/sqli_answer.html') ?>

        <form method="GET">
            <div class="my-5 row g3 align-items-center justify-content-center">
                <div class="col-auto">
                    <label for="name" class="col-form-label">ユーザ名</label>
                </div>
                <div class="col-auto">
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name) ?>">
                </div>
                <div class="col-auto">
                    <button type="submit" class="form-btton btn btn-dark">検索</button>
                </div>
            </div>
        </form>

        <table class="table text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ユーザ名</th>
                    <th>メールアドレス</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $users_list ?>
            </tbody>
        </table>
    </div>

    <?php readfile('base_html/footer.html') ?>

</body>
</html>
