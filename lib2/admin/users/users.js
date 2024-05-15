document.getElementById("showAddUsers").addEventListener("click", function (event) {
    event.preventDefault();
    var showAddUser = document.getElementById("addUserForm");
    if (showAddUser.style.display === "none" || showAddUser.style.display === "") {
        showAddUser.style.display = "block";
        showUpdateUser.style.display = "none"
    } else {
        showAddUser.style.display = "none";
    }

})
document.querySelectorAll("#showUpdateForm").forEach(function(element) {
    element.addEventListener("click", function (event) {
        event.preventDefault();
        var showUpdateUser = document.getElementById("updateUserForm");
        if (showUpdateUser.style.display === "none" || showUpdateUser.style.display === "") {
            showUpdateUser.style.display = "block"
            showAddUser.style.display = "none";
        } else {
            showUpdateUser.style.display = "none";
        }
    });
});
