<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./FirstPage.css" />
  <title>Registration Page</title>
</head>

<body>
  <div class="container">
    <?php
    require_once "../database/database.php";
    if (isset($_POST["login"])) {
      $email = $_POST["email"];
      $password = $_POST["password"];
      $role = $_POST["role"];

      if ($role == 'Admin') {
        $sql = "SELECT * FROM admins WHERE Email = '$email'";
      } else {
        $sql = "SELECT * FROM users WHERE Email = '$email'";
      }

      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);

      if ($row) {
        if (password_verify($password, $row["Password"])) {
          if ($role == 'Admin') {
            $_SESSION["admin"] = $row;
            header("Location: ../admin/adminDashboard.php");
            exit();
          } else {
            $_SESSION["user"] = $row;
            header("Location: ../user/userDashboard.php");
            exit();
          }
        } else {
          echo "<div class='alert alert-danger'>Password does not match</div>";
        }
      } else {
        echo "<div class='alert alert-danger'>Email does not exist</div>";
      }
    }
    ?>
    <div class="forms-container">
      <div class="signin-signup">
        <form action="firstPage.php" class="sign-in-form" method="post">
          <h2 class="title">Sign in</h2>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="text" name="email" placeholder="Email" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" />
          </div>
          <div>
            <select class="userSelect" name="role">
              <option value="Admin">Admin</option>
              <option value="Student">Student</option>
            </select>
          </div>
          <input type="submit" value="login" class="btn solid" name="login" />
        </form>
        <?php
        if (isset($_POST["submit"])) {
          $fullName = $_POST["fullName"];
          $email = $_POST["email"];
          $password = $_POST["password"];
          $passwordRepeat = $_POST["repeat_password"];
          $passwordHash = password_hash($password, PASSWORD_DEFAULT);

          $errors = array();

          if (empty($fullName) or empty($email) or empty($password) or empty($passwordRepeat)) {
            array_push($errors, "All fields are required");
          }
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
          }
          if (strlen($password) < 8) {
            array_push($errors, "Password must be at least 8 charactes long");
          }
          if ($password !== $passwordRepeat) {
            array_push($errors, "Password does not match");
          }
          require_once "../database/database.php";
          $sql = "SELECT * FROM users WHERE Email = '$email'";
          $result = mysqli_query($conn, $sql);
          $rowCount = mysqli_num_rows($result);
          if ($rowCount > 0) {
            array_push($errors, "Email already exists!");
          }
          if (count($errors) > 0) {
            foreach ($errors as  $error) {
              echo "<div class='alert alert-danger'>$error</div>";
            }
          } else {
            $sql = "INSERT INTO users (Full_name, Email, Password) VALUES (?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
            if ($prepareStmt) {
              mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordHash);
              mysqli_stmt_execute($stmt);
              echo "<div class='alert alert-success'>You are registered successfully.</div>";
            } else {
              die("Something went wrong");
            }
          }
        }
        ?>
        <form action="firstPage.php" method="post" class="sign-up-form">
          <h2 class="title">Sign up</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="fullName" placeholder="User Full_name" />
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="repeat_password" placeholder="Repeat_Password" />
          </div>
          <input type="submit" class="btn" value="Sign up" name="submit" />
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h2>New Here !?</h2>
          <button class="btn transparent" id="sign-up-btn">
            Sign up
          </button>
        </div>
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h2>WELCOME</h2>
          <p>
            You have an account!!
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Sign in
          </button>
        </div>
      </div>
    </div>
  </div>

  <script src="firstPage.js"></script>
</body>

</html>