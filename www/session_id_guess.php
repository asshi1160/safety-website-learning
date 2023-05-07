<?php
require 'base_php/users_pdo.php';


$session_id;
$message = '';
$guess_session_id = $_POST['guess_session_id'] ?? '';

try {
    $pdo = new UsersPdo();
    $user = $pdo->searchUsers(['id' => 1]);
    $session_id = $user[0]['session_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($guess_session_id)) {
            if ($guess_session_id == $session_id + 1) {
                $message = '推測に成功しました';
            } else {
                $guess_session_id = htmlspecialchars($guess_session_id);
                $message = "次のセッションIDは、入力値「{$guess_session_id}」ではありません";
            }
        }
    } else {
        $pdo->setSessionId(1, $session_id + 1);
        $user = $pdo->searchUsers(['id' => 1]);
        $session_id = $user[0]['session_id'];
        setcookie('session_id', $session_id);
    }
} catch (PDOException $e) {
    exit($e->getMessage());
}

?>

<!DOCTYPE html>
<html>
<head>

    <?php readfile('base_html/head.html') ?>

    <title>セッションIDの推測</title>
</head>
<body class="d-flex flex-column">

    <?php readfile('base_html/header.html') ?>

    <div class="container">
        <h1 class="m-4 text-center">セッションIDの推測</h1>
        <p>
            このページではセッションIDを発行していますが、推測されやすいセッションIDになっています。<br>
            次にアクセスされた時に発行されるセッションIDを推測してみましょう。
        </p>
        <p><a href="./sources/session_id_guess_src.php" target="_blank">ソースコードを開く</a></p>

        <button class="btn btn-primary m-2" type="button" data-toggle="collapse" data-target="#hint" aria-expanded="false" aria-controls="hint">
            ヒントを表示
        </button>
        <div class="collapse m-4" id="hint">
            <p>セッションIDは、Cookieに保存されています。</p>
        </div>

        <?php readfile('answer_html/session_id_guess_answer.html') ?>

        <form method="POST">
            <div class="mt-5 row g3 align-items-center justify-content-center">
                <div class="col-auto">
                    <label for="guessSessionId" class="col-form-label">次に発行されると推測されるセッションID</label>
                </div>
            </div>
            <div class="row g3 align-items-center justify-content-center">
                <div class="col-auto">
                    <input type="text" class="form-control" id="guessSessionId" name="guess_session_id" value="<?php echo htmlspecialchars($guess_session_id) ?>">
                </div>
                <div class="col-auto">
                    <button type="submit" class="form-btton btn btn-dark">送信</button>
                </div>
            </div>
        </form>

    </div>
    <div class="container">
        <h4>実行結果</h4>
        <hr>
        <?php echo "<p>{$message}</p>" ?>

    </div>

    <?php readfile('base_html/footer.html') ?>

</body>
</html>
