<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: firstPage.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="AdminDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Admin Dashboard</title>
</head>

<body>
    <?php
    require_once "../database/database.php";
    $fetchUser = mysqli_query($conn, "SELECT * FROM users");
    $fetchBook = mysqli_query($conn, "SELECT * FROM book_store");
    ?>
    <div class="menu">
        <ul>
            <li class="profile">
                <div class="profile-photo">
                    <img src="../photos/user.photo.jpg" alt="">
                </div>
                <h2>ABDULRAHMAN</h2>
            </li>
            <li>
                <a class="active" href="">
                    <i class="fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li>
                <a href="../admin/users/users.php">
                    <i class="fas fa-user"></i>
                    <p>Users</p>
                </a>
            </li>
            <li>
                <a href="../admin/books/books.php">
                    <i class="fa-solid fa-book-open"></i>
                    <p>Books</p>
                </a>
            </li>
            <li>
                <a href="#" id="showMessageBox">
                    <i class="fa-solid fa-message"></i>
                    <p>Messages</p>
                </a>
            </li>
            <li>
                <a href="" id="settingLink">
                    <i class="fas fa-cog"></i>
                    <p>Setting</p>
                </a>
            </li>
            <li class="log-out">
                <a href="../logOut.php">
                    <i class="fas fa-sign-out"></i>
                    <p>Log out</p>
                </a>
            </li>
        </ul>
    </div>
    <div class="content">
        <div class="title-info">
            <p>Dashboard</p>
            <i class="fas fa-chart-bar"></i>
        </div>
        <div class="data-info">
            <div class="box">
                <i class="fas fa-user"></i>
                <div class="data">
                    <a href="" id="showUsers">Users</a>
                </div>
            </div>
            <div class="box">
                <i class="fas fa-book"></i>
                <div class="data">
                    <a href="#" id="showBooks">Books</a>
                </div>
            </div>
            <div class="box">
                <i class="fas fa-message"></i>
                <div class="data">
                    <a href="#">Messages</a>
                </div>
            </div>
        </div>
        <div class="Container">
            <div class="userTable" id="userTable" style="display: none;">
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
                            echo '<td><button type="button" class="btn btn-success">Update</button></td>';
                            echo '<td><button type="button" class="btn btn-danger">Delete</button></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="bookTable" id="bookTable" style="display: none;">
                <table class="table2">
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
                        while ($row = mysqli_fetch_array($fetchBook)) {
                            echo '<tr>';
                            echo '<td>' . $row['Book_ID'] . '</td>';
                            echo '<td>' . $row['Book_name'] . '</td>';
                            echo '<td>' . $row['Author'] . '</td>';
                            echo '<td><button type="button" class="btn btn-danger">Delete</button></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="sentMessage">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["message"])) {
                    $message = $_POST["message"];
                    $message = mysqli_real_escape_string($conn, $message);
                    $insertQuery = "INSERT INTO messages (message) VALUES ('$message')";
                    $result = mysqli_query($conn, $insertQuery);
                    if ($result) {
                    echo "Message sent successfully!";
                    } else {
                    echo "Error: " . mysqli_error($conn);
                    }
                }
                ?>
                <div class="messageBox" id="messageBox" style="display: none;">
                    <form method="POST" action="">
                        <input type="text" name="message" placeholder="Send a message">
                        <button type="submit" class="sendBtn">Send</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script src="./adminDashboard.js"></script>



</body>

</html>