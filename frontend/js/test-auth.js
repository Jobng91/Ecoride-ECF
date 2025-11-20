
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


document.getElementById("loginForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const payload = {
        email: document.getElementById("login_email").value.trim(),
        password: document.getElementById("login_password").value.trim()
    };

    const res = await fetch("/api/login.php", {
        method: "POST",
        credentials: "include", 
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(payload)
    });

    const data = await res.json();
    document.getElementById("loginResult").textContent = JSON.stringify(data, null, 4);

    
    await window.refreshCurrentUser();
    updateUserDisplay();
});


document.getElementById("refreshBtn").addEventListener("click", async () => {
    await window.refreshCurrentUser();
    updateUserDisplay();
});


document.getElementById("logoutBtn").addEventListener("click", async () => {
    await signout();
});


function updateUserDisplay() {
    const box = document.getElementById("currentUserBox");

    if (window.currentUser) {
        box.textContent = JSON.stringify(window.currentUser, null, 4);
    } else {
        box.textContent = "null (déconnecté)";
    }

    if (typeof showAndHideElementsForRoles === "function") {
        showAndHideElementsForRoles();
    }
}

setTimeout(updateUserDisplay, 400);
