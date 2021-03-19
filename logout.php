<?php
session_start();
if (isset($_SESSION['id'])) {
	$_SESSION = array();
	session_destroy();
	$result = 'ログアウトしました。';
} else {
	header('Location: display_posts.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログアウトページ</title>
</head>
<body>
<p><?php echo $result ?></p>
<a href="display_posts.php">投稿一覧ページへ戻る</a>
</body>
</html>
