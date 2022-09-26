<?php 

require 'config/config.php';
require 'config/auth.php';

if (!empty($_POST)) {
	$id = $_POST['id'];
	$title = $_POST['title'];
	$content = $_POST['content'];

	if ($_FILES['image']['name'] == '') {
		$sql = "UPDATE posts SET title='$title', content= '$content' WHERE id='$id'";
		$stmt = $pdo->prepare($sql);
		$result = $stmt->execute();

		if ($result) {
			echo "<script>alert('Successful Updated.');
			window.location.href='index.php';</script>";
		}
	}else{
		$file = 'images/'.($_FILES['image']['name']);
    	$imageType = pathinfo($file,PATHINFO_EXTENSION);

    	if ($imageType != 'png' and $imageType != 'jpg' and $imageType != 'jpeg') {
    		echo "<script>alert('Image must be png, jpg, and jpeg.');
    		window.location.href='index.php';</script>";
    	}else{
    		$image = $_FILES['image']['name'];
    		move_uploaded_file($_FILES['image']['tmp_name'], $file);

    		$sql = "UPDATE posts SET title='$title', content= '$content', image='$image' WHERE id='$id'";
    		$stmt = $pdo->prepare($sql);
    		$result = $stmt->execute();

    		if ($result) {
    			echo "<script>alert('Successful Updated.');
    			window.location.href='index.php';</script>";

    		}
		}
	}
}