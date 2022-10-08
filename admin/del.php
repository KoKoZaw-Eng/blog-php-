<?php 

session_start();
require 'config/config.php';
require 'config/auth.php';

if ($_GET) {
	
	$id = $_GET['id'];
	$sqli = "SELECT image FROM posts WHERE id='$id'";
	$imgDel = $pdo->prepare($sqli);
	$imgDel->execute();
	$result = $imgDel->fetchAll();

	if ($result) {
		unlink('images/'.$result[0]['image']);
	}

	$sql = "DELETE FROM posts WHERE id='$id'";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	$result = $stmt->fetchAll();

	header('Location: index.php');
	exit();

}