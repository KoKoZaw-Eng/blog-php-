<?php 

session_start();
require 'config/config.php';
require 'config/auth.php';
require 'config/common.php';

// echo $_POST['password'];
// echo strlen($_POST['password']);
// exit();

if (!empty($_POST)) {

  if (empty($_POST['name']) || empty($_POST['email']) || (!empty($_POST['password']) and strlen($_POST['password']) < 4)) {
    if (empty($_POST['name'])) {
      $nameError = 'Name cannot be Null';
    }
    if (empty($_POST['email'])) {
      $emailError = 'Email cannot be Null';
    }

    if (!empty($_POST['password']) and strlen($_POST['password']) < 4) {
      $passwordError = 'Password Length at least 4';
    }

  }else{

    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

    if (empty($_POST['admin'])) {
      $role = 0;
    }else{
      $role = 1;
    }

    $sql = "SELECT * FROM users WHERE email=:email AND id!=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email',$email);
    $stmt->bindValue(':id',$id);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
      echo "<script>alert('Duplicated Email with another user');
      window.location.href='user.php';</script>";
    }else{
      if ($password != '') {
        $sql = "UPDATE users SET name='$name', email='$email', password='$password', role='$role' WHERE id=:id";
      }else{
        $sql = "UPDATE users SET name='$name', email='$email', role='$role' WHERE id=:id";
      }

      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':id',$id);
      $update = $stmt->execute();

      if ($update) {
        echo "<script>alert('Update successfully.');
        window.location.href='user.php';</script>";
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
                <h3 class="card-title">Create New User</h3>
              </div>
              <!-- /.card-header -->
              <?php 
              if (!empty($_GET)) {
                $id = $_GET['id'];

                $sql = "SELECT * FROM users WHERE id=:id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id',$id);
                $stmt->execute();

                $result = $stmt->fetchAll();
}
               ?>
              <!-- form start -->
              <form class="form-group" action="user-edit.php" method="post">
                <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                <div class="card-body">
                  <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <p class="text-danger"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>
                    <input type="text" name="name" value="<?php echo escape($result[0]['name']); ?>" class="form-control" id="name" required>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <p class="text-danger"><?php echo empty($emailError) ? '' : '*'.$emailError; ?></p>
                    <input type="text" name="email" value="<?php echo escape($result[0]['email']); ?>" class="form-control" id="email" required>
                  </div>
                  <input type="hidden" name="email1" value="<?php echo $result[0]['email']; ?>">
                  <div class="form-group">
                    <label for="password">Password</label>
                    <p class="text-danger"><?php echo empty($passwordError) ? '' : '*'.$passwordError; ?></p>
                    <input type="password" id="password" name="password" class="form-control" placeholder="This user have already password.">
                  </div>
                  <div class="form-group">
                    <label for="admin">Admin</label><br>
                    <input type="checkbox" name="admin" id="admin">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="button-group card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
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


