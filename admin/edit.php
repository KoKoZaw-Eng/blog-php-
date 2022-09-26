<?php 

require 'config/config.php';
require 'config/auth.php';
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
              <form class="form-group" action="update.php" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="<?php echo $result[0]['title']; ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content" id="content" class="form-control" required><?php echo $result[0]['content']; ?></textarea>
                  </div>
                  <div>
                    <label for="image">Image</label><br>
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


