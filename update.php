<?php
session_start();
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$dsn = 'mysql:host=localhost; dbname=procir_tanabe323; charset=utf8';
	$db_name = 'tanabe323';
	$db_pass = '9ie1jpvrkr';
	if (!empty($id)) {
		try {
			$dbh = new PDO($dsn, $db_name, $db_pass);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		$stmt = $dbh->prepare('SELECT user_id, title, text FROM posts WHERE id = :id');
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if (isset($_SESSION['id']) && $result['user_id'] === $_SESSION['id']) {
			$answer = 'タイトルと本文を入力してください。';
		} else {
			header('Location: display_posts.php');
			exit();
		}
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
<title> 投稿編集ページ</title>
</head>
<body>
<h1>編集フォーム</h1>
<?php echo $answer; ?>
<form action="update_result.php" method="POST">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<h2>タイトル(28文字以内でお願いします。)</h2>
<input type="text" name="title" placeholder="<?php echo $result['title']; ?>">
<h2>本文(140文字以内でお願いします。)</h2>
<textarea name="text" placeholder="<?php echo $result['text']; ?>" cols="28" rows="5"></textarea><br>
<input type="submit" value="編集する">
</form>
</body>
</html>
