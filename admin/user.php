<?php

require 'config/config.php';
require 'config/auth.php';

 ?>

<?php include 'header.html'; ?><!-- Header Section -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title text-success">User Management</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div>
                  <a href="user-add.php" type="button" class="btn btn-primary">Create New User</a>
                </div><br>
                <table class="table table-bordered text-center">
                  <?php
                  if (!empty($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                  }else{
                    $pageno = 1;
                  }
                  $numOfrecs = 3;
                  $offset = ($pageno - 1) * $numOfrecs;

                  // Condition for Search
                  if (empty($_POST['search'])) {

                    //Page Number
                    $sql = "SELECT * FROM users ORDER BY id DESC";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $rawResult = $stmt->fetchAll();

                    $total_pages = ceil(count($rawResult) / $numOfrecs);

                    //Result Looping
                    $sql = "SELECT * FROM users ORDER BY id DESC LIMIT $offset,$numOfrecs";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $result= $stmt->fetchAll();
                  }else{
                    
                    $searchKey = $_POST['search'];
                    $sql = "SELECT * FROM users WHERE title LIKE '%$searchKey%' ORDER BY id DESC";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $rawResult = $stmt->fetchAll();

                    $total_pages = ceil(count($rawResult) / $numOfrecs);

                    
                    $sql = "SELECT * FROM users WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $result= $stmt->fetchAll();
                  }
                  
                   ?>
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Password</th>
                      <th>User Role</th>
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($result) {
                      $i = 1;
                      foreach ($result as $value) { ?>
                        <tr>
                          <td><?php echo $i; ?></td>
                          <td><?php echo $value['name']; ?></td>
                          <td><?php echo $value['email']; ?></td>
                          <td><?php echo $value['password']; ?></td>
                          <td>
                            <?php 
                            if ($value['role'] === 1) {
                              echo "Admin";
                            }else{
                              echo "User";
                             }
                            ?>
                          </td>
                          <td><a href="user-edit.php?id=<?php echo $value['id']; ?>" type="button" class="btn btn-warning">Edit</a>
                          </td>
                          <td><a href="user-del.php?id=<?php echo $value['id']; ?>"
                          onclick="return confirm('Are you sure you want to delete this user?');"
                          type="button" class="btn btn-danger">Delete</a></td>
                        </tr>
                    <?php
                    $i++;
                      }
                    }
                     ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
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
              </div>
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