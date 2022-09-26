<?php 
require 'config.php';

session_start();

if (empty($_SESSION['user_id']) and empty($_SESSION['user_name']) and empty($_SESSION['logged_in'])) {
  header("Location: login.php");

}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body>
<div class="container-fluid">
  <div class="content-header">
    <h1 class="text-center">Blog Posts</h1>
  </div>
  <?php 
  $sql = "SELECT * FROM posts ORDER BY id DESC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $result = $stmt->fetchAll();

   ?>
  <div class="row">
    <?php 
    if ($result) {
      foreach ($result as $value) { ?>
        <div class="col-md-4">
          <!-- Box Comment -->
          <div class="card card-widget">
            <div class="card-header text-secondary">
              <h1 class="h4 text-center"><?php echo $value['title']; ?></h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <a href="detail.php?id=<?php echo $value['id']; ?>">
                <img class="img-fluid pad" src="admin/images/<?php echo $value['image']; ?>" alt="Photo">
              </a>

              <p><?php echo substr($value['content'], 0,90) ?>
                <a class="float-right" href="detail.php?id=<?php echo $value['id']; ?>">More Detail...</a>
              </p>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->


    <?php
      }
    }

     ?>
  </div>
  <!-- /.row -->
<!-- Main Footer -->
  <footer class="main-footer text-center" style="margin-left: 0px !important;">
    <!-- Default to the left -->
    <strong>Copyright &copy; 2022 <a href="#">eMRTech</a>.</strong> All rights reserved.
  </footer>
  
</div>
<!-- ./Container-Fluid -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
