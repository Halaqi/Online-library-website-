document.getElementById("showUserBook").addEventListener("click", function (event) {
    event.preventDefault();
    var UserBookTable = document.getElementById("UserBookTable");
    var UserMessageBox = document.getElementById("messageBox");
    var UserBookList = document.getElementById("listTable");
    var UserComingMes = document.getElementById("comingMessages");

    if (UserBookTable.style.display === "none" || UserBookTable.style.display === "") {
        UserBookTable.style.display = "block";
        UserMessageBox.style.display = "none";
        UserBookList.style.display = "none";
        UserComingMes.style.display = "none";
    } else {
        UserBookTable.style.display = "none";
    }
});
document.getElementById("showMessageBox").addEventListener("click", function (event) {
    event.preventDefault();
    var UserBookTable = document.getElementById("UserBookTable");
    var UserMessageBox = document.getElementById("messageBox");
    var UserBookList = document.getElementById("listTable");
    var UserComingMes = document.getElementById("comingMessages");

    if (UserMessageBox.style.display === "none" || UserMessageBox.style.display === "") {
        UserMessageBox.style.display = "block";
        UserBookTable.style.display = "none";
        UserBookList.style.display = "none";
        UserComingMes.style.display = "none";
    } else {
        UserMessageBox.style.display = "none";
    }
});
document.getElementById("showList").addEventListener("click", function (event) {
    event.preventDefault();
    var UserBookTable = document.getElementById("UserBookTable");
    var UserMessageBox = document.getElementById("messageBox");
    var UserBookList = document.getElementById("listTable");
    var UserComingMes = document.getElementById("comingMessages");

    if (UserBookList.style.display === "none" || UserBookList.style.display === "") {
        UserBookList.style.display = "block";
        UserBookTable.style.display = "none";
        UserMessageBox.style.display = "none";
        UserComingMes.style.display = "none";
    } else {
        UserBookList.style.display = "none";
    }
});
document.getElementById("showComingMessages").addEventListener("click", function (event) {
    event.preventDefault();
    var UserBookTable = document.getElementById("UserBookTable");
    var UserMessageBox = document.getElementById("messageBox");
    var UserBookList = document.getElementById("listTable");
    var UserComingMes = document.getElementById("comingMessages");

    if (UserComingMes.style.display === "none" || UserComingMes.style.display === "") {
        UserComingMes.style.display = "block";
        UserBookList.style.display = "none";
        UserBookTable.style.display = "none";
        UserMessageBox.style.display = "none";
    } else {
        UserComingMes.style.display = "none";
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const addBookButtons = document.querySelectorAll(".add-book-btn");
    const listTableBody = document.querySelector(".myListTable tbody");

    // Retrieve previously added books from local storage
    const storedBooks = JSON.parse(localStorage.getItem("myBooks")) || [];

    // Add previously added books to the list table
    storedBooks.forEach(book => {
        const newRow = createRow(book);
        listTableBody.appendChild(newRow);
    });

    // Add event listeners to the add book buttons
    addBookButtons.forEach(button => {
        button.addEventListener("click", function () {
            const row = this.closest("tr");
            const bookId = row.querySelector("td:nth-child(1)").innerText;
            const bookName = row.querySelector("td:nth-child(2)").innerText;
            const author = row.querySelector("td:nth-child(3)").innerText;

            const book = { bookId, bookName, author };

            const newRow = createRow(book);
            listTableBody.appendChild(newRow);

            // Store the updated list of books in local storage
            const updatedBooks = [...storedBooks, book];
            localStorage.setItem("myBooks", JSON.stringify(updatedBooks));
        });
    });

    // Function to create a row for the given book data
    function createRow(book) {
        const { bookId, bookName, author } = book;
        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td>${bookId}</td>
            <td>${bookName}</td>
            <td>${author}</td>
            <td><button type="button" class="btn btn-danger">Delete</button></td>
        `;

        // Add event listener to the delete button
        newRow.querySelector(".btn-danger").addEventListener("click", function () {
            newRow.remove();
            // Remove the deleted book from local storage
            const updatedBooks = storedBooks.filter(b => b.bookId !== book.bookId);
            localStorage.setItem("myBooks", JSON.stringify(updatedBooks));
        });

        return newRow;
    }
});
