<?php
session_start();
if (isset($_SESSION['id'])) {
	header('Location: display_posts.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログインページ</title>
</head>
<body>
<h1>ログインページ</h1>
<form action="login_result.php" method="POST">
<h2>メールアドレス</h2>
<input type="text" name="mail">
<h2>パスワード</h2>
<input type="password" name="pass"><br>
<input type="submit" value="ログインする">
</form>
<a href="member_registration.php">初めてご利用の方ははこちら</a><br>
<a href="display_posts.php">投稿一覧ページへ戻る </a>
</body>
</html>
