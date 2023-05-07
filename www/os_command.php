<?php
$result = [];
$file_name = $_GET['file_name'] ?? '';

$file_name = preg_replace('/\.\.+/', '', $file_name);
exec("cat ./{$file_name}", $tmp_res);
$result = array_map('htmlspecialchars', $tmp_res);

$data = '';
foreach ($result as $row) {
    $data .= $row . "<br>";
}

?>

<!DOCTYPE html>
<html>
<head>

    <?php readfile('base_html/head.html') ?>

    <title>OSコマンド・インジェクション</title>
</head>
<body class="d-flex flex-column">

    <?php readfile('base_html/header.html') ?>

    <div class="container">
        <h1 class="m-4 text-center">OSコマンド・インジェクション</h1>
        <p>
            catコマンドでファイルの中身が見えるようになっていますが、OSコマンド・インジェクションの脆弱性があります。<br>
            脆弱性を突いて「http://example.com」にcurlコマンドでアクセスしてみましょう。
        </p>
        <p><a href="./sources/os_command_src.php" target="_blank">ソースコードを開く</a></p>

        <button class="btn btn-primary m-2" type="button" data-toggle="collapse" data-target="#hint" aria-expanded="false" aria-controls="hint">
            ヒントを表示
        </button>
        <div class="collapse m-4" id="hint">
            <p>サーバ側で入力文字列に対してcatコマンドが直接実行されています。</p>
        </div>

        <?php readfile('answer_html/os_command_answer.html') ?>

        <form method="GET">
            <div class="mt-5 row g3 align-items-center justify-content-center">
                <div class="col-auto">
                    <label for="fileName" class="col-form-label">確認したいファイル名を入力してください。（例：os_command.php）</label>
                </div>
            </div>
            <div class="row g3 align-items-center justify-content-center">
                <div class="col-auto">
                    <input type="text" class="form-control" id="fileName" name="file_name" value="<?php echo htmlspecialchars($file_name) ?>">
                </div>
                <div class="col-auto">
                    <button type="submit" class="form-btton btn btn-dark">表示</button>
                </div>
            </div>
        </form>

    </div>
    <div class="container">
        <h4>実行結果</h4>
        <hr>
        <?php echo $data ?>

    </div>

    <?php readfile('base_html/footer.html') ?>

</body>
</html>
