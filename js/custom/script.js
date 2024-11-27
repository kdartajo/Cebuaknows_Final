function togglePasswordVisibility() {
    const passwordInput = document.getElementById("password");
    const passwordType = passwordInput.getAttribute("type");

    if (passwordType === "password") {
        passwordInput.setAttribute("type", "text");
    } else {
        passwordInput.setAttribute("type", "password");
    }
}