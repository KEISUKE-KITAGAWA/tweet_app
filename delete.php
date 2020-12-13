<?php 

require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

$dbh = connectDB();
$sql = "DELETE from tweets WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam('id', $id, PDO::PARAM_INT);
$stmt->execute();

header('Location:index.php');
exit;
