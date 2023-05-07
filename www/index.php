<!DOCTYPE html>
<html>
<head>
    <?php readfile('base_html/head.html') ?>

    <title>安全なウェブサイトの作り方</title>
</head>
<body class="d-flex flex-column">
    <?php readfile('base_html/header.html') ?>

    <div class="container">
        <h1 class="m-4 text-center">お試し脆弱性一覧</h1>
        <p>本サイトはIPAが発行している「<a href="https://www.ipa.go.jp/files/000017316.pdf" target="_blank">安全なウェブサイトの作り方 改訂第7版</a>」に記載された脆弱性を実際に試し、脆弱性について理解を深める初めの一歩となることを目的に作成されています。一部の脆弱性（メールヘッダ・インジェクション等）については掲載していません。</p>
        <p>脆弱性等の詳細や対策等については、安全なウェブサイトの作り方 改訂第7版を参照してください。</p>
        <p>下記リンクから検証を行えるページへ飛べます。また、「ページ」カラムには安全なウェブサイトの作り方 改訂第7版の該当ページが記載されています。</p>
        <div class="alert alert-danger text-center">自身が管理しているパソコンやサーバ等以外には、絶対に脆弱性の検証を行わないでください</div>
        <table class="table text-center">
            <thead>
                <tr>
                    <th>リンク</th>
                    <th>概要</th>
                    <th>ページ</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a href="/sqli.php">SQLインジェクション</a></td>
                    <td>SQLインジェクションの脆弱性を突いてユーザのパスワードを入手する</td>
                    <td>P.6</td>
                </tr>
                <tr>
                    <td><a href="/os_command.php">OSコマンド・インジェクション</a></td>
                    <td>OSコマンド・インジェクションの脆弱性を突いてcurl結果を表示する</td>
                    <td>P.10</td>
                </tr>
                <tr>
                    <td><a href="/directory_traversal.php">ディレクトリ・トラバーサル</a></td>
                    <td>ディレクトリ・トラバーサルの脆弱性を突いて/etc/passwdを表示する</td>
                    <td>P.13</td>
                </tr>
                <tr>
                    <td><a href="/session_id_guess.php">セッションIDの推測</a></td>
                    <td>セッション管理の不備にあたる、推測されやすいセッションIDを推測する</td>
                    <td>P.16</td>
                </tr>
                <tr>
                    <td><a href="/xss.php">クロスサイト・スクリプティング</a></td>
                    <td>クロスサイト・スクリプティングの脆弱性を突いてCookie情報を表示する</td>
                    <td>P.22</td>
                </tr>
                <tr>
                    <td><a href="/csrf.php">クロスサイト・リクエスト・フォージェリ</a></td>
                    <td>クロスサイト・リクエスト・フォージェリの脆弱性を突いてパスワードを変更する</td>
                    <td>P.30</td>
                </tr>
                <tr>
                    <td><a href="/http_headeri.php">HTTPヘッダ・インジェクション</a></td>
                    <td>HTTPヘッダ・インジェクションの脆弱性を突いてヘッダを追加する</td>
                    <td>P.34</td>
                </tr>
            </tbody>
        </table>
    </div>


    <?php readfile('base_html/footer.html') ?>
</body>
</html>
