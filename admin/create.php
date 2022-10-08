<?php 

session_start();
require 'config/config.php';
require 'config/auth.php';
require 'config/common.php';

if (!empty($_POST)) {
  if (empty($_POST['title']) || empty($_POST['content']) || empty($_FILES['image'])) {
    if (empty($_POST['title'])) {
      $titleError = 'Title cannot be Null';
    }
    if (empty($_POST['content'])) {
      $contentError = 'Content cannot be Null';
    }
    if (empty($_FILES['image'])) {
      $imageError = 'Image cannot be Null';
    }
  }else{
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
        echo "<script>alert('Your post is added successfully.');
        window.location.href='index.php';</script>";
      }
    }
  }
}

 ?>

<?php include 'header.php'; ?><!-- Header Section -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-10">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create New Post</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-group" action="create.php" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <p class="text-danger"><?php echo empty($titleError) ? '' : '*'.$titleError; ?></p>
                    <input type="text" name="title" class="form-control" id="title" required>
                  </div>
                  <div class="form-group">
                    <label for="content">Content</label>
                    <p class="text-danger"><?php echo empty($contentError) ? '' : '*'.$contentError; ?></p>
                    <textarea name="content" id="content" class="form-control" required></textarea>
                  </div>
                  <div>
                    <label for="image">Image</label><br>
                    <p class="text-danger"><?php echo empty($imageError) ? '' : '*'.$imageError; ?></p>
                    <input type="file" id="image" name="image" required>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="button-group card-footer">
                  <button type="submit" class="btn btn-primary">Create</button>
                  <a href="index.php" type="button" class="btn btn-secondary">Back</a>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div><!-- column -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section><!-- Content -->
   
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

<?php include 'footer.html'; ?><!-- Footer Section -->


