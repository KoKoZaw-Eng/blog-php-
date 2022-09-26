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
                <h3 class="card-title">Create New Post</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-group" action="add.php" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" required>
                  </div>
                  <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content" id="content" class="form-control" required></textarea>
                  </div>
                  <div>
                    <label for="image">Image</label><br>
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


