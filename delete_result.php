<?php
session_start();
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$dsn = 'mysql:host=localhost; dbname=procir_tanabe323; charset=utf8';
	$db_user = 'tanabe323';
	$db_pass = '9ie1jpvrkr';
	try {
		$dbh = new PDO($dsn, $db_user, $db_pass);
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
	$stmt = $dbh->prepare('SELECT user_id FROM posts WHERE id = :id');
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$user_id = $stmt->fetch(PDO::FETCH_ASSOC);
	if (!empty($user_id) && $user_id['user_id'] === $_SESSION['id']) {
		$stmt = $dbh->prepare('UPDATE posts SET delete_flag = 1 WHERE id = :id');
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result = '削除しました';
	} else {
		header('Location: display_posts.php');
		exit();
	}
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>削除結果ページ</title>
</head>
<body>
<h1>削除結果</h1>
<p><?php echo $result; ?></p>
<a href="display_posts.php">投稿一覧ページへ戻る</a>
</body>
</html>
