/* -----------------------------------
   1) REGISTER (JSON)
----------------------------------- */
document.getElementById("registerForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const payload = {
        email: document.getElementById("reg_email").value.trim(),
        username: document.getElementById("reg_username").value.trim(),
        password: document.getElementById("reg_password").value.trim()
    };

    const res = await fetch("/api/register.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(payload)
    });

    const data = await res.json();
    document.getElementById("registerResult").textContent = JSON.stringify(data, null, 4);
});

/* -----------------------------------
   2) LOGIN (JSON)
----------------------------------- */
document.getElementById("loginForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const payload = {
        email: document.getElementById("login_email").value.trim(),
        password: document.getElementById("login_password").value.trim()
    };

    const res = await fetch("/api/login.php", {
        method: "POST",
        credentials: "include", // nécessaire pour le cookie HttpOnly
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(payload)
    });

    const data = await res.json();
    document.getElementById("loginResult").textContent = JSON.stringify(data, null, 4);

    // Mise à jour du currentUser
    await window.refreshCurrentUser();
    updateUserDisplay();
});

/* -----------------------------------
   3) /api/me.php
----------------------------------- */
document.getElementById("refreshBtn").addEventListener("click", async () => {
    await window.refreshCurrentUser();
    updateUserDisplay();
});

/* -----------------------------------
   4) Déconnexion
----------------------------------- */
document.getElementById("logoutBtn").addEventListener("click", async () => {
    await signout();
});

/* -----------------------------------
   Mise à jour affichage
----------------------------------- */
function updateUserDisplay() {
    const box = document.getElementById("currentUserBox");

    if (window.currentUser) {
        box.textContent = JSON.stringify(window.currentUser, null, 4);
    } else {
        box.textContent = "null (déconnecté)";
    }

    // affichage conditionnel
    if (typeof showAndHideElementsForRoles === "function") {
        showAndHideElementsForRoles();
    }
}

// première synchronisation
setTimeout(updateUserDisplay, 400);
