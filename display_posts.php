<?php
session_start();
$dsn = 'mysql:host=localhost; dbname=procir_tanabe323; charset=utf8';
$db_user = 'tanabe323';
$db_pass = '9ie1jpvrkr';
$token = '9a23sder';
try {
	$dbh = new PDO($dsn, $db_user, $db_pass);
} catch (PDOException $e) {
	echo $e->getMessage();
}
$results = $dbh->query('SELECT posts.id, users.name, posts.user_id, posts.title, posts.text, posts.created_at FROM post_infomations INNER JOIN members ON posts.user_id = users.id AND delete_flag = 0 ORDER BY posts.id ASC');
function h($str) {
	return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>投稿一覧ページ</title>
</head>
<body>
<h1>掲示板</h1>
<?php var_dump($test); ?>
<a href="new_post.php">新規投稿はこちら</a><br>
<?php if (isset($_SESSION['id'])): ?>
<a href="logout.php">ログアウトはこちら</a><br>
<?php else: ?>
<a href="login.php">ログインはこちら</a><br>
<a href="member_registration.php">新規会員登録はこちら</a><br>
<?php endif; ?>
<h2>投稿一覧</h2>
<table border="1">
<tr>
<th>投稿ID</th>
<th>投稿者名</th>
<th>タイトル</th>
<th>本文</th>
<th>記入年月日時分</th>
</tr>
<?php foreach ($results as $result): ?>
<tr>
<td><?php echo $result['id']; ?></td>
<td><?php echo h($result['name']); ?></td>
<?php if (isset($_SESSION['id']) && $result['user_id'] === $_SESSION['id']): ?>
<td><?php echo h($result['title']); ?><br><a href="update.php?id=<?php echo $result['id']; ?>">編集</a><a href="delete_result.php?id=<?php echo $result['id']; ?>">削除</a></td>
<?php else: ?>
<td><?php echo h($result['title']); ?>
<?php endif; ?>
<td><?php echo h($result['text']); ?></td>
<td><?php echo $result['created_at']; ?></td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
