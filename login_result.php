<?php
session_start();
if (isset($_SESSION['id'])) {
	header('Location: display_posts.php');
	exit();
}
if (isset($_POST['mail']) && isset($_POST['pass'])) {
	$mail = $_POST['mail'];
	$pass = $_POST['pass'];
	$dsn = 'mysql:host=localhost; dbname=procir_tanabe323; charset=utf8';
	$db_user = 'tanabe323';
	$db_pass = '9ie1jpvrkr';
	if (!empty($mail) && !empty($pass)) {
		try {
			$dbh = new PDO($dsn, $db_user, $db_pass);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		$stmt = $dbh->prepare('SELECT id, name FROM users WHERE mail = :mail AND pass = :pass');
		$stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
		$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if (!empty($result)) {
			$_SESSION['id'] = $result['id'];
			$_SESSION['name'] = $result['name'];
			$result = 'ログインしました';
		} else {
			$result = 'メンバーが存在しません。';
		}
	} else {
		$result = '空欄または値に0が含まれています。';
	}
} else {
	$result = '変数が存在しません。';
}
function h($str) {
	return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログイン結果ページ</title>
</head>
<body>
<p><?php echo $result; ?></p>
<?php if (isset($_SESSION['id'])): ?>
<p><?php echo 'ようこそ' . h($_SESSION['name']) . 'さん'; ?></p>
<?php endif; ?>
<a href="display_posts.php">投稿一覧ページへ戻る </a>
</body>
</html>
