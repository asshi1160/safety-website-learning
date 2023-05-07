<?php

$url = is_null($_GET['url']) ? '' : $_GET['url'];
$cookies = array();

if (!empty($url)) {
    header("Location: {$url}");
}

foreach ($_COOKIE as $key => $value) {
    $cookies[] = "{$key}: {$value}";
}

?>

<!DOCTYPE html>
<html>
<head>

    <?php readfile('base_html/head.html') ?>


    <title>HTTPヘッダ・インジェクション</title>
</head>
<body class="d-flex flex-column">

    <?php readfile('base_html/header.html') ?>

    <div class="container">
        <h1 class="m-4 text-center">HTTPヘッダ・インジェクション</h1>
        <p>
            このページでは、入力されたURLへ遷移する機能を実装しています。<br>
            HTTPヘッダ・インジェクションの脆弱性をついて、「HTTP_HEADER_INJECTION」という名前のクッキーを追加してみましょう。<br>
            まずは、https://google.com等を送信して動作を確認してみてください。<br>
            脆弱性を確認する際は、/http_headeri.phpへ遷移するようにしてください。
        </p>
        <p><a href="./sources/http_headeri_src.php" target="_blank">ソースコードを開く</a></p>
        <button class="btn btn-primary m-2" type="button" data-toggle="collapse" data-target="#hint1" aria-expanded="false" aria-controls="hint1">
            ヒント1を表示
        </button>
        <div class="collapse m-4" id="hint1">
            <p>入力されたURLは、HTTPのGETメソッドで送信され、Locationヘッダに直接書き込まれています。</p>
        </div>
        <button class="btn btn-primary m-2" type="button" data-toggle="collapse" data-target="#hint2" aria-expanded="false" aria-controls="hint2">
            ヒント2を表示
        </button>
        <div class="collapse m-4" id="hint2">
            <p>下記フォームから改行コード%0D%0Aを入力するとさらにURLエンコードされるため、URLに直接書き込むかinputではなくtextareaにして試してみましょう。</p>
        </div>

        <?php readfile('answer_html/http_headeri_answer.html') ?>

        <form method="GET">
            <div class="mt-5 row g3 align-items-center justify-content-center">
                <div class="col-auto">
                    <label for="url" class="col-form-label">遷移先URLを入力</label>
                </div>
                <div class="col-auto">
                    <input type="text" class="form-control" id="url" name="url">
                </div>
                <div class="col-auto">
                    <button type="submit" class="form-btton btn btn-dark">送信</button>
                </div>
            </div>
        </form>

    </div>
    <div class="container">
        <h4>クッキー情報</h4>
        <hr>
        <?php echo "<p>{$message}</p>" ?>
        <p id="cookie"><?php echo join('<br>', $cookies) ?></p>
    </div>

    <?php readfile('base_html/footer.html') ?>

</body>
</html>
