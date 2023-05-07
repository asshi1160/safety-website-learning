<?php
$xss = $_GET['xss'] ?? '';
$session_id = 'xss_session_id';
setcookie('session_id', $session_id);

?>

<!DOCTYPE html>
<html>
<head>

    <?php readfile('base_html/head.html') ?>

    <title>クロスサイト・スクリプティング</title>
</head>
<body class="d-flex flex-column">

    <?php readfile('base_html/header.html') ?>

    <div class="container">
        <h1 class="m-4 text-center">クロスサイト・スクリプティング</h1>
        <p>
            このページでは、入力された値をそのまま画面に出力するようにしています。<br>
            クロスサイト・スクリプティングの脆弱性をついて、自身のCookie情報を出力してみましょう。
        </p>
        <p><a href="./sources/xss_src.php" target="_blank">ソースコードを開く</a></p>

        <button class="btn btn-primary m-2" type="button" data-toggle="collapse" data-target="#hint" aria-expanded="false" aria-controls="hint">
            ヒントを表示
        </button>
        <div class="collapse m-4" id="hint">
            <p>入力値はエスケープ処理されていません。</p>
        </div>

        <?php readfile('answer_html/xss_answer.html') ?>

        <form method="GET">
            <div class="mt-5 row g3 align-items-center justify-content-center">
                <div class="col-auto">
                    <label for="xss" class="col-form-label">XSS</label>
                </div>
                <div class="col-auto">
                    <input type="text" class="form-control" id="xss" name="xss" value="<?php echo htmlspecialchars($xss) ?>">
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
        <?php echo $xss ?>

    </div>

    <?php readfile('base_html/footer.html') ?>

</body>
</html>
