<?php 
require 'config.php';
require 'auth.php';


if (!empty($_GET)) {
  $id = $_GET['id'];
  $sql = "SELECT * FROM posts WHERE id=:id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':id',$id);
  $stmt->execute();

  $result = $stmt->fetchAll();

  if (!empty($_POST)) {
    if (empty($_POST['comment'])) {
      $commentError = 'Comment canot be null';
    }else{
      $content = $_POST['comment'];

      $sql = "INSERT INTO comments(content,author_id,post_id) VALUES (:content,:author_id,:post_id)";
      $stmt = $pdo->prepare($sql);

      $stmt->bindValue(':content',$content);
      $stmt->bindValue(':author_id',$_SESSION['user_id']);
      $stmt->bindValue(':post_id',$id);

      $result = $stmt->execute();
      if ($result) {
        header('Location: detail.php?id='.$id);
      }
    }
  }
}

 ?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail</title>

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
  <div class="row">
    <div class="col-md-12">
      <!-- Box Comment -->
      <div class="card card-widget">
        <div class="card-header">
          <h1 class="h4 text-center"><?php echo $result[0]['title']; ?>
          <div class="float-left">
            <a class="btn btn-secondary" href="index.php">Back</a>
          </div>
          </h1>
        </div>
          <!-- /.user-block -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <img class="img-fluid pad" src="admin/images/<?php echo $result[0]['image']; ?>" alt="Photo">

          <div><br>
            <p><?php echo $result[0]['content'] ?></p>
          </div><br>
          <h1 class="h3">Comments</h1><hr>
        </div>
        <!-- /.card-body -->

        <?php 
        $sql = "SELECT * FROM comments WHERE post_id=:id";
        $comm = $pdo->prepare($sql);
        $comm->bindValue(':id',$id);
        $comm->execute();
        $comResult = $comm->fetchAll();
        // print'<pre>';
        // print_r($comResult);
        // exit();
        $auResult = [];
        if ($comResult) {
          foreach ($comResult as $key => $value) {
            $auId = $comResult[$key]['author_id'];
            $sql = "SELECT * FROM users WHERE id=$auId";
            $stmtau = $pdo->prepare($sql);
            $stmtau->execute();
            $auResult[] = $stmtau->fetchAll();

          }
        }

         ?>
        <div class="card-footer card-comments">
          <div class="card-comment">
            <?php 
            if ($comResult) {
              foreach ($comResult as $key => $value) { ?>
                <div>
                  <span class="username">
                    <?php echo $auResult[$key][0]['name']; ?>
                    <span class="text-muted float-right"><?php echo $value['created_at']; ?></span>
                  </span><!-- /.username -->
                  <?php echo $value['content']; ?>
                </div>
                <!-- /.comment-text -->
            <?php
              }
            }
             ?>
          </div>
          <!-- /.card-comment -->
        </div>
        <!-- /.card-footer -->
        <div class="card-footer">
          <form action="" method="post">
            <div class="img-push">
              <p class="text-danger"><?php echo empty($commentError) ? '' : '*'.$commentError; ?></p>
              <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
            </div>
          </form>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
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
