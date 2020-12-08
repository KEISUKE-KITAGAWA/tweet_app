<?php 

require_once('config.php');
require_once('functions.php');

$dbh = connectDB();
$sql = "SELECT * FROM tweets ORDER BY created_at DESC";
$stmt = $dbh->prepare($sql);
$stmt->execute();

$tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $_POST['content'];
    $error = "";

    if (!$content) {
        $error = 'ツイートが入力されていません';
    }

    if (!$error) {
        $dbh = connectDB();
        $sql = "INSERT INTO tweets SET content = :content";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->execute();
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ツイート一覧</title>

</head>
<body>
    <h1>新規tweet</h1>
    <?php if($error) : ?>
        <?= h($error) ?>
    <?php endif ; ?>

    <form action="" method="post">
        <label for="content">ツイート内容</label><br>
        <textarea name="content" id="content" cols="30" rows="5" placeholder="いまどうしてる？"></textarea><br>
        <input type="submit" value="投稿する">
    </form>

    <h1>Tweet一覧</h1>
    <?php if($tweets) : ?>
        <ul class="tweet-list">
            <?php foreach($tweets as $tweet) : ?>
                <li>
                    <a href=""><?= h($tweet['content']) ?></a><br>
                    投稿日時: <?= h($tweet['created_at']) ?>
                    <?php if(h($tweet['good']) == '0') : ?>
                        <a href="good.php?id=<?= h($tweet['id']) ?>">☆</a>
                    <?php else : ?>
                        <a href="good.php?id=<?= h($tweet['id']) ?>">★</a>
                    <?php endif ; ?>
                    <hr>
                </li>
            <?php endforeach ; ?>
        </ul>
    <?php endif ; ?>
    
</body>
</html>