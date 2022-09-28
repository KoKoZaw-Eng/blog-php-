<?php 

require 'config/config.php';
require 'config/auth.php';

if ($_GET) {

	$id = $_GET['id'];
	$user = $_SESSION['user_id'];

	
	if ($id == $user) {
		echo "<script>alert('Can not Delete.');
		window.location.href='user.php';</script>";

	}else{
		echo "Not Hello";
		$sql = "DELETE FROM users WHERE id=$id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();

		header('Location: user.php');
		exit();
	}

}