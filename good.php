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

if ($tweet['good'] == '0') {
    $sql2 = "UPDATE tweets SET good = '1' WHERE id = :id";
} else {
    $sql2 = "UPDATE tweets SET good = '0' WHERE id = :id";
}

$stmt2 = $dbh->prepare($sql2);
$stmt2->bindParam(':id', $id, PDO::PARAM_INT);
$stmt2->execute();

$tweet2 = $stmt2->fetch(PDO::FETCH_ASSOC);

var_dump($tweet);
var_dump($tweet2);

?>