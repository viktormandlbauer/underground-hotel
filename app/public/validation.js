// Password confirmation check
document.querySelector("form").addEventListener("submit", function (event) {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("password_confirm").value;
    if (password !== confirmPassword) {
        alert("Passwörter stimmen nicht überein!");
        event.preventDefault();
    }
});