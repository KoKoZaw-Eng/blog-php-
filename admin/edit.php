<?php 

session_start();
require 'config/config.php';
require 'config/auth.php';
require 'config/common.php';

if (!empty($_POST)) {
  if (empty($_POST['title']) || empty($_POST['content'])) {
    if (empty($_POST['title'])) {
      $titleError = 'Title cannot be Null';
    }
    if (empty($_POST['content'])) {
      $contentError = 'Content cannot be Null';
    }
  }else{
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    if ($_FILES['image']['name'] == '') {

      $sql = "UPDATE posts SET title='$title', content= '$content' WHERE id=$id";
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

        $sql = "UPDATE posts SET title='$title', content= '$content', image='$image' WHERE id=$id";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute();

        if ($result) {
          echo "<script>alert('Successful Updated.');
          window.location.href='index.php';</script>";

        }
      }
    }
  }
}
 ?>

<?php include 'header.html'; ?><!-- Header Section -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-10">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Blog Post</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php 
              if ($_GET) {
                $id = $_GET['id'];
                $sql = "SELECT * FROM posts WHERE id= :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id',$id);
                $stmt->execute();

                $result = $stmt->fetchAll();
              }

               ?>
              <form class="form-group" action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                  <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <p class="text-danger"><?php echo empty($titleError) ? '' : '*'.$titleError; ?></p>
                    <input type="text" name="title" class="form-control" id="title" 
                    value="<?php echo escape($result[0]['title']); ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="content">Content</label>
                    <p class="text-danger"><?php echo empty($contentError) ? '' : '*'.$contentError; ?></p>
                    <textarea name="content" id="content" class="form-control" required><?php echo escape($result[0]['content']); ?></textarea>
                  </div>
                  <div>
                    <label for="image">Image</label>
                    <p class="text-danger"><?php echo empty($imageError) ? '' : '*'.$imageError; ?></p>
                    <img src="images/<?php echo $result[0]['image']; ?>" alt="image" width="150" height="100"><br><br>
                    <input type="file" id="image" name="image">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="button-group card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
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


