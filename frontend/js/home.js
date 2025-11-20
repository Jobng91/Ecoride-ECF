/* 🔥 1) REGISTER */
async function register() {
    const email = document.getElementById("reg-email").value;
    const username = document.getElementById("reg-username").value;
    const password = document.getElementById("reg-password").value;

    const res = await fetch("/api/register.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email, username, password })
    });

    document.getElementById("register-response").textContent = 
        JSON.stringify(await res.json(), null, 2);
}



/* 🔥 2) LOGIN */
async function login() {
    const email = document.getElementById("login-email").value;
    const password = document.getElementById("login-password").value;

    const res = await fetch("/api/login.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        credentials: "include",
        body: JSON.stringify({ email, password })
    });

    document.getElementById("login-response").textContent = 
        JSON.stringify(await res.json(), null, 2);
}



/* 🔥 3) /api/me */
async function me() {
    const res = await fetch("/api/me.php", {
        method: "GET",
        credentials: "include"
    });

    document.getElementById("me-response").textContent =
        JSON.stringify(await res.json(), null, 2);
}



/* 🔥 4) LOGOUT */
async function logoutUser() {
    const res = await fetch("/api/logout.php", {
        method: "POST",
        credentials: "include"
    });

    document.getElementById("logout-response").textContent =
        JSON.stringify(await res.json(), null, 2);
}