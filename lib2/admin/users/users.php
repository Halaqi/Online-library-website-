<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users</title>
  <link rel="stylesheet" href="./Users.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
  <?php
  $hostName = "localhost";
  $dbUser = "root";
  $dbPassword = "";
  $dbName = "lib2";
  $conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
  $fetchUser = mysqli_query($conn, "SELECT * FROM users");
  ?>
  <div class="userTable" id="userTable">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Full Name</th>
          <th scope="col">Email</th>
          <th scope="col">User</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row = mysqli_fetch_array($fetchUser)) {
          echo '<tr>';
          echo '<td>' . $row['Id'] . '</td>';
          echo '<td>' . $row['Full_name'] . '</td>';
          echo '<td>' . $row['Email'] . '</td>';
          echo '<td><button type="button" id="showUpdateForm" class="btn btn-success">Update</button></td>';
          echo '<td>
                  <form method="POST">
                    <input type="hidden" name="userID" value="' . $row['Id'] . '">
                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                  </form>
                </td>';
          echo '</tr>';
        }
        if (isset($_POST["delete"])) {
          $userID = $_POST["userID"];
          $sql = "DELETE FROM users WHERE ID = ?";
          $stmt = mysqli_stmt_init($conn);
          $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
          if ($prepareStmt) {
            mysqli_stmt_bind_param($stmt, "i", $userID);
            mysqli_stmt_execute($stmt);
            echo "<div class='alert alert-success'>User deleted successfully.</div>";
          } else {
            echo "<div class='alert alert-danger'>Failed to delete user.</div>";
          }
        }
        ?>
      </tbody>
    </table>
  </div>
  <div>
    <button type="button" class="btn btn-primary" id="showAddUsers" style="margin: 10px;">ADD USER</button>
  </div>
  <?php
  if (isset($_POST["submit"])) {
    $userName = $_POST["userName"];
    $userEmail = $_POST["userEmail"];
    $password = $_POST["password"];
    $rePassword = $_POST["rePassword"];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM users WHERE Email = '$userEmail'";
    $addUserResult = mysqli_query($conn, $sql);
    $rowCount = mysqli_num_rows($addUserResult);
    $errors = array();

    if ($rowCount > 0) {
      array_push($errors, "User already exists!");
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
        mysqli_stmt_bind_param($stmt, "sss", $userName, $userEmail, $passwordHash);
        mysqli_stmt_execute($stmt);
        echo "<div class='alert alert-success'>You added the user successfully.</div>";
      } else {
        die("Something went wrong");
      }
    }
  }
  ?>
  <div class="addDiv">
    <form method="POST" class="addUser" id="addUserForm" style="display: none;">
      <input type="text" placeholder="User name" name="userName">
      <input type="text" placeholder="User email" name="userEmail">
      <input type="password" placeholder="Password" name="password">
      <input type="password" placeholder="Repeat password" name="rePassword">
      <input type="submit" class="btn btn-success" value="Submit" name="submit" />
    </form>
  </div>
  <?php
if (isset($_POST["update"])) {
  $userName = $_POST["userName"];
  $userEmail = $_POST["userEmail"];
  $oldPassword = $_POST["oldPassword"];
  $newPassword = $_POST["newPassword"];
  $rePassword = $_POST["rePassword"];

  $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

  $sql = "UPDATE users SET Password = ? WHERE Full_name = ?";
  $stmt = mysqli_stmt_init($conn);

  if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "ss", $passwordHash, $userName);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
      echo "<div class='alert alert-success'>You updated the user successfully.</div>";
    } else {
      echo "<div class='alert alert-danger'>Failed to update user.</div>";
    }
  } else {
    echo "<div class='alert alert-danger'>Something went wrong.</div>";
  }
}
?>

  <div class="updateDiv">
    <form method="POST" class="updateUser" id="updateUserForm" style="display: none;">
      <input type="text" placeholder="User name" name="userName">
      <input type="text" placeholder="User email" name="userEmail">
      <input type="password" placeholder="Old password" name="oldPassword">
      <input type="password" placeholder="New password" name="newPassword">
      <input type="password" placeholder="repeat password" name="rePassword">
      <input type="submit" class="btn btn-success" value="Update" name="update" />
    </form>
  </div>

  <script src="./Users.js"></script>
</body>

</html>