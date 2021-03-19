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
<title>会員登録ページ</title>
</head>
<body>
<h1>会員登録ページ</h1>
<form action="member_registration_result.php" method="POST">
<h2>名前(50字以内でお願いします)</h2>
<input type="text" name="name">
<h2>メールアドレス</h2>
<input type="text" name="mail">
<h2>パスワード(10文字以上でお願いします)</h2>
<input type="text" name="pass"><br>
<input type="submit" value="会員登録する">
</form>
<a href="login.php">既に会員の方はこちら</a><br>
<a href="display_posts.php">投稿一覧ページへ戻る </a>
</body>
</html>
