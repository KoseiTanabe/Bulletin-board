<?php
session_start();
if (isset($_POST['title']) && isset($_POST['text'])) {
	$title = $_POST['title'];
	$text = $_POST['text'];
	$dsn = 'mysql:host=localhost; dbname=procir_tanabe323; charset=utf8';
	$db_user = 'tanabe323';
	$db_pass = '9ie1jpvrkr';
	if ($title !== "" && $text !== "") {
		if (preg_match('/^.{1,28}$/us', $title) && preg_match('/^.{1,140}$/us', $text)) {
			try {
				$dbh = new PDO($dsn, $db_user, $db_pass);
			} catch (PDOException $e) {
				echo $e->getMessage();
				exit();
			}
			$stmt = $dbh->prepare('INSERT INTO posts (user_id, title, text) VALUES (:user_id, :title, :text)');
			$stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
			$stmt->bindParam(':title', $title, PDO::PARAM_STR);
			$stmt->bindParam(':text', $text, PDO::PARAM_STR);
			$stmt->execute();
			$result = '投稿しました。';
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
function h($str) {
	return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>新規投稿結果ページ</title>
</head>
<body>
<h1>投稿結果</h1>
<p><?php echo $result; ?></p>
<h2>投稿内容</h2>
<?php if ($title !== "" && $text !== ""): ?>
<p><?php echo h($title); ?></p>
<p><?php echo h($text); ?></p>
<?php endif; ?>
<a href="display_posts.php">投稿一覧ページへ戻る</a>
</body>
</html>
