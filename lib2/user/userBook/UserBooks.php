<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Book Store</title>
</head>
<body>
<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "lib2";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

$fetch = mysqli_query($conn,"SELECT * FROM book_store");
?>
<table class="table">
  <thead>
    <tr>
        <th scope="col">Book_ID</th>
        <th scope="col">Book_name</th>
        <th scope="col">Author</th>
        <th scope="col">Borrow</th>
    </tr>
  </thead>
  <tbody>
    <?php
    while($row = mysqli_fetch_array($fetch)){
      echo '<tr>';
      echo '<td>'.$row['Book_ID'].'</td>';
      echo '<td>'.$row['Book_name'].'</td>';
      echo '<td>'.$row['Author'].'</td>';
      echo '<td><button type="button" class="btn btn-success">ADD</button></td>';
      echo '</tr>';
    }
    ?>
  </tbody> 
</table>
</body>
</html>