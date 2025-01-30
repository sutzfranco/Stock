
document.querySelector("form").addEventListener("submit", function(event) {
    var name = document.getElementById("name").value;
    var subject = document.getElementById("subject").value;
    var email = document.getElementById("email").value;
    var message = document.getElementById("message").value;

    if (!name || !subject || !email || !message) {
        event.preventDefault();
        alert("Por favor completa todos los campos.");
    }

    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        event.preventDefault();
        alert("Formato de correo electrónico no válido.");
    }
});
