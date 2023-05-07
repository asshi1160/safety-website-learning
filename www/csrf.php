<?php
require 'base_php/users_pdo.php';


$session_id = $_COOKIE['session_id'] ?? '';
$users = '';
$message = '';
$post_name = $_POST['post_name'] ?? '';
$post_password = $_POST['post_password'] ?? '';
$name = '';
$password = '';

try {
    $pdo = new UsersPdo();
    $stmt = $pdo->searchUsers();

    foreach ($stmt as $row) {
        $users .= '<tr>';
        $users .= "<td>{$row['name']}</td>";
        $users .= "<td>{$row['password']}</td>";
        $users .= "<td>{$row['session_id']}</td>";
        $users .= '</tr>';
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user1 = $pdo->login($post_name, $post_password);

        if ($user1) {
            $name = $user1['name'];
            $password = $user1['password'];
            $session_id = $user1['session_id'];
            setcookie('session_id', $session_id);
        } else {
            $message = 'ユーザー名またはパスワードが違います。';
        }
    }

    if (!empty($session_id)) {
        if ($pdo->checkSessionId($session_id)) {
            $user1 = $pdo->searchUsers(['session_id' => $session_id]);
            $name = $user1[0]['name'];
            $password = $user1[0]['password'];
        } else {
            setcookie('session_id', '', time()-1);
            $message .= 'セッションIDが違います。';
        }
    }
} catch (PDOException $e) {
    exit('DB接続エラー' . $e->getMessage());
}

?>

<!DOCTYPE html>
<html>
<head>

    <?php readfile('base_html/head.html') ?>

    <title>クロスサイト・リクエスト・フォージェリ</title>
</head>
<body class="d-flex flex-column">

    <?php readfile('base_html/header.html') ?>

    <div class="container">
        <h1 class="m-4 text-center">クロスサイト・リクエスト・フォージェリ</h1>
        <p>
            このページでは、クロスサイト・リクエスト・フォージェリ（CSRF）の脆弱性を利用して、USER-1のパスワードが変更されることを確認します。
        </p>
        <p>
            本来のパスワードの変更手順は下記を想定しているとします。実際に手順を行なって動作を確認してください。
        </p>
        <figure class="bg-light">
            <ol>
                <li>
                    ログインする<br>
                    下記のユーザー名に「USER-1」パスワードに「user1」と入力してログインをクリックする<br>
                    <small class="text-danger">※ログインが成功すると、Cookie情報欄に情報が記載される</small>
                </li>
                <form method="POST">
                    <div class="my-1 row g3">
                        <div class="col-auto">
                            <label for="name" class="col-form-label">ユーザー名</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control" id="post_name" name="post_name" value="<?php echo htmlspecialchars($post_name) ?>">
                        </div>
                        <div class="col-auto">
                            <label for="password" class="col-form-label">パスワード</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control" id="postpassword" name="post_password" value="<?php echo htmlspecialchars($post_password) ?>">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="form-btton btn btn-dark">ログイン</button>
                        </div>
                    </div>
                </form>
                <li><a href="http://localhost:18888/csrf_password.php">パスワード変更ページ</a>へアクセスする</li>
                <li>新しいパスワードを入力して送信する</li>
                <li>パスワードが変更される</li>
            </ol>
        </figure>
        <p>
            しかし、CSRFの脆弱性がある（パスワード変更ページにてトークン等による検証を行っていない）ため下記の手順を実施するだけで、パスワードが変更されます。<br>
            <small class="text-danger">※本来の攻撃では、下記2の手順を攻撃者が用意した罠サイトで実施します。</small>
        </p>
        <figure class="bg-light">
            <ol>
                <li>
                    ログインする<br>
                    下記のユーザー名に「USER-1」パスワードに「user1」と入力してログインをクリックする<br>
                    <small class="text-danger">※ログインが成功すると、Cookie情報欄に情報が記載される</small>
                </li>
                <form method="POST">
                    <div class="my-1 row g3">
                        <div class="col-auto">
                            <label for="name" class="col-form-label">ユーザー名</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control" id="post_name" name="post_name" value="<?php echo htmlspecialchars($post_name) ?>">
                        </div>
                        <div class="col-auto">
                            <label for="password" class="col-form-label">パスワード</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control" id="postpassword" name="post_password" value="<?php echo htmlspecialchars($post_password) ?>">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="form-btton btn btn-dark">ログイン</button>
                        </div>
                    </div>
                </form>
                <li>ユーザーを検索する<br>
                    ユーザー名で検索に「USER-2」等任意の文字列を入力して検索をクリックする<br>
                    <small class="text-danger">※ログイン情報のセッションIDが表示されている状態で実施する</small>
                </li>
                <form method="POST" action="/csrf_password.php">
                    <input type="hidden" name="type" value="new_password">
                    <input type="hidden" name="new_password" value="change_password">
                    <div class="my-1 row g3">
                        <div class="col-auto">
                            <label for="name" class="col-form-label">ユーザー名で検索</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="form-btton btn btn-dark">検索</button>
                        </div>
                    </div>
                </form>
            </ol>
        </figure>
        <p>上記の検索を押すと、実際にはユーザーの検索はされず、パスワード変更ページへ直接変更するパスワードが送信され、USER-1のパスワードが変更されます。</p>

        <h4 class="mt-4">Cookie情報</h4>
        <hr>
        <?php echo "<p class='text-danger'>{$message}</p>" ?>
        <?php echo "<p>ユーザー名：{$name}</p>" ?>
        <?php echo "<p>パスワード：{$password}</p>" ?>
        <?php echo "<p>セッションID：{$session_id}</p>" ?>
        <h4 class="mt-4">ユーザー情報</h4>
        <table class="table text-center">
            <thead>
                <tr>
                    <th>ユーザ名</th>
                    <th>パスワード</th>
                    <th>セッションID</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $users ?>
            </tbody>
        </table>
    </div>

    <?php readfile('base_html/footer.html') ?>

</body>
</html>
