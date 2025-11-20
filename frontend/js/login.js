document.getElementById("loginForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const errorBox = document.getElementById("error");

    errorBox.textContent = "";

    const formData = new FormData();
    formData.append("email", email);
    formData.append("password", password);

    const response = await fetch("/api/login.php", {
        method: "POST",
        credentials: "include", // IMPORTANT pour le cookie HttpOnly !!
        body: formData
    });

    const data = await response.json();

    if (!data.success) {
        errorBox.textContent = data.error || "Erreur inconnue.";
        return;
    }

    // Mise à jour du currentUser via /api/me.php
    await window.refreshCurrentUser();

    // Redirection
    window.location.href = "/";
});
