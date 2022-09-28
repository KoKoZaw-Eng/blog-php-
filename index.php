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
    <h1 class="text-center">Blog Posts
    <div class="float-right">
      <a class="btn btn-secondary" href="logout.php">Logout</a>
    </div>
    </h1>
  </div>
  <?php
  if (!empty($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
  }else{
    $pageno = 1;
  }
  $numOfrecs = 3;
  $offset = ($pageno - 1) * $numOfrecs; 


  //For Counting for Raw Posts
  $sql = "SELECT * FROM posts ORDER BY id DESC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $rawResult = $stmt->fetchAll();

  $total_pages = ceil(count($rawResult) / $numOfrecs);
  
  //For Limit Post 
  $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrecs";
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

  <!-- Pagination -->
  <div class="card-footer clearfix">
    <ul class="pagination pagination-sm m-0 float-right">
      <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
      <li class="page-item <?php if ($pageno <=1){echo 'disabled';} ?>">
        <a class="page-link"
        href="<?php if ($pageno<=1){echo '#';}else{echo "?pageno=".($pageno-1);}?>">Previous</a>
      </li>
      <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
      <li class="page-item <?php if ($pageno >= $total_pages){echo 'disabled';} ?>">
        <a class="page-link" href="<?php if ($pageno>=$total_pages){echo '#';}else{echo "?pageno=".($pageno+1);} ?>">Next</a>
      </li>
      <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages ?>">Last</a></li>
    </ul>
  </div> <!-- Pagination -->

  <!-- Main Footer -->
  <footer class="main-footer text-center" style="margin-left: 0px !important;">
    <!-- Default to the left -->
    <strong>Copyright &copy; 2022 <a href="#">eMRTech</a>.</strong> All rights reserved.
  </footer>
  <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
    <i class="fas fa-chevron-up"></i>
  </a>
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
