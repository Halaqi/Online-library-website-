<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Books Store</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" href="./books.css">
</head>

<body>
  <?php
  $hostName = "localhost";
  $dbUser = "root";
  $dbPassword = "";
  $dbName = "lib2";
  $conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
  
  $fetch = mysqli_query($conn, "SELECT * FROM book_store");
  ?>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Book_ID</th>
        <th scope="col">Book_name</th>
        <th scope="col">Author</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($row = mysqli_fetch_array($fetch)) {
        echo '<tr>';
        echo '<td>' . $row['Book_ID'] . '</td>';
        echo '<td>' . $row['Book_name'] . '</td>';
        echo '<td>' . $row['Author'] . '</td>';
        echo '<td>
                  <form method="POST">
                    <input type="hidden" name="bookID" value="' . $row['Book_ID'] . '">
                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                  </form>
              </td>';
        echo '</tr>';
      }
      if (isset($_POST["delete"])) {
        $bookID = $_POST["bookID"];
        $sql = "DELETE FROM book_store WHERE Book_ID = ?";
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
        if ($prepareStmt) {
          mysqli_stmt_bind_param($stmt, "i", $bookID);
          mysqli_stmt_execute($stmt);
          echo "<div class='alert alert-success'>Book deleted successfully.</div>";
        } else {
          echo "<div class='alert alert-danger'>Failed to delete book.</div>";
        }
      }
      ?>
    </tbody>
  </table>
  <?php
  if (isset($_POST["submit"])) {
    $bookName = $_POST["bookName"];
    $authorName = $_POST["authorName"];
    $sql = "SELECT * FROM book_store WHERE Book_name = '$bookName'";
    $addBookResult = mysqli_query($conn, $sql);
    $rowCount = mysqli_num_rows($addBookResult);
    $errors = array();

    if ($rowCount > 0) {
      array_push($errors, "Book already exists!");
    }
    if (count($errors) > 0) {
      foreach ($errors as  $error) {
        echo "<div class='alert alert-danger'>$error</div>";
      }
    } else {
      $sql = "INSERT INTO book_store (Book_name, Author) VALUES (?, ?)";
      $stmt = mysqli_stmt_init($conn);
      $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
      if ($prepareStmt) {
        mysqli_stmt_bind_param($stmt, "ss", $bookName, $authorName);
        mysqli_stmt_execute($stmt);
        echo "<div class='alert alert-success'>You added the book successfully.</div>";
      } else {
        die("Something went wrong");
      }
    }
  }
  ?>
  <div>
    <button type="button" class="btn btn-primary" id="addBookBtnn" style="margin: 10px;">ADD BOOK</button>
  </div>
  <div>
    <form method="POST" class="addBook" id="showAddBook" style="display: none;">
      <input type="text" placeholder="Book Name" name="bookName">
      <input type="text" placeholder="Author Name" name="authorName">
      <input type="submit" class="btn btn-success" value="Submit" name="submit" />
    </form>
  </div>
  <script src="./books.js"></script>
</body>

</html>