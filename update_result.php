<?php
session_start();
if (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['text'])) {
	$id = $_POST['id'];
	$title = $_POST['title'];
	$text = $_POST['text'];
	$dsn = 'mysql:host=localhost; dbname=procir_tanabe323; charset=utf8';
	$db_user = 'tanabe323';
	$db_pass = '9ie1jpvrkr';
	if (!empty($id) && $title !== "" && $text !== "") {
		if (preg_match('/^.{1,28}$/us', $title) && preg_match('/^.{1,140}$/us', $text)) {
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
				$stmt = $dbh->prepare('UPDATE posts SET title = :title, text = :text WHERE id = :id');
				$stmt->bindParam(':title', $title, PDO::PARAM_STR);
				$stmt->bindParam(':text', $text, PDO::PARAM_STR);
				$stmt->bindValue(':id', $id, PDO::PARAM_INT);
				$stmt->execute();
				$result = '更新しました。';
			} else {
				$result = '他の人の投稿を更新しないでください。';
			}
		} else {
			$result = '文字数がオーバーしています。';
		}
	} else {
		$result = '入力欄に内容を入力してください。';
	}
} else {
	header('Location: display_posts.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>編集結果ページ</title>
</head>
<body>
<p><?php echo $result; ?></p>
<a href="display_posts.php">投稿一覧ページへ戻る</a>
</body>
</html>
