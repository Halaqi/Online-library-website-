document.getElementById("showUsers").addEventListener("click", function(event) {
    event.preventDefault();
    var userTable = document.getElementById("userTable");
    var bookTable = document.getElementById("bookTable");
    var messageBox = document.getElementById("messageBox");

    if (userTable.style.display === "none" || userTable.style.display === "") {
        userTable.style.display = "block";            
        bookTable.style.display = "none";
        messageBox.style.display = "none";
    } else {
        userTable.style.display = "none";
    }
});

document.getElementById("showBooks").addEventListener("click", function(event) {
    event.preventDefault();
    var bookTable = document.getElementById("bookTable");
    var userTable = document.getElementById("userTable");
    var messageBox = document.getElementById("messageBox");
    
    if (bookTable.style.display === "none" || bookTable.style.display === "") {
        bookTable.style.display = "block";
        userTable.style.display = "none";
        messageBox.style.display = "none";
    } else {
        bookTable.style.display = "none";
    }
});

document.getElementById("showMessageBox").addEventListener("click", function(event) {
    event.preventDefault();
    var messageBox = document.getElementById("messageBox");
    var bookTable = document.getElementById("bookTable");
    var userTable = document.getElementById("userTable");
    

    if (messageBox.style.display === "none" || messageBox.style.display === "") {
        messageBox.style.display = "block";
        bookTable.style.display = "none";
        userTable.style.display = "none";
    } else {
        messageBox.style.display = "none";
    }
});