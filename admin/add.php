<?php 

require 'config/config.php';
require 'config/auth.php';

if (!empty($_POST)) {
  $file = 'images/'.($_FILES['image']['name']);
  $imageType = pathinfo($file,PATHINFO_EXTENSION);

  if ($imageType != 'png' and $imageType != 'jpg' and $imageType != 'jpeg') {
    echo "<script>alert('Image must be png, jpg, and jpeg.');
    window.location.href='index.php';</script>";
  }else{
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];

    move_uploaded_file($_FILES['image']['tmp_name'], $file);

    $sql = "INSERT INTO posts(title,content,image,author_id) VALUES (:title,:content,:image,:author_id)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':title',$title);
    $stmt->bindValue(':content',$content);
    $stmt->bindValue(':image',$image);
    $stmt->bindValue(':author_id',$_SESSION['user_id']);

    $result = $stmt->execute();

    if ($result) {
      echo "<script>alert('Your post is added successfully.')</script>";
      header('Location: index.php');
    }
  }
}
