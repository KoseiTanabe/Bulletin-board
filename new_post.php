<?php
session_start();
if (isset($_SESSION['id'])) {
	$result = 'こちらにタイトルと本文を入力してください';
} else {
	header('Location: member_registration.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>新規投稿ページ</title>
</head>
<body>
<h1>新規投稿</h1>
<?php echo $result; ?>
<form action="new_post_result.php" method="POST">
<h2>タイトル(28文字以内でお願いします。)</h2>
<input type="text" name="title">
<h2>本文(140文字以内でお願いします。)</h2>
<textarea name="text" cols="28" rows="5"></textarea><br>
<input type="submit" value="投稿する">
</form>
</body>
</html>
