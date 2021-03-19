<?php
session_start();
if (isset($_SESSION['id'])) {
	header('Location: display_posts.php');
	exit();
}
if (isset($_POST['name']) && isset($_POST['mail']) && isset($_POST['pass'])) {
	$name = $_POST['name'];
	$mail = $_POST['mail'];
	$pass = $_POST['pass'];
	$dsn = 'mysql:host=localhost; dbname=procir_tanabe323; charset=utf8';
	$db_user = 'tanabe323';
	$db_pass = '9ie1jpvrkr';
	if (!empty($name) && !empty($mail) && !empty($pass)) {
		if (preg_match('/^.{1,50}$/us', $name) && strlen($mail) <= 254 && preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $mail)) {
			if (preg_match('/^[a-zA-Z0-9!#<>:;&~@%+$"\'|*\^\(\)\[\]\|\/\.,_-]{10,255}$/', $pass)) {
				try {
					$dbh = new PDO($dsn, $db_user, $db_pass);
				} catch (PDOException $e) {
					echo $e->getMessage();
				}
				$stmt = $dbh->prepare('SELECT mail FROM users WHERE mail = :mail');
				$stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
				$stmt->execute();
				$email = $stmt->fetch(PDO::FETCH_ASSOC);
				if (!empty($email)) {
					$result = 'このメールアドレスは既に使われています。';
				} else {
					$stmt = $dbh->prepare('INSERT INTO users (name, mail, pass) VALUES (:name, :mail, :pass)');
					$stmt->bindParam(':name', $name, PDO::PARAM_STR);
					$stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
					$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
					$stmt->execute();
					$result = '会員情報を登録しました。';
				}
			} else {
				$result = 'パスワードの文字数が足りないです。';
			}
		} else {
			$result = '名前の文字数がオーバーしているか、間違えた形式でメールアドレスが入力されています。';
		}
	} else {
		$result = '空欄もしくは値に0が含まれています。';
	}
} else {
	$result = '変数が存在しません。';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>会員登録結果ページ</title>
</head>
<body>
<p><?php echo $result; ?></p>
<a href="display_posts.php">投稿一覧ページへ戻る</a>
</body>
</html>
