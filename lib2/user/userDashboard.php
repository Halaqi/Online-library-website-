<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: firstPage.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="userDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>User control Panel</title>
</head>

<body>
    <?php
    require_once "../database/database.php";
    $fetchMessagesResult = mysqli_query($conn, "SELECT * FROM messages");
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["messageContent"])) {
        $messageContent = $_POST["messageContent"];
        $messageContent = mysqli_real_escape_string($conn, $messageContent);

        $insertMessage = "INSERT INTO messages (message) VALUES ('$messageContent')";
        $insertMessageResult = mysqli_query($conn, $insertMessage);
        if ($insertMessageResult) {
            echo "Message sent successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    $fetchBook = mysqli_query($conn, "SELECT * FROM book_store");
    ?>
    <div class="UserMenu">
        <ul>
            <li>
                <a class="active" href="">
                    <i class="fa-solid fa-house"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li>
                <a href="../user/userBook/UserBooks.php">
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
                <a href="#" id="showList">
                    <i class="fa-solid fa-circle-down"></i>
                    <p>MyList</p>
                </a>
            </li>
            <li>
                <a href="">
                    <i class="fa-solid fa-gear"></i>
                    <p>Setting</p>
                </a>
            </li>
            <li class="log-out">
                <a href="../logOut.php">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <p>Log out</p>
                </a>
            </li>

        </ul>
    </div>
    <div class="UserContent">
        <div class="user-title-info">
            <p>Dashboard</p>
            <i class="fas fa-chart-bar"></i>
        </div>
        <div class="user-data-info">
            <div class="box">
                <i class="fas fa-message"></i>
                <div class="data">
                    <a href="#" id="showComingMessages">Messages</a>
                </div>
            </div>
            <div class="box">
                <i class="fas fa-book"></i>
                <div class="data">
                    <a href="#" id="showUserBook">Books</a>
                </div>
            </div>
        </div>
        <div class="UserBookTable" id="UserBookTable" style="display: none;">
            <table class="table2">
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
                    while ($row = mysqli_fetch_array($fetchBook)) {
                        echo '<tr>';
                        echo '<td>' . $row['Book_ID'] . '</td>';
                        echo '<td>' . $row['Book_name'] . '</td>';
                        echo '<td>' . $row['Author'] . '</td>';
                        echo '<td><button type="button" class="btn btn-success add-book-btn">ADD</button></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="messageBox" id="messageBox" style="display: none;">
            <form action="">
                <input type="text" placeholder="Send a message">
                <button class="sendBtn">Send</button>
            </form>
        </div>
        <div class="myListTable" id="listTable" style="display: none;">
            <table class="listTable">
                <thead>
                    <tr>
                        <th scope="col">Book_ID</th>
                        <th scope="col">Book_name</th>
                        <th scope="col">Author</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="myComingMessages" id="comingMessages" style="display: none;">
            <form method="POST" action="">
            <h2>Messages</h2>
                <?php
                while ($row = mysqli_fetch_assoc($fetchMessagesResult)) {
                    echo '<div class="message">';
                    echo '<p>' . $row['message'] . '</p>';
                    echo '</div>';
                }
                ?>
            </form>
        </div>
    </div>
    <script src="./UserDashboard.js"></script>
</body>

</html>