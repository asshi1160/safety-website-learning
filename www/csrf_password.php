<?php
require 'base_php/users_pdo.php';


$session_id = $_COOKIE['session_id'] ?? '';
$users = '';
$message = '';
$post_name = $_POST['post_name'] ?? '';
$post_password = $_POST['post_password'] ?? '';
$name = '';
$password = '';
$new_password = $_POST['new_password'] ?? '';
$type = $_POST['type'] ?? '';
$success = '';

try {
    $pdo = new UsersPdo();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($type == 'login') {
            $user1 = $pdo->login($post_name, $post_password);

            if ($user1) {
                $name = $user1['name'];
                $password = $user1['password'];
                $session_id = $user1['session_id'];
                setcookie('session_id', $session_id);
            } else {
                $message = 'ユーザー名またはパスワードが違います。';
            }
        } elseif ($type == 'new_password') {
            if (!empty($session_id) && $pdo->checkSessionId($session_id)) {
                $pdo->newPassword($new_password);
                $message = 'パスワードを変更したため、再度ログインしてください。';
                $session_id = '';
                setcookie('session_id', '', time()-1);
                $success = '<h1 class="text-success">パスワードを変更しました</h1>';
            } else {
                $message = '先にログインしてください。';
            }
        }
    }

    if (!empty($session_id)) {
        if ($pdo->checkSessionId($session_id)) {
            $user1 = $pdo->searchUsers(['session_id' => $session_id]);
            $name = $user1[0]['name'];
            $password = $user1[0]['password'];
        } else {
            $message = 'セッションIDが違います。';
        }
    }

    $stmt = $pdo->searchUsers();

    foreach ($stmt as $row) {
        $users .= '<tr>';
        $users .= "<td>{$row['name']}</td>";
        $users .= "<td>{$row['password']}</td>";
        $users .= "<td>{$row['session_id']}</td>";
        $users .= '</tr>';
    }
} catch (PDOException $e) {
    exit('DB接続エラー' . $e->getMessage());
}

?>

<!DOCTYPE html>
<html>
<head>

    <?php readfile('base_html/head.html') ?>

    <title>クロスサイト・リクエスト・フォージェリ-パスワード変更</title>
</head>
<body class="d-flex flex-column">

    <?php readfile('base_html/header.html') ?>

    <div class="container">
        <h1 class="m-4 text-center">クロスサイト・リクエスト・フォージェリ-パスワード変更</h1>
        <p>
            このページでは、セッションIDをもとにパスワードの変更が行われます。<br>
            トークン等を使用していないため、クロスサイト・リクエスト・フォージェリ（CSRF）の脆弱性が存在します。<br>
            CSRFを試したい場合は、<a href="/csrf.php">こちら</a>へアクセスしてください。
        </p>
        <p>パスワードを入力して変更をクリックするとパスワードが変更されます。</p>
        <form method="POST">
            <div class="my-3 row g3">
                <input type="hidden" name="type" value="new_password">
                <div class="col-auto">
                    <label for="new_password" class="col-form-label">新しいパスワード</label>
                </div>
                <div class="col-auto">
                    <input type="text" class="form-control" id="new_password" name="new_password" value="<?php echo htmlspecialchars($new_password) ?>">
                </div>
                <div class="col-auto">
                    <button type="submit" class="form-btton btn btn-dark">変更</button>
                </div>
            </div>
        </form>
        <p>ログインがまだの場合（ログイン情報が表示されていない場合）は、USER-1ユーザーでログインしてください。</p>
        <form method="POST">
            <div class="row g3">
                <input type="hidden" name="type" value="login">
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
                    <input type="text" class="form-control" id="post_password" name="post_password" value="<?php echo htmlspecialchars($post_password) ?>">
                </div>
                <div class="col-auto">
                    <button type="submit" class="form-btton btn btn-dark">ログイン</button>
                </div>
            </div>
        </form>

        <?php echo $success ?>
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
        <h4 class="mt-4">ログイン情報</h4>
        <hr>
        <?php echo "<p class='text-danger'>{$message}</p>" ?>
        <?php echo "<p>ユーザー名：{$name}</p>" ?>
        <?php echo "<p>パスワード：{$password}</p>" ?>
        <?php echo "<p>セッションID：{$session_id}</p>" ?>
    </div>

    <?php readfile('base_html/footer.html') ?>

</body>
</html>
