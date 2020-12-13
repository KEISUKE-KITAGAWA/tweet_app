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

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>      
    <h1><?= $tweet['content'] ?></h1>
    <a href="index.php">戻る</a>
    <ul class="delete">
        <li>
            [#<?= h($tweet['id']) ?>]<?= h($tweet['content']) ?>
        </li>
        <li>
            <?= h($tweet['created_at']) ?>
            <a class="favorite" href="good.php?id=<?= h($tweet['id']) ?>">
                <?php if(h($tweet['good'] == 0)) : ?>
                    ☆
                <?php else : ?>
                    ★
                <?php endif ; ?>
            </a> 
            <a href="edit.php?id=<?= h($tweet['id']) ?>">[編集]</a>
            <a href="delete.php?id=<?= h($tweet['id']) ?>">[削除]</a>
        </li>
        <hr>
    </ul>
</body>
</html>