<?php 

require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

$dbh = connectDB();
$sql = "SELECT * FROM tweets WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$tweet = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = "";
    $content = $_POST['content'];
    
    if ($content == $tweet['content']) {
        $error = "ツイートが変更されていません";
    }

    if (!$content) {
        $error = "ツイートが入力されていません";
    }
    
    if (!$error) {
        $date = date("Y-m-d H:i:s");
        $dbh = connectDB();
        $sql = "UPDATE tweets SET content = :content, created_at = :date WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        
        header('Location:index.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>tweetの編集</h1>
    <?= $error ?><br>
    <a href="show.php">戻る</a>
    <form  method="post">
        <label for="content">ツイート内容</label><br>
        <textarea name="content" id="content" cols="30" rows="10" ><?= h($tweet['content']) ?></textarea><br>
        <input type="submit" value="編集する">
    </form>
</body>
</html>