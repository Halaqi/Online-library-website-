document.getElementById("addBookBtnn").addEventListener("click", function(event) {
  event.preventDefault();
  var showAddBook = document.getElementById("showAddBook");
  if (showAddBook.style.display === "none" || showAddBook.style.display === "") {
    showAddBook.style.display = "block";
  } else {
    showAddBook.style.display = "none";
  }
})