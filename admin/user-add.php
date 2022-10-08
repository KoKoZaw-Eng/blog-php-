<?php 

session_start();
require 'config/config.php';
require 'config/auth.php';
require 'config/common.php';

if (!empty($_POST)) {
  // Validation
  if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || ($_POST['password'] && strlen($_POST['password']) < 4)) {
    if (empty($_POST['name'])) {
      $nameError = 'Name cannot be Null';
    }
    if (empty($_POST['email'])) {
      $emailError = 'Email cannot be Null';
    }
    if (empty($_POST['password'])) {
      $passwordError = 'Password cannot be Null';
    }
    if ($_POST['password'] && strlen($_POST['password']) < 4) {
      $passwordError = 'Password Length at least 4';
    }

  }else{

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

    if (empty($_POST['admin'])) {
      $role = 0;
    }else{
      $role = 1;
    }

    $sql = "SELECT * FROM users WHERE email=:email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email',$email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
      echo "<script>alert('Duplicated Email');
      window.location.href='user.php';</script>";
    }else{
      $sql = "INSERT INTO users(name,email,password,role) VALUES (:name,:email,:password,:role)";
      $stmt = $pdo->prepare($sql);

      $stmt->bindValue(':name',$name);
      $stmt->bindValue(':email',$email);
      $stmt->bindValue(':password',$password);
      $stmt->bindValue(':role',$role);


      $result = $stmt->execute();

      if ($result) {
        echo "<script>alert('New user is added successfully.');
        window.location.href='user.php';</script>";
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
                <h3 class="card-title">Create New User</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-group" action="user-add.php" method="post">
                <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <p class="text-danger"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>
                    <input type="text" name="name" class="form-control" id="name" required>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <p class="text-danger"><?php echo empty($emailError) ? '' : '*'.$emailError; ?></p>
                    <input type="text" name="email" class="form-control" id="email" required>
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <p class="text-danger"><?php echo empty($passwordError) ? '' : '*'.$passwordError; ?></p>
                    <input type="password" id="password" name="password" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="admin">Admin</label><br>
                    <input type="checkbox" name="admin" id="admin">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="button-group card-footer">
                  <button type="submit" class="btn btn-primary">Create</button>
                  <a href="user.php" type="button" class="btn btn-secondary">Back</a>
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


